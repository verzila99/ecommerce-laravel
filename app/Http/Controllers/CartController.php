<?php

namespace App\Http\Controllers;

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

    if ($items[0]) {
      $productList = new Collection();

      foreach ($items as $item) {

        $category = DB::table('products')->select('product_category')->where('product_id', $item)->first();

        $result = DB::table('products')->select($category->product_category . '.*', 'products.product_id')->join($category->product_category, 'products.product_id', '=', $category->product_category . '.product_id')->where($category->product_category . '.product_id', $item)->get();

        $productList = $productList->concat($result);

      }

      return view('cart', compact('productList'));
    }

    $productList = [];

    return view('cart', compact('productList'));

  }


  public function do(): void
  {
    ini_set('memory_limit', '-1');
    set_time_limit(100000);
    $f = DB::table('smartwatches')->get();

    foreach ($f as $product) {



        $images = Collection::wrap(explode(',', $product->images));
        $path = 'public/uploads/images/';
        $pathApp = 'app/public/uploads/images/';
        $images->each(function ($image) use ($pathApp, $path, $product) {
          $imag = Storage::get('public/uploads' . '/' . $image);
          if (!Storage::exists('public/uploads/images/' . $product->product_id . '/full/' . $image)) {


            Storage::copy('public/uploads' . '/' . $image, 'public/uploads/images/' . $product->product_id . '/full/' . $image);
            $name = $image;

            if (!is_dir(storage_path($path . $product->product_id . '/700x700'))) {
              Storage::makeDirectory($path . $product->product_id . '/700x700');
            }
            if (!is_dir(storage_path($path . $product->product_id . '/225x225'))) {
              Storage::makeDirectory($path . $product->product_id . '/225x225');
            }
            if (!is_dir(storage_path($path . $product->product_id . '/45x45'))) {
              Storage::makeDirectory($path . $product->product_id . '/45x45');
            }

            Image::make($imag)->resize(700, 700, function ($constraint) {
              $constraint->aspectRatio();
              $constraint->upsize();
            })->save(storage_path($pathApp . $product->product_id . '/700x700/' . $name));

            Image::make($imag)->resize(225, 225, function ($constraint) {
              $constraint->aspectRatio();
              $constraint->upsize();
            })->save(storage_path($pathApp . $product->product_id . '/225x225/' . $name));

            Image::make($imag)->resize(45, 45, function ($constraint) {
              $constraint->aspectRatio();
              $constraint->upsize();

            })->save(storage_path($pathApp . $product->product_id . '/45x45/' . $name));
          }
        });

    }


  }


  public function getSumOfProducts(): bool|int|string
  {

    $items = is_array(explode(',', Cookie::get('cart'))) ? explode(',', Cookie::get('cart')) : [Cookie::get('cart')];

    if ($items[0]) {
      $productList = new Collection();

      foreach ($items as $item) {

        $category = DB::table('products')->select('product_category')->where('product_id', $item)->get();

        $result = DB::table('products')->select($category[0]->product_category . '.*', 'products.product_id')->join($category[0]->product_category, 'products.product_id', '=', $category[0]->product_category . '.product_id')->where($category[0]->product_category . '.product_id', $item)->get();

        $productList = $productList->concat($result);
      }
      $productSum = $productList->sum('price');

      return json_encode($productSum, JSON_THROW_ON_ERROR);
    }


    return 0;
  }


}
