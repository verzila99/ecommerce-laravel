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

    protected $fillable = [ 'name', 'name_ru' ];

    public static function getCategoriesForCatalog(): Collection
    {
        $categories = new Collection();
        $raw = [];
        $allCategories = self::all();

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

    public static function getAllCategories(): Collection
    {

        return DB::table('categories')->get();
    }


    public static function getPropsOfCategory($category): Collection
    {
        return DB::table('categories')->join('props_of_category', 'props_of_category.category_id', '=', 'categories.category_id')->where('categories.category_name', $category)->get();

    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Product::class);
    }
}
