<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PropertyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/cart/sum-of-products', [CartController::class, "getSumOfProducts"]);
Route::get('/cart/sum-of-order', [CartController::class, "getSumOfOrder"]);
Route::get('/search', [ProductController::class, "searchApi"]);
Route::get('/getPropsOfCategory/{category}', [PropertyController::class, "index"])->name('getPropsOfCategory');
Route::get('/{category}', [ProductController::class, "indexApi"]);
