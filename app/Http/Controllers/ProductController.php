<?php

namespace App\Http\Controllers;


use App\Actions\FavoritesList\FavoritesList;
use App\Actions\Paginator\CustomPaginator;
use App\Actions\RecentlyViewed\RecentlyViewed;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class ProductController extends Controller
{
  //

  public function show(Request $request,$cat, $productId):
\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
  {

    $product = Product::with('properties')->with('categories')->findOrFail($productId);

    $category = $product->category;

    $attributes = Property::where('category_name', $category)->get()->toArray();

    $key = $category . '/' . $productId;



    $favoritesStatusList = FavoritesList::getFavoritesList();

//views
    if (!$request->session()->has($key)) {

      Product::where('id', $productId)->update(['views' => (int)$product->views + 1]);

      $request->session()->put($key, '1');
    }

//recently viewed

    RecentlyViewed::addToRecentlyViewed($productId);

    return view('product', compact(['product', 'favoritesStatusList', 'attributes']));

  }


  public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
  {
    $categories = Category::all();

    $propsOfCategory = Property::where('category_id', 1)->get();

    return view('admin.createProduct', compact('categories', 'propsOfCategory'));
  }


  public function store(Request $request): \Illuminate\Http\RedirectResponse
  {

    $validated = $request->except(['_token']);

    $category = Category::where('category_id', $validated['category_id'])->firstOrFail();

    $product = Product::create(['title' => $validated['title'], 'category' => $category->category_name, 'price' => $validated['price']]);

    if ($request->hasFile('image')) {

      $images = Collection::wrap($validated['image']);

      $path = 'public/uploads/images/';
      $pathApp = 'app/public/uploads/images/';

      $images->each(function ($image) use ($pathApp, $path, $product) {
        $image->storeAs('public/uploads/images/' . $product->id . '/full', $image->getClientOriginalName());
        $name = $image->getClientOriginalName();

        if (!is_dir(storage_path($path . $product->id . '/700x700'))) {
          Storage::makeDirectory($path . $product->id . '/700x700');
        }
        if (!is_dir(storage_path($path . $product->id . '/225x225'))) {
          Storage::makeDirectory($path . $product->id . '/225x225');
        }
        if (!is_dir(storage_path($path . $product->id . '/45x45'))) {
          Storage::makeDirectory($path . $product->id . '/45x45');
        }

        Image::make($image)->resize(700, 700, function ($constraint) {
          $constraint->aspectRatio();
          $constraint->upsize();
        })->save(storage_path($pathApp . $product->id . '/700x700/' . $name));

        Image::make($image)->resize(225, 225, function ($constraint) {
          $constraint->aspectRatio();
          $constraint->upsize();
        })->save(storage_path($pathApp . $product->id . '/225x225/' . $name));

        Image::make($image)->resize(45, 45, function ($constraint) {
          $constraint->aspectRatio();
          $constraint->upsize();

        })->save(storage_path($pathApp . $product->id . '/45x45/' . $name));
      });
      foreach ($images as $image) {
        $names[] = $image->getClientOriginalName();
      }

      array_pop($validated);

      DB::table($category->category_name)->insert(['id' => $product->id, 'category' => $category->category_name, 'images' => implode(',', $names)] + $validated);
    }

    Product::where('id', $product->id)->update(['explode(',',$product->images)[0]' => $names[0]]);

    return redirect()->back()->with('status', 'Товар добавлен!');
  }


  public function edit($category, $id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
  {


    try {
      $this->authorize('updateProduct', Product::class);
    } catch (AuthorizationException $e) {
      abort(403);
    }
    $categories = Category::all();

    $propsOfCategory = Property::where('category_id', 1)->get();

    $product = Product::with('properties')->findOrFail($id);

    return view('admin.editProduct', compact('product', 'categories', 'propsOfCategory'));
  }


  public function update()
  {
    try {
      $this->authorize('updateProduct', Product::class);
    } catch (AuthorizationException $e) {
      abort(403);
    }

  }


  public function destroy($id): \Illuminate\Http\RedirectResponse
  {
    Product::destroy($id);

    return redirect()->back()->with('status', 'Товар удалён!');
  }


  public function search(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
  {

    $productList = Product::where('title', 'LIKE', '%' . $request->validate(['search_string' => 'required|string|min:1'])['search_string'] .
        '%')->get();

    $favoritesStatusList = FavoritesList::getFavoritesList();

    $propsOfCategory = Property::All();

    $productList->each(function ($product) use ($propsOfCategory) {
      $product->propsOfCategory = $propsOfCategory
        ->filter(fn($item) => $item->category_name === $product->category)
        ->pluck('name_ru', 'name')
        ->toArray();
    });

    [$productList, $totalItems, $paginator] = CustomPaginator::makeCustomPaginator($productList, 10, $request, 'search');

    return view('search', compact('productList', 'totalItems', 'paginator', 'favoritesStatusList'));

  }


  public function searchApi(Request $request): string
  {

    $data = Product::where('title', 'LIKE', '%' . $request->validate(['search_string' => 'required|string'])['search_string'] . '%')->get();


    return $data ? $data->toJson() : 'Не найдено товаров';

  }

}
