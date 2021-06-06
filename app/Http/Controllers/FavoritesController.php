<?php

namespace App\Http\Controllers;

use App\Actions\Paginator\CustomPaginator;
use App\Models\Property;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
{
  // Favorites logic
  public static function getFavoritesStatusList()
  {

  }


  public function favorites(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|RedirectResponse|Application
  {

    if (Auth::check()) {

      $user = User::find(auth()->id());

      $favoritesStatusList = $user->favorites;

      if (!$favoritesStatusList) {

        return view('favorites');
      }

      $favoritesList = explode("|", $favoritesStatusList);

      $query = [];

      foreach ($favoritesList as $item) {

        if ($item) {

          $query[] = [explode(':', $item)[0] => explode(':', $item)[1]];

        }
      }
      $productList = new Collection();

      $i = 0;
      foreach ($query as $q) {

        foreach ($q as $key => $value) {
          $props = Property::where('category_name', $key)->get();

          $result = DB::table('products')->select($key . '.*', 'products.id')->join($key, 'products.id', '=', $key . '.id')->select('products.*', $key . '.*')->where($key . '.id', $value)->get();

          $productList = $productList->concat($result);

          $productList[$i++]->propsOfCategory = $props->pluck('name_ru', 'name');
        }
      }


      [$productList, $totalItems, $paginator] = CustomPaginator::makeCustomPaginator($productList, 10, $request, 'favorites');

      return view('favorites', compact('productList', 'favoritesStatusList', 'totalItems', 'paginator'));

    }

    return redirect()->back();
  }


  public function addToFavorites(Request $request): Response|Application|ResponseFactory
  {
    if (!Auth::check()) {
      abort(403);
    }

    $validated = $request->validate(['category' => 'required|string', 'productId' => 'required|numeric',]);

    $validatedData = '|' . $validated['category'] . ':' . $validated['productId'];

    $user = User::find(auth()->id());

    if (!str_contains($user->favorites, $validatedData)) {

      $user->favorites .= $validatedData;

      $user->save();

      return response('added to favorites', 200);
    }

    return response('already in favorites', 409);
  }


  public function removeFromFavorites($category, $productId): Response|Application|ResponseFactory
  {
    if (!Auth::check()) {
      abort(403);
    }

    $validatedData = '|' . $category . ':' . $productId;

    $user = User::find(auth()->id());

    if (str_contains($user->favorites, $validatedData)) {

      $user->favorites = str_replace($validatedData, '', $user->favorites);

      $user->save();

      return response('removed from favorites', 200,);
    }

    return response('not in favorites', 409,);
  }
}
