<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
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

Route::get('/', [HomeController::class,"index"]);
Route::get('/cart', [CartController::class,"index"]);
Route::post('/api/addtocart/{id}', [CartController::class, "cart"]);
Route::get('/api/{category}', [ProductListController::class, "indexApi"]);
Route::get('/do', [ProductListController::class, "do"]);
Route::get('/{category}', [ProductListController::class,"index"]);
Route::get('/{category}/{product}', [ProductController::class,"show"]);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->get('/users/{user}', function (Request $request) {
    return $request->user();
});
