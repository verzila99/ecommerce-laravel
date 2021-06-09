<?php

namespace App\Actions\Paginator;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Redirector;

class CustomPaginator
{

  /**
   * @param $productList
   * @param $itemsPerPage
   * @param $request
   * @param string $path
   * @return array|Redirector|RedirectResponse|Application
   */
  public static function makeCustomPaginator($productList, $itemsPerPage, $request, $path = '/'): array|Redirector|RedirectResponse|Application
  {

    $totalItems = $productList->count();

    $pages = ceil($totalItems / $itemsPerPage);

      if ((int)$request->page > $pages) {

        return redirect('/' . $path);

      }

    $paginator = new lengthAwarePaginator($productList, $totalItems, $itemsPerPage, null, ['path' => $path]);


      if (!$request->page) {

        $productList = $productList->forPage(1, $itemsPerPage);

      }

      else {

        $productList = $productList->forPage((int)$request->page, $itemsPerPage);

      }

      return [$productList, $totalItems, $paginator];

  }
}
