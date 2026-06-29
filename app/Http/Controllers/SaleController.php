<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use App\Models\Recipe;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('details.product')->orderBy('sale_date', 'desc')->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::where('category', 'finished product')->get();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_date' => ['required', 'date'],
            'customer_name' => ['required'],
            'customer_email' => ['required', 'email'],
            'customer_phone' => ['required'],
            'products' => ['required', 'array'],
            'quantities' => ['required', 'array'],
        ]);

        foreach ($request->products as $index => $productId) {

            $product = Product::find($productId);
            $qty = (int) $request->quantities[$index];

            $recipe = Recipe::with('details.product')
                ->where('product_id', $productId)
                ->first();

            if (!$recipe) {
                return back()->withErrors([
                    'products' => 'Recipe untuk ' . $product->product_name . ' belum dibuat.'
                ])->withInput();
            }

            foreach ($recipe->details as $detail) {

                $required_qty = $detail->quantity * $qty;

                $stock = Stock::where('product_id', $detail->product_id)->first(); 

                if (
                    !$stock ||
                    $stock->quantity < $required_qty
                ) {
                    return back()->withErrors(['products' => 'Stok bahan ' . $detail->product->product_name . ' tidak mencukupi.'])->withInput();
                }
            }
        }

        $sale = Sale::create([
            'sale_date' => $request->sale_date,
            'user_id' => Auth::id(),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total' => 0
        ]);

        $total = 0;

        foreach ($request->products as $index => $productId) {

            $product = Product::find($productId);

            $qty = (int) $request->quantities[$index];
            $price = $product->selling_price;
            $subtotal = $qty * $price;

            SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $productId,
                'quantity' => $qty,
                'price' => $price,
                'subtotal' => $subtotal
            ]);

            $total += $subtotal;

            $this->updateRecipeMaterials($product->id, $qty, 'decrease');
        }

        $sale->update([
            'total' => $total
        ]);

        return redirect()->route('sales.index')->with('success', 'Data penjualan berhasil ditambahkan.');
    }

    public function show(int $id)
    {
        $sale = Sale::with('details.product')->findOrFail($id);
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $products = Product::where('category', 'finished product')->get();
        $sale->load('details');
        return view('sales.edit', compact('sale', 'products'));
    }

    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'sale_date' => ['required', 'date'],
            'customer_name' => ['required'],
            'customer_email' => ['required', 'email'],
            'customer_phone' => ['required'],
            'products' => ['required', 'array'],
            'quantities' => ['required', 'array'],
        ]);

        foreach ($sale->details as $detail) {

            $this->updateRecipeMaterials($detail->product_id, $detail->quantity, 'increase');
        }

        foreach ($request->products as $index => $productId) {

            $product = Product::find($productId);
            $qty = (int) $request->quantities[$index];

            $recipe = Recipe::with('details.product')->where('product_id', $productId)->first();

            if (!$recipe) {
                return back()->withErrors(['products' => 'Recipe untuk ' . $product->product_name . ' belum dibuat.'])->withInput();
            }

            foreach ($recipe->details as $detail) {

                $required_qty = $detail->quantity * $qty;

                $stock = Stock::where('product_id',$detail->product_id)->first();

                if (
                    !$stock ||
                    $stock->quantity < $required_qty
                ) {
                    return back()->withErrors(['products' => 'Stok bahan ' . $detail->product->product_name . ' tidak mencukupi.'
                    ])->withInput();
                }
            }
        }

        $sale->details()->delete();

        $sale->update([
            'user_id' => Auth::id(),
            'sale_date' => $request->sale_date,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total' => 0
        ]);

        $total = 0;

        foreach ($request->products as $index => $productId) {

            $product = Product::find($productId);

            $qty = (int) $request->quantities[$index];
            $price = $product->selling_price;
            $subtotal = $qty * $price;

            SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $productId,
                'quantity' => $qty,
                'price' => $price,
                'subtotal' => $subtotal
            ]);

            $total += $subtotal;

            $this->updateRecipeMaterials($product->id, $qty, 'decrease');
        }

        $sale->update([
            'total' => $total
        ]);

        return redirect()->route('sales.index')->with('success', 'Data penjualan berhasil diupdate.');
    }

    public function destroy(Sale $sale)
    {
        foreach ($sale->details as $detail) {

            $this->updateRecipeMaterials($detail->product_id, $detail->quantity, 'increase');
        }

        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Data penjualan berhasil dihapus.');
    }

    private function updateRecipeMaterials(int $product_id, int $sale_qty, string $type = 'decrease'): void
    {
        $recipe = Recipe::with('details')->where('product_id', $product_id)->first();

        if (!$recipe) {
            return;
        }

        foreach ($recipe->details as $detail) {

            $stock = Stock::where('product_id', $detail->product_id)->first();

            if (!$stock) {
                continue;
            }

            $usedQty = $detail->quantity * $sale_qty;

            if ($type == 'decrease') {
                $stock->quantity -= $usedQty;
            } else {
                $stock->quantity += $usedQty;
            }

            $stock->user_id = Auth::id();
            $stock->save();
        }
    }
}