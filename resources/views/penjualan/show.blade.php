@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h5 class="card-title">Detail Penjualan #{{ $penjualan->id }}</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th>Tanggal</th>
                                    <td>{{ date('d-m-Y', strtotime($penjualan->tanggal_pesan)) }}</td>
                                </tr>
                                <tr>
                                    <th>Pembeli</th>
                                    <td>{{ $penjualan->pembeli->nama }} ({{ $penjualan->pembeli->no_hp }})</td>
                                </tr>
                                <tr>
                                    <th>Kasir</th>
                                    <td>{{ $penjualan->kasir->username }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat</th>
                                    <td>{{ date('d-m-Y H:i', strtotime($penjualan->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <th>Diperbarui</th>
                                    <td>{{ date('d-m-Y H:i', strtotime($penjualan->updated_at)) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <h6 class="border-bottom pb-2 mb-3 mt-4">Daftar Barang</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($penjualan->detailPenjualans as $detail)
                                <tr>
                                    <td>{{ $detail->barang->nama }}</td>
                                    <td>{{ $detail->jumlah }}</td>
                                    <td>Rp {{ number_format($detail->barang->harga, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($detail->total_harga, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada barang dalam transaksi ini</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total</th>
                                    <th>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <a href="{{ route('penjualan.invoice', $penjualan->id) }}" class="btn btn-primary">
                            <i class="fas fa-print me-1"></i> Cetak Invoice
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
