<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CartController extends Controller
{
  public function index(Request $request): Factory|View|Application
  {

    $items = is_array(explode(',', Cookie::get('cart'))) ? explode(',', Cookie::get('cart')) : [Cookie::get('cart')];

    $items = array_filter($items, static function ($item){
      return is_numeric($item);
    });

      $productList = $items ? Product::whereIn('id',$items)->get(): [];

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


  public function getSumOfProducts(): bool|int|string
  {

    $items = is_array(explode(',', Cookie::get('cart'))) ? explode(',', Cookie::get('cart')) : [Cookie::get('cart')];

    if ($items[0]) {

      return Product::whereIn('id',$items)->sum('price');

    }

    return 0;
  }


}
