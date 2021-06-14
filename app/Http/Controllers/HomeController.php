<?php

namespace App\Http\Controllers;


use App\Models\Banner;
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
        $topSlider = Banner::where('location', 'top_slider')->orderBy('position')->get();
        $bottomSlider = Banner::where('location', 'bottom_slider')->orderBy('position')->get();

        return view('home', compact('categories','smartphones','smartwatches','topSlider','bottomSlider'));
    }


}
