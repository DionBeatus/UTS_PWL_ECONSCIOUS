<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('stock', 'user')->orderBy('id', 'desc')->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string'],
            'source_type' => ['required', 'in:purchase,handmade,donation'],
            'unit' => ['required', 'string'],
            'selling_price' => ['present', 'numeric', 'min:0'],
        ]);

        $product = Product::create([
            'user_id' => Auth::id(),
            'product_name' => $validated['name'],
            'category' => $validated['category'],
            'source_type' => $validated['source_type'],
            'unit' => $validated['unit'],
            'selling_price' => $validated['selling_price'],
        ]);

        if (strtolower(trim($validated['category'])) != 'finished product') {
            Stock::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => 0,
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Data produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
    
        $validated = $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string'],
            'source_type' => ['required', 'in:purchase,handmade,donation'],
            'unit' => ['required', 'string'],
            'selling_price' => ['present', 'numeric', 'min:0'],
        ]);

        $product->update([
            'user_id' => Auth::id(),
            'product_name' => $validated['product_name'],
            'category' => $validated['category'],
            'source_type' => $validated['source_type'],
            'unit' => $validated['unit'],
            'selling_price' => $validated['selling_price'],
        ]);

        return redirect()->route('products.index')->with('success', 'Data produk berhasil diupdate.');
    }

    public function destroy(Product $product)
    {
        Stock::where('product_id', $product->id)->delete();

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Data produk berhasil dihapus.');
    }
}