<?php

namespace App\Models;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductListController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
  use HasFactory;

  protected $table = 'products';
  public $timestamps = false;
  protected $guarded = [];
  protected $primaryKey = 'product_id';


  public static function getViewedProducts()
  {
    $viewedProducts = explode(',', Cookie::get('viewed'));

    return self::whereIn('product_id', $viewedProducts)->get()->reverse();
  }


  public function orders(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')->withPivot('quantity');
  }


  public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(Category::class, 'category_name', 'product_category');
  }


  public static function getProducts($request, $category)
  {

    [$manufacturer, $priceFrom, $priceTo, $sortBy] = ProductListController::handleRequest($request);


    $queryModel = DB::table($category)
                    ->join('categories', $category . '.category_id', '=', 'categories.category_id')
                    ->select($category . '.*', 'categories.*');

    $propsOfCategory = CategoryController::getPropsOfCategory($category);
    $propValue = [];
    foreach ($propsOfCategory->pluck('name') as $prop) {

      if ($request->has($prop)) {
        foreach ($request->$prop as $p) {
          $propValue[] = str_replace('   ', ' + ', $p);
        }

        $queryModel = $queryModel->when($propValue,
          function ($query, $propValue) use ($prop) {
            return $query->whereIn($prop, $propValue);
          });


      }
    }
    $queryModel = $queryModel
      ->when($manufacturer,
        function ($query, $manufacturer) {
          return $query->whereIn('manufacturer', $manufacturer);
        })
      ->when($priceFrom,
        function ($query, $priceFrom) {
          return $query->where('price', '>', $priceFrom);
        })->when($priceTo,
        function ($query, $priceTo) {
          return $query->where('price', '<', $priceTo);
        })->when($sortBy,
        function ($query, $sortBy) {
          if ($sortBy === 'popularity') {
            return $query->orderBy('product_views', 'desc');
          }
          if ($sortBy === 'price') {
            return $query->orderBy('price', 'asc');
          }
          if ($sortBy === '-price') {
            return $query->orderBy('price', 'desc');
          }
          if ($sortBy === 'created_at') {
            return $query->orderBy('created_at', 'desc');
          }

          return null;

        },
        function ($query) {
          return $query->orderBy('product_views', 'desc');
        });

    return $queryModel;
  }
}
