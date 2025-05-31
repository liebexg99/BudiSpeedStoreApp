@extends('layouts.app')

@section('title', 'Data Supplier')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="{{ route('supplier.create') }}" class="btn" >
                        <i class="fas fa-plus-circle me-1"></i> Tambah Supplier
                    </a>
                </div>
                <div class="col-md-4">
                    <form action="{{ route('supplier.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari supplier..." name="search" value="{{ request('search') }}">
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
                            <th>Alamat</th>
                            <th>Kode Pos</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $index => $supplier)
                        <tr>
                            <td>{{ $suppliers->firstItem() + $index }}</td>
                            <td>{{ $supplier->nama }}</td>
                            <td>{{ $supplier->alamat }}</td>
                            <td>{{ $supplier->kode_pos }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('supplier.show', $supplier->id) }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')">
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
                            <td colspan="5" class="text-center">Data kosong</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $suppliers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
