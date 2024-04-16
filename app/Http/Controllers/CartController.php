<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\cart;
use App\Models\Order;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($userId)
    {
        $cartProducts = Cart::query()->where('user_id', $userId)->get();
        $total_price = 0;
        foreach ($cartProducts as $cartProduct)
        {
            $total_price += $cartProduct->total_price;
        }
        return view('cart.index', compact('cartProducts', 'total_price'));
    }

    public function buyProduct($productId)
    {
        $product = Product::where('id',$productId)->first();
        return view('cart.create', ['product' => $product]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {
        $productId = $request->productId;
        $product = Product::where('id', $productId)->first();
        $quantity = $request->quantity;


        $existingCart = Cart::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if ($existingCart) {
            $existingCart->quantity += $quantity;
            $existingCart->save();

            $product->quantity -= $quantity;
            $product->save();

            return redirect()->route('cart.index', auth()->id())
                ->withSuccess('New quantity in cart is added successfully');
        } else {
            $newCart = new Cart();
            $newCart->user_id = auth()->id();
            $newCart->product_id = $productId;
            $newCart->quantity = $quantity;
            $newCart->save();

            $product->quantity -= $quantity;
            $product->save();

            return redirect()->route('cart.index', auth()->id())
                ->withSuccess('New product in cart is added successfully');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($productId)
    {
        $cartProduct = Cart::find($productId);
        return view('cart.show',compact('cartProduct'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($cartId)
    {
        $cartProduct = Cart::find($cartId);
        return view('cart.edit', compact('cartProduct'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request)
    {
        $cart = Cart::where('product_id', $request->productId)
            ->where('user_id', auth()->id())
            ->first();

        if (!$cart) {
            return redirect()->back()->withErrors('Cart item not found.');
        }

        $oldQuantity = $cart->quantity;
        $newQuantity = $request->quantity;
        $quantityDifference = $newQuantity - $oldQuantity;

        $cart->quantity = $newQuantity;
        $cart->save();

        $product = Product::find($request->productId);
        if ($product) {
            $product->quantity -= $quantityDifference;
            $product->save();
        }

        return redirect()->route('cart.index', auth()->id())
            ->withSuccess('Cart updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */

    public function destroy($cartId)
    {
        $cart = Cart::find($cartId);


        if (!$cart) {
            return redirect()->route('cart.index', auth()->id())->withErrors('Cart item not found.');
        }

        $quantityToRemove = $cart->quantity;

        $cart->delete();

        $product = Product::find($cart->product_id);
        if ($product) {
            $product->quantity += $quantityToRemove;
            $product->save();
        }

        return redirect()->route('cart.index', auth()->id())->withSuccess('Product is deleted successfully from cart');
    }

}
