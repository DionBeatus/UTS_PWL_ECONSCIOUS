<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'sale_date',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'total',
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }

    public function details()
    {
        return $this->hasMany(
            SaleDetail::class
        );
    }
}