<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductListController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/do', [CartController::class,"do"]);

Route::get('/', [HomeController::class,"index"])->name('home');

//Cart
Route::get('/cart', [CartController::class,"index"]);
Route::post('/api/addtocart/{Id}', [CartController::class, "cart"]);


//Order
Route::post('/order/confirmation', [OrderController::class,"orderConfirmationRequest"])->name('confirmation');
Route::post('/order/confirmed', [OrderController::class,"orderConfirmation"])->name('order-confirmed');
Route::get('/order/confirm', [OrderController::class, "getOrderConfirmationPage"])->name('getConfirmationPage');
Route::put('/order/updateStatus/', [OrderController::class, "updateStatus"])->middleware('admin')->name('orderUpdateStatus');
Route::get('/orders', [OrderController::class, "index"])->middleware('admin')->name('orders');

//Profile
Route::middleware(['auth'])->prefix('profile')->group(function () {
    Route::get('/', [UserController::class, "show"])->name('profile');
    Route::get('/edit', [UserController::class, "edit"])->name('edit');
    Route::put('/edit', [UserController::class, "update"])->name('update');
    Route::get('/orders', [UserController::class, "userOrders"])->name('userOrders');
});


//Favorites
Route::get('/favorites', [FavoritesController::class, "favorites"])->middleware('auth');
Route::patch('/addtofavorites', [FavoritesController::class, "addToFavorites"])
     ->middleware('authajax');
Route::delete('/addtofavorites/{category}/{productId}', [FavoritesController::class,
    "removeFromFavorites"])->middleware('authajax');


//Auth
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/logout', [UserController::class, 'logout']);


//Products
Route::middleware(['admin'])->prefix('product')->group(function () {
  Route::get('/create', [ProductController::class, "create"])->name('createProduct');
  Route::post('/create', [ProductController::class, "store"])->name('storeProduct');
  Route::delete('/{product_id}', [ProductController::class, "destroy"])->name('deleteProduct');
  Route::put('/update', [ProductController::class, "update"])->name('updateProduct');
  Route::get('/{category}/{product_id}/edit', [ProductController::class, "edit"])->name('editProduct');
});

Route::get('/{category}', [ProductListController::class,"index"]);
Route::get('/{category}/{productId}', [ProductController::class,"show"]);
