<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductListController extends Controller
{
    //
    public function index($category)
    {

        $currentCategory =Category::where('name', $category)->first();
        $productList = DB::table($category)->inRandomOrder()->take(10)->get();


        return view('productList', ['productList' => $productList,'currentCategory' => $currentCategory]);
    }
}