<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('details.product')->latest()->paginate(10);
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $products = Product::where('source_type', 'purchase')->get();
        return view('purchases.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_date' => ['required', 'date'],
            'store_name' => ['required'],
            'shipping_cost' => ['nullable', 'integer'],
            'products' => ['required', 'array'],
            'quantities' => ['required', 'array'],
            'prices' => ['required', 'array'],
        ]);

        $purchase = Purchase::create([
            'purchase_date' => $request->purchase_date,
            'store_name' => $request->store_name,
            'user_id' => Auth::id(),
            'shipping_cost' => $request->shipping_cost ?? 0,
            'total' => 0
        ]);

        $total = 0;

        foreach ($request->products as $index => $productId) {
            $qty = (int) $request->quantities[$index];
            $price = (int) $request->prices[$index];
            $subtotal = $qty * $price;

            PurchaseDetail::create([
                'purchase_id' => $purchase->id,
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $qty,
                'price' => $price,
                'subtotal' => $subtotal
            ]);

            $total += $subtotal;

            $stock = Stock::firstOrCreate(
                ['product_id' => $productId],
                [
                    'user_id' => Auth::id(),
                    'quantity' => 0,
                ]
            );

            $stock->quantity += $qty;
            $stock->save();
        }

        $purchase->update([
            'total' => $total + ($request->shipping_cost ?? 0)
        ]);

        return redirect()->route('purchases.index')->with('success', 'Data pembelian berhasil ditambahkan.');
    }

    public function show(int $id)
    {
        $purchase = Purchase::with(['details.product', 'user'])->findOrFail($id);
        return view('purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        $products = Product::where('source_type', 'purchase')->get();
        $purchase->load('details');
        return view('purchases.edit', compact('purchase', 'products'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'purchase_date' => ['required', 'date'],
            'store_name' => ['required'],
            'shipping_cost' => ['nullable', 'integer'],
            'products' => ['required', 'array'],
            'quantities' => ['required', 'array'],
            'prices' => ['required', 'array'],
        ]);

        foreach ($purchase->details as $detail) {
            $stock = Stock::where('product_id', $detail->product_id)->first();
            if ($stock) {
                $stock->quantity -= $detail->quantity;
                $stock->save();
            }
        }

        $purchase->details()->delete();

        $purchase->update([
            'purchase_date' => $request->purchase_date,
            'store_name' => $request->store_name,
            'user_id' => Auth::id(),
            'shipping_cost' => $request->shipping_cost ?? 0,
            'total' => 0
        ]);

        $total = 0;

        foreach ($request->products as $index => $productId) {
            $qty = (int) $request->quantities[$index];
            $price = (int) $request->prices[$index];
            $subtotal = $qty * $price;

            PurchaseDetail::create([
                'purchase_id' => $purchase->id,
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $qty,
                'price' => $price,
                'subtotal' => $subtotal
            ]);

            $total += $subtotal;

            $stock = Stock::firstOrCreate(
                ['product_id' => $productId],
                [
                    'user_id' => Auth::id(),
                    'quantity' => 0,
                ]
            );

            $stock->quantity += $qty;
            $stock->save();
        }

        $purchase->update([
            'total' => $total + ($request->shipping_cost ?? 0)
        ]);

        return redirect()->route('purchases.index')->with('success', 'Data pembelian berhasil diupdate.');
    }

    public function destroy(Purchase $purchase)
    {
        foreach ($purchase->details as $detail) {
            $stock = Stock::where('product_id', $detail->product_id)->first();
            if ($stock) {
                $stock->quantity -= $detail->quantity;
                $stock->save();
            }
        }

        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Data pembelian berhasil dihapus.');
    }
}