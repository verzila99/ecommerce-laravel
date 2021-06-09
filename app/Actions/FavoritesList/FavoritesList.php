<?php


namespace App\Actions\FavoritesList;


use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FavoritesList
{
  public static function getFavoritesList(): string
  {
    $favoritesStatusList = '';

    if (Auth::check()) {

      $user = User::find(auth()->id());

      if ($user->favorites!== null) {

        $favoritesStatusList = $user->favorites;
      }
    }

    return $favoritesStatusList;
  }
}
