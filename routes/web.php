<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Master Data
    Route::resources([
        'kategori' => KategoriController::class,
        'barang'   => BarangController::class,
        'supplier' => SupplierController::class,
        'pembeli'  => PembeliController::class,
    ]);

    // Transaksi
    Route::resources([
        'pembelian' => PembelianController::class,
        'penjualan' => PenjualanController::class,
    ]);

    // Pembelian status update
    Route::patch('/pembelian/{pembelian}/status', [PembelianController::class, 'updateStatus'])->name('pembelian.update-status');

    // Penjualan detail
    Route::get('/penjualan/{penjualan}/invoice', [PenjualanController::class, 'cetakInvoice'])->name('penjualan.invoice');
    Route::get('/get-barang-info', [PenjualanController::class, 'getBarangInfo'])->name('get-barang-info');

    // Laporan
    Route::get('/laporan/penjualan', [LaporanController::class, 'penjualan'])->name('laporan.penjualan');
    Route::get('/laporan/stok-barang', [LaporanController::class, 'stokBarang'])->name('laporan.stok');
    Route::get('/laporan/barang-terjual', [LaporanController::class, 'barangTerjual'])->name('laporan.barang-terjual');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPDF'])->name('laporan.export-pdf');
});