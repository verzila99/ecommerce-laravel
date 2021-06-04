<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Product;
use App\Models\PropsOfCategory;
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

  public function show(Request $request, $category, $productId):
  \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
  {

    Category::where('category_name', $category)->firstOrFail();


    $currentCategoryProps = CategoryController::getPropsOfCategory($category);


    $props = $currentCategoryProps->toArray();


    $product = DB::table('products')
                 ->join('categories', 'products.product_category', '=', 'categories.category_name')
                 ->join($category, 'products.product_id', '=', $category . '.product_id')
                 ->where('products.product_id', $productId)->first();

    if (!$product) {

      abort(404);
    }

    $key = $category . '/' . $productId;

    $favoritesStatus = 0;

    if (Auth::check()) {
      $checkingData = $category . ':' . $productId;
      $user = User::find(auth()->id());
      $favoritesStatus = str_contains($user->favorites, $checkingData) ?
        1 : 0;
    }

    if (!$request->session()->has($key)) {

      DB::table($category)
        ->where('product_id', $productId)
        ->update(['product_views' => (int)$product->product_views + 1]);
      $request->session()->put($key, '1');
    }

    $viewed = explode(',', Cookie::get('viewed'));

    is_array($viewed) ?: $viewed[0] = $viewed;

    count($viewed) > 5 ? array_shift($viewed) : $viewed;

    if (!in_array($productId, $viewed, true)) {

      Cookie::queue('viewed', implode(',', $viewed) . ',' . $productId, 100000);
    }

    return view('product', compact(['product', 'favoritesStatus', 'props']));

  }


  public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
  {
    $categories = Category::all();

    $propsOfCategory = PropsOfCategory::where('category_id', 1)->get();

    return view('admin.createProduct', compact( 'categories', 'propsOfCategory'));
  }

  public function store(Request $request): \Illuminate\Http\RedirectResponse
  {

    $validated = $request->except(['_token']);

    $category = Category::where('category_id', $validated['category_id'])->firstOrFail();

    $product = Product::create([
      'product_title' => $validated['title'],
      'product_category' => $category->category_name,
      'product_price' => $validated['price']
    ]);

    if ($request->hasFile('image')) {

      $images = Collection::wrap($validated['image']);

      $path = 'public/uploads/images/';
      $pathApp = 'app/public/uploads/images/';

      $images->each(function ($image) use ($pathApp, $path, $product) {
        $image->storeAs('public/uploads/images/' . $product->product_id . '/full', $image->getClientOriginalName());
        $name = $image->getClientOriginalName();

        if (!is_dir(storage_path($path . $product->product_id . '/700x700'))) {
          Storage::makeDirectory($path . $product->product_id . '/700x700');
        }
        if (!is_dir(storage_path($path . $product->product_id . '/225x225'))) {
          Storage::makeDirectory($path . $product->product_id . '/225x225');
        }
        if (!is_dir(storage_path($path . $product->product_id . '/45x45'))) {
          Storage::makeDirectory($path . $product->product_id . '/45x45');
        }

        Image::make($image)->resize(700, 700, function ($constraint) {
          $constraint->aspectRatio();
          $constraint->upsize();
        })->save(storage_path($pathApp . $product->product_id . '/700x700/' . $name));

        Image::make($image)->resize(225, 225, function ($constraint) {
          $constraint->aspectRatio();
          $constraint->upsize();
        })->save(storage_path($pathApp . $product->product_id . '/225x225/' . $name));

        Image::make($image)->resize(45, 45, function ($constraint) {
          $constraint->aspectRatio();
          $constraint->upsize();

        })->save(storage_path($pathApp . $product->product_id . '/45x45/' . $name));
      });
      foreach ($images as $image) {
        $names[] = $image->getClientOriginalName();
      }

      array_pop($validated);

      DB::table($category->category_name)->insert([
          'product_id' => $product->product_id,
          'category' => $category->category_name,
          'images' => implode(',', $names)] + $validated);
    }

      Product::where('product_id',$product->product_id)->update(['product_image'=> $names[0]]);

    return redirect()->back()->with('status', 'Товар добавлен!');
  }


  public function edit($category, $product_id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
  {


    try {
      $this->authorize('updateProduct', Product::class);
    } catch (AuthorizationException $e) {
      abort(403);
    }
    $categories = Category::all();

    $propsOfCategory = PropsOfCategory::where('category_id', 1)->get();

    $product = DB::table($category)->where('product_id',$product_id)->first();

    return view('admin.editProduct', compact('product','categories', 'propsOfCategory'));
  }


  public function update()
  {
    try {
      $this->authorize('updateProduct', Product::class);
    } catch (AuthorizationException $e) {
      abort(403);
    }

}


  public function destroy($product_id): \Illuminate\Http\RedirectResponse
  {
    Product::destroy($product_id);
    return redirect()->back()->with('status', 'Товар удалён!');
  }


  public function search(Request $request): string
  {
    $data = Product::where('product_title', 'LIKE', '%' . $request->validate([
      'search_string' => 'required|string'])['search_string'] . '%')
                   ->get();

    return $data ? $data->toJson() : 'Не найдено товаров';

  }

}
