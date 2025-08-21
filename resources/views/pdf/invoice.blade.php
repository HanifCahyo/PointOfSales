<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h3>Nota Pembelian</h3>
    <p>No: {{ $transaction->invoice_number }}</p>
    <p>Tanggal: {{ $transaction->date }}</p>

    <table>
        <thead>
            <tr>
                <th>Barang</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ number_format($item->price) }}</td>
                    <td>{{ number_format($item->qty * $item->price) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Total: Rp {{ number_format($transaction->total_price) }}</h4>
</body>

</html>
