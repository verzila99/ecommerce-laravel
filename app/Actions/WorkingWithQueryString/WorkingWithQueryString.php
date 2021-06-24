<?php


namespace App\Actions\WorkingWithQueryString;


class WorkingWithQueryString
{
  public static function getSortingType($request): string
  {

    $sortingType = $request->query('sort_by');

    return match ($sortingType) {
      'popularity' => 'Popularity',
      'price' => 'Low to high',
      '-price' => 'High to low',
      'rating' => 'Rating',
      'newness' => 'Newness',
      default => 'Popularity',
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
