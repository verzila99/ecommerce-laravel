<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function login(Request $request)
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
    public function favorites()
    {
        $productList = [];

        if (Auth::check()) {

            $user = User::find(auth()->id());
            $favoritesStatusList = $user->favorites;
            $favoritesList = explode("|", $user->favorites);

            $query = [];
            foreach ($favoritesList as $item) {
                if($item){
                    $item = explode(':',$item);
                    dd(array_push($query[$item[0]], $item[1]));
                    in_array($item[0], $query, true) ? array_push($query[$item[0]],$item[1]) : $query[$item[0]] =
                        $item[1];
                }
            }
            dd($query);
            foreach ($query as $q){
                $result = DB::table('products')->join($q[0], $q[0] . '.product_id', '=', 'products.product_id')
                            ->whereIn('product_id', $q[1])->get();
                $productList[] = $result;

            }
            $productList = array_slice($productList,0,10);
            $productList = new lengthAwarePaginator($productList, count($productList), 5, null, ['path' =>
                'favorites']);
            return view('favorites', compact('productList', 'favoritesStatusList'));
        }

    }


    public function addToFavorites(Request $request)
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

    public function removeFromFavorites(Request $request, $category, $productId)
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
