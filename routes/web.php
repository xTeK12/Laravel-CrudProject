<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Search product in dashboard
Route::get('/search', [ProductController::class, 'search'])->name('search');
//Search product in product/index
Route::get('/searchProduct', [ProductController::class, 'searchProduct'])->name('searchProduct');

Route:: resource('products', ProductController::class);
Route::get('products/index', [ProductController::class, 'index'])->middleware('role:admin, seller');
//Show products on dashboard
Route::get('/dashboard', [ProductController::class, 'dashboardProducts'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Order Routes
Route::get('/orders/index/{userId}', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
Route::delete('/orders/destroy/{orderId}', [OrderController::class, 'destroy'])->name('orders.destroy');

//Cart Routes
Route::get('/cart/index/{userId}', [CartController::class, 'index'])->name('cart.index');
Route::get('/buyProduct/{productId}', [CartController::class, 'buyProduct'])->name('cart.buyProduct');
Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store');
Route::delete('/cart/destroy/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::get('/cart/view/{productId}', [CartController::class, 'show'])->name('cart.show');
Route::get('/cart/edit/{productId}', [CartController::class, 'edit'])->name('cart.edit');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

//Wishlist Routes
Route::get('/wishlist/index/{userId}', [WishlistController::class, 'index'])->name('wishlist.index');
Route::get('wishlist/addProduct/{productId}', [WishlistController::class, 'productToWishlist'])->name('wishlist.addProduct');
Route::post('/wishlist/store', [WishlistController::class, 'storeAllProducts'])->name('wishlist.store');
Route::delete('/wishlist/destroy/{productId}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');


require __DIR__.'/auth.php';
