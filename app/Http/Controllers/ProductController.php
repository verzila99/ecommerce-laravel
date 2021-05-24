<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    //

    public function show(Request $request, $category, $productId):
    \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {

         Category::where('category_name',$category)->firstOrFail();



        $currentCategoryProps = Category::getPropsOfCategory($category);



        $props = $currentCategoryProps->toArray();


        $product = DB::table('products')
                     ->join('categories', 'products.product_category', '=', 'categories.category_name')
                     ->join($category, 'products.product_id', '=', $category . '.product_id')
                     ->where('products.product_id', $productId)->get();

        if (!$product) {

            abort(404);
        }

        $key = $category . '/' . $productId;

        $favoritesStatus = 0;

        if (Auth::check()) {
            $checkingData = $category . ':' . $productId;
            $user = User::find(auth()->id());
            $favoritesStatus = str_contains($user->favorites, $checkingData) ?
                1 : 0;
        }

        if (!$request->session()->has($key)) {

            DB::table($category)
              ->where('product_id', $productId)
              ->update(['product_views' => (int)$product[0]->product_views + 1]);
            $request->session()->put($key, '1');
        }

        $viewed = explode(',', Cookie::get('viewed'));

        is_array($viewed) ?: $viewed[0] = $viewed;

        count($viewed) > 5 ? array_shift($viewed) : $viewed;

        if (!in_array($productId, $viewed, true)) {

            Cookie::queue('viewed', implode(',', $viewed) . ',' . $productId, 100000);
        }

        return view('product', compact(['product', 'favoritesStatus', 'props']));

    }


}
