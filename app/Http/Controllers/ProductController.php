<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function show(Request $request, $category, $product): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $productItem = DB::table($category)->find($product);
        $key = $category . '/' . $product;

        if (!$request->session()->has($key)) {

            DB::table($category)
                ->where('id',$product)
                ->update(['product_views'=> (int)$productItem->product_views + 1]);
            $request->session()->put($key, '1');
        }

        return view('product',compact(['productItem']));

    }


}
