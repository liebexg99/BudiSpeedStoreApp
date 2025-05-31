@extends('layouts.app')

@section('title', 'Data Kategori')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="{{ route('kategori.create') }}"  class="btn btn-sc">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Kategori
                    </a>
                </div>
                <div class="col-md-4">
                    <form action="{{ route('kategori.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari kategori..." name="search" value="{{ request('search') }}">
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
                            <th>Nama Kategori</th>
                            <th>Jumlah Barang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $index => $kategori)
                        <tr>
                            <td>{{ $kategoris->firstItem() + $index }}</td>
                            <td>{{ $kategori->nama }}</td>
                            <td>{{ $kategori->barangs->count() }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('kategori.show', $kategori->id) }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
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
                            <td colspan="4" class="text-center">Data kosong</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $kategoris->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
