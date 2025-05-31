@extends('layouts.app')

@section('title', 'Data Pembelian')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="{{ route('pembelian.create') }}" class="btn" style="background-color:rgba(167, 40, 40, 0.3);">
                        <i class="fas fa-plus-circle me-1"></i>Tambah Pembelian
                    </a>
                </div>
                <div class="col-md-4">
                    <form action="{{ route('pembelian.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari pembelian..." name="search" value="{{ request('search') }}">
                            <select class="form-select" name="status">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            <button class="btn btn-outline" type="submit">
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
                            <th>Barang</th>
                            <th>Supplier</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembelians as $index => $pembelian)
                        <tr class="{{ $pembelian->status == 'pending' ? 'status-pending' : 'status-completed' }}">
                            <td>{{ $pembelians->firstItem() + $index }}</td>
                            <td>{{ $pembelian->barang->nama }}</td>
                            <td>{{ $pembelian->supplier->nama }}</td>
                            <td>{{ $pembelian->jumlah }}</td>
                            <td>{{ date('d-m-Y', strtotime($pembelian->tanggal)) }}</td>
                            <td>
                                <span class="badge {{ $pembelian->status == 'pending' ? 'bg-warning text-dark' : 'bg-success' }}">
                                    {{ ucfirst($pembelian->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('pembelian.show', $pembelian->id) }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pembelian.edit', $pembelian->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('pembelian.destroy', $pembelian->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembelian ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('pembelian.update-status', $pembelian->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="{{ $pembelian->status == 'pending' ? 'completed' : 'pending' }}">
                                        <button type="submit" class="btn btn-sm {{ $pembelian->status == 'pending' ? 'btn-success' : 'btn-warning' }}">
                                            <i class="fas fa-sync-alt"></i>
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
                {{ $pembelians->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
