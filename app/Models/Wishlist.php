<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Wishlist extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'product_id',
    ];

    /**
     * @return HasOne
     */
    public function ProductInfo():HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
