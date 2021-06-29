<?php

namespace App\Http\Controllers;

use App\Actions\CartActions\CartActions;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
  public function index(Request $request): Factory|View|Application
  {

    $items = CartActions::getCartItemsFromCookies();

    $productList = $items ? Product::whereIn('id', $items)->get() : [];

    return view('cart', compact('productList'));

  }


//  public function do(): void
//  {
//
//
//    $f = DB::table('products')->get();
//
//    foreach ($f as $product) {
//
//      $r = preg_replace('/спортивный ремешок/u','sport strap',$product->title);
//
//
//      DB::table('products')->where('id', $product->id)->update(['title'=>$r]);
//    }
//
//
//  }


  public function getSumOfProducts(): bool|int|string
  {

    if (session()->get('sum')) {

      return session()->get('sum');

    }

    $items = CartActions::getCartItemsFromCookies();

    if (isset($items[0])) {

      return Product::whereIn('id', $items)->sum('price');

    }

    return 0;
  }


}
