<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use JsonException;


class ProductListController extends Controller
{

    public function index(Request $request, $category): View|Factory|Redirector|RedirectResponse|Application
    {


        Category::where('category_name',$category)->firstOrFail();

        $page = $request->page;

        $currentCategory = CategoryController::getPropsOfCategory($category);

        $props = $currentCategory->toArray();

        $productList = Product::getProducts($request,$category)->paginate(10);

        $requestUri = preg_replace('/sort_by\S+/', '', str_replace('   ',' + ',urldecode
    ($request->fullUrl())));

        if ($productList->lastPage() < (int)$page) {

            return redirect($request->fullUrlWithQuery(['page' => 1]));
        }

// Favorites
        if (Auth::check()) {

            $user = User::find(auth()->id());
            $favoritesStatusList = $user->favorites;

        } else {

            $favoritesStatusList = '';

        }

//sidebar inputs
        $filterInputs = CategoryController::getInputFieldsForSidebar($category);

        $explodedQueryString = explode("&", str_replace('   ', ' + ', urldecode($request->getQueryString())));

        return view('productList', compact(['productList',
            'requestUri', 'filterInputs', 'explodedQueryString', 'favoritesStatusList','props']));
    }


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

        return [$manufacturer, $priceFrom, $priceTo, $sortBy ];
    }


    public function indexApi(Request $request, $category): bool|string
    {

      return Product::getProducts($request, $category)->count();

    }

}
