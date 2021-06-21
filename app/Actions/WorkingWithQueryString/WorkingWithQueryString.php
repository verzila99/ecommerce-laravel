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

    $requestUri= preg_replace('/sort_by\S+/', '', str_replace('   ', ' + ', urldecode($request->fullUrl())));
    if (preg_match('/\?$/', url($requestUri))) {
      $query = url($requestUri);
    } elseif (preg_match('/&$/', url($requestUri))) {
      $query = url($requestUri);
    } elseif (!preg_match('/[\?&]/', url($requestUri))) {
      $query = url($requestUri) . '?';
    } else {
      $query = url($requestUri) . '&';
    }
    return $query;
  }
}
