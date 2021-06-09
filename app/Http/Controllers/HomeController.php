<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $categories =Category::get();
        $smartphones = Product::where('category','smartphones')->inRandomOrder()->take(10)->get();
        $smartwatches = Product::where('category','smartwatches')->inRandomOrder()->take(10)->get();

        return view('home', compact('categories','smartphones','smartwatches'));
    }


}
