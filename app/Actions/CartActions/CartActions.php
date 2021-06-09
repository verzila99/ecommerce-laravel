<?php


namespace App\Actions\CartActions;


use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartActions
{

  public static function getCartItemsFromCookies(): array
  {
    if (Request::class->cookie('cart')) {

      $items = is_array(explode(',', Cookie::get('cart'))) ? explode(',', Cookie::get('cart')) : [Cookie::get('cart')];

      return array_filter($items, static function ($item) {
        return is_numeric($item);
      });
    }

    return [];
  }


  public static function getSumOfProducts($productsInOrder): int
  {
    $sum=0;

    foreach ($productsInOrder as $product) {

      $currentProduct = Product::find($product['id']);

      $sum += $currentProduct->price * $product['quantity'];
    }
    return $sum;
  }
}
