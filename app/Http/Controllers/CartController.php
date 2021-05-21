<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Smartphone;
use App\Models\Smartwatch;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(Request $request): Factory|View|Application
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

    public function do()
    {
            $h=664;
            $f = DB::table('smartwatches')
                   ->get();

        foreach($f as $k){
$i=$h++;

                    $g = explode(',', $k->images)[0];

                    Product::create(['product_image' => $g,
                        'product_id'=>$i,'product_category'=>'smartwatches','product_title'=>$k->title, 'product_price' =>
                            $k->price]);

                    Smartwatch::where('id', $k->id)->update(['product_id' => $i]);

            }


    }

    public function getSumOfProducts(): bool|int|string
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
            $productSum = $productList->sum('price');

            return json_encode($productSum, JSON_THROW_ON_ERROR);
        }


        return 0;
    }




}
