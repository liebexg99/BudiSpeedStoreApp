@extends('layouts.app')

@section('title', 'Detail Pembeli')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h5 class="card-title">Detail Pembeli: {{ $pembeli->nama }}</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $pembeli->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>{{ $pembeli->jenis_kelamin }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $pembeli->alamat }}</td>
                                </tr>
                                <tr>
                                    <th>No HP</th>
                                    <td>{{ $pembeli->no_hp }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Transaksi</th>
                                    <td>{{ $pembeli->penjualans->count() }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat</th>
                                    <td>{{ date('d-m-Y H:i', strtotime($pembeli->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <th>Diperbarui</th>
                                    <td>{{ date('d-m-Y H:i', strtotime($pembeli->updated_at)) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <h6 class="border-bottom pb-2 mb-3 mt-4">Riwayat Transaksi</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Kasir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pembeli->penjualans as $penjualan)
                                <tr>
                                    <td>{{ date('d-m-Y', strtotime($penjualan->tanggal_pesan)) }}</td>
                                    <td>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
                                    <td>{{ $penjualan->kasir->username }}</td>
                                    <td>
                                        <a href="{{ route('penjualan.show', $penjualan->id) }}" class="btn btn-sm btn-info text-white">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada riwayat transaksi</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <a href="{{ route('pembeli.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
