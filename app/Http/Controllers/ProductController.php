<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:products,code',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive', // Assuming status can be 'active' or 'inactive'
        ]);

        Product::create($validated);

        // Check if user wants to save and continue adding more products
        if ($request->has('save_and_continue')) {
            return redirect()->route('admin.products.create')
                ->with('success', 'Produk berhasil ditambahkan. Tambah produk lainnya.');
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:products,code,' . $product->id,
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive', // Assuming status can be 'active' or 'inactive'
        ]);

        $product->update($validated);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
    }
}
