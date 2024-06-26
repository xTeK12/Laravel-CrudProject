<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    /**
     * @param $userId
     * @return Application|Factory|View|\Illuminate\Foundation\Application
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

    /**
     * @param $productId
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function buyProduct($productId)
    {
        $product = Product::where('id',$productId)->first();
        return view('cart.create', ['product' => $product]);
    }

    /**
     * @param StoreCartRequest $request
     * @return mixed
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
     * @param $productId
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show($productId)
    {
        $cartProduct = Cart::find($productId);
        return view('cart.show',compact('cartProduct'));
    }

    /**
     * @param $cartId
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function edit($cartId)
    {
        $cartProduct = Cart::find($cartId);
        return view('cart.edit', compact('cartProduct'));
    }

    /**
     * @param UpdateCartRequest $request
     * @return RedirectResponse
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
     * @param $cartId
     * @return RedirectResponse
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
