<?php

namespace App\Http\Controllers;


use App\Actions\FavoritesList\FavoritesList;
use App\Models\Property;
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


class ProductListController extends Controller
{

  public function index(Request $request, $category): View|Factory|Redirector|RedirectResponse|Application
  {

    Category::where('category_name', $category)->firstOrFail();

    $attributes = Property::where('category_name', $category)->get();

    $productList = Product::getProducts($request, $attributes,$category)->paginate(10);

    $requestUri = preg_replace('/sort_by\S+/', '', str_replace('   ', ' + ', urldecode($request->fullUrl())));

    $page = $request->page;

    if ($productList->lastPage() < (int)$page) {

      return redirect($request->fullUrlWithQuery(['page' => 1]));
    }

    $attributes = $attributes->toArray();

    $favoritesStatusList =FavoritesList::getFavoritesList();


//sidebar inputs
    $filterInputs = CategoryController::getInputFieldsForSidebar($category);

    $explodedQueryString = explode("&", str_replace('   ', ' + ', urldecode($request->getQueryString())));


    return view('productList', compact(['productList', 'requestUri', 'filterInputs', 'explodedQueryString', 'favoritesStatusList', 'attributes']));
  }


  public function indexApi(Request $request, $category): bool|string
  {
    $attributes = Property::where('category_name', $category)->get();

    return Product::getProducts($request,$attributes,$category)->count();

  }

}
