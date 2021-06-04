<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
{
  // Favorites logic
  public function favorites(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|RedirectResponse|Application
  {

    if (Auth::check()) {

      $user = User::find(auth()->id());

      $favoritesStatusList = $user->favorites;

      if (!$favoritesStatusList) {

        return view('favorites');
      }

      $favoritesList = explode("|", $user->favorites);

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
          $props = CategoryController::getPropsOfCategory($key);

          $result = DB::table('products')->select($key . '.*', 'products.product_id')
                      ->join($key, 'products.product_id', '=', $key . '.product_id')
                      ->select('products.*', $key . '.*')
                      ->where($key . '.product_id', $value)
                      ->get();

          $productList = $productList->concat($result);

          $productList[$i++]->bar = $props->pluck('name_ru', 'name');
        }
      }

      $ITEMSPERPAGE = 10;

      $totalItems = count($productList);

      $pages = ceil($totalItems / $ITEMSPERPAGE);

      $paginator = new lengthAwarePaginator($productList, count($productList), 10, null, ['path' =>
        'favorites']);

      for ($i = 1; $i <= $pages; $i++) {

        if ((int)$request->page === $i) {

          $productList = $productList->forPage($i, $ITEMSPERPAGE);

          return view('favorites', compact('productList', 'favoritesStatusList', 'totalItems', 'paginator'));

        }

        if (!$request->page) {

          $productList = $productList->forPage(1, $ITEMSPERPAGE);

          return view('favorites', compact('productList', 'favoritesStatusList', 'totalItems', 'paginator'));

        }

        if ((int)$request->page > $pages) {

          return redirect('/favorites');

        }
      }
    }
    return redirect()->back();
  }


  public function addToFavorites(Request $request): Response|Application|ResponseFactory
  {
    if(!Auth::check()){
      abort(403);
    }

    $validated = $request->validate([
      'category' => 'required|string',
      'productId' => 'required|numeric',
    ]);

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

      return response('removed from favorites', 200,
      );
    }

    return response('not in favorites', 409,
    );
  }
}
