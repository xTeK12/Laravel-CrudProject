<?php

namespace App\Console\Commands;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Console\Command;

class CartToWishlist extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart:to_wishlist';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Products from cart are transformed into wishlist';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Cart::query()
            ->whereDate('created_at', now()->subDays(1))
            ->get()
            ->each(function ($cart) {
                $product = Product::where('id', $cart->product_id)->first();

                if ($product) {
                    $product->quantity += $cart->quantity;
                    $product->save();
                }

                $wishlistItem = Wishlist::where('user_id', $cart->user_id)
                    ->where('product_id', $cart->product_id)
                    ->first();

                if (!$wishlistItem) {
                    $wishlist = new Wishlist();
                    $wishlist->user_id = $cart->user_id;
                    $wishlist->product_id = $cart->product_id;
                    $wishlist->save();
                }

                $cart->delete();
            });

        $this->info('the products in the cart have been moved to the wishlist');
    }

}
