<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {

        $items = is_array(explode(',', Cookie::get('cart')))
            ? explode(',', Cookie::get('cart'))
            : [Cookie::get('cart')];

        if ($items[0]) {
            $productList = new Collection();

            foreach ($items as $item) {

                $category = DB::table('products')->select('product_category')->where('product_id', $item)->get();

                $result = DB::table('products')->select($category[0]->product_category . '.*', 'products.product_id')
                            ->join($category[0]->product_category, 'products.product_id', '=', $category[0]
                                    ->product_category . '.product_id')
                            ->where($category[0]->product_category . '.product_id', $item)->get();

                $productList = $productList->concat($result);

            }

            return view('cart', compact('productList'));
        }

        $productList = [];
        return view('cart', compact('productList'));

    }
    public function getSumOfProducts(){

        $items = is_array(explode(',', Cookie::get('cart')))
            ? explode(',', Cookie::get('cart'))
            : [Cookie::get('cart')];

        if ($items[0]) {
            $productList = new Collection();

            foreach ($items as $item) {

                $category = DB::table('products')->select('product_category')->where('product_id', $item)->get();

                $result = DB::table('products')->select($category[0]->product_category . '.*', 'products.product_id')
                            ->join($category[0]->product_category, 'products.product_id', '=', $category[0]
                                    ->product_category . '.product_id')
                            ->where($category[0]->product_category . '.product_id', $item)->get();

                $productList = $productList->concat($result);
            }
            $productSum = $productList->sum('price');

            return json_encode($productSum, JSON_THROW_ON_ERROR);
        }


        return  0;
    }
}
