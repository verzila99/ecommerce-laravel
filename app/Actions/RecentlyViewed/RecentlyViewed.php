<?php


namespace App\Actions\RecentlyViewed;


use Illuminate\Support\Facades\Cookie;

class RecentlyViewed
{
  public static function addToRecentlyViewed($productId)
  {
    $viewed = explode(',', Cookie::get('viewed'));

    is_array($viewed) ?: $viewed[0] = $viewed;

    count($viewed) > 5 ? array_shift($viewed) : $viewed;

    if (!in_array($productId, $viewed, true)) {

      Cookie::queue('viewed', implode(',', $viewed) . ',' . $productId, 100000);
    }
  }
}
