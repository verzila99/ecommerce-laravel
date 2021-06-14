<?php


namespace App\Actions\SearchFilter;


class SearchFilter
{

  public static function applyFilters($request, $query)
  {
    [$manufacturer, $priceFrom, $priceTo, $sortBy] = self::handleRequest($request);

    return $query->when($manufacturer, function ($query, $manufacturer) {
        return $query->whereIn('manufacturer', $manufacturer);
      })->when($priceFrom, function ($query, $priceFrom) {
        return $query->where('price', '>', $priceFrom);
      })->when($priceTo, function ($query, $priceTo) {
        return $query->where('price', '<', $priceTo);
      })->when($sortBy, function ($query, $sortBy) {
        if ($sortBy === 'popularity') {
          return $query->orderBy('product_views', 'desc');
        }
        if ($sortBy === 'price') {
          return $query->orderBy('price', 'asc');
        }
        if ($sortBy === '-price') {
          return $query->orderBy('price', 'desc');
        }
        if ($sortBy === 'created_at') {
          return $query->orderBy('created_at', 'desc');
        }

        return null;

      }, function ($query) {
        return $query->orderBy('product_views', 'desc');
      });

  }


  public static function handleRequest($request): array
  {
    if ($request->manufacturer) {

      foreach ($request->manufacturer as $man) {
        $manufacturer[] = $man;

      }
    } else {
      $manufacturer = null;
    }
    $priceFrom = $request->price_from;
    $priceTo = $request->price_to;
    $sortBy = $request->sort_by;

    return [$manufacturer, $priceFrom, $priceTo, $sortBy];
  }
}
