@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data" id="barangForm">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $barang->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">Kategori</label>
                            <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id', $barang->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok" value="{{ old('stok', $barang->stok) }}" min="0" required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga (Rp)</label>
                            <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga', $barang->harga) }}" min="0" step="1" required>
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar Barang</label>
                            <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/jpeg,image/png,image/jpg,image/gif">
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($barang->gambar)
                                <img src="{{ asset('storage/barang/' . $barang->gambar) }}" alt="{{ $barang->nama }}" class="img-fluid mt-2" style="max-width: 100px;">
                            @endif
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('barang.index') }}" class="btn btn-secondary">
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

@section('scripts')
<script>
    $(document).ready(function() {
        // Validasi sisi klien
        $('#barangForm').submit(function(e) {
            const nama = $('#nama').val();
            const kategori = $('#kategori_id').val();
            const stok = $('#stok').val();
            const harga = $('#harga').val();

            if (!nama || !kategori || stok < 0 || harga < 0) {
                e.preventDefault();
                toastr.error('Silakan lengkapi semua field dengan data yang valid!');
                return false;
            }

            const gambar = $('#gambar').prop('files')[0];
            if (gambar) {
                const maxSize = 2 * 1024 * 1024; // 2MB
                if (gambar.size > maxSize) {
                    e.preventDefault();
                    toastr.error('Ukuran gambar tidak boleh melebihi 2MB!');
                    return false;
                }
            }
        });

        // Pratinjau gambar
        $('#gambar').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = $('<img>').attr('src', e.target.result).css({
                        'max-width': '100px',
                        'margin-top': '10px'
                    });
                    $('#gambar').siblings('.image-preview, img').remove();
                    $('#gambar').after(preview.addClass('image-preview'));
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
