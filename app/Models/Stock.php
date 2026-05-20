<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    protected $fillable = [
        'user_id', 
        'product_id', 
        'quantity'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    
    public function getStatusAttribute(): string
    {
        if ($this->quantity <= 0) {
            return 'Habis';
        } elseif ($this->quantity <= 10) {
            return 'Menipis';
        }
            return 'Aman';
    }
}