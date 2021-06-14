<?php


namespace App\Actions\WorkingWithQueryString;


class WorkingWithQueryString
{
  public static function getSortingType($request): string
  {

    $sortingType = $request->query('sort_by');

    return match ($sortingType) {
      'popularity' => 'По популярности',
      'price' => 'Сначала дешевле',
      '-price' => 'Сначала дороже',
      'rating' => 'По рейтингу',
      'newness' => 'По новизне',
      default => 'По популярности',
    };
  }


  public static function getQueryStringWithoutSorting($request)
  {
    return preg_replace('/sort_by\S+/', '', str_replace('   ', ' + ', urldecode($request->fullUrl())));
  }
}
