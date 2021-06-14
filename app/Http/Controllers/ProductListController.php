<?php

namespace App\Http\Controllers;


use App\Actions\FavoritesList\FavoritesList;
use App\Actions\WorkingWithQueryString\WorkingWithQueryString;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;


class ProductListController extends Controller
{

  public function index(Request $request, $category): View|Factory|Redirector|RedirectResponse|Application
  {

    Category::where('category_name', $category)->firstOrFail();

    $properties = Property::where('category_name', $category)->get();

    $productList = Product::getProducts($request, $category, $properties)->paginate(10);

    $sortingType = WorkingWithQueryString::getSortingType($request);

    $requestUri = WorkingWithQueryString::getQueryStringWithoutSorting($request);

    $page = $request->page;

    if ($productList->lastPage() < (int)$page) {

      return redirect($request->fullUrlWithQuery(['page' => 1]));
    }

    $properties = $properties->toArray();

    $favoritesStatusList = FavoritesList::getFavoritesList();


//sidebar inputs
    $filterInputs = CategoryController::getInputFieldsForSidebar($category);

    $explodedQueryString = explode("&", str_replace('   ', ' + ', urldecode($request->getQueryString())));


    return view('category', compact(['productList',
                                     'requestUri',
                                     'filterInputs',
                                     'explodedQueryString',
                                     'favoritesStatusList',
                                     'properties',
                                     'sortingType']));
  }


  public function indexApi(Request $request, $category): bool|string
  {
    $properties = Property::where('category_name', $category)->get();

    return Product::getProducts($request, $category, $properties)->count();

  }

}
