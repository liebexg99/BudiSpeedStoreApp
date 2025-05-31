@extends('layouts.app')

@section('title', 'Laporan Barang Terjual')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <h5 class="border-bottom pb-2 mb-3">Filter Laporan</h5>

            <form action="{{ route('laporan.barang-terjual') }}" method="GET" class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" class="form-control" name="tanggal_mulai" value="{{ request('tanggal_mulai', date('Y-m-01')) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" class="form-control" name="tanggal_akhir" value="{{ request('tanggal_akhir', date('Y-m-d')) }}">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn" style="background-color:rgba(167, 40, 40, 0.3);">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow">
        <div class="card-body">
            <h5 class="mb-3">Laporan Barang Terjual</h5>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Total Terjual</th>
                            <th>Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangTerjual as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>{{ $item->total_terjual }}</td>
                            <td>Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}</td>
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
