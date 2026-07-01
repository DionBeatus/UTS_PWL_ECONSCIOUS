<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Production;
use App\Models\ProductionDetail;
use App\Models\Recipe;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductionController extends Controller
{
    public function index()
    {
        $productions = Production::with(['product', 'user', 'recipe', 'details.product'])->orderBy('production_date', 'desc')->paginate(10);

        return view('productions.index', compact('productions'));
    }

    public function create()
    {
        $products = Product::where('category', 'complement')->where('source_type', 'handmade')->orderBy('product_name')->get();

        return view('productions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'production_date' => ['required', 'date'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $recipe = Recipe::with('details.product')->where('product_id', $request->product_id)->first();

        if (!$recipe) {
            return back()->withErrors([
                'product_id' => 'Recipe belum dibuat.'
            ])->withInput();
        }

        foreach ($recipe->details as $detail) {

            $need = $detail->quantity * $request->quantity;

            $stock = Stock::where('product_id', $detail->product_id)->first();

            if (!$stock || $stock->quantity < $need) {
                return back()->withErrors([
                    'product_id' => 'Stok ' . $detail->product->product_name . ' tidak mencukupi.'
                ])->withInput();
            }
        }

        $production = Production::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'recipe_id' => $recipe->id,
            'production_date' => $request->production_date,
            'quantity' => $request->quantity,
        ]);

        foreach ($recipe->details as $detail) {

            $usedQty = $detail->quantity * $request->quantity;

            ProductionDetail::create([
                'production_id' => $production->id,
                'product_id' => $detail->product_id,
                'quantity' => $usedQty,
            ]);

            $stock = Stock::where('product_id', $detail->product_id)->first();

            $stock->quantity -= $usedQty;
            $stock->user_id = Auth::id();
            $stock->save();
        }

        $finishedStock = Stock::where('product_id', $request->product_id)->first();

        return redirect()->route('productions.index')->with('success', 'Data produksi berhasil ditambahkan.');
    }
    public function show(Production $production)
    {
        $production->load(['product', 'user', 'details.product']);

        return view('productions.show', compact('production'));
    }

    public function edit(Production $production)
    {
        $products = Product::where('category', 'complement')->where('source_type', 'handmade')->orderBy('product_name')->get();

        return view('productions.edit', compact('production', 'products'));
    }

    public function update(Request $request, Production $production)
    {
        $request->validate([
            'production_date' => ['required', 'date'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        foreach ($production->details as $detail) {

            $stock = Stock::where('product_id', $detail->product_id)->first();

            if ($stock) {
                $stock->quantity += $detail->quantity;
                $stock->user_id = Auth::id();
                $stock->save();
            }
        }

        $recipe = Recipe::with('details.product')->where('product_id', $request->product_id)->first();

        if (!$recipe) {
            return back()->withErrors([
                'product_id' => 'Recipe belum tersedia.'
            ])->withInput();
        }

        foreach ($recipe->details as $detail) {

            $need = $detail->quantity * $request->quantity;

            $stock = Stock::where('product_id', $detail->product_id)->first();

            if (!$stock || $stock->quantity < $need) {
                return back()->withErrors([
                    'product_id' => 'Stok ' . $detail->product->product_name . ' tidak mencukupi.'
                ])->withInput();
            }
        }

        $production->details()->delete();

        $production->update([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'recipe_id' => $recipe->id,
            'production_date' => $request->production_date,
            'quantity' => $request->quantity,
        ]);

        foreach ($recipe->details as $detail) {

            $usedQty = $detail->quantity * $request->quantity;

            ProductionDetail::create([
                'production_id' => $production->id,
                'product_id' => $detail->product_id,
                'quantity' => $usedQty,
            ]);

            $stock = Stock::where('product_id', $detail->product_id)->first();

            $stock->quantity -= $usedQty;
            $stock->user_id = Auth::id();
            $stock->save();
        }

        return redirect()->route('productions.index')->with('success', 'Data produksi berhasil diupdate.');
    }

    public function destroy(Production $production)
    {
        foreach ($production->details as $detail) {

            $stock = Stock::where('product_id', $detail->product_id)->first();

            if ($stock) {
                $stock->quantity += $detail->quantity;
                $stock->user_id = Auth::id();
                $stock->save();
            }
        }

        $production->delete();

        return redirect()->route('productions.index')->with('success', 'Data produksi berhasil dihapus.');
    }
}
