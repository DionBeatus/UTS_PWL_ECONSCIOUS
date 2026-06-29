<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Recipe;
use App\Models\RecipeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with(['user', 'product', 'details'])->latest()->paginate(10);

        return view('recipes.index', compact('recipes'));
    }

    public function create()
    {
        $existingRecipeProductIds = Recipe::pluck('product_id')->toArray();

        $products = Product::where('category', 'finished product')->whereNotIn('id', $existingRecipeProductIds)->get();

        $materials = Product::where('category', '!=', 'finished product')->get();

        return view('recipes.create', compact('products', 'materials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required'],
            'products' => ['required', 'array'],
            'quantities' => ['required', 'array'],
        ]);

        $recipe = Recipe::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
        ]);

        foreach ($request->products as $index => $productId) {

            RecipeDetail::create([
                'recipe_id' => $recipe->id,
                'product_id' => $productId,
                'quantity' => $request->quantities[$index],
            ]);
        }

        return redirect()
            ->route('recipes.index')
            ->with('success', 'Data resep berhasil ditambahkan.');
    }

    public function edit(Recipe $recipe)
    {
        $recipe->load('details.product');

        $products = Product::where(
            'category',
            'finished product'
        )->get();

        $materials = Product::where('category', '!=', 'finished product')->get();

        return view(
            'recipes.edit',
            compact(
                'recipe',
                'products',
                'materials'
            )
        );
    }

    public function update(Request $request, Recipe $recipe)
    {
        $request->validate([
            'product_id' => ['required'],
            'products' => ['required', 'array'],
            'quantities' => ['required', 'array'],
        ]);

        $recipe->update([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
        ]);

        $recipe->details()->delete();

        foreach ($request->products as $index => $productId) {

            RecipeDetail::create([
                'recipe_id' => $recipe->id,
                'product_id' => $productId,
                'quantity' => $request->quantities[$index],
            ]);
        }

        return redirect()->route('recipes.index')->with('success', 'Data resep berhasil diperbarui.');
    }

    public function show(Recipe $recipe)
    {
        $recipe->load(['user', 'product', 'details.product']);

        return view('recipes.show', compact('recipe'));
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        return redirect()->route('recipes.index')->with('success', 'Data resep berhasil dihapus.');
    }
}
