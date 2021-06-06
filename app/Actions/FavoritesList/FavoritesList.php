<?php


namespace App\Actions\FavoritesList;


use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FavoritesList
{
  public static function getFavoritesList(): string
  {
    if (Auth::check()) {

      $user = User::find(auth()->id());

      $favoritesStatusList = $user->favorites;

    } else {

      $favoritesStatusList = '';

    }

    return $favoritesStatusList;
  }
}
