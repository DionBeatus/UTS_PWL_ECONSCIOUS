<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

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

            $recipes = [
                'EcoChain V1' => ['Paracord', 'Lonceng', 'Biji Lada', 'Carabiner O', 'EcoCharm', 'Packaging', 'Kantong Starch Singkong'],
                'EcoChain V2' => ['Paracord', 'Lonceng', 'Biji Lada', 'Carabiner Love', 'EcoCharm', 'Packaging', 'Kantong Starch Singkong'],
            ];

            if (isset($recipes[$product->product_name])) {

                foreach ($recipes[$product->product_name] as $materialName) {

                    $materialProduct = Product::where('product_name', $materialName)->first();

                    if ($materialProduct) {

                        $materialStock = Stock::where('product_id', $materialProduct->id)->first();

                        if (
                            !$materialStock ||
                            $materialStock->quantity <= 0 ||
                            $qty > $materialStock->quantity
                        ) {
                            return back()->withErrors([
                                'products' => 'Stok bahan ' . $materialName . ' untuk ' . $product->product_name . ' tidak mencukupi.'
                            ])->withInput();
                        }
                    }
                }
            } else {

                $stock = Stock::where('product_id', $productId)->first();

                if (
                    !$stock ||
                    $stock->quantity <= 0 ||
                    $qty > $stock->quantity
                ) {
                    return back()->withErrors([
                        'products' => 'Stok produk ' . $product->product_name . ' tidak mencukupi.'
                    ])->withInput();
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

            if (!in_array($product->product_name, ['EcoChain V1', 'EcoChain V2'])) {

                $stock = Stock::where('product_id', $productId)->first();

                if ($stock) {
                    $stock->quantity -= $qty;
                    $stock->user_id = Auth::id();
                    $stock->save();
                }
            }

            $this->updateEcochainMaterials($product->product_name, $qty, 'decrease');
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

            $stock = Stock::where('product_id', $detail->product_id)->first();

            if (
                $stock &&
                !in_array($detail->product->product_name, ['EcoChain V1', 'EcoChain V2'])
            ) {
                $stock->quantity += $detail->quantity;
                $stock->save();
            }

            $this->updateEcochainMaterials($detail->product->product_name, $detail->quantity, 'increase');
        }

        foreach ($request->products as $index => $productId) {

            $product = Product::find($productId);
            $qty = (int) $request->quantities[$index];

            $recipes = [
                'EcoChain V1' => ['Paracord', 'Lonceng', 'Biji Lada', 'Carabiner O', 'EcoCharm', 'Packaging', 'Kantong Starch Singkong'],
                'EcoChain V2' => ['Paracord', 'Lonceng', 'Biji Lada', 'Carabiner Love', 'EcoCharm', 'Packaging', 'Kantong Starch Singkong'],
            ];

            if (isset($recipes[$product->product_name])) {

                foreach ($recipes[$product->product_name] as $materialName) {

                    $materialProduct = Product::where('product_name', $materialName)->first();

                    if ($materialProduct) {

                        $materialStock = Stock::where('product_id', $materialProduct->id)->first();

                        if (
                            !$materialStock ||
                            $materialStock->quantity <= 0 ||
                            $qty > $materialStock->quantity
                        ) {
                            return back()->withErrors([
                                'products' => 'Stok bahan ' . $materialName . ' untuk ' . $product->product_name . ' tidak mencukupi.'
                            ])->withInput();
                        }
                    }
                }
            } else {

                $stock = Stock::where('product_id', $productId)->first();

                if (
                    !$stock ||
                    $stock->quantity <= 0 ||
                    $qty > $stock->quantity
                ) {
                    return back()->withErrors([
                        'products' => 'Stok produk ' . $product->product_name . ' tidak mencukupi.'
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

            if (!in_array($product->product_name, ['EcoChain V1', 'EcoChain V2'])) {

                $stock = Stock::where('product_id', $productId)->first();

                if ($stock) {
                    $stock->quantity -= $qty;
                    $stock->user_id = Auth::id();
                    $stock->save();
                }
            }

            $this->updateEcochainMaterials($product->product_name, $qty, 'decrease');
        }

        $sale->update([
            'total' => $total
        ]);

        return redirect()->route('sales.index')->with('success', 'Data penjualan berhasil diupdate.');
    }

    public function destroy(Sale $sale)
    {
        foreach ($sale->details as $detail) {

            $stock = Stock::where('product_id', $detail->product_id)->first();

            if (
                $stock &&
                !in_array($detail->product->product_name, ['EcoChain V1', 'EcoChain V2'])
            ) {
                $stock->quantity += $detail->quantity;
                $stock->save();
            }

            $this->updateEcochainMaterials($detail->product->product_name, $detail->quantity, 'increase');
        }

        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Data penjualan berhasil dihapus.');
    }

    private function updateEcochainMaterials(string $productName, int $qty, string $type = 'decrease'): void
    {
        $recipes = [
            'EcoChain V1' => ['Paracord', 'Lonceng', 'Biji Lada', 'Carabiner O', 'EcoCharm', 'Packaging', 'Kantong Starch Singkong'],
            'EcoChain V2' => ['Paracord', 'Lonceng', 'Biji Lada', 'Carabiner Love', 'EcoCharm', 'Packaging', 'Kantong Starch Singkong'],
        ];

        if (!isset($recipes[$productName])) {
            return;
        }

        foreach ($recipes[$productName] as $materialName) {

            $materialProduct = Product::where('product_name', $materialName)->first();

            if ($materialProduct) {

                $materialStock = Stock::where('product_id', $materialProduct->id)->first();

                if ($materialStock) {

                    if ($type == 'decrease') {
                        $materialStock->quantity -= $qty;
                    } else {
                        $materialStock->quantity += $qty;
                    }

                    $materialStock->save();
                }
            }
        }
    }
}