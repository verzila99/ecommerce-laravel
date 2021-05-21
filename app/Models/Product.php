<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    public $timestamps = false;
    protected $guarded=[];
    public static function getViewedProducts()
    {
       $viewedProducts = explode(',',Cookie::get('viewed'));

       return self::whereIn('product_id',$viewedProducts)->get()->reverse();
    }
}
