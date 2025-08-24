<?php

namespace App\Http\Controllers;

use App\Models\StockOpname;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockOpnameController extends Controller
{
    public function index()
    {
        $opnames = StockOpname::with('product', 'user')->latest()->get();
        return view('admin.stock-opnames.index', compact('opnames'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.stock-opnames.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'physical_stock' => 'required|integer|min:0',
            'note' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $systemStock = $product->stock;
        $physicalStock = $request->physical_stock;

        $difference = $physicalStock - $systemStock;

        StockOpname::create([
            'product_id' => $product->id,
            'system_stock' => $systemStock,
            'physical_stock' => $physicalStock,
            'difference' => $difference,
            'note' => $request->note,
            'created_by' => Auth::id(),
        ]);

        // Update stok produk berdasarkan hasil stock opname
        $product->stock = $physicalStock;
        $product->save();

        return redirect()->route('admin.stock-opnames.index')
            ->with('success', 'Stock opname berhasil dicatat dan stok produk terupdate.');
    }

}
