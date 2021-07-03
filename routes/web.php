<?php

use App\Events\UserRegisteredEvent;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

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
Route::get('/cart', [CartController::class,"index"])->name('cart');

//Order
Route::post('/order/confirmation', [OrderController::class,"orderConfirmationRequest"])->name('confirmation');
Route::post('/order/confirmed', [OrderController::class, "store"])->name('order-confirmed');
Route::get('/order/confirm', [OrderController::class, "create"])->name('getConfirmationPage');
Route::put('/order/updateStatus', [OrderController::class, "updateStatus"])->middleware('admin')->name('orderUpdateStatus');
Route::delete('/order/delete', [OrderController::class, "destroy"])->middleware('admin')->name('orderDelete');
Route::get('/orders', [OrderController::class, "index"])->middleware('admin')->name('orders');


//News subscription
Route::post('/subscribe', [UserController::class, "subscribeForNews"])->name('subscribeForNews');


//Profile
Route::middleware(['verified'])->prefix('profile')->group(function () {
    Route::get('/', [UserController::class, "show"])->name('profile');
    Route::get('/edit', [UserController::class, "edit"])->name('edit');
    Route::put('/edit', [UserController::class, "update"])->name('update');
    Route::get('/order', [UserController::class, "userOrders"])->name('userOrders');
});

//Users
Route::middleware(['superAdmin'])->prefix('user')->group(
  function () {
    Route::get('/', [UserController::class, 'index'])->name('indexUser');
    Route::put('/updaterole', [UserController::class, 'updateRole'])->name('updateRole');
    Route::delete('/destroy', [UserController::class, 'destroy'])->name('userDelete');
  });

//Favorites
Route::middleware(['verified'])->group(
  function () {
Route::get('/favorites', [FavoritesController::class, "favorites"])->name('favorites');
Route::patch('/addtofavorites', [FavoritesController::class, "addToFavorites"]);
Route::delete('/removefromfavorites/', [FavoritesController::class, "removeFromFavorites"]);
  }
);

//Auth
//verify email
Route::get('/email/verify', function () {

  return view('auth.verify-email');

}
)->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}',[UserController::class,'verifyEmail'])
  ->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification',function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'Verification link sent!');
  }
  )->middleware(['auth', 'throttle:6,1'])->name('verification.send');
//forgot password
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
  }
  )->middleware('guest')->name('password.request');

Route::post('/forgot-password',[UserController::class,'resetPassword'])
  ->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}',function ($token) {
    return view('auth.reset-password', ['token' => $token]);
  }
)->middleware('guest')->name('password.reset');

Route::post(
  '/reset-password',[UserController::class,'updatePasswordAfterReset'])
     ->middleware('guest')->name('password.update');


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

Route::get('/{category}', [ProductController::class,"index"]);
Route::get('/{cat}/{productId}', [ProductController::class,"show"]);
