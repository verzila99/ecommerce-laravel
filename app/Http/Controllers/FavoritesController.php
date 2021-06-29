<?php

namespace App\Http\Controllers;

use App\Actions\FavoritesList\FavoritesList;
use App\Actions\CustomPaginator\CustomPaginator;
use App\Actions\WorkingWithQueryString\WorkingWithQueryString;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{

  public function favorites(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|RedirectResponse|Application
  {

    $favoritesStatusList = FavoritesList::getFavoritesList();

    $favoritesList = explode(",", $favoritesStatusList);

    $productList = Product::getProducts($request)->whereIn('id', $favoritesList)->get();

    $sortingType = WorkingWithQueryString::getSortingType($request);

    $requestUri = WorkingWithQueryString::getQueryStringWithoutSorting($request);

    [$productList, $totalItems, $paginator] = CustomPaginator::makeCustomPaginator($productList, 10, $request, 'favorites');

    return view('favorites', compact('productList', 'favoritesStatusList', 'totalItems', 'paginator','requestUri','sortingType'));

  }


  public function addToFavorites(Request $request): Response|Application|ResponseFactory
  {

    $validated = $request->validate(['productId' => 'required|numeric']);

    $user = User::find(auth()->id());

    $favorites = explode(',', $user->favorites);

    if (!in_array($validated['productId'], $favorites)) {

      $favorites[] = $validated['productId'];

      $user->favorites = implode(',',$favorites);

      $user->save();

      return response('added to favorites', 200);
    }

    return response('already in favorites', 409);
  }


  public function removeFromFavorites(Request $request): Response|Application|ResponseFactory
  {

    $validated = $request->validate(['productId' => 'required|numeric']);

    $user = User::find(auth()->id());

    $favorites = explode(',', $user->favorites);

    if (in_array($validated['productId'], $favorites)) {

      $favorites = array_diff($favorites,[$validated['productId']]);

      $user->favorites = implode(',', $favorites);

      $user->save();

      return response('removed from favorites', 200,);
    }

    return response('not in favorites', 409,);
  }
}
