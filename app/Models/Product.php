<?php

namespace App\Models;

use App\Actions\SearchFilter\SearchFilter;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductListController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
  use HasFactory;

  protected $guarded = [];


  public function properties(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany(Property::class, 'product_property')->withPivot('value');
  }


  public function orders(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany(Order::class)->withPivot('quantity');
  }


  public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(Category::class, 'category_id', 'id');
  }


  public static function getViewedProducts()
  {
    $viewedProducts = explode(',', Cookie::get('viewed'));

    return self::whereIn('id', $viewedProducts)->get()->reverse();
  }


  public static function getProducts($request, $properties, $category)
  {
    $query = self::with(['properties','categories'])->where('category', $category);
//                 ->join('product_property','products.id','=','product_property.product_id');

    $propertyValue = [];
    foreach ($properties as $property) {
      $name = $property->name;

      if ($request->has($name)) {

        foreach ($request->$name as $p) {

          $propertyValue[] = str_replace('   ', ' + ', $p);

        }

        $query = $query->whereHas('properties', function ($q) use ($propertyValue) {
          $q->whereIn("value",  $propertyValue);
//        $query = $query->whereIn('product_property.value', $propertyValue);

        });
      }
    }

      return SearchFilter::applyFilters($request, $query);

  }
}
