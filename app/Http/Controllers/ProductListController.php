<?php

namespace App\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Support\Collection;


class ProductListController extends Controller
{

    public function index(Request $request, $category): Factory|View|Application
    {
        $currentCategory = DB::table('categories')->where('name', $category)->first();



        $queryParams = $this->handleSmartphonesRequest($request);
        $manufacturer = $queryParams['manufacturer'];
        $memory = $queryParams['memory'];
        $priceFrom = $queryParams['priceFrom'];
        $priceTo = $queryParams['priceTo'];
        $sortBy = $queryParams['sortBy'];

        $productList = DB::table($category)->when($manufacturer,
            function ($query, $manufacturer) {
                return $query->whereIn('manufacturer', $manufacturer);
            })->when($memory,
            function ($query, $memory) {
                return $query->whereIn('memory', $memory);
            })->when($priceFrom,
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
            })->paginate(10);

        $requestUri= str_contains('?', $request->fullUrl()) ? $request->fullUrl()
            .'&': $request->fullUrl() . '?' ;
        $requestUri =preg_replace('/=,/', '=', $requestUri);
        $requestUri =preg_replace('/,,/', ',', $requestUri);
        $requestUri =preg_replace('/sort_by\S+/','', $requestUri);
        $requestUri = substr_count($requestUri, '?',) === 2 ?
        preg_replace('/\?$/','&', $requestUri) : $requestUri;
        $filterInputs = self::getInputFields();

        $explodedQueryString = explode('&', $requestUri);

        return view('productList', compact(['productList', 'currentCategory',
            'requestUri', 'filterInputs','explodedQueryString']));
    }


    #[ArrayShape(['manufacturers' => Collection::class, 'memorySize' => Collection::class])]
    protected static function getInputFields(): array
    {
        $manufacturers = DB::table('smartphones')->select(DB::raw('count(*) as manufacturer_count,manufacturer'))
            ->groupBy('manufacturer')
            ->orderBy('manufacturer_count','desc')
            ->get();

        $memorySize = DB::table('smartphones')->select(DB::raw('count(*) as memory_count,memory'))
            ->groupBy('memory')
            ->orderBy('memory_count', 'desc')
            ->get();

        return ['manufacturers'=>$manufacturers,
            'memorySize'=>$memorySize];
    }


    protected function handleSmartphonesRequest(Request $request): array
    {
        if ($request->manufacturer) {
            $manufacturer = explode(',', $request->manufacturer);
            if (!is_array($manufacturer)) {
                $manufacturer[] = $manufacturer;
            }
        } else {
            $manufacturer = null;
        }
        if ($request->memory) {
            $memory = explode(',', $request->memory);
            if (!is_array($memory)) {
                $memory[] = $memory;
            }
        } else {
            $memory = null;
        }
        $priceFrom = $request->price_from;
        $priceTo = $request->price_to;
        $sortBy = $request->sort_by;
        return ['manufacturer'=>$manufacturer,'memory'=> $memory,'priceFrom' =>
        $priceFrom, 'priceTo'=> $priceTo,'sortBy'=>  $sortBy];
    }
    public function indexApi(Request $request, $category): bool|string
    {


        $queryParams = $this->handleSmartphonesRequest($request);
        $manufacturer = $queryParams['manufacturer'];
        $memory = $queryParams['memory'];
        $priceFrom = $queryParams['priceFrom'];
        $priceTo = $queryParams['priceTo'];
        $sortBy = $queryParams['sortBy'];




        $productList = DB::table('smartphones')->when($manufacturer,
            function ($query, $manufacturer) {
                return $query->whereIn('manufacturer', $manufacturer);
            })->when($memory,
            function ($query, $memory) {
                return $query->whereIn('memory', $memory);
            })->when($priceFrom,
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
            })->count();




        return json_encode($productList);
    }


}
