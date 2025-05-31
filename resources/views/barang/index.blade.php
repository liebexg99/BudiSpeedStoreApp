@extends('layouts.app')

@section('title', 'Data Barang')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="{{ route('barang.create') }}" class="btn">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Barang
                    </a>
                </div>
                <div class="col-md-4">
                    <form action="{{ route('barang.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari barang..." name="search" value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $index => $barang)
                        <tr @if($barang->stok == 0) class="out-of-stock" @elseif($barang->stok <= 5) class="low-stock" @endif>
                            <td>{{ $barangs->firstItem() + $index }}</td>
                            <td>
                                @if($barang->gambar)
                                    <img src="{{ asset('storage/barang/' . $barang->gambar) }}" alt="{{ $barang->nama }}" width="50">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
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
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('barang.show', $barang->id) }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Data kosong</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $barangs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
