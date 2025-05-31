@extends('layouts.app')

@section('title', 'Data Penjualan')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="{{ route('penjualan.create') }}" class="btn" style="background-color:rgba(167, 40, 40, 0.3);">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Penjualan
                    </a>
                </div>
                <div class="col-md-6 d-flex flex-column flex-md-row align-items-center">
                    <form action="{{ route('penjualan.index') }}" method="GET" class="row g-2 w-100">
                        <div class="col-md-3 col-6">
                            <input type="date" class="form-control" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                        </div>
                        <div class="col-md-3 col-6">
                            <input type="date" class="form-control" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                        </div>
                        <div class="col-md-2 col-12">
                            <button class="btn btn-outline-secondary w-100" type="submit">
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
                            <th>ID Penjualan</th>
                            <th>Pembeli</th>
                            <th>Kasir</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penjualans as $index => $penjualan)
                        <tr>
                            <td>{{ $penjualans->firstItem() + $index }}</td>
                            <td>{{ $penjualan->id }}</td>
                            <td>{{ $penjualan->pembeli->nama ?? 'N/A' }}</td>
                            <td>{{ $penjualan->kasir->username ?? 'N/A' }}</td>
                            <td>{{ date('d-m-Y', strtotime($penjualan->tanggal_pesan)) }}</td>
                            <td>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('penjualan.show', $penjualan->id) }}" class="btn btn-sm btn-info text-white" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('penjualan.edit', $penjualan->id) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('penjualan.invoice', $penjualan->id) }}" class="btn btn-sm btn-primary" title="Cetak Invoice">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <form action="{{ route('penjualan.destroy', $penjualan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus penjualan ini?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Data penjualan kosong</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $penjualans->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
