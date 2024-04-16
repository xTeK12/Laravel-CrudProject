<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWishlistRequest;
use App\Http\Requests\UpdateWishlistRequest;
use App\Models\Product;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($userId)
    {
        $wishlistProducts = Wishlist::query()->where('user_id', $userId)->get();
        return view('wishlist.index',compact('wishlistProducts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function productToWishlist($productId)
    {
        if(!Wishlist::where('product_id', $productId)->exists()) {

        $wishlist = new Wishlist();
        $wishlist->product_id = $productId;
        $wishlist->user_id = auth()->id();
        $wishlist->save();
        return redirect()->route('wishlist.index', auth()->id())
            ->withSuccess('New product in wishlist is added successfully');
        }else {
            return back()->withErrors(['msg' => 'This product exists once in wishlist']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($productId)
    {
        $productDelete = Wishlist::query()->where('product_id', $productId);
        $productDelete->delete();
        return redirect()->route('wishlist.index', auth()->id())
            ->withSuccess('Product from wishlist is removed successfully');
    }
}
