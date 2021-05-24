<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function orderConfirmationRequest(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $productsInOrder = $request->except('_token');

        if (empty($productsInOrder)) {
            return redirect()->route('home');
        }
        $sum = 0;
        $productList = new Collection();

        foreach ($productsInOrder as $productId => $quantity) {
            if (is_int((int)$productId) && is_int((int)$quantity)) {
                $item = Product::where('product_id', $productId)->get()->toArray();
                if ($item) {
                    $item[0]['quantity'] = $quantity;
                    $productList = $productList->concat(collect($item));
                    $sum += $item[0]['product_price'] * $quantity;
                }
            } else {
                return redirect()->route('home');
            }
        }

        $request->session()->put('productList', $productList);
        $request->session()->put('sum', $sum);

        return redirect()->action([OrderController::class, "getOrderConfirmationPage"]);
    }


    public function getOrderConfirmationPage():
 \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $sum = session()->get('sum');
        $productList = session()->get('productList');
        return view('order', compact('sum', 'productList'));
    }

    public function orderConfirmation(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {

        $userCredentials = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string'
        ]);

        $productsInOrder = session()->get('productList');

        if (is_null($productsInOrder)) {

            return redirect()->route('home');
        }


        if (Auth::check()) {
            $userId = User::find(auth()->id())->id;
        }

        $order = Order::create([
            'username' => $userCredentials['name'],
            'email' => $userCredentials['email'],
            'phone_number' => $userCredentials['phone_number'],
            'user_id' => $userId ?? null
        ]);

        foreach ($productsInOrder as $product) {

            $currentProduct = Product::find($product['product_id']);

            $ordersProducts = $currentProduct->orders()->attach($order, [

                'quantity' => $product['quantity']
            ]);
        }

        session()->forget('productList');

        Cookie::queue('cart','');

//         return back()->withInput();
        return view('orderSuccess');
    }
}
