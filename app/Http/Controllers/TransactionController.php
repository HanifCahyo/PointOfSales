<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // Filter berdasarkan periode waktu
        $filter = $request->get('filter', 'all');

        // Base query untuk kasir yang sedang login
        $query = Transaction::where('user_id', Auth::id());

        switch ($filter) {
            case 'today':
                $query->whereDate('created_at', today());
                break;
            case 'this_week':
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
                break;
            case 'this_month':
                $query->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year);
                break;
            case 'last_7_days':
                $query->whereBetween('created_at', [
                    Carbon::now()->subDays(7),
                    Carbon::now()
                ]);
                break;
            case 'last_30_days':
                $query->whereBetween('created_at', [
                    Carbon::now()->subDays(30),
                    Carbon::now()
                ]);
                break;
            // 'all' atau default - tampilkan semua transaksi kasir
        }

        // Hitung statistik sebelum pagination
        $totalTransactions = $query->count();
        $totalRevenue = $query->sum('total_amount');

        // Query untuk pagination dengan eager loading
        $transactions = $query->with(['user', 'details.product.category'])->latest()->paginate(10);

        // Append filter parameter to pagination links
        $transactions->appends(['filter' => $filter]);

        return view('kasir.transactions.index', compact('transactions', 'filter', 'totalTransactions', 'totalRevenue'));
    }

    public function create()
    {
        $products = Product::with('category')->where('status', 'active')->get();

        // Statistik hari ini untuk kasir yang sedang login
        $userId = Auth::id();
        $todayTransactions = Transaction::where('user_id', $userId)
            ->whereDate('created_at', today())
            ->count();
        $todayRevenue = Transaction::where('user_id', $userId)
            ->whereDate('created_at', today())
            ->sum('total_amount');

        return view('kasir.transactions.create', compact('products', 'todayTransactions', 'todayRevenue'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Validasi tambahan untuk memastikan produk yang dipilih berstatus active
        foreach ($request->products as $item) {
            $product = Product::find($item['id']);
            if ($product->status !== 'active') {
                return back()->withErrors(['error' => 'Produk ' . $product->name . ' tidak tersedia (inactive).']);
            }
        }

        DB::transaction(function () use ($request) {
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'invoice_no' => $this->generateInvoiceNumber(),
                'total_amount' => 0,
            ]);

            $total = 0;

            foreach ($request->products as $item) {
                $product = Product::find($item['id']);
                $subtotal = $product->price * $item['quantity'];

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                // Kurangi stok produk
                $product->decrement('stock', $item['quantity']);

                $total += $subtotal;
            }

            $transaction->update(['total_amount' => $total]);
        });

        return redirect()->route('kasir.transactions.index')->with('success', 'Transaction created successfully.');
    }

    public function invoice($trx)
    {
        $transaction = Transaction::with(['details.product', 'user'])->findOrFail($trx);
        return view('kasir.transactions.invoice', compact('transaction'));
    }

    public function receipt($trx)
    {
        $transaction = Transaction::with(['details.product', 'user'])->findOrFail($trx);
        return view('kasir.transactions.receipt', compact('transaction'));
    }

    private function generateInvoiceNumber()
    {
        $date = now()->format('Ymd');
        $lastTransaction = Transaction::whereDate('created_at', today())->latest()->first();

        if ($lastTransaction) {
            $lastNumber = (int) substr($lastTransaction->invoice_no, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return 'INV-' . $date . '-' . $newNumber;
    }
}
