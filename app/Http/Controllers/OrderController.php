<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\PropsOfCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class OrderController extends Controller
{
  public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
  {
    $ordersList = Order::All();

    return view('admin.orders', compact('ordersList'));
  }

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
      'phone_number' => 'required|string',
      'message' => 'nullable|string'
    ]);

    $productsInOrder = session()->get('productList');

    if (is_null($productsInOrder)) {

      return redirect()->route('home');
    }


    if (Auth::check()) {
      $userId = User::find(auth()->id())->id;
    }

    $sum = 0;

    foreach ($productsInOrder as $product) {
      $currentProduct = Product::find($product['product_id']);
      $sum += $currentProduct->product_price * $product['quantity'];
    }

    $order = Order::create([
      'username' => $userCredentials['name'],
      'email' => $userCredentials['email'],
      'phone_number' => $userCredentials['phone_number'],
      'message' => $userCredentials['message'],
      'user_id' => $userId ? $userId : null,
      'sum' => $sum
    ]);


    foreach ($productsInOrder as $product) {

      $currentProduct = Product::find($product['product_id']);

      $currentProduct->orders()->attach($order, [

        'quantity' => $product['quantity']
      ]);
    }

    session()->forget('productList');

    Cookie::queue('cart', '');


    return view('orderSuccess');
  }

  public function updateStatus(Request $request): \Illuminate\Http\RedirectResponse
  {
    $data = $request->validate(['id'=>'required']);

     Order::where('id', (int)$data['id'])->update(['status'=> 1]);

     return redirect()->route('admin');
  }
}
