<?php

namespace App\Models;

use App\Http\Controllers\ProductListController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Smartwatch extends Model
{
 use HasFactory;

    protected $table = 'smartwatches';
    protected $guarded = [];

    public static function getCountSmartwatches($request, $category)
    {


        $compatibility = $request->compatibility;
        $diagonal = $request->diagonal;
        $sensors = $request->sensors;

        $queryParams = ProductListController::handleRequest($request);
        $manufacturer = $queryParams['manufacturer'];
        $priceFrom = $queryParams['priceFrom'];
        $priceTo = $queryParams['priceTo'];
        $sortBy = $queryParams['sortBy'];
        return DB::table('smartwatches')
                 ->join('categories', $category . '.category_id', '=', 'categories.category_id')
                 ->select($category . '.*', 'categories.*')
                 ->when($diagonal,
            function ($query, $diagonal) {
                return $query->whereIn('diagonal', $diagonal);
            })->when($sensors,
            function ($query, $sensors) {
                return $query->whereIn('sensors', $sensors);
            })->when($compatibility,
            function ($query, $compatibility) {
                return $query->whereIn('compatibility', $compatibility);
            })
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
    }
}
