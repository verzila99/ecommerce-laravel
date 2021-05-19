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
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{


    public function register(Request $request): void
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed|string|min:6',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        Auth::login($user);

    }

    public function login(Request $request): Response|Application|RedirectResponse|ResponseFactory
    {

        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($validatedData)) {

            $request->session()->regenerate();

            return redirect()->intended();
        }

        return response('Incorrect email or password', 401)
            ->header('Content-Type', 'text/plain');


    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->back();
    }


    // Favorites logic
    public function favorites(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|RedirectResponse|Application
    {

        if (Auth::check()) {

            $user = User::find(auth()->id());

            $favoritesStatusList = $user->favorites;

            $favoritesList = explode("|", $user->favorites);

            $query = [];

            foreach ($favoritesList as $item) {

                if ($item) {

                    $item = explode(':', $item);

                    if (isset($query[$item[0]])) {

                        $query[$item[0]][] = $item[1];

                    } else {

                        $query[$item[0]] = [$item[1]];

                    }
                }
            }
            $productList = new Collection();

            foreach ($query as $key => $value) {

                $result = DB::table('products')->select($key . '.*', 'products.product_id')
                            ->join($key, 'products.product_id', '=', $key . '.product_id')
                            ->whereIn($key . '.product_id', $value)->get();

                $productList = $productList->concat($result);

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
        abort(404);
    }


    public function addToFavorites(Request $request): Response|Application|ResponseFactory
    {

        $validated = $request->validate([
            'category' => 'required|string',
            'productId' => 'required|numeric',

        ]);

        $validatedData = '|' . $validated['category'] . ':' . $validated['productId'];

        $user = User::find(auth()->id());

        if (!str_contains($user->favorites, $validatedData)) {

            $user->favorites .= $validatedData;

            $user->save();

            return response('added to favorites', 200,
            );
        }

        return response('already in favorites', 409,
        );


    }

    public function removeFromFavorites( $category, $productId): Response|Application|ResponseFactory
    {


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
