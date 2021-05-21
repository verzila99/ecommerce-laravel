<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Smartphone;
use App\Models\Smartwatch;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use JetBrains\PhpStorm\ArrayShape;
use JsonException;


class ProductListController extends Controller
{

    public function index(Request $request, $category): View|Factory|Redirector|RedirectResponse|Application
    {

        if (!Category::getAllCategories()->pluck('category_name')->contains($category)) {

            abort(404);
        }
        $page = $request->page;
        $currentCategory = Category::getPropsOfCategory($category);
        $props = $currentCategory->toArray();

        if ($category === 'smartphones') {
            $productList = Smartphone::getCountSmartphones($request,$category)->paginate(10);
        } else if ($category === 'smartwatches') {
            $productList = Smartwatch::getCountSmartwatches($request, $category)->paginate(10);
        }

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

        $filterInputs = self::getInputFields($category);


        $explodedQueryString = preg_split('/[,=&]/', $requestUri);

        return view('productList', compact(['productList',
            'requestUri', 'filterInputs', 'explodedQueryString', 'favoritesStatusList','props']));
    }







    #[ArrayShape(['manufacturer' => "array|null", 'memory' => "array|null", 'priceFrom' => "mixed", 'priceTo' =>
        "mixed", 'sortBy' => "mixed", 'page' => "mixed"])]
    public static function handleRequest(Request $request): array
    {

        if ($request->manufacturer) {
            foreach ($request->manufacturer as $man) {
                $manufacturer[] =$man;
            }

        } else {
            $manufacturer = null;
        }
        $priceFrom =$request->price_from;
        $priceTo =$request->price_to;
        $sortBy =$request->sort_by;
        $page =$request->page;

        return ['manufacturer' => $manufacturer, 'priceFrom' =>
            $priceFrom, 'priceTo' => $priceTo, 'sortBy' => $sortBy, 'page' => $page];
    }



    #[ArrayShape(['manufacturers' => Collection::class, 'memorySize' => Collection::class])]
    protected static function getInputFields($category): array
    {

            $propsOfCategory = Category::getPropsOfCategory($category);
            foreach ($propsOfCategory as $prop){

                $props[$prop->name.'|'. $prop->name_ru] = DB::table($category)
                                        ->select(DB::raw('count(*) as some_count,'. $prop->name))
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



    public function indexApi(Request $request, $category): bool|string
    {


        if ($category==='smartphones'){
            $productList=Smartphone::getCountSmartphones($request,$category)->count();
        }else if($category === 'smartwatches'){
            $productList=Smartwatch::getCountSmartwatches($request, $category)->count();
        }




        try {
            return json_encode($productList, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return $e;
        }
    }

}
