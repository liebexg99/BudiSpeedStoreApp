@extends('layouts.app')

@section('title', 'Detail Supplier')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h5 class="card-title">Detail Supplier: {{ $supplier->nama }}</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $supplier->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $supplier->alamat }}</td>
                                </tr>
                                <tr>
                                    <th>Kode Pos</th>
                                    <td>{{ $supplier->kode_pos }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Pembelian</th>
                                    <td>{{ $supplier->pembelians->count() }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat</th>
                                    <td>{{ date('d-m-Y H:i', strtotime($supplier->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <th>Diperbarui</th>
                                    <td>{{ date('d-m-Y H:i', strtotime($supplier->updated_at)) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <a href="{{ route('supplier.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
