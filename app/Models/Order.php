<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * @var string[]
     */
    protected $appends = [
        'total_order_price',
    ];

    /**
     * @return HasMany
     */
    public function orderDetails():HasMany
    {
        return $this->hasMany(Order_details::class, 'order_id', 'id');
    }


    /**
     * @return float|int
     */
    public function getTotalOrderPriceAttribute(): float|int
    {
        $total_price = 0;
        foreach ($this->orderDetails as $orderDetail){
            $total_price += $orderDetail->total_product_price;
        }
        return $total_price;
    }

}
