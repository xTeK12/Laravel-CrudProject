<?php

namespace App\Models;

use App\Http\Controllers\ProductController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Offer extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price'
    ];

    /**
     * @return HasOne
     */
    public function product():HasOne
    {
        return $this->hasOne(Product::class, 'id','product_id');
    }
}
