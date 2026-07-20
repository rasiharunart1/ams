<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Barang Keluar — {{ $stockOut->transaction_number }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 30px 16px;
            color: #1a1a2e;
        }

        .receipt-wrapper {
            width: 100%;
            max-width: 680px;
        }

        /* Action bar (hidden on print) */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 10px;
        }
        .action-bar a, .action-bar button {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: none;
        }
        .btn-back {
            background: #fff;
            color: #495057;
            border: 1.5px solid #dee2e6 !important;
        }
        .btn-print {
            background: linear-gradient(135deg, #dc3545, #a71d2a);
            color: #fff;
        }
        .btn-print:hover { opacity: 0.9; }

        /* Receipt Card */
        .receipt {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            overflow: hidden;
        }

        /* Header */
        .receipt-header {
            background: linear-gradient(135deg, #dc3545 0%, #7b1d1d 100%);
            color: #fff;
            padding: 32px 36px 28px;
            position: relative;
        }
        .receipt-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0; right: 0;
            height: 24px;
            background: #fff;
            border-radius: 24px 24px 0 0;
        }
        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .company-name {
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .company-sub {
            font-size: 0.82rem;
            opacity: 0.85;
            margin-top: 2px;
        }
        .badge-type {
            background: rgba(255,255,255,0.2);
            border: 1.5px solid rgba(255,255,255,0.4);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .trx-number {
            margin-top: 20px;
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            opacity: 0.95;
        }

        /* Body */
        .receipt-body {
            padding: 28px 36px 32px;
        }

        /* Section title */
        .section-title {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #dc3545;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 2px solid #f8d7da;
        }

        /* Info grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px 24px;
            margin-bottom: 28px;
        }
        .info-item label {
            display: block;
            font-size: 0.72rem;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }
        .info-item span {
            font-size: 0.92rem;
            font-weight: 600;
            color: #1a1a2e;
        }

        /* Product box */
        .product-box {
            background: #fff8f8;
            border: 1.5px solid #f8d7da;
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 28px;
        }
        .product-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: #7b1d1d;
            margin-bottom: 4px;
        }
        .product-code {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 14px;
        }
        .product-meta {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .meta-item {
            display: flex;
            flex-direction: column;
        }
        .meta-item .meta-label {
            font-size: 0.7rem;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .meta-item .meta-value {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1a1a2e;
        }

        /* Quantity highlight */
        .qty-highlight {
            background: linear-gradient(135deg, #dc3545, #7b1d1d);
            color: #fff;
            border-radius: 10px;
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }
        .qty-highlight .qty-label {
            font-size: 0.85rem;
            font-weight: 600;
            opacity: 0.9;
        }
        .qty-highlight .qty-value {
            font-size: 1.8rem;
            font-weight: 800;
            letter-spacing: -1px;
        }
        .qty-highlight .qty-unit {
            font-size: 0.85rem;
            opacity: 0.85;
            margin-left: 4px;
        }

        /* Notes */
        .notes-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 28px;
        }
        .notes-box p {
            font-size: 0.88rem;
            color: #495057;
            line-height: 1.5;
        }

        /* Divider */
        .divider {
            border: none;
            border-top: 1.5px dashed #dee2e6;
            margin: 20px 0;
        }

        /* Footer */
        .receipt-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding-top: 8px;
        }
        .footer-left {
            font-size: 0.75rem;
            color: #adb5bd;
            line-height: 1.6;
        }
        .signature-area {
            display: flex;
            gap: 40px;
        }
        .signature-box {
            text-align: center;
        }
        .signature-line {
            width: 120px;
            border-top: 1.5px solid #dee2e6;
            margin: 48px auto 6px;
        }
        .signature-label {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 600;
        }

        /* Watermark strip */
        .watermark-strip {
            background: #f8d7da;
            text-align: center;
            padding: 8px;
            font-size: 0.72rem;
            font-weight: 700;
            color: #7b1d1d;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Receipt image */
        .receipt-image-section {
            margin-bottom: 28px;
        }
        .receipt-image-section img {
            width: 100%;
            max-height: 400px;
            object-fit: contain;
            border-radius: 8px;
            border: 1.5px solid #f8d7da;
        }
        .receipt-pdf-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            background: #fff8f8;
            border: 1.5px solid #f8d7da;
            border-radius: 8px;
            font-size: 0.88rem;
            color: #7b1d1d;
            font-weight: 600;
            text-decoration: none;
        }
        .receipt-pdf-link span { font-size: 1.5rem; }

        /* ===== PRINT STYLES ===== */
        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .action-bar { display: none !important; }
            .receipt {
                box-shadow: none;
                border-radius: 0;
            }
            .receipt-image-section img {
                max-height: 300px;
                page-break-inside: avoid;
            }
            .receipt-pdf-link { display: none !important; }
            @page {
                size: A4 portrait;
                margin: 10mm;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-wrapper">

        <!-- Action Bar -->
        <div class="action-bar">
            <a href="{{ route('stock-out.index') }}" class="btn-back">
                ← Kembali
            </a>
            <button class="btn-print" onclick="window.print()">
                🖨️ Cetak / Simpan PDF
            </button>
        </div>

        <!-- Receipt -->
        <div class="receipt">

            <!-- Header -->
            <div class="receipt-header">
                <div class="header-top">
                    <div>
                        <div class="company-name">WMS</div>
                        <div class="company-sub">Sistem Manajemen Gudang</div>
                    </div>
                    <div class="badge-type">📤 Barang Keluar</div>
                </div>
                <div class="trx-number">{{ $stockOut->transaction_number }}</div>
            </div>

            <!-- Body -->
            <div class="receipt-body">

                <!-- Transaction Info -->
                <div class="section-title">Informasi Transaksi</div>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Tanggal Transaksi</label>
                        <span>{{ $stockOut->date->format('d F Y') }}</span>
                    </div>
                    <div class="info-item">
                        <label>Waktu Cetak</label>
                        <span>{{ now()->format('d/m/Y H:i') }} WIB</span>
                    </div>
                    <div class="info-item">
                        <label>Penerima</label>
                        <span>{{ $stockOut->receiver ?: '—' }}</span>
                    </div>
                    <div class="info-item">
                        <label>Kategori Produk</label>
                        <span>{{ $stockOut->product->category->name ?? '—' }}</span>
                    </div>
                </div>

                <!-- Product -->
                <div class="section-title">Detail Produk</div>
                <div class="product-box">
                    <div class="product-name">{{ $stockOut->product->name }}</div>
                    <div class="product-code">Kode: {{ $stockOut->product->code }}</div>
                    <div class="product-meta">
                        <div class="meta-item">
                            <span class="meta-label">Satuan</span>
                            <span class="meta-value">{{ $stockOut->product->unit }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Lokasi Rak</span>
                            <span class="meta-value">{{ $stockOut->product->rack_location ?: '—' }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Sisa Stok</span>
                            <span class="meta-value">{{ $stockOut->product->current_stock }} {{ $stockOut->product->unit }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="qty-highlight">
                    <span class="qty-label">Jumlah Barang Keluar</span>
                    <div>
                        <span class="qty-value">-{{ $stockOut->quantity }}</span>
                        <span class="qty-unit">{{ $stockOut->product->unit }}</span>
                    </div>
                </div>

                <!-- Purpose / Notes -->
                @if($stockOut->purpose)
                <div class="section-title">Keperluan / Keterangan</div>
                <div class="notes-box">
                    <p>{{ $stockOut->purpose }}</p>
                </div>
                @endif

                @if($stockOut->receipt_path)
                @php $ext = strtolower(pathinfo($stockOut->receipt_path, PATHINFO_EXTENSION)); @endphp
                <div class="section-title">Bukti Kwitansi</div>
                <div class="receipt-image-section">
                    @if(in_array($ext, ['jpg','jpeg','png']))
                        <img src="{{ asset('storage/' . $stockOut->receipt_path) }}" alt="Bukti Kwitansi">
                    @else
                        <a href="{{ asset('storage/' . $stockOut->receipt_path) }}" target="_blank" class="receipt-pdf-link">
                            <span>📄</span> Lihat File PDF Kwitansi (klik untuk buka)
                        </a>
                    @endif
                </div>
                @endif

                <hr class="divider">

                <!-- Footer -->
                <div class="receipt-footer">
                    <div class="footer-left">
                        Dicetak oleh: {{ Auth::user()->name }}<br>
                        {{ now()->format('d/m/Y H:i:s') }} WIB<br>
                        WMS — Sistem Manajemen Gudang
                    </div>
                    <div class="signature-area">
                        <div class="signature-box">
                            <div class="signature-line"></div>
                            <div class="signature-label">Petugas Gudang</div>
                        </div>
                        <div class="signature-box">
                            <div class="signature-line"></div>
                            <div class="signature-label">Penerima</div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Watermark Strip -->
            <div class="watermark-strip">
                📤 Dokumen Resmi — Barang Keluar Gudang
            </div>
        </div>

    </div>

    <script>
        // Auto-trigger print dialog when page loads
        window.addEventListener('load', () => {
            setTimeout(() => window.print(), 500);
        });
    </script>
</body>
</html>
