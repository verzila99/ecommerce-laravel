<?php

namespace App\Models;

use App\Actions\SearchFilter\SearchFilter;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductListController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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


  public static function updateProductViews($product): void
  {
    $key = $product->category . '/' . $product->id;

    !session($key) ? self::where('id', $product->id)->update(['views' => (int)$product->views + 1]) : session([$key=>'1']);

  }


  public static function getProducts($request,$category=null,$properties=[])
  {
    $query = self::with(['properties','categories'])->when($category,function ($query,$category){

        return $query->where('category', $category);
    });

    $propertyValue = [];

    foreach ($properties as $property) {

      $name = $property->name;

      if ($request->has($name)) {

        foreach ($request->$name as $p) {

          $propertyValue[] = str_replace('   ', ' + ', $p);

        }
        $property_id = $property->id;

        $query = $query->whereHas('properties', function ($q) use ($propertyValue, $property_id) {

          $q->whereIn("value",  $propertyValue)->where('property_id', $property_id);

        });
      }
    }

      return SearchFilter::applyFilters($request, $query);

  }


  public static function validateUpdateProductRequest( $request): array
  {
    return Validator::make($request->except([
          $request->title === null ? 'title' : null,
          $request->price === null ? 'price' : null,
          $request->vendorcode === null ? 'vendorcode' : null,
          $request->manufacturer === null ? 'manufacturer' : null]),
          ['id'=>'required|numeric',
            'title' => 'string',
            'category' => 'string',
            'price' => 'sometimes|numeric',
            'manufacturer' => 'sometimes|string',
            'vendorcode' => 'sometimes|numeric',])->validate();
  }
}
