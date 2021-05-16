<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function do(){


        $tables = DB::table('products')->get();
        foreach($tables as $table){
            DB::table('smartwatches')->where('title', $table->product_title)->update(['product_id' =>
                $table->product_id]);


        }
        return 'ok';
    return view('cart');
    }
}
