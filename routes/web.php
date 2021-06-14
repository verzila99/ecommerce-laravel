<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\BannerController;
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

Route::get('/do', [CartController::class,"do"]);

Route::get('/', [HomeController::class,"index"])->name('home');

//search
Route::get('/search', [ProductController::class, "search"])->name('search');


//Cart
Route::get('/cart', [CartController::class,"index"]);
Route::post('/api/addtocart/{Id}', [CartController::class, "cart"]);


//Order
Route::post('/order/confirmation', [OrderController::class,"orderConfirmationRequest"])->name('confirmation');
Route::post('/order/confirmed', [OrderController::class, "store"])->name('order-confirmed');
Route::get('/order/confirm', [OrderController::class, "create"])->name('getConfirmationPage');
Route::put('/order/updateStatus/', [OrderController::class, "updateStatus"])->middleware('admin')->name('orderUpdateStatus');
Route::get('/orders', [OrderController::class, "index"])->middleware('admin')->name('orders');


//News subscription
Route::post('/subscribe', [UserController::class, "subscribeForNews"])->name('subscribeForNews');


//Profile
Route::middleware(['auth'])->prefix('profile')->group(function () {
    Route::get('/', [UserController::class, "show"])->name('profile');
    Route::get('/edit', [UserController::class, "edit"])->name('edit');
    Route::put('/edit', [UserController::class, "update"])->name('update');
    Route::get('/orders', [UserController::class, "userOrders"])->name('userOrders');
});


//Favorites
Route::get('/favorites', [FavoritesController::class, "favorites"])->middleware('auth')->name('favorites');
Route::patch('/addtofavorites', [FavoritesController::class, "addToFavorites"])
     ->middleware('authajax');
Route::delete('/removefromfavorites/', [FavoritesController::class,
    "removeFromFavorites"])->middleware('authajax');


//Auth
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/logout', [UserController::class, 'logout']);

//Banners

Route::middleware(['admin'])->prefix('banner')->group(function (){
  Route::get('/', [BannerController::class,'index'])->name('indexBanner');
  Route::get('/create', [BannerController::class,'create'])->name('createBanner');
  Route::get('/edit/{id}', [BannerController::class,'edit'])->name('editBanner');
  Route::put('/update', [BannerController::class,'update'])->name('updateBanner');
  Route::post('/store', [BannerController::class,'store'])->name('storeBanner');
  Route::delete('/destroy', [BannerController::class,'destroy'])->name('deleteBanner');
});

//Products
Route::middleware(['admin'])->prefix('product')->group(function () {
  Route::get('/create', [ProductController::class, "create"])->name('createProduct');
  Route::post('/create', [ProductController::class, "store"])->name('storeProduct');
  Route::delete('/delete', [ProductController::class, "destroy"])->name('deleteProduct');
  Route::put('/update', [ProductController::class, "update"])->name('updateProduct');
  Route::get('/{category}/{id}/edit', [ProductController::class, "edit"])->name('editProduct');
});

Route::get('/{category}', [ProductListController::class,"index"]);
Route::get('/{cat}/{productId}', [ProductController::class,"show"]);
