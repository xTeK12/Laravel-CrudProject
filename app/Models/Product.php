<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;


    /**
     * @var string[]
     */
    protected $fillable = [
        'code',
        'ownerID',
        'name',
        'quantity',
        'price',
        'description',
    ];

    /**
     * @return HasOne
     */
    public function media():HasOne
    {
        return $this->hasOne(Media::class, 'product_id', 'id');
    }

}
