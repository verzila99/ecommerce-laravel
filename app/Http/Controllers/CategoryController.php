<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{


  public static function getPropsOfCategory($category): Collection
  {
    return DB::table('categories')->join('props_of_category', 'props_of_category.category_id', '=', 'categories.category_id')->where('categories.category_name', $category)->get();

  }

  public static function getInputFieldsForSidebar($category): array
  {
    $propsOfCategory = self::getPropsOfCategory($category);

    foreach ($propsOfCategory as $prop) {

      $props[$prop->name . '|' . $prop->name_ru] = DB::table($category)
                                                     ->select(DB::raw('count(*) as some_count,' . $prop->name))
                                                     ->groupBy($prop->name)
                                                     ->orderBy('some_count', 'desc')
                                                     ->limit(20)
                                                     ->get();

    }

    $manufacturers = DB::table($category)->select(DB::raw('count(*) as some_count,manufacturer'))
                       ->groupBy('manufacturer')
                       ->orderBy('some_count', 'desc')
                       ->get();

    $props['manufacturer|Производители'] = $manufacturers;

    return array_reverse($props);
  }


  public static function getCategoriesForCatalog(): Collection
  {
    $categories = new Collection();
    $raw = [];
    $allCategories = Category::all();

    foreach ($allCategories as $category) {

      $categories[] = $category->category_name . ',' . $category->category_name_ru;
    }

    foreach ($allCategories as $key => $category) {

      $items = DB::table('products')
                 ->join($category->category_name, $category->category_name . '.product_id', '=', 'products.product_id')
                 ->select(DB::raw('count(*) as manufacturer_count,manufacturer,products.product_id'))
                 ->groupBy('manufacturer')
                 ->orderBy('manufacturer_count', 'desc')
                 ->limit(10)
                 ->get();

      $raw[$key] = $items;
    }

    return $categories->combine($raw);
  }

}
