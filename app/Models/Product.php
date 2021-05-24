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
    protected $primaryKey = 'product_id';

    public static function getViewedProducts()
    {
       $viewedProducts = explode(',',Cookie::get('viewed'));

       return self::whereIn('product_id',$viewedProducts)->get()->reverse();
    }

    public function orders(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Order::class,'order_product','product_id','order_id')->withPivot('quantity');
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class,'category_name','product_category');
    }
}
