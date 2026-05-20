<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('stock', 'user')->where('user_id', Auth::id())->orderBy('id', 'desc')->paginate(10);

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
            'source_type' => ['required', 'in:purchase,handmade'],
            'unit' => ['required', 'string'],
            'selling_price' => ['required', 'integer'],
        ]);

        Product::create([
            'user_id' => Auth::id(),
            'product_name' => $validated['name'],
            'category' => $validated['category'],
            'source_type' => $validated['source_type'],
            'unit' => $validated['unit'],
            'selling_price' => $validated['selling_price'],
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Data produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        if ($product->user_id != Auth::id()) {
            abort(403);
        }

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->user_id != Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string'],
            'source_type' => ['required', 'in:purchase,handmade'],
            'unit' => ['required', 'string'],
            'selling_price' => ['required', 'integer'],
        ]);

        $product->update([
            'product_name' => $validated['product_name'],
            'category' => $validated['category'],
            'source_type' => $validated['source_type'],
            'unit' => $validated['unit'],
            'selling_price' => $validated['selling_price'],
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Data produk berhasil diupdate.');
    }

    public function destroy(Product $product)
    {
        if ($product->user_id != Auth::id()) {
            abort(403);
        }

        if ($product->stock) {
            $product->stock->delete();
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Data produk berhasil dihapus.');
    }
}