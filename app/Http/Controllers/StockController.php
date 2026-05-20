<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = Stock::with(['product', 'user']);

        if ($request->filled('search')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('product_name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('category', $request->category);
            });
        }

        $stocks = $query->latest()->paginate(10)->withQueryString();

        if ($request->filled('status')) {
            $filteredItems = $stocks->getCollection()->filter(function ($stock) use ($request) {
                return strtolower($stock->status) === strtolower($request->status);
            });
            $stocks->setCollection($filteredItems);
        }

        $categories = Product::select('category')->whereNotNull('category')->distinct()->pluck('category');

        return view('stocks.index', compact('stocks', 'categories'));
    }

    public function create()
    {
        $existingProductIds = Stock::pluck('product_id')->toArray();
        $products = Product::whereNotIn('id', $existingProductIds)->get();
        return view('stocks.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id|unique:stocks,product_id',
            'quantity' => 'required|integer|min:0',
        ], [
            'product_id.unique' => 'Stok untuk produk ini sudah terdaftar, silakan gunakan menu edit.'
        ]);

        Stock::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('stocks.index')->with('success', 'Data stok berhasil ditambahkan.');
    }

    public function edit(Stock $stock)
    {
        return view('stocks.edit', compact('stock'));
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $stock->update([
            'user_id' => Auth::id(),
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('stocks.index')->with('success', 'Data stok berhasil diperbarui.');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stocks.index')->with('success', 'Data stok berhasil dihapus.');
    }
}