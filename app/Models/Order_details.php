<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order_details extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
    ];

    /**
     * @var string[]
     */
    protected $appends = [
        'total_product_price',
    ];

    /**
     * @return HasOne
     */
    public function productDetails():HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    /**
     * @return float|int
     */
    public function getTotalProductPriceAttribute():float|int
    {
        return $this->productDetails->price * $this->quantity;
    }
}
