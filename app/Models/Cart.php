<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cart extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity'
    ];

    /**
     * @var string[]
     */
    protected $appends = [
        'total_price',
    ];

    /**
     * @return HasOne
     */
    public function product():HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    /**
     * @return float|int
     */
    public function getTotalPriceAttribute(): float|int
    {
        return $this->product->price * $this->quantity;
    }
}
