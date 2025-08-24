<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $transaction->invoice_no }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
            padding: 20px;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .invoice-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .invoice-header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 300;
        }

        .invoice-header .invoice-no {
            font-size: 1.2rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
        }

        .invoice-info {
            padding: 30px;
            background: #f8f9fa;
            border-bottom: 3px solid #e9ecef;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .info-section h3 {
            color: #495057;
            margin-bottom: 15px;
            font-size: 1.1rem;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 5px;
        }

        .info-item {
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
        }

        .info-label {
            font-weight: 600;
            color: #6c757d;
        }

        .info-value {
            color: #212529;
        }

        .invoice-body {
            padding: 30px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .items-table th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
        }

        .items-table td {
            padding: 15px 12px;
            border-bottom: 1px solid #e9ecef;
        }

        .items-table tr:hover {
            background-color: #f8f9fa;
        }

        .category-badge {
            background: #e3f2fd;
            color: #1976d2;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .total-section {
            border-top: 3px solid #e9ecef;
            padding-top: 20px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
        }

        .total-label {
            font-size: 1.2rem;
            font-weight: 600;
            color: #495057;
        }

        .total-amount {
            font-size: 1.8rem;
            font-weight: 700;
            color: #28a745;
            background: #f8fff9;
            padding: 10px 20px;
            border-radius: 25px;
            border: 2px solid #d4edda;
        }

        .invoice-footer {
            text-align: center;
            padding: 30px;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }

        .thank-you {
            font-size: 1.3rem;
            color: #495057;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .footer-note {
            color: #6c757d;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .action-buttons {
            text-align: center;
            padding: 20px 30px;
            background: white;
            border-top: 1px solid #e9ecef;
        }

        .btn {
            padding: 12px 24px;
            margin: 0 10px;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .invoice-container {
                box-shadow: none;
                border-radius: 0;
            }

            .action-buttons {
                display: none;
            }

            .invoice-header {
                background: #333 !important;
                -webkit-print-color-adjust: exact;
            }
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .items-table {
                font-size: 0.9rem;
            }

            .items-table th,
            .items-table td {
                padding: 10px 8px;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <h1>INVOICE</h1>
            <div class="invoice-no">{{ $transaction->invoice_no }}</div>
        </div>

        <!-- Invoice Info -->
        <div class="invoice-info">
            <div class="info-grid">
                <div class="info-section">
                    <h3>Informasi Transaksi</h3>
                    <div class="info-item">
                        <span class="info-label">No. Invoice:</span>
                        <span class="info-value">{{ $transaction->invoice_no }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tanggal:</span>
                        <span class="info-value">{{ $transaction->created_at->format('d F Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Waktu:</span>
                        <span class="info-value">{{ $transaction->created_at->format('H:i:s') }}</span>
                    </div>
                </div>
                <div class="info-section">
                    <h3>Informasi Kasir</h3>
                    <div class="info-item">
                        <span class="info-label">Nama Kasir:</span>
                        <span class="info-value">{{ $transaction->user->name ?? 'Unknown' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Total Item:</span>
                        <span class="info-value">{{ $transaction->details->count() }} item</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Total Qty:</span>
                        <span class="info-value">{{ $transaction->details->sum('quantity') }} pcs</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="invoice-body">
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 35%">Produk</th>
                        <th style="width: 15%">Kategori</th>
                        <th style="width: 10%">Qty</th>
                        <th style="width: 15%">Harga</th>
                        <th style="width: 20%">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction->details as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $detail->product->name }}</strong>
                                @if ($detail->product->code)
                                    <br><small class="text-muted">Kode: {{ $detail->product->code }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="category-badge">
                                    {{ $detail->product->category->name ?? '-' }}
                                </span>
                            </td>
                            <td>{{ $detail->quantity }}</td>
                            <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                            <td><strong>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Total Section -->
            <div class="total-section">
                <div class="total-row">
                    <span class="total-label">TOTAL PEMBAYARAN</span>
                    <span class="total-amount">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="invoice-footer">
            <div class="thank-you">🙏 Terima kasih atas pembelian Anda!</div>
            <div class="footer-note">
                Invoice ini sah dan telah diproses secara elektronik.<br>
                Untuk pertanyaan, silakan hubungi customer service kami.
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button onclick="window.print()" class="btn btn-primary">
                🖨️ Cetak Invoice
            </button>
            <a href="{{ route('kasir.transactions.index') }}" class="btn btn-secondary">
                ⬅️ Kembali ke Transaksi
            </a>
        </div>
    </div>

    <script>
        // Auto focus and keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl + P for print
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
            // Escape to go back
            else if (e.key === 'Escape') {
                e.preventDefault();
                window.history.back();
            }
        });

        // Print button enhancement
        window.addEventListener('beforeprint', function() {
            document.title = 'Invoice ' + '{{ $transaction->invoice_no }}' + ' - Print';
        });

        window.addEventListener('afterprint', function() {
            document.title = 'Invoice {{ $transaction->invoice_no }}';
        });
    </script>
</body>

</html>
