<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $fillable = [
        'purchase_id',
        'product_id',
        'user_id',
        'quantity',
        'price',
        'subtotal'
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }
    
    public function purchase()
    {
        return $this->belongsTo(
            Purchase::class
        );
    }

    public function product()
    {
        return $this->belongsTo(
            Product::class
        );
    }
}