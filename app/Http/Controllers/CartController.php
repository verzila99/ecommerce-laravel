<?php

namespace App\Http\Controllers;

use App\Actions\CartActions\CartActions;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
  public function index(Request $request): Factory|View|Application
  {

    $items = CartActions::getCartItemsFromCookies();

    $productList = $items ? Product::whereIn('id', $items)->get() : [];

    return view('cart', compact('productList'));

  }

//
//  public function do(): void
//  {
//
//
//    $f = DB::table('smartphones')->get();
//
//    foreach ($f as $product) {
//      DB::table('product_prop')->insert([
//        ['product_id' => $product->product_id, 'prop_id' => 1, 'value' => $product->diagonal],
//        ['product_id' => $product->product_id, 'prop_id' => 2, 'value' => $product->memory],
//        ['product_id' => $product->product_id, 'prop_id' => 3, 'value' => $product->camera],
//      ]);
//
//    }
//
//
//  }


  public function getSumOfProducts(Request $request): bool|int|string
  {

    if (session()->get('sum')) {

      return session()->get('sum');

    }

    $items = CartActions::getCartItemsFromCookies();

    if ($items[0]) {

      return Product::whereIn('id', $items)->sum('price');

    }

    return 0;
  }


}
