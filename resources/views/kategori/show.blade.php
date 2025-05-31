@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h5 class="card-title">Detail Kategori: {{ $kategori->nama }}</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $kategori->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Barang</th>
                                    <td>{{ $kategori->barangs->count() }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat</th>
                                    <td>{{ date('d-m-Y H:i', strtotime($kategori->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <th>Diperbarui</th>
                                    <td>{{ date('d-m-Y H:i', strtotime($kategori->updated_at)) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <h6 class="border-bottom pb-2 mb-3 mt-4">Daftar Barang dalam Kategori</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kategori->barangs as $barang)
                                <tr>
                                    <td>{{ $barang->nama }}</td>
                                    <td>{{ $barang->stok }}</td>
                                    <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada barang dalam kategori ini</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
