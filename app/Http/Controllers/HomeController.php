<?php

namespace App\Http\Controllers;


use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $categories =Category::get();
        $smartphones = DB::table('smartphones')->inRandomOrder()->take(10)->get();
        $smartwatches = DB::table('smartwatches')->inRandomOrder()->take(10)->get();

        return view('home', ['categories' => $categories,'smartphones' => $smartphones,'smartwatches' => $smartwatches]);
    }
}