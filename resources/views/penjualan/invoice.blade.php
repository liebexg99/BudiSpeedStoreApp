<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Penjualan #{{ $penjualan->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/fontawesome.min.css">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            font-size: 14px;
            color: #333;
            background: #ffffff;
            margin: 0;
        }
        .invoice-box {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            background: #ffffff;
            box-shadow: 0 8px 20px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        .invoice-box table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-box table td, .invoice-box table th {
            padding: 10px;
            vertical-align: top;
        }
        .invoice-box .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .invoice-box .title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .invoice-box .info-table td:first-child {
            font-weight: bold;
            width: 30%;
        }
        .invoice-box .items-table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #ddd;
            text-align: left;
            font-weight: 600;
            padding: 12px;
        }
        .invoice-box .items-table td {
            border-bottom: 1px solid #eee;
            padding: 12px;
        }
        .invoice-box .items-table tr {
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .invoice-box .items-table tr:hover {
            background-color: #f1f3f5;
        }
        .invoice-box .total {
            font-weight: bold;
            font-size: 16px;
            text-align: right;
            margin-top: 15px;
            color: rgb(167, 40, 40);
        }
        .guide-message {
            background: #ffffff;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            font-size: 0.85rem;
            font-weight: 400;
            color: #A31D1D;
            margin-bottom: 15px;
            text-align: center;
        }
        .no-print {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }
        .btn-primary {
            background:rgb(188, 43, 43);
            border: none;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background:rgb(179, 0, 0);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
        }
        .btn-secondary {
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
        }
        .animate-zoom-in {
            animation: zoomIn 0.6s ease-out;
        }
        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }
        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media print {
            .no-print {
                display: none;
            }
            .invoice-box {
                border: none;
                box-shadow: none;
                margin: 0;
            }
            .guide-message {
                display: none;
            }
        }
    </style>
</head>
<body>
    @if(isset($penjualan))
        <div class="invoice-box animate-zoom-in" data-invoice-id="{{ $penjualan->id }}">
            <div class="header animate-slide-up">
                <div class="title">Toko Online</div>
                <div>
                    <strong>Invoice #{{ $penjualan->id }}</strong><br>
                    Tanggal: {{ date('d F Y', strtotime($penjualan->tanggal_pesan)) }}<br>
                    Kasir: {{ $penjualan->kasir->username ?? 'Tidak ada kasir' }}
                </div>
            </div>

            <table class="info-table mb-4 animate-slide-up">
                <tr>
                    <td>Kepada</td>
                    <td>
                        {{ $penjualan->pembeli->nama ?? 'Tidak ada pembeli' }}<br>
                        {{ $penjualan->pembeli->alamat ?? 'Tidak ada alamat' }}<br>
                        No HP: {{ $penjualan->pembeli->no_hp ?? 'Tidak ada nomor' }}
                    </td>
                </tr>
                <tr>
                    <td>Dari</td>
                    <td>
                        Toko Online<br>
                        Jl. Contoh No. 123, Kota<br>
                        Kode Pos 12345
                    </td>
                </tr>
            </table>

            <div class="guide-message animate-slide-up">
                <i class="fas fa-hand-point-up me-1"></i> Klik tabel untuk melihat detail (opsional)
            </div>

            <table class="items-table animate-slide-up">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penjualan->detailPenjualans as $detail)
                        <tr class="item-row" data-id="{{ $detail->id }}" data-nama="{{ $detail->barang->nama }}" data-harga="{{ $detail->barang->harga }}" data-jumlah="{{ $detail->jumlah }}" data-total="{{ $detail->total_harga }}">
                            <td>{{ $detail->barang->nama }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td>Rp {{ number_format($detail->barang->harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total animate-slide-up">
                Total: Rp {{ number_format($penjualan->total ?? 0, 0, ',', '.') }}
            </div>

            <div class="no-print">
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print me-1"></i> Cetak
                </button>
                <button onclick="downloadPDF()" class="btn btn-primary">
                    <i class="fas fa-download me-1"></i> Unduh
                </button>
                <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Item Detail Modal -->
        <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="itemModalLabel">Detail Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Nama:</strong> <span id="modal-nama"></span></p>
                        <p><strong>Jumlah:</strong> <span id="modal-jumlah"></span></p>
                        <p><strong>Harga Satuan:</strong> Rp <span id="modal-harga"></span></p>
                        <p><strong>Subtotal:</strong> Rp <span id="modal-total"></span></p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center mt-5">
            <p class="text-danger">Error: Penjualan tidak ditemukan.</p>
            <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        // Toastr notification for guide
        document.addEventListener('DOMContentLoaded', function() {
            if (!sessionStorage.getItem('guideShown')) {
                toastr.info('Klik tabel untuk melihat detail (opsional)', 'Panduan', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    timeOut: 5000,
                    extendedTimeOut: 2000,
                    showEasing: 'swing',
                    hideEasing: 'linear',
                    showMethod: 'fadeIn',
                    hideMethod: 'fadeOut'
                });
                sessionStorage.setItem('guideShown', 'true');
            }

            // Table row click handler
            document.querySelectorAll('.item-row').forEach(row => {
                row.addEventListener('click', function() {
                    const nama = this.getAttribute('data-nama');
                    const jumlah = this.getAttribute('data-jumlah');
                    const harga = parseInt(this.getAttribute('data-harga')).toLocaleString('id-ID');
                    const total = parseInt(this.getAttribute('data-total')).toLocaleString('id-ID');

                    document.getElementById('modal-nama').textContent = nama;
                    document.getElementById('modal-jumlah').textContent = jumlah;
                    document.getElementById('modal-harga').textContent = harga;
                    document.getElementById('modal-total').textContent = total;

                    const modal = new bootstrap.Modal(document.getElementById('itemModal'));
                    modal.show();
                });
            });
        });

        // Download PDF function
        function downloadPDF() {
            const element = document.querySelector('.invoice-box');
            const opt = {
                margin: 10,
                filename: `Pembelian_@json(date('d-m-Y', strtotime($penjualan->tanggal_pesan))).pdf`,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>
</html>