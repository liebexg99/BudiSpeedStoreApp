@extends('layouts.app')

@section('title', 'Laporan Stok Barang')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow">
        <div class="card-body">
            <h5 class="border-bottom pb-2 mb-3">Laporan Stok Barang</h5>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $index => $barang)
                        <tr @if($barang->stok == 0) class="out-of-stock" @elseif($barang->stok <= 5) class="low-stock" @endif>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $barang->nama }}</td>
                            <td>{{ $barang->kategori->nama }}</td>
                            <td>
                                @if($barang->stok == 0)
                                    <span class="badge bg-danger">Habis</span>
                                @elseif($barang->stok <= 5)
                                    <span class="badge bg-warning text-dark">{{ $barang->stok }}</span>
                                @else
                                    <span class="badge bg-success">{{ $barang->stok }}</span>
                                @endif
                            </td>
                            <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Data kosong</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
