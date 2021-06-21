<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Category extends Model
{

  use HasFactory;

  protected $table = 'categories';

  protected $guarded= [];


    public static function getInputFieldsForSidebar($category, $properties): array
    {

        foreach ($properties as $prop) {
            $props[$prop->name . '|' . $prop->name] = DB::table('product_property')->where(
                'property_id',
                $prop->id
              )->select(DB::raw('count(property_id) as count,value'))->groupBy('value')->orderBy(
                'count',
                'desc'
              )->limit(20)->get();
        }

        $manufacturers = DB::table('products')->select(DB::raw('count(*) as count,manufacturer'))->where(
            'category',
            $category
          )->groupBy('manufacturer')->orderBy('count', 'desc')->get();

        $props['manufacturer|Manufacturer'] = $manufacturers;

        return array_reverse($props);
    }


    public static function getCategoriesForCatalog(): Collection
    {
        $categories = new Collection();
        $raw = [];
        $allCategories = self::all();

        foreach ($allCategories as $key => $category) {
            $categories[] = $category->category_name . ',' . $category->category_name;

            $items = Product::where('category', $category->category_name)->select(
                DB::raw('count(*) as some_count,manufacturer')
              )->groupBy('manufacturer')->orderBy('some_count', 'desc')->limit(10)->get();

            $raw[$key] = $items;
        }

        return $categories->combine($raw);
    }


    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(Product::class);

  }

  public function properties(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(Property::class);
  }
}
