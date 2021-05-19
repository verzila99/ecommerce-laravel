<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;
use JsonException;


class ProductListController extends Controller
{

    public function index(Request $request, $category): View|Factory|Redirector|RedirectResponse|Application
    {

        if (!$this->getAllCategories()->pluck('category_name')->contains($category)) {

            abort(404);
        }

        $currentCategory = $this->getCategory($category);

        $categoryProps = $currentCategory->pluck(['name']);
        $props = $currentCategory->toArray();
        $parameters = [];
        foreach ($categoryProps as $prop) {
            if ($request->$prop) {
                $parameters[$prop] = $request->$prop;
            } else {
                $parameters[$prop] = null;
            }
        }

        $queryParams = $this->handleSmartphonesRequest($request);
        $manufacturer = $queryParams['manufacturer'];
        $priceFrom = $queryParams['priceFrom'];
        $priceTo = $queryParams['priceTo'];
        $sortBy = $queryParams['sortBy'];
        $page = $queryParams['page'];

        $productList = DB::table($category)
                         ->join('categories', $category . '.category_id', '=', 'categories.category_id')
                         ->join('props_of_category', $category .'.category_id', '=', 'props_of_category.category_id')
                         ->select($category . '.*', 'props_of_category.*','categories.*')
                         ->when($manufacturer, function ($query, $manufacturer) {
                             return $query->whereIn('manufacturer', $manufacturer);
                         })
                         ->when($priceFrom, function ($query, $priceFrom) {
                             return $query->where('price', '>', $priceFrom);
                         })
                         ->when($priceTo, function ($query, $priceTo) {
                             return $query->where('price', '<', $priceTo);
                         })
                         ->when($sortBy,
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

        $requestUri = preg_replace('/sort_by\S+/', '', $request->fullUrl());


        if ($productList->lastPage() < (int)$page) {

            return redirect($request->fullUrlWithQuery(['page' => 1]));
        }

        if (Auth::check()) {

            $user = User::find(auth()->id());
            $favoritesStatusList = $user->favorites;
        } else {
            $favoritesStatusList = '';
        }

        $filterInputs = self::getInputFields();


        $explodedQueryString = preg_split('/[,=&]/', $requestUri);


        return view('productList', compact(['productList',
            'requestUri', 'filterInputs', 'explodedQueryString', 'favoritesStatusList','props']));
    }



    public function getAllCategories(): Collection
    {

        return DB::table('categories')->get();
    }



    public function getCategory($category): Collection
    {
        $currentCategory = DB::table('categories')->join('props_of_category', 'props_of_category.category_id', '=', 'categories.category_id')->where('category_name', $category)->get();
        return $currentCategory;
    }



    #[ArrayShape(['manufacturer' => "array|null", 'memory' => "array|null", 'priceFrom' => "mixed", 'priceTo' =>
        "mixed", 'sortBy' => "mixed", 'page' => "mixed"])]
    protected function handleSmartphonesRequest(Request $request): array
    {

        if ($request->manufacturer) {
            foreach ($request->manufacturer as $man) {
                $manufacturer[] = $man;
            }

        } else {
            $manufacturer = null;
        }
        $priceFrom = $request->price_from;
        $priceTo = $request->price_to;
        $sortBy = $request->sort_by;
        $page = $request->page;

        return ['manufacturer' => $manufacturer, 'priceFrom' =>
            $priceFrom, 'priceTo' => $priceTo, 'sortBy' => $sortBy, 'page' => $page];
    }



    #[ArrayShape(['manufacturers' => Collection::class, 'memorySize' => Collection::class])]
    protected static function getInputFields(): array
    {
        $manufacturers = DB::table('smartphones')->select(DB::raw('count(*) as manufacturer_count,manufacturer'))
                           ->groupBy('manufacturer')
                           ->orderBy('manufacturer_count', 'desc')
                           ->get();

        $memorySize = DB::table('smartphones')->select(DB::raw('count(*) as memory_count,memory'))
                        ->groupBy('memory')
                        ->orderBy('memory_count', 'desc')
                        ->get();

        return ['manufacturers' => $manufacturers,
            'memorySize' => $memorySize];
    }



    public function indexApi(Request $request, $category): bool|string
    {


        $queryParams = $this->handleSmartphonesRequest($request);
        $manufacturer = $queryParams['manufacturer'];
        $memory = $queryParams['memory'];
        $priceFrom = $queryParams['priceFrom'];
        $priceTo = $queryParams['priceTo'];
        $sortBy = $queryParams['sortBy'];
        $page = $queryParams['page'];


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

        try {
            return json_encode($productList, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return $e;
        }
    }

}
