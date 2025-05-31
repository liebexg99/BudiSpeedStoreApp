@extends('layouts.app')

@section('title', 'Edit Penjualan')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow">
        <div class="card-body">
            <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST" id="penjualanForm">
                @csrf
                @method('PUT') {{-- Use PUT method for updates --}}

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="pembeli_id" class="form-label">Pembeli</label>
                            <select class="form-select @error('pembeli_id') is-invalid @enderror" id="pembeli_id" name="pembeli_id" required>
                                <option value="">Pilih Pembeli</option>
                                @foreach($pembelis as $pembeli)
                                    <option value="{{ $pembeli->id }}" {{ old('pembeli_id', $penjualan->pembeli_id) == $pembeli->id ? 'selected' : '' }}>
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
                            <input type="date" class="form-control @error('tanggal_pesan') is-invalid @enderror" id="tanggal_pesan" name="tanggal_pesan" value="{{ old('tanggal_pesan', $penjualan->tanggal_pesan) }}" required>
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
                            @forelse($penjualan->detailPenjualans as $index => $detail)
                            <tr id="row{{ $index }}">
                                <td>
                                    <select class="form-select barang-select" name="barang_id[]" required>
                                        <option value="">Pilih Barang</option>
                                        @foreach($barangs as $barang)
                                            <option value="{{ $barang->id }}"
                                                    data-harga="{{ $barang->harga }}"
                                                    data-stok="{{ $barang->stok }}" {{-- $barang->stok here already includes original quantity --}}
                                                    {{ $detail->barang_id == $barang->id ? 'selected' : '' }}>
                                                {{ $barang->nama }} (Stok: {{ $barang->stok }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control harga" value="{{ number_format($detail->harga_jual, 0, ',', '.') }}" readonly>
                                </td>
                                <td>
                                    <input type="number" class="form-control jumlah" name="jumlah[]" min="1" value="{{ $detail->jumlah }}" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control subtotal" value="{{ number_format($detail->subtotal, 0, ',', '.') }}" readonly>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-row" {{ $loop->first && $penjualan->detailPenjualans->count() === 1 ? 'disabled' : '' }}>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            {{-- Fallback if no details exist (should not happen for editing, but good for robustness) --}}
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
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <button type="button" class="btn btn-sm" id="addRow" style="background-color: rgba(255, 148, 151, 0.3);">
                                        <i class="fas fa-plus-circle me-1"></i> Tambah Barang
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Total</th>
                                <th>
                                    <input type="text" class="form-control" id="grandTotal" value="{{ number_format($penjualan->total, 0, ',', '.') }}" readonly>
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
                    <button type="submit" class="btn" style="background-color:rgba(255, 148, 151, 0.3);">
                        <i class="fas fa-save me-1"></i> Update Penjualan
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
        let rowCount = {{ $penjualan->detailPenjualans->count() > 0 ? $penjualan->detailPenjualans->count() : 1 }};

        function formatRupiah(angka) {
            return parseFloat(angka).toLocaleString('id-ID');
        }

        function calculateSubtotal(row) {
            const hargaVal = $(row).find('.harga').val();
            const harga = parseFloat(hargaVal.replace(/\./g, '').replace(',', '.')); // Handle Rupiah format
            const jumlah = parseInt($(row).find('.jumlah').val());
            const subtotal = harga * jumlah;

            $(row).find('.subtotal').val(formatRupiah(subtotal));
        }

        function calculateGrandTotal() {
            let total = 0;
            $('.subtotal').each(function() {
                total += parseFloat($(this).val().replace(/\./g, '').replace(',', '.') || 0);
            });
            $('#grandTotal').val(formatRupiah(total));
        }

        // Initialize subtotals and grand total on page load for existing items
        $('#detailTable tbody tr').each(function() {
            calculateSubtotal(this);
        });
        calculateGrandTotal();

        $('#addRow').click(function() {
            const newRowHtml = `
                <tr id="row${rowCount}">
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
                        <button type="button" class="btn btn-danger btn-sm remove-row">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $('#detailTable tbody').append(newRowHtml);
            rowCount++;
            updateRemoveButtons(); // Re-evaluate which remove buttons to disable
        });

        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
            calculateGrandTotal();
            updateRemoveButtons(); // Re-evaluate which remove buttons to disable
            if ($('#detailTable tbody tr').length === 0) {
                // If all rows are removed, add a new empty row and disable its remove button
                $('#addRow').click();
                $('#detailTable tbody tr:first-child .remove-row').prop('disabled', true);
            }
        });

        // Function to update the disabled state of remove buttons
        function updateRemoveButtons() {
            const rowCount = $('#detailTable tbody tr').length;
            if (rowCount === 1) {
                $('#detailTable tbody tr:first-child .remove-row').prop('disabled', true);
            } else {
                $('.remove-row').prop('disabled', false);
            }
        }

        // Call initially to set correct state
        updateRemoveButtons();

        $(document).on('change', '.barang-select', function() {
            const row = $(this).closest('tr');
            const selectedOption = $(this).find('option:selected');
            const harga = selectedOption.data('harga');
            const stok = selectedOption.data('stok');

            row.find('.harga').val(formatRupiah(harga));
            row.find('.jumlah').attr('max', stok);

            // If current quantity is greater than the new available stock, reset to 1
            if (parseInt(row.find('.jumlah').val()) > stok) {
                row.find('.jumlah').val(1);
            }

            calculateSubtotal(row);
            calculateGrandTotal();
        });

        $(document).on('input', '.jumlah', function() {
            const row = $(this).closest('tr');
            const selectedOption = row.find('.barang-select option:selected');
            const stok = selectedOption.data('stok');
            let currentValue = parseInt($(this).val());

            if (isNaN(currentValue) || currentValue < 1) {
                $(this).val(1); // Set to 1 if empty or less than 1
                currentValue = 1;
            }

            if (currentValue > stok) {
                $(this).val(stok);
                toastr.warning(`Jumlah tidak bisa melebihi stok yang tersedia (${stok})!`);
            }

            calculateSubtotal(row);
            calculateGrandTotal();
        });

        $('#penjualanForm').submit(function(e) {
            const rows = $('#detailTable tbody tr');

            if (rows.length === 0) {
                e.preventDefault();
                toastr.error('Silakan tambahkan minimal 1 barang!');
                return false;
            }

            let isValid = true;
            let selectedBarangIds = [];

            rows.each(function() {
                const barangId = $(this).find('.barang-select').val();
                const jumlah = $(this).find('.jumlah').val();

                if (!barangId || !jumlah || parseInt(jumlah) < 1) {
                    isValid = false;
                    return false; // Break from .each loop
                }

                // Check for duplicate barang selections within the same sale
                if (selectedBarangIds.includes(barangId)) {
                    isValid = false;
                    toastr.error('Tidak boleh ada barang yang sama dalam satu transaksi!');
                    return false; // Break from .each loop
                }
                selectedBarangIds.push(barangId);
            });

            if (!isValid) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>
@endsection