<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
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
        .report-box {
            max-width: 1200px; /* Increased max-width for better report layout */
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            background: #ffffff;
            box-shadow: 0 8px 20px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        .report-box table {
            width: 100%;
            border-collapse: collapse;
        }
        .report-box table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #ddd;
            text-align: left;
            font-weight: 600;
            padding: 12px;
        }
        .report-box table td {
            border-bottom: 1px solid #eee;
            padding: 12px;
            vertical-align: top;
        }
        .report-box table tr {
            transition: background-color 0.3s ease;
        }
        .report-box table tr:hover {
            background-color: #f1f3f5;
        }
        .report-box table tr.total td {
            font-weight: bold;
            background-color: #f8f9fa;
            font-size: 16px;
            text-align: right; /* Align total to the right */
            color: rgb(167, 40, 40);
        }
        .report-box table tr.total td:first-child {
            text-align: right;
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
        @media print {
            .no-print {
                display: none;
            }
            .report-box {
                border: none;
                box-shadow: none;
                margin: 0;
                padding: 0;
            }
            body {
                font-size: 12px; /* Adjust font size for printing if needed */
            }
        }
    </style>
</head>
<body>
    <div class="report-box">
        <h2 class="text-center mb-4">Laporan Penjualan</h2>
        <p class="text-center mb-4">
            Periode: {{ request('tanggal_mulai', date('Y-m-01')) }} s/d {{ request('tanggal_akhir', date('Y-m-d')) }}<br>
            Kasir: {{ request('kasir_id') ? App\Models\User::find(request('kasir_id'))->username : 'Semua Kasir' }}
        </p>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Pembeli</th>
                    <th>Kasir</th>
                    <th>Total</th>
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
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Data kosong</td>
                </tr>
                @endforelse
                <tr class="total">
                    <td colspan="4">Total Pendapatan</td>
                    <td>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="mt-4 no-print">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print me-1"></i> Cetak
            </button>
            <a href="{{ route('laporan.penjualan') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        // Auto-generate PDF on page load
        window.onload = function() {
            const element = document.querySelector('.report-box');
            html2pdf()
                .from(element)
                .set({
                    margin: 10, /* Adjusted margin to 10mm */
                    filename: 'laporan-penjualan.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' } /* Changed unit to mm and format to a4 */
                })
                .save();
        };
    </script>
</body>
</html>