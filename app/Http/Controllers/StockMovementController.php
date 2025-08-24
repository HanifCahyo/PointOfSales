<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockMovementController extends Controller
{
    public function index()
    {
        $movements = StockMovement::with(['product', 'user'])
            ->latest()
            ->get();

        return view('admin.stock-movements.index', compact('movements'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.stock-movements.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'movement_type' => 'required|in:IN,OUT',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:500',
        ], [
            'product_id.required' => 'Produk harus dipilih.',
            'product_id.exists' => 'Produk yang dipilih tidak valid.',
            'movement_type.required' => 'Tipe pergerakan harus dipilih.',
            'movement_type.in' => 'Tipe pergerakan harus IN atau OUT.',
            'quantity.required' => 'Kuantitas harus diisi.',
            'quantity.integer' => 'Kuantitas harus berupa angka.',
            'quantity.min' => 'Kuantitas minimal adalah 1.',
            'note.max' => 'Catatan maksimal 500 karakter.',
        ]);

        // 1. Validasi stok terlebih dahulu sebelum menyimpan
        $product = Product::findOrFail($request->product_id);

        if ($request->movement_type === 'OUT' && $product->stock < $request->quantity) {
            return back()
                ->withErrors(['quantity' => 'Stok tidak mencukupi. Stok tersedia: ' . number_format($product->stock)])
                ->withInput();
        }

        try {
            // 2. Simpan stock movement setelah validasi berhasil
            StockMovement::create([
                'product_id' => $request->product_id,
                'movement_type' => $request->movement_type,
                'quantity' => $request->quantity,
                'note' => $request->note,
                'created_by' => Auth::id(),
            ]);

            // 3. Update stok di products
            if ($request->movement_type === 'IN') {
                $product->stock += $request->quantity;
            } else {
                $product->stock -= $request->quantity;
            }

            $product->save();

            $message = $request->movement_type === 'IN'
                ? 'Stok berhasil ditambahkan sebanyak ' . number_format($request->quantity) . ' unit.'
                : 'Stok berhasil dikurangi sebanyak ' . number_format($request->quantity) . ' unit.';

            return redirect()
                ->route('admin.stock-movements.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'])
                ->withInput();
        }
    }

}
