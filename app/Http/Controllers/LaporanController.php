<?php
namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function penjualan(Request $request)
    {
        $users = User::all();
        $query = Penjualan::with(['pembeli', 'kasir', 'detailPenjualans.barang']);

        if ($request->has('tanggal_mulai') && $request->has('tanggal_akhir')) {
            $query->whereBetween('tanggal_pesan', [$request->tanggal_mulai, $request->tanggal_akhir]);
        }

        if ($request->has('kasir_id') && $request->kasir_id != '') {
            $query->where('kasir_id', $request->kasir_id);
        }

        $penjualans      = $query->orderBy('tanggal_pesan', 'desc')->get();
        $totalPendapatan = $penjualans->sum('total');

        return view('laporan.penjualan', compact('penjualans', 'users', 'totalPendapatan'));
    }

    public function stokBarang()
    {
        $barangs = Barang::with('kategori')->get();
        return view('laporan.stok', compact('barangs'));
    }

    public function barangTerjual(Request $request)
    {
        $query = DB::table('detail_penjualans')
            ->join('barangs', 'detail_penjualans.barang_id', '=', 'barangs.id')
            ->join('penjualans', 'detail_penjualans.penjualan_id', '=', 'penjualans.id')
            ->join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
            ->select(
                'barangs.id',
                'barangs.nama',
                'kategoris.nama as kategori',
                DB::raw('SUM(detail_penjualans.jumlah) as total_terjual'),
                DB::raw('SUM(detail_penjualans.total_harga) as total_pendapatan')
            )
            ->groupBy('barangs.id', 'barangs.nama', 'kategoris.nama');

        if ($request->has('tanggal_mulai') && $request->has('tanggal_akhir')) {
            $query->whereBetween('penjualans.tanggal_pesan', [$request->tanggal_mulai, $request->tanggal_akhir]);
        }

        $barangTerjual = $query->orderBy('total_terjual', 'desc')->get();

        return view('laporan.barang-terjual', compact('barangTerjual'));
    }

    public function exportPDF(Request $request)
    {
        $query = Penjualan::with(['pembeli', 'kasir', 'detailPenjualans.barang']);

        if ($request->has('tanggal_mulai') && $request->has('tanggal_akhir')) {
            $query->whereBetween('tanggal_pesan', [$request->tanggal_mulai, $request->tanggal_akhir]);
        }

        if ($request->has('kasir_id') && $request->kasir_id != '') {
            $query->where('kasir_id', $request->kasir_id);
        }

        $penjualans      = $query->orderBy('tanggal_pesan', 'desc')->get();
        $totalPendapatan = $penjualans->sum('total');

        return view('laporan.export-pdf', compact('penjualans', 'totalPendapatan'));
    }
}