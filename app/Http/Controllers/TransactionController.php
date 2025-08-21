<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;

use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index()
    {
        return view('transactions.index', [
            'transactions' => Transaction::with('items.product')->get(),
            'products' => Product::all()
        ]);
    }

    public function store(Request $request)
    {
        $invoice = 'INV-' . time();
        $total = 0;

        // Filter produk yang memiliki qty > 0
        $validProducts = collect($request->products)->filter(function ($p) {
            return isset($p['qty']) && $p['qty'] > 0;
        });

        // Cek apakah ada produk yang valid
        if ($validProducts->isEmpty()) {
            return redirect()->back()->with('error', 'Pilih minimal satu produk dengan qty > 0');
        }

        $transaction = Transaction::create([
            'invoice_number' => $invoice,
            'date' => now(),
            'total_price' => 0,
        ]);

        foreach ($validProducts as $p) {
            $product = Product::find($p['id']);

            // Validasi stok
            if ($product->stock < $p['qty']) {
                $transaction->delete(); // Hapus transaksi jika stok tidak cukup
                return redirect()->back()->with('error', "Stok {$product->name} tidak mencukupi");
            }

            $subtotal = $product->price * $p['qty'];

            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'qty' => $p['qty'],
                'price' => $product->price,
            ]);

            // Kurangi stok
            $product->decrement('stock', $p['qty']);
            $total += $subtotal;
        }

        $transaction->update([
            'total_price' => $total
        ]);

        return redirect()->route('transactions.invoice', $transaction->id);
    }

    public function invoice($id)
    {
        $transaction = Transaction::with('items.product')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.invoice', compact('transaction'))->setPaper('a5', 'portrait');

        return $pdf->stream("invoice-{$transaction->invoice_number}.pdf");
    }
}
