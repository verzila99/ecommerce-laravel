<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    //

    public function index($category, $product)
    {
        $productItem = DB::table($category)->find($product);
        return view('product',['productItem'=>$productItem] );
    }
}