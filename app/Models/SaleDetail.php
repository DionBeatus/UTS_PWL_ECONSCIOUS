<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $fillable = [
        'sale_id',
        'user_id',
        'product_id',
        'quantity',
        'price',
        'subtotal'
    ];

    public function sale()
    {
        return $this->belongsTo(
            Sale::class
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }

    public function product()
    {
        return $this->belongsTo(
            Product::class
        );
    }
}