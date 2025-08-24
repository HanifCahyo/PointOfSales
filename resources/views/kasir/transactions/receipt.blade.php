<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk {{ $transaction->invoice_no }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            width: 80mm;
            margin: 0 auto;
            padding: 10px;
            background: #f9f9f9;
            font-size: 12px;
            line-height: 1.4;
        }

        .receipt-container {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px dashed #333;
            padding-bottom: 10px;
        }

        .store-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .store-info {
            font-size: 10px;
            color: #666;
            margin-bottom: 8px;
        }

        .receipt-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .transaction-info {
            margin-bottom: 15px;
            font-size: 11px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }

        .items-section {
            margin-bottom: 15px;
        }

        .item {
            margin-bottom: 8px;
            padding-bottom: 5px;
            border-bottom: 1px dotted #ccc;
        }

        .item:last-child {
            border-bottom: none;
        }

        .item-name {
            font-weight: bold;
            margin-bottom: 2px;
        }

        .item-details {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
        }

        .quantity-price {
            color: #666;
        }

        .subtotal {
            font-weight: bold;
        }

        .separator {
            border-top: 2px dashed #333;
            margin: 10px 0;
        }

        .total-section {
            margin-bottom: 15px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 13px;
        }

        .grand-total {
            font-size: 16px;
            font-weight: bold;
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
            padding: 8px 0;
            margin: 10px 0;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            border-top: 2px dashed #333;
            padding-top: 10px;
        }

        .thank-you {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .footer-note {
            font-size: 9px;
            color: #666;
            line-height: 1.3;
            margin-bottom: 10px;
        }

        .timestamp {
            font-size: 10px;
            color: #999;
        }

        .action-buttons {
            text-align: center;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }

        .btn {
            padding: 8px 15px;
            margin: 0 5px;
            border: none;
            border-radius: 15px;
            font-size: 11px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .barcode {
            text-align: center;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
            font-size: 8px;
            letter-spacing: 1px;
        }

        @media print {
            body {
                background: white;
                padding: 0;
                width: 58mm;
            }

            .receipt-container {
                box-shadow: none;
                border-radius: 0;
                padding: 5px;
            }

            .action-buttons {
                display: none;
            }
        }

        @media screen and (max-width: 480px) {
            body {
                width: 100%;
                padding: 5px;
            }
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="header">
            <div class="store-name">{{ config('', 'Point Of Sales') }}</div>
            <div class="store-info">
                Jl. Contoh No. 123, Kota<br>
                Telp: (021) 1234-5678
            </div>
            <div class="receipt-title">STRUK PEMBELIAN</div>
        </div>

        <!-- Transaction Info -->
        <div class="transaction-info">
            <div class="info-row">
                <span>Invoice:</span>
                <span><strong>{{ $transaction->invoice_no }}</strong></span>
            </div>
            <div class="info-row">
                <span>Kasir:</span>
                <span>{{ $transaction->user->name ?? 'Unknown' }}</span>
            </div>
            <div class="info-row">
                <span>Tanggal:</span>
                <span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>

        <div class="separator"></div>

        <!-- Items -->
        <div class="items-section">
            @foreach ($transaction->details as $index => $detail)
                <div class="item">
                    <div class="item-name">{{ $detail->product->name ?? 'Product not found' }}</div>
                    <div class="item-details">
                        <span class="quantity-price">
                            {{ $detail->quantity }} x Rp{{ number_format($detail->price, 0, ',', '.') }}
                        </span>
                        <span class="subtotal">
                            Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Total Section -->
        <div class="total-section">
            <div class="total-row">
                <span>Total Item:</span>
                <span>{{ $transaction->details->count() }}</span>
            </div>
            <div class="total-row">
                <span>Total Qty:</span>
                <span>{{ $transaction->details->sum('quantity') }}</span>
            </div>

            <div class="grand-total total-row">
                <span>TOTAL BAYAR:</span>
                <span>Rp{{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Barcode Simulation -->
        <div class="barcode">
            |||||| |||| ||||| || |||| |||||
            <br>{{ $transaction->invoice_no }}
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="thank-you">🙏 Terima kasih!</div>
            <div class="footer-note">
                Barang yang sudah dibeli tidak dapat<br>
                ditukar atau dikembalikan.<br>
                Simpan struk ini sebagai bukti pembelian.
            </div>
            <div class="timestamp">
                Dicetak: {{ now()->format('d/m/Y H:i:s') }}
            </div>
        </div>

        <!-- Action Buttons (hidden when printed) -->
        <div class="action-buttons">
            <button onclick="window.print()" class="btn btn-primary">
                🖨️ Cetak
            </button>
            <a href="{{ route('kasir.transactions.index') }}" class="btn btn-secondary">
                ⬅️ Kembali
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

        // Print enhancement
        window.addEventListener('beforeprint', function() {
            document.title = 'Struk ' + '{{ $transaction->invoice_no }}' + ' - Print';
        });

        window.addEventListener('afterprint', function() {
            document.title = 'Struk {{ $transaction->invoice_no }}';
        });

        // Auto print option (uncomment if needed)
        // window.addEventListener('load', function() {
        //     if (confirm('Cetak struk sekarang?')) {
        //         window.print();
        //     }
        // });
    </script>
</body>

</html>
