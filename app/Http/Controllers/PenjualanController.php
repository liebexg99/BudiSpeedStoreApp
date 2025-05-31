<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Barang;
use App\Models\Pembeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penjualan::with(['pembeli', 'kasir', 'detailPenjualans']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('pembeli', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })->orWhereHas('kasir', function($q) use ($search) {
                $q->where('username', 'like', "%{$search}%");
            });
        }

        if ($request->has('tanggal_mulai') && $request->has('tanggal_akhir')) {
            $query->whereBetween('tanggal_pesan', [$request->tanggal_mulai, $request->tanggal_akhir]);
        }

        $penjualans = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('penjualan.index', compact('penjualans'));
    }

    public function create()
    {
        $pembelis = Pembeli::all();
        $barangs = Barang::where('stok', '>', 0)->get();
        return view('penjualan.create', compact('pembelis', 'barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pembeli_id' => 'required|exists:pembelis,id',
            'tanggal_pesan' => 'required|date',
            'barang_id' => 'required|array',
            'barang_id.*' => 'exists:barangs,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Buat penjualan baru
            $penjualan = new Penjualan();
            $penjualan->pembeli_id = $request->pembeli_id;
            $penjualan->kasir_id = Auth::id();
            $penjualan->tanggal_pesan = $request->tanggal_pesan;
            $penjualan->total = 0;
            $penjualan->save();

            $totalPenjualan = 0;

            // Tambahkan detail penjualan
            for ($i = 0; $i < count($request->barang_id); $i++) {
                $barangId = $request->barang_id[$i];
                $jumlah = $request->jumlah[$i];

                $barang = Barang::find($barangId);

                // Cek stok barang
                if ($barang->stok < $jumlah) {
                    DB::rollback();
                    return redirect()->back()->with('error', "Stok {$barang->nama} tidak mencukupi! Tersedia: {$barang->stok}");
                }

                // Kurangi stok barang
                $barang->stok -= $jumlah;
                $barang->save();

                // Hitung total harga
                $totalHarga = $barang->harga * $jumlah;
                $totalPenjualan += $totalHarga;

                // Buat detail penjualan
                DetailPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'barang_id' => $barangId,
                    'jumlah' => $jumlah,
                    'total_harga' => $totalHarga,
                ]);
            }

            // Update total penjualan
            $penjualan->total = $totalPenjualan;
            $penjualan->save();

            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Penjualan $penjualan)
    {
        $penjualan->load(['pembeli', 'kasir', 'detailPenjualans.barang']);
        return view('penjualan.show', compact('penjualan'));
    }

    public function edit(Penjualan $penjualan)
    {
        $pembelis = Pembeli::all();
        $barangs = Barang::all();
        $penjualan->load('detailPenjualans.barang');
        return view('penjualan.edit', compact('penjualan', 'pembelis', 'barangs'));
    }

    public function update(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'pembeli_id' => 'required|exists:pembelis,id',
            'tanggal_pesan' => 'required|date',
            'detail_id' => 'nullable|array',
            'detail_id.*' => 'exists:detail_penjualans,id',
            'barang_id' => 'required|array',
            'barang_id.*' => 'exists:barangs,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Kembalikan stok barang yang diedit/dihapus
            foreach ($penjualan->detailPenjualans as $detail) {
                $barang = Barang::find($detail->barang_id);
                $barang->stok += $detail->jumlah;
                $barang->save();
            }

            // Update data penjualan
            $penjualan->pembeli_id = $request->pembeli_id;
            $penjualan->tanggal_pesan = $request->tanggal_pesan;
            $penjualan->total = 0;
            $penjualan->save();

            // Hapus semua detail penjualan
            DetailPenjualan::where('penjualan_id', $penjualan->id)->delete();

            $totalPenjualan = 0;

            // Tambahkan detail penjualan baru
            for ($i = 0; $i < count($request->barang_id); $i++) {
                $barangId = $request->barang_id[$i];
                $jumlah = $request->jumlah[$i];

                $barang = Barang::find($barangId);

                // Cek stok barang
                if ($barang->stok < $jumlah) {
                    DB::rollback();
                    return redirect()->back()->with('error', "Stok {$barang->nama} tidak mencukupi! Tersedia: {$barang->stok}");
                }

                // Kurangi stok barang
                $barang->stok -= $jumlah;
                $barang->save();

                // Hitung total harga
                $totalHarga = $barang->harga * $jumlah;
                $totalPenjualan += $totalHarga;

                // Buat detail penjualan
                DetailPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'barang_id' => $barangId,
                    'jumlah' => $jumlah,
                    'total_harga' => $totalHarga,
                ]);
            }

            // Update total penjualan
            $penjualan->total = $totalPenjualan;
            $penjualan->save();

            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Penjualan $penjualan)
    {
        DB::beginTransaction();
        try {
            // Kembalikan stok barang
            foreach ($penjualan->detailPenjualans as $detail) {
                $barang = Barang::find($detail->barang_id);
                $barang->stok += $detail->jumlah;
                $barang->save();
            }

            // Hapus penjualan dan detail penjualan (cascade)
            $penjualan->delete();

            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('penjualan.index')->with('error', 'Gagal menghapus penjualan: ' . $e->getMessage());
        }
    }

    public function cetakInvoice(Penjualan $penjualan)
    {
        $penjualan->load(['pembeli', 'kasir', 'detailPenjualans.barang']);
        return view('penjualan.invoice', compact('penjualan'));
    }

    // Menambahkan item ke keranjang (AJAX)
    public function getBarangInfo(Request $request)
    {
        $barang = Barang::find($request->barang_id);
        return response()->json($barang);
    }
}