<?php

namespace App\Http\Controllers;



use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function show(Request $request, $category,$productId):
    \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $product = DB::table($category)->join('categories', $category . '.category_id', '=', 'categories.category_id')
            ->find($productId);

        $key = $category . '/' .$productId;

        $favoritesStatus = 0;

        if(Auth::check()){
            $checkingData = $category . ':' . $productId;
            $user = User::find(auth()->id());
            $favoritesStatus = str_contains($user->favorites,$checkingData) ?
                1 : 0;
        }

        if (!$request->session()->has($key)) {

            DB::table($category)
                ->where('id',$productId)
                ->update(['product_views'=> (int)$product->product_views + 1]);
            $request->session()->put($key, '1');
        }
        return view('product',compact(['product','favoritesStatus']));

    }


}
