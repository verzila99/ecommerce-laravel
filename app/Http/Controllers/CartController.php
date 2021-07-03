<?php

namespace App\Http\Controllers;

use App\Actions\CartActions\CartActions;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(Request $request): Factory|View|Application
    {
        $items = CartActions::getCartItemsFromCookies();

        $productList = $items ? Product::whereIn('id', $items)->get() : [];

        return view('cart', compact('productList'));
    }


    public function do(): void
    {
        $f = DB::table('product_property')->get();

        foreach ($f as $product) {

            if (DB::table('product_property')->where(
                    [
                        'property_id' => $product->property_id,
                        'product_id'  => $product->product_id,
                        'value'       => $product->value
                    ]
                )->count() > 1) {

                $first = DB::table('product_property')->where(
                    [
                        'property_id' => $product->property_id,
                        'product_id'  => $product->product_id,
                        'value'       => $product->value
                    ]
                )->first();
                DB::table('product_property')->where(
                    [
                        'property_id' => $product->property_id,
                        'product_id'  => $product->product_id,
                        'value'       => $product->value
                    ]
                )->delete();

                DB::table('product_property')->insert(
                    [
                        'property_id' => $first->property_id,
                        'product_id'  => $first->product_id,
                        'value'       => $first->value
                    ]
                );
            }
        }
    }


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
