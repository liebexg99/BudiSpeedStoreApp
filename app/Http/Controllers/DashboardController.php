<?php
namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $totalPenjualan = Penjualan::count();
        $totalPendapatan = Penjualan::sum('total') ?? 0;

        $barangLowStock = Barang::where('stok', '<=', 5)
            ->where('stok', '>', 0)
            ->get();

        $barangOutOfStock = Barang::where('stok', 0)
            ->get();

        $penjualanBulanan = Penjualan::select(
                DB::raw('MONTH(tanggal_pesan) as bulan'),
                DB::raw('SUM(total) as total_pendapatan')
            )
            ->whereYear('tanggal_pesan', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return view('dashboard.index', compact(
            'totalBarang',
            'totalPenjualan',
            'totalPendapatan',
            'barangLowStock',
            'barangOutOfStock',
            'penjualanBulanan'
        ));
    }
}