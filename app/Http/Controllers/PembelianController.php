<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Barang;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembelian::with(['barang', 'supplier']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('barang', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })->orWhereHas('supplier', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            });
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $pembelians = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('pembelian.index', compact('pembelians'));
    }

    public function create()
    {
        $barangs = Barang::all();
        $suppliers = Supplier::all();
        return view('pembelian.create', compact('barangs', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'status' => 'required|in:pending,completed',
        ]);

        DB::beginTransaction();
        try {
            $pembelian = Pembelian::create($request->all());

            // Jika status completed, tambahkan stok barang
            if ($request->status == 'completed') {
                $barang = Barang::find($request->barang_id);
                $barang->stok += $request->jumlah;
                $barang->save();
            }

            DB::commit();
            return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Pembelian $pembelian)
    {
        return view('pembelian.show', compact('pembelian'));
    }

    public function edit(Pembelian $pembelian)
    {
        $barangs = Barang::all();
        $suppliers = Supplier::all();
        return view('pembelian.edit', compact('pembelian', 'barangs', 'suppliers'));
    }

    public function update(Request $request, Pembelian $pembelian)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'status' => 'required|in:pending,completed',
        ]);

        DB::beginTransaction();
        try {
            $oldStatus = $pembelian->status;
            $oldJumlah = $pembelian->jumlah;
            $oldBarangId = $pembelian->barang_id;

            $pembelian->update($request->all());

            // Jika sebelumnya pending dan sekarang completed
            if ($oldStatus == 'pending' && $request->status == 'completed') {
                $barang = Barang::find($request->barang_id);
                $barang->stok += $request->jumlah;
                $barang->save();
            }
            // Jika sebelumnya completed dan barang_id berubah
            elseif ($oldStatus == 'completed' && $oldBarangId != $request->barang_id) {
                // Kurangi stok barang lama
                $oldBarang = Barang::find($oldBarangId);
                $oldBarang->stok -= $oldJumlah;
                $oldBarang->save();

                // Tambah stok barang baru jika status masih completed
                if ($request->status == 'completed') {
                    $newBarang = Barang::find($request->barang_id);
                    $newBarang->stok += $request->jumlah;
                    $newBarang->save();
                }
            }
            // Jika status tetap completed tapi jumlah berubah
            elseif ($oldStatus == 'completed' && $request->status == 'completed' && $oldJumlah != $request->jumlah) {
                $barang = Barang::find($request->barang_id);
                $barang->stok = $barang->stok - $oldJumlah + $request->jumlah;
                $barang->save();
            }

            DB::commit();
            return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Pembelian $pembelian)
    {
        DB::beginTransaction();
        try {
            // Jika status completed, kurangi stok barang
            if ($pembelian->status == 'completed') {
                $barang = Barang::find($pembelian->barang_id);
                $barang->stok -= $pembelian->jumlah;

                // Pastikan stok tidak negatif
                if ($barang->stok < 0) {
                    return redirect()->route('pembelian.index')->with('error', 'Tidak dapat menghapus. Stok barang akan menjadi negatif!');
                }

                $barang->save();
            }

            $pembelian->delete();
            DB::commit();

            return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('pembelian.index')->with('error', 'Gagal menghapus pembelian: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Pembelian $pembelian)
    {
        $request->validate([
            'status' => 'required|in:pending,completed',
        ]);

        DB::beginTransaction();
        try {
            $oldStatus = $pembelian->status;
            $pembelian->status = $request->status;
            $pembelian->save();

            // Jika status berubah dari pending ke completed
            if ($oldStatus == 'pending' && $request->status == 'completed') {
                $barang = Barang::find($pembelian->barang_id);
                $barang->stok += $pembelian->jumlah;
                $barang->save();
            }
            // Jika status berubah dari completed ke pending
            elseif ($oldStatus == 'completed' && $request->status == 'pending') {
                $barang = Barang::find($pembelian->barang_id);
                $barang->stok -= $pembelian->jumlah;

                // Pastikan stok tidak negatif
                if ($barang->stok < 0) {
                    DB::rollback();
                    return redirect()->back()->with('error', 'Tidak dapat mengubah status. Stok barang akan menjadi negatif!');
                }

                $barang->save();
            }

            DB::commit();
            return redirect()->route('pembelian.index')->with('success', 'Status pembelian berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}