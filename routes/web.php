<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\UserController;
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
Route::middleware('auth:sanctum')->get('/users/{user}', function (Request $request) {
    return $request->user();
});
Route::get('/', [HomeController::class,"index"]);
Route::get('/cart', [CartController::class,"index"]);


Route::get('/favorites', [UserController::class, "favorites"])->middleware('auth');
Route::get('/admin', [AdminController::class,"index"])->middleware('admin');

Route::patch('/addtofavorites', [UserController::class,"addToFavorites"])
    ->middleware('authajax');
Route::delete('/addtofavorites/{category}/{productId}', [UserController::class,
    "removeFromFavorites"])->middleware('authajax');

Route::post('/api/addtocart/{Id}', [CartController::class, "cart"]);
Route::get('/api/{category}', [ProductListController::class, "indexApi"]);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);
Route::get('/{category}', [ProductListController::class,"index"]);
Route::get('/{category}/{productId}', [ProductController::class,"show"]);
