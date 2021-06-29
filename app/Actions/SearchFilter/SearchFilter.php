<?php


namespace App\Actions\SearchFilter;


class SearchFilter
{

  public static function applyFilters($request, $query)
  {
    [$manufacturer, $price, $sortBy] = self::handleRequest($request);

    return $query->when($manufacturer, function ($query, $manufacturer) {
        return $query->whereIn('manufacturer', $manufacturer);
      })->when($price, function ($query, $price) {
        return $query->whereBetween('price', [$price[0],$price[1]]);
      })->when($sortBy, function ($query, $sortBy) {
        if ($sortBy === 'popularity') {
          return $query->orderBy('views', 'desc');
        }
        if ($sortBy === 'price') {
          return $query->orderBy('price', 'asc');
        }
        if ($sortBy === '-price') {
          return $query->orderBy('price', 'desc');
        }
        if ($sortBy === 'newness') {
          return $query->orderBy('created_at', 'desc');
        }

        return null;

      }, function ($query) {
        return $query->orderBy('views', 'desc');
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

    $price = $request->price ? explode(':',$request->price) : null;

    $sortBy = $request->sort_by;

    return [$manufacturer, $price, $sortBy];
  }


  public static function getAppliedFilters($request,$properties): array
  {
    $appliedFilters = [];

    foreach ($properties as $property) {

      $name = $property->name;

      if ($request->has($name)) {

        foreach ($request->$name as $p) {

          $appliedFilters[] = [$name , str_replace('   ', ' + ', $p)];
        }
      }
    }
    if ($request->manufacturer) {

      foreach ($request->manufacturer as $man) {

        $appliedFilters[] =['manufacturer', $man];
      }
    }
    if ($request->price) {

      $price =explode(':', $request->price);

      $appliedFilters[] = ['price',$price[0] . ':' . $price[1]];
    }

    return $appliedFilters;
  }
}
