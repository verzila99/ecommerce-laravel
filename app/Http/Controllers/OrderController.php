<?php

namespace App\Http\Controllers;

use App\Actions\CartActions\CartActions;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Property;
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

      return redirect()->back()->with('status', 'Добавьте товары в корзину');
    }

    $sum = 0;

    $productList = new Collection();

    foreach ($productsInOrder as $productId => $quantity) {

      if (is_int((int)$productId) && is_int((int)$quantity)) {

        $item = Product::where('id', $productId)->get()->toArray();

        if ($item) {

          $item[0]['quantity'] = $quantity;

          $productList = $productList->concat(collect($item));

          $sum += $item[0]['price'] * $quantity;
        }
      } else {

        return redirect()->route('home');
      }
    }

    if($sum===0){

      return redirect()->back()->with('status','Добавьте товары в корзину');

    }
    $request->session()->put('productList', $productList);

    $request->session()->put('sum', $sum);

    return redirect()->action([OrderController::class, "create"]);
  }


  public function create():
  \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
  {
    $sum = session()->get('sum');

    $productList = session()->get('productList');

    return view('order', compact('sum', 'productList'));
  }


  public function store(StoreOrderRequest $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
  {

    $userCredentials = $request->validated();

    $productsInOrder = session()->get('productList');

    if (is_null($productsInOrder)) {

      return redirect()->back();
    }

    $userId = auth()->id();

    $sum = CartActions::getSumOfProducts($productsInOrder);

    $order = Order::create([
      'username' => $userCredentials['name'],
      'email' => $userCredentials['email'],
      'phone_number' => $userCredentials['phone_number'],
      'message' => $userCredentials['message'],
      'user_id' => $userId ?: null,
      'sum' => $sum
    ]);

    foreach ($productsInOrder as $product) {

      $currentProduct = Product::find($product['id']);

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
