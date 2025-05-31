@extends('layouts.app')

@section('title', 'Detail Pembelian')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h5 class="card-title">Detail Pembelian</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th>Barang</th>
                                    <td>{{ $pembelian->barang->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Supplier</th>
                                    <td>{{ $pembelian->supplier->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah</th>
                                    <td>{{ $pembelian->jumlah }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td>{{ date('d-m-Y', strtotime($pembelian->tanggal)) }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge {{ $pembelian->status == 'pending' ? 'bg-warning text-dark' : 'bg-success' }}">
                                            {{ ucfirst($pembelian->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dibuat</th>
                                    <td>{{ date('d-m-Y H:i', strtotime($pembelian->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <th>Diperbarui</th>
                                    <td>{{ date('d-m-Y H:i', strtotime($pembelian->updated_at)) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <form action="{{ route('pembelian.update-status', $pembelian->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="{{ $pembelian->status == 'pending' ? 'completed' : 'pending' }}">
                            <button type="submit" class="btn {{ $pembelian->status == 'pending' ? 'btn-success' : 'btn-warning' }}">
                                <i class="fas fa-sync-alt me-1"></i>
                                {{ $pembelian->status == 'pending' ? 'Tandai Selesai' : 'Tandai Pending' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
