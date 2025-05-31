@extends('layouts.app')

@section('title', 'Data Pembeli')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="{{ route('pembeli.create') }}" class="btn">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Pembeli
                    </a>
                </div>
                <div class="col-md-4">
                    <form action="{{ route('pembeli.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari pembeli..." name="search" value="{{ request('search') }}">
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
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembelis as $index => $pembeli)
                        <tr>
                            <td>{{ $pembelis->firstItem() + $index }}</td>
                            <td>{{ $pembeli->nama }}</td>
                            <td>{{ $pembeli->jenis_kelamin }}</td>
                            <td>{{ $pembeli->alamat }}</td>
                            <td>{{ $pembeli->no_hp }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('pembeli.show', $pembeli->id) }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pembeli.edit', $pembeli->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('pembeli.destroy', $pembeli->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembeli ini?')">
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
                            <td colspan="6" class="text-center">Data kosong</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $pembelis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
