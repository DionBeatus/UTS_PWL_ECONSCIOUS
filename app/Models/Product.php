<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_name',
        'user_id',
        'category',
        'source_type',
        'unit',
        'selling_price'
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }
}