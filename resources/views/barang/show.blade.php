@extends('layouts.app')

@section('title', 'Detail Barang')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h5 class="card-title">{{ $barang->nama }}</h5>
                    <p class="card-text">
                        <strong>Kategori:</strong> {{ $barang->kategori->nama }}<br>
                        <strong>Stok:</strong> {{ $barang->stok }}<br>
                        <strong>Harga:</strong> Rp. {{ number_format($barang->harga, 0, ',', '.') }}
                    </p>
                    @if($barang->gambar)
                        <img src="{{ asset('storage/barang/' . $barang->gambar) }}" alt="{{ $barang->nama }}" class="img-fluid mt-2" style="max-width: 100px;">
                    @endif
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

