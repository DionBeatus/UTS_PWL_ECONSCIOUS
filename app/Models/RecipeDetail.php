<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipeDetail extends Model
{
    protected $fillable = [
        'recipe_id',
        'product_id',
        'quantity',
    ];

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}