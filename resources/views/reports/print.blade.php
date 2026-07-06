<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Gudang WMS</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff;
            color: #000000;
            font-size: 12px;
            padding: 20px;
        }
        .header-title {
            text-align: center;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .header-subtitle {
            text-align: center;
            margin-bottom: 25px;
            font-size: 14px;
            color: #555555;
        }
        .table {
            border: 1px solid #000000 !important;
        }
        .table th, .table td {
            border: 1px solid #000000 !important;
            padding: 6px !important;
        }
        .table th {
            background-color: #f2f2f2 !important;
            color: #000000 !important;
            font-weight: bold;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Print Control Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-print alert alert-light border">
        <span>Pratinjau Cetak / PDF. Gunakan tombol Cetak untuk membuka dialog browser.</span>
        <div>
            <button onclick="window.print()" class="btn btn-primary btn-sm"><i class="bi bi-printer"></i> Cetak Sekarang</button>
            <button onclick="window.close()" class="btn btn-secondary btn-sm">Tutup Halaman</button>
        </div>
    </div>

    <!-- Report Header -->
    <div class="header-title h4">Laporan Sistem Manajemen Gudang (WMS)</div>
    <div class="header-subtitle">
        @if($type === 'stock_in')
            Jenis: Transaksi Barang Masuk
        @elseif($type === 'stock_out')
            Jenis: Transaksi Barang Keluar
        @else
            Jenis: Pemantauan Stok Inventaris
        @endif
        @if($startDate || $endDate)
            <br>Periode: {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : 'Awal' }} s/d {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : 'Hari Ini' }}
        @endif
        <br><small>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</small>
    </div>

    <!-- Report Data Table -->
    <table class="table table-bordered table-striped align-middle">
        @if($type === 'stock_in')
            <thead>
                <tr>
                    <th>No Trx</th>
                    <th>Tanggal</th>
                    <th>Kode Produk</th>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Jml</th>
                    <th>Satuan</th>
                    <th>Pemasok</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                    <tr>
                        <td><strong>{{ $row->transaction_number }}</strong></td>
                        <td>{{ $row->date->format('d/m/Y') }}</td>
                        <td>{{ $row->product->code }}</td>
                        <td>{{ $row->product->name }}</td>
                        <td>{{ $row->product->category->name }}</td>
                        <td><strong>+{{ $row->quantity }}</strong></td>
                        <td>{{ $row->product->unit }}</td>
                        <td>{{ $row->supplier ?? '-' }}</td>
                        <td>{{ $row->description ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        @elseif($type === 'stock_out')
            <thead>
                <tr>
                    <th>No Trx</th>
                    <th>Tanggal</th>
                    <th>Kode Produk</th>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Jml</th>
                    <th>Satuan</th>
                    <th>Penerima</th>
                    <th>Keperluan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                    <tr>
                        <td><strong>{{ $row->transaction_number }}</strong></td>
                        <td>{{ $row->date->format('d/m/Y') }}</td>
                        <td>{{ $row->product->code }}</td>
                        <td>{{ $row->product->name }}</td>
                        <td>{{ $row->product->category->name }}</td>
                        <td><strong>-{{ $row->quantity }}</strong></td>
                        <td>{{ $row->product->unit }}</td>
                        <td>{{ $row->receiver ?? '-' }}</td>
                        <td>{{ $row->purpose ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        @elseif($type === 'inventory')
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Stok Saat Ini</th>
                    <th>Min Stok</th>
                    <th>Satuan</th>
                    <th>Lokasi Rak</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                    <tr>
                        <td><strong>{{ $row->code }}</strong></td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->category->name }}</td>
                        <td>{{ $row->current_stock }}</td>
                        <td>{{ $row->minimum_stock }}</td>
                        <td>{{ $row->unit }}</td>
                        <td>{{ $row->rack_location ?? '-' }}</td>
                        <td>
                            @if($row->current_stock <= 0)
                                Out of Stock
                            @elseif($row->current_stock <= $row->minimum_stock)
                                Warning (Menipis)
                            @else
                                Safe (Aman)
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        @endif
    </table>

    <script>
        // Auto trigger print dialog on page load
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
