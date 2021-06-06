<?php


namespace App\Actions\Paginator;


use Illuminate\Pagination\LengthAwarePaginator;

class CustomPaginator
{

  public static function makeCustomPaginator($productList,$itemsPerPage,$request, $path = '/'): array|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
  {
    $totalItems = count($productList);

    $pages = ceil($totalItems / $itemsPerPage);

    $paginator = new lengthAwarePaginator($productList, count($productList), $itemsPerPage, null, ['path' => $path]);

    for ($i = 1; $i <= $pages; $i++) {

      if ((int)$request->page === $i) {

        $productList = $productList->forPage($i, $itemsPerPage);

        return [$productList, $totalItems, $paginator];
      }

      if (!$request->page) {

        $productList = $productList->forPage(1, $itemsPerPage);

        return [$productList, $totalItems, $paginator];

      }

      if ((int)$request->page > $pages) {

        return redirect('/' . $path);

      }


    }
      return [$productList, $totalItems, $paginator];

  }
}
