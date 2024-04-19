<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OfferController;
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
// Sort products by category
Route::get('/sortCategory', [ProductController::class, 'sortCategory'])->name('sortCategory');

Route:: resource('products', ProductController::class);
Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware(\App\Http\Middleware\ProductsIndex::class);
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware(\App\Http\Middleware\ProductsIndex::class);
Route::get('products/create', [ProductController::class, 'create'])->name('products.create')->middleware(\App\Http\Middleware\ProductsIndex::class);
//Show products on dashboard
Route::get('/dashboard', [ProductController::class, 'dashboardProducts'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Order Routes
Route::get('/orders/index/{userId}', [OrderController::class, 'index'])->name('orders.index')->middleware(\App\Http\Middleware\OnlyCurrentUser::class);;
Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
Route::delete('/orders/destroy/{orderId}', [OrderController::class, 'destroy'])->name('orders.destroy');

//Cart Routes
Route::get('/cart/index/{userId}', [CartController::class, 'index'])->name('cart.index')->middleware(\App\Http\Middleware\OnlyCurrentUser::class);
Route::get('/buyProduct/{productId}', [CartController::class, 'buyProduct'])->name('cart.buyProduct');
Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store');
Route::delete('/cart/destroy/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::get('/cart/view/{productId}', [CartController::class, 'show'])->name('cart.show')->middleware(\App\Http\Middleware\OnlyCurrentUser::class);
Route::get('/cart/edit/{productId}', [CartController::class, 'edit'])->name('cart.edit')->middleware(\App\Http\Middleware\OnlyCurrentUser::class);
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

//Wishlist Routes
Route::get('/wishlist/index/{userId}', [WishlistController::class, 'index'])->name('wishlist.index')->middleware(\App\Http\Middleware\OnlyCurrentUser::class);
Route::get('wishlist/addProduct/{productId}', [WishlistController::class, 'productToWishlist'])->name('wishlist.addProduct');
Route::post('/wishlist/store', [WishlistController::class, 'storeAllProducts'])->name('wishlist.store');
Route::delete('/wishlist/destroy/{productId}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

//Offer Routes
Route::get('/offers', [OfferController::class, 'indexOffer'])->name('offer.index');
Route::get('/offer/{productId}', [OfferController::class, 'createOffer'])->name('offer.create');
Route::post('/offer/store', [OfferController::class, 'storeOffer'])->name('offer.store');
Route::delete('/offer/delete/{offerId}', [OfferController::class, 'deleteOffer'])->name('offer.destroy');
Route::post('offer/accept/{offerId}', [OfferController::class, 'acceptOffer'])->name('offer.accept');

//Categories Routes
Route::get('/category/index', [CategoryController::class, 'indexCategory'])->name('category.index')->middleware(\App\Http\Middleware\CheckAdminRole::class);
Route::get('/category/create', [CategoryController::class, 'createCategory'])->name('category.create')->middleware(\App\Http\Middleware\CheckAdminRole::class);
Route::get('category/edit/{categoryId}', [CategoryController::class, 'editCategory'])->name('category.edit')->middleware(\App\Http\Middleware\CheckAdminRole::class);
Route::post('/category/update', [CategoryController::class, 'updateCategory'])->name('category.update');
Route::post('/category/store', [CategoryController::class, 'storeCategory'])->name('category.store');
Route::delete('/category/destroy{categoryId}', [CategoryController::class, 'deleteCategory'])->name('category.destroy');

require __DIR__.'/auth.php';
