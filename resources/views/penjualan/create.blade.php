@extends('layouts.app')

@section('title', 'Tambah Penjualan')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow">
        <div class="card-body">
            <form action="{{ route('penjualan.store') }}" method="POST" id="penjualanForm">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="pembeli_id" class="form-label">Pembeli</label>
                            <select class="form-select @error('pembeli_id') is-invalid @enderror" id="pembeli_id" name="pembeli_id" required>
                                <option value="">Pilih Pembeli</option>
                                @foreach($pembelis as $pembeli)
                                    <option value="{{ $pembeli->id }}" {{ old('pembeli_id') == $pembeli->id ? 'selected' : '' }}>
                                        {{ $pembeli->nama }} - {{ $pembeli->no_hp }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pembeli_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal_pesan" class="form-label">Tanggal Penjualan</label>
                            <input type="date" class="form-control @error('tanggal_pesan') is-invalid @enderror" id="tanggal_pesan" name="tanggal_pesan" value="{{ old('tanggal_pesan', date('Y-m-d')) }}" required>
                            @error('tanggal_pesan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mb-3">Detail Barang</h5>

                <div class="table-responsive">
                    <table class="table table-bordered" id="detailTable">
                        <thead class="table-light">
                            <tr>
                                <th>Barang</th>
                                <th width="150">Harga (Rp)</th>
                                <th width="100">Jumlah</th>
                                <th width="200">Subtotal (Rp)</th>
                                <th width="50">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="row0">
                                <td>
                                    <select class="form-select barang-select" name="barang_id[]" required>
                                        <option value="">Pilih Barang</option>
                                        @foreach($barangs as $barang)
                                            <option value="{{ $barang->id }}" data-harga="{{ $barang->harga }}" data-stok="{{ $barang->stok }}">
                                                {{ $barang->nama }} (Stok: {{ $barang->stok }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control harga" readonly>
                                </td>
                                <td>
                                    <input type="number" class="form-control jumlah" name="jumlah[]" min="1" value="1" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control subtotal" readonly>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-row" disabled>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <button type="button" class="btn " id="addRow" style="background-color:rgb(226, 165, 165);">
                                        <i class="fas fa-plus-circle me-1"></i> Tambah Barang
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Total</th>
                                <th>
                                    <input type="text" class="form-control" id="grandTotal" readonly>
                                </th>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn" style="background-color:rgba(167, 40, 40, 0.3);">
                        <i class="fas fa-save me-1"></i> Simpan Penjualan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        let rowCount = 1;

        // Format number to currency
        function formatRupiah(angka) {
            return parseFloat(angka).toLocaleString('id-ID');
        }

        // Calculate subtotal
        function calculateSubtotal(row) {
            const harga = parseFloat($(row).find('.harga').val().replace(/\./g, '').replace(',', '.'));
            const jumlah = parseInt($(row).find('.jumlah').val());
            const subtotal = harga * jumlah;

            $(row).find('.subtotal').val(formatRupiah(subtotal));
        }

        // Calculate grand total
        function calculateGrandTotal() {
            let total = 0;
            $('.subtotal').each(function() {
                total += parseFloat($(this).val().replace(/\./g, '').replace(',', '.') || 0);
            });

            $('#grandTotal').val(formatRupiah(total));
        }

        // Add new row
        $('#addRow').click(function() {
            const newRow = $('#row0').clone();
            newRow.attr('id', 'row' + rowCount);
            newRow.find('input').val('');
            newRow.find('.barang-select').val('');
            newRow.find('.jumlah').val(1);
            newRow.find('.remove-row').prop('disabled', false);

            $('#detailTable tbody').append(newRow);
            rowCount++;
        });

        // Remove row
        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
            calculateGrandTotal();
        });

        // Update price and stock when product changes
        $(document).on('change', '.barang-select', function() {
            const row = $(this).closest('tr');
            const selectedOption = $(this).find('option:selected');
            const harga = selectedOption.data('harga');
            const stok = selectedOption.data('stok');

            row.find('.harga').val(formatRupiah(harga));
            row.find('.jumlah').attr('max', stok);

            // Reset jumlah if it's more than available stock
            if (parseInt(row.find('.jumlah').val()) > stok) {
                row.find('.jumlah').val(1);
            }

            calculateSubtotal(row);
            calculateGrandTotal();
        });

        // Update subtotal when quantity changes
        $(document).on('input', '.jumlah', function() {
            const row = $(this).closest('tr');
            const selectedOption = row.find('.barang-select option:selected');
            const stok = selectedOption.data('stok');

            // Validate max quantity
            if (parseInt($(this).val()) > stok) {
                $(this).val(stok);
                toastr.warning('Jumlah tidak bisa melebihi stok yang tersedia!');
            }

            calculateSubtotal(row);
            calculateGrandTotal();
        });

        // Form validation
        $('#penjualanForm').submit(function(e) {
            const rows = $('#detailTable tbody tr');

            if (rows.length === 0) {
                e.preventDefault();
                toastr.error('Silakan tambahkan minimal 1 barang!');
                return false;
            }

            let isValid = true;

            rows.each(function() {
                const barang = $(this).find('.barang-select').val();
                const jumlah = $(this).find('.jumlah').val();

                if (!barang || !jumlah || jumlah < 1) {
                    isValid = false;
                    return false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                toastr.error('Silakan lengkapi data barang!');
                return false;
            }
        });
    });
</script>
@endsection
