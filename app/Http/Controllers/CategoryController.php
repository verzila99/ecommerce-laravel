<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

  public static function getInputFieldsForSidebar($category): array
  {
    $propsOfCategory = Property::where('category_name', $category)->get();

    foreach ($propsOfCategory as $prop) {

      $props[$prop->name . '|' . $prop->name_ru] = DB::table('product_property')
                                                     ->where('property_id', $prop->id)
                                                     ->select(DB::raw('count(property_id) as count,value'))
                                                     ->groupBy('value')
                                                     ->orderBy('count', 'desc')
                                                     ->limit(20)
                                                     ->get();
    }

    $manufacturers = DB::table('products')->select(DB::raw('count(*) as count,manufacturer'))
                            ->where('category', $category)
                            ->groupBy('manufacturer')
                            ->orderBy('count', 'desc')
                            ->get();

    $props['manufacturer|Производители'] = $manufacturers;

    return array_reverse($props);
  }


  public static function getCategoriesForCatalog(): Collection
  {
    $categories = new Collection();
    $raw = [];
    $allCategories = Category::all();

    foreach ($allCategories as $key =>$category) {

      $categories[] = $category->category_name . ',' . $category->category_name_ru;

      $items = Product::where('category', $category->category_name)
                      ->select(DB::raw('count(*) as some_count,manufacturer'))
                      ->groupBy('manufacturer')
                      ->orderBy('some_count', 'desc')
                      ->limit(10)
                      ->get();

      $raw[$key] = $items;
    }

    return $categories->combine($raw);
  }

}
