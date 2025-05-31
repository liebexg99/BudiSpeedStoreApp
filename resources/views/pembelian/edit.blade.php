@extends('layouts.app')

@section('title', 'Edit Pembelian')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <form action="{{ route('pembelian.update', $pembelian->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="barang_id" class="form-label">Barang</label>
                            <select class="form-select @error('barang_id') is-invalid @enderror" id="barang_id" name="barang_id" required>
                                <option value="">Pilih Barang</option>
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->id }}" {{ old('barang_id', $pembelian->barang_id) == $barang->id ? 'selected' : '' }}>
                                        {{ $barang->nama }} (Stok: {{ $barang->stok }})
                                    </option>
                                @endforeach
                            </select>
                            @error('barang_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="supplier_id" class="form-label">Supplier</label>
                            <select class="form-select @error('supplier_id') is-invalid @enderror" id="supplier_id" name="supplier_id" required>
                                <option value="">Pilih Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id', $pembelian->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah', $pembelian->jumlah) }}" min="1" required>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal Pembelian</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $pembelian->tanggal) }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="pending" {{ old('status', $pembelian->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ old('status', $pembelian->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn" style="background-color:rgba(167, 40, 40, 0.3);">
                                <i class="fas fa-save me-1"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
