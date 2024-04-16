<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
//        $product =
//        $maxQuantity = $product->quantity;
        return [
//            'quantity' => "required|integer|min:1|max:$maxQuantity",
        ];
    }
}
