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
            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body {
                background: white !important;
                padding: 5mm !important;
                width: 58mm !important;
                margin: 0 !important;
                font-size: 10px !important;
                font-family: 'Courier New', monospace !important;
            }

            .receipt-container {
                box-shadow: none !important;
                border-radius: 0 !important;
                padding: 0 !important;
                background: white !important;
                width: 100% !important;
            }

            .header {
                text-align: center !important;
                margin-bottom: 10px !important;
                border-bottom: 2px dashed #333 !important;
                padding-bottom: 8px !important;
            }

            .store-name {
                font-size: 14px !important;
                font-weight: bold !important;
                margin-bottom: 3px !important;
            }

            .store-info {
                font-size: 9px !important;
                color: #333 !important;
                margin-bottom: 5px !important;
            }

            .receipt-title {
                font-size: 12px !important;
                font-weight: bold !important;
                margin-bottom: 3px !important;
            }

            .transaction-info {
                margin-bottom: 10px !important;
                font-size: 9px !important;
            }

            .info-row {
                display: flex !important;
                justify-content: space-between !important;
                margin-bottom: 2px !important;
            }

            .separator {
                border-top: 2px dashed #333 !important;
                margin: 8px 0 !important;
            }

            .item {
                margin-bottom: 5px !important;
                padding-bottom: 3px !important;
                border-bottom: 1px dotted #ccc !important;
            }

            .item-name {
                font-weight: bold !important;
                font-size: 9px !important;
                margin-bottom: 2px !important;
            }

            .item-details {
                display: flex !important;
                justify-content: space-between !important;
                font-size: 8px !important;
            }

            .total-section {
                margin-bottom: 10px !important;
            }

            .total-row {
                display: flex !important;
                justify-content: space-between !important;
                margin-bottom: 3px !important;
                font-size: 9px !important;
            }

            .grand-total {
                font-size: 12px !important;
                font-weight: bold !important;
                border-top: 2px solid #333 !important;
                border-bottom: 2px solid #333 !important;
                padding: 5px 0 !important;
                margin: 8px 0 !important;
            }

            .barcode {
                text-align: center !important;
                margin: 8px 0 !important;
                font-family: 'Courier New', monospace !important;
                font-size: 6px !important;
                letter-spacing: 1px !important;
            }

            .footer {
                text-align: center !important;
                margin-top: 10px !important;
                border-top: 2px dashed #333 !important;
                padding-top: 8px !important;
            }

            .thank-you {
                font-size: 10px !important;
                font-weight: bold !important;
                margin-bottom: 3px !important;
            }

            .footer-note {
                font-size: 7px !important;
                color: #333 !important;
                line-height: 1.2 !important;
                margin-bottom: 8px !important;
            }

            .timestamp {
                font-size: 8px !important;
                color: #333 !important;
            }

            .action-buttons {
                display: none !important;
            }

            @page {
                size: 58mm auto;
                margin: 0 !important;
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
            <div class="store-name">{{ config('app.name', 'Point Of Sales') }}</div>
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
            <button id="print-btn" class="btn btn-primary">
                🖨️ Cetak
            </button>
            <a href="{{ route('kasir.transactions.index') }}" class="btn btn-secondary">
                ⬅️ Kembali
            </a>
        </div>
    </div>

    <script>
        // Enhanced print function with paper size detection
        function smartPrint() {
            // Try to detect if thermal printer is available
            if (navigator.userAgent.includes('Android') || navigator.userAgent.includes('iPhone')) {
                // Mobile - suggest thermal printing
                if (confirm(
                        'Print ke thermal printer (58mm)?\nPilih "OK" untuk thermal atau "Cancel" untuk printer biasa.')) {
                    printThermal();
                } else {
                    window.print();
                }
            } else {
                // Desktop - show options
                const choice = confirm('Pilih ukuran kertas:\n\nOK = Thermal Receipt (58mm)\nCancel = Printer Biasa (A4)');
                if (choice) {
                    printThermal();
                } else {
                    printRegular();
                }
            }
        }

        // Thermal printer optimized
        function printThermal() {
            const printContent = document.querySelector('.receipt-container').cloneNode(true);

            // Remove action buttons
            const actionButtons = printContent.querySelector('.action-buttons');
            if (actionButtons) {
                actionButtons.remove();
            }

            const printStyles = `
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                    -webkit-print-color-adjust: exact;
                    color-adjust: exact;
                    print-color-adjust: exact;
                }

                @page {
                    size: 58mm auto;
                    margin: 0;
                }

                body {
                    width: 58mm;
                    font-size: 10px;
                    font-family: 'Courier New', monospace;
                    margin: 0;
                    padding: 2mm;
                    background: white;
                    color: black;
                    line-height: 1.3;
                }

                .receipt-container {
                    padding: 0;
                    box-shadow: none;
                    border-radius: 0;
                    background: white;
                    width: 100%;
                }

                .header {
                    text-align: center;
                    margin-bottom: 8px;
                    border-bottom: 2px dashed black;
                    padding-bottom: 5px;
                }

                .store-name {
                    font-size: 12px;
                    font-weight: bold;
                    margin-bottom: 2px;
                }

                .store-info {
                    font-size: 8px;
                    margin-bottom: 3px;
                }

                .receipt-title {
                    font-size: 10px;
                    font-weight: bold;
                }

                .transaction-info {
                    margin-bottom: 8px;
                    font-size: 8px;
                }

                .info-row {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 1px;
                }

                .separator {
                    border-top: 1px dashed black;
                    margin: 5px 0;
                }

                .item {
                    margin-bottom: 4px;
                    padding-bottom: 2px;
                    border-bottom: 1px dotted #999;
                }

                .item-name {
                    font-weight: bold;
                    font-size: 8px;
                    margin-bottom: 1px;
                }

                .item-details {
                    display: flex;
                    justify-content: space-between;
                    font-size: 7px;
                }

                .total-row {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 2px;
                    font-size: 8px;
                }

                .grand-total {
                    font-size: 10px;
                    font-weight: bold;
                    border-top: 2px solid black;
                    border-bottom: 2px solid black;
                    padding: 3px 0;
                    margin: 5px 0;
                }

                .barcode {
                    text-align: center;
                    margin: 5px 0;
                    font-size: 6px;
                    letter-spacing: 1px;
                }

                .footer {
                    text-align: center;
                    margin-top: 8px;
                    border-top: 2px dashed black;
                    padding-top: 5px;
                }

                .thank-you {
                    font-size: 8px;
                    font-weight: bold;
                    margin-bottom: 2px;
                }

                .footer-note {
                    font-size: 6px;
                    line-height: 1.2;
                    margin-bottom: 5px;
                }

                .timestamp {
                    font-size: 7px;
                }
            </style>
        `;

            const printWindow = window.open('', '_blank', 'width=400,height=600');

            if (!printWindow) {
                alert('Pop-up terblokir. Mohon izinkan pop-up untuk mencetak.');
                return;
            }

            printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Thermal Print - ${document.title}</title>
                <meta charset="UTF-8">
                ${printStyles}
            </head>
            <body>
                ${printContent.outerHTML}
            </body>
            </html>
        `);

            printWindow.document.close();
            printWindow.focus();

            printWindow.onload = function() {
                setTimeout(() => {
                    printWindow.print();
                    setTimeout(() => printWindow.close(), 1000);
                }, 300);
            };
        }
        // Regular printer (A4)
        function printRegular() {
            const printStyles = `
                <style>
                    @page {
                        size: A4;
                        margin: 20mm;
                    }
                    body {
                        width: auto !important;
                        max-width: 80mm;
                        margin: 0 auto !important;
                        background: white !important;
                    }
                    .action-buttons { display: none !important; }
                </style>
            `;

            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Print - ${document.title}</title>
                    <meta charset="UTF-8">
                    ${printStyles}
                </head>
                <body>
                    ${document.querySelector('.receipt-container').outerHTML}
                </body>
                </html>
            `);

            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }

        // Auto focus and keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl + P for smart print
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                smartPrint();
            }
            // Ctrl + Shift + P for thermal print
            else if (e.ctrlKey && e.shiftKey && e.key === 'P') {
                e.preventDefault();
                printThermal();
            }
            // Escape to go back
            else if (e.key === 'Escape') {
                e.preventDefault();
                window.history.back();
            }
        });

        // Update button onclick
        document.addEventListener('DOMContentLoaded', function() {
            const printBtn = document.getElementById('print-btn');
            if (printBtn) {
                printBtn.onclick = function(e) {
                    e.preventDefault();
                    smartPrint();
                };
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
        //         smartPrint();
        //     }
        // });
    </script>
</body>

</html>
