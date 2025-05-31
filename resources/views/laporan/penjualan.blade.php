@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <h5 class="border-bottom pb-2 mb-3">Filter Laporan</h5>

            <form action="{{ route('laporan.penjualan') }}" method="GET" class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" class="form-control" name="tanggal_mulai" value="{{ request('tanggal_mulai', date('Y-m-01')) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" class="form-control" name="tanggal_akhir" value="{{ request('tanggal_akhir', date('Y-m-d')) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Kasir</label>
                    <select class="form-select" name="kasir_id">
                        <option value="">Semua Kasir</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('kasir_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->username }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 d-flex justify-content-between">
                    <button type="submit" class="btn" style="background-color:rgba(167, 40, 40, 0.3);">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>

                    <a href="{{ route('laporan.export-pdf') }}?tanggal_mulai={{ request('tanggal_mulai', date('Y-m-01')) }}&tanggal_akhir={{ request('tanggal_akhir', date('Y-m-d')) }}&kasir_id={{ request('kasir_id', '') }}" class="btn" target="_blank" style="background-color:rgb(234, 112, 112); color: white;">
                        <i class="fas fa-file-pdf me-1"></i> Export PDF
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">Data Penjualan</h5>
                <h5 style="color: #A31D1D;" class="mb-0">Total: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h5>
            </div>

            <div class="table-responsive" id="printArea">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Pembeli</th>
                            <th>Kasir</th>
                            <th>Total Harga</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penjualans as $index => $penjualan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ date('d-m-Y', strtotime($penjualan->tanggal_pesan)) }}</td>
                            <td>{{ $penjualan->pembeli->nama }}</td>
                            <td>{{ $penjualan->kasir->username }}</td>
                            <td>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info text-white show-detail"
                                        data-bs-toggle="modal" data-bs-target="#detailModal"
                                        data-id="{{ $penjualan->id }}"
                                        data-tanggal="{{ date('d-m-Y', strtotime($penjualan->tanggal_pesan)) }}"
                                        data-pembeli="{{ $penjualan->pembeli->nama }}"
                                        data-kasir="{{ $penjualan->kasir->username }}"
                                        data-total="{{ number_format($penjualan->total, 0, ',', '.') }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="{{ route('penjualan.invoice', $penjualan->id) }}" class="btn btn-sm btn-secondary" target="_blank">
                                    <i class="fas fa-print"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Data kosong</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Penjualan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th>Tanggal</th>
                                    <td id="modalTanggal"></td>
                                </tr>
                                <tr>
                                    <th>Pembeli</th>
                                    <td id="modalPembeli"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th>Kasir</th>
                                    <td id="modalKasir"></td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td id="modalTotal"></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <h6 class="border-bottom pb-2 mb-3">Detail Barang</h6>
                    <div id="modalItems"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Show detail in modal
        $('.show-detail').click(function() {
            const id = $(this).data('id');
            const tanggal = $(this).data('tanggal');
            const pembeli = $(this).data('pembeli');
            const kasir = $(this).data('kasir');
            const total = $(this).data('total');

            $('#modalTanggal').text(tanggal);
            $('#modalPembeli').text(pembeli);
            $('#modalKasir').text(kasir);
            $('#modalTotal').text('Rp ' + total);

            // Load items via AJAX
            $.ajax({
                url: '/penjualan/' + id,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    let items = '<table class="table table-bordered">';
                    items += '<thead class="table-light"><tr><th>Barang</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th></tr></thead>';
                    items += '<tbody>';

                    $.each(data.detail_penjualans, function(i, item) {
                        items += '<tr>';
                        items += '<td>' + item.barang.nama + '</td>';
                        items += '<td>Rp ' + parseFloat(item.barang.harga).toLocaleString('id-ID') + '</td>';
                        items += '<td>' + item.jumlah + '</td>';
                        items += '<td>Rp ' + parseFloat(item.total_harga).toLocaleString('id-ID') + '</td>';
                        items += '</tr>';
                    });

                    items += '</tbody></table>';
                    $('#modalItems').html(items);
                },
                error: function() {
                    $('#modalItems').html('<p class="text-danger">Gagal memuat data detail.</p>');
                }
            });
        });
    });
</script>
@endsection
