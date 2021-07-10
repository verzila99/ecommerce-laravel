<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Category;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Storage;
use App\Actions\SearchFilter\SearchFilter;
use App\Http\Requests\StoreProductRequest;
use App\Actions\FavoritesList\FavoritesList;
use App\Http\Controllers\PropertyController;
use App\Actions\RecentlyViewed\RecentlyViewed;
use App\Actions\CustomPaginator\CustomPaginator;
use Illuminate\Contracts\Foundation\Application;
use App\Actions\WorkingWithImage\WorkingWithImage;
use Illuminate\Auth\Access\AuthorizationException;
use App\Actions\WorkingWithQueryString\WorkingWithQueryString;


class ProductController extends Controller
{

    public function index(Request $request, $category): View|Factory|Redirector|RedirectResponse|Application
    {
        Category::where('category_name', $category)->firstOrFail();

        $properties = Property::where('category_name', $category)->get();

        $productList = Product::getProducts($request, $category, $properties)->paginate(10);

        $sortingType = WorkingWithQueryString::getSortingType($request);

        $requestUri = WorkingWithQueryString::getQueryStringWithoutSorting($request);

        if ($productList->lastPage() < (int)$request->page) {
            return redirect($request->fullUrlWithQuery(['page' => 1]));
        }

        //sidebar inputs
        $appliedFilters = SearchFilter::getAppliedFilters($request, $properties);

        $filterInputs = Category::getInputFieldsForSidebar($category, $properties);

        $properties = $properties->toArray();

        $favoritesStatusList = FavoritesList::getFavoritesList();

        $minMaxPrice = [
            Product::select('price')->where('category', $category)->min('price'),
            Product::select('price')->where('category', $category)->max('price')
        ];

        $explodedQueryString = explode('&', str_replace('   ', ' + ', urldecode($request->getQueryString())));


        return view(
            'category',
            compact(
                [
                    'productList',
                    'requestUri',
                    'filterInputs',
                    'explodedQueryString',
                    'favoritesStatusList',
                    'properties',
                    'sortingType',
                    'minMaxPrice',
                    'appliedFilters'
                ]
            )
        );
    }


    public function indexApi(Request $request, $category): bool|string
    {
        $properties = Property::where('category_name', $category)->get();

        return Product::getProducts($request, $category, $properties)->count();
    }


    public function show($cat, $productId): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {

        $product = Product::with(['properties', 'categories'])->findOrFail($productId);

        $attributes = Property::where('category_name', $product->category)->get()->toArray();

        $favoritesStatusList = FavoritesList::getFavoritesList();

        Product::updateProductViews($product);

        RecentlyViewed::addToRecentlyViewed($productId);

        return view('product', compact(['product', 'favoritesStatusList', 'attributes']));
    }


    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $categories = Category::all();

        $propsOfCategory = Property::where('category_id', 1)->get();

        return view('admin.createProduct', compact('categories', 'propsOfCategory'));
    }


    public function store(StoreProductRequest $request): \Illuminate\Http\RedirectResponse
    {

        $validated = $request->validated();

        $category = Category::where('category_name', $validated['category'])->firstOrFail();

        $product = Product::create($validated + ['category_id' => $category->id]);

        $names = WorkingWithImage::storeImages($request, $product);

        PropertyController::store($request, $category, $product);

        Product::where('id', $product->id)->update(['images' => implode(',', $names)]);

        return redirect()->back()->with('status', 'Item added!');
    }


    public function edit($category, $id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {

        $categories = Category::all();

        $propsOfCategory = Property::where('category_id', 1)->get();

        $product = Product::with('properties')->findOrFail($id);

        return view('admin.editProduct', compact('product', 'categories', 'propsOfCategory'));
    }


    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {


        $validated = Product::validateUpdateProductRequest($request);

        $category = Category::where('category_name', $validated['category'])->firstOrFail();

        $product = Product::findOrFail($validated['id']);

        $names = WorkingWithImage::updateImages($request, $product);

        PropertyController::update($request, $category, $product);

        Product::where('id', $product->id)->update($validated + ['images' => implode(',', $names)]);

        return redirect()->back()->with('status', 'Item updated!');
    }


    public function destroy(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $this->authorize('updateProduct', Product::class);
        } catch (AuthorizationException $e) {
            abort(403);
        }

        $validated = $request->validate(['id' => 'required|numeric']);

        Product::destroy($validated['id']);

        Storage::deleteDirectory('public/uploads/images/' . $validated['id']);

        return redirect()->route('createProduct')->with('status', 'Item deleted!');
    }


    public function search(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {

        $query = Product::where('title', 'LIKE', '%' . $request->validate(['search_string' => 'required|string|min:1'])['search_string'] . '%');

        $productList = SearchFilter::applyFilters($request, $query)->get();

        $favoritesStatusList = FavoritesList::getFavoritesList();

        $propsOfCategory = Property::All();

        $productList->each(function ($product) use ($propsOfCategory) {
            $product->propsOfCategory = $propsOfCategory->filter(fn ($item) => $item->category_name === $product->category)
                ->pluck('name', 'name')
                ->toArray();
        });
        $sortingType = WorkingWithQueryString::getSortingType($request);

        $requestUri = WorkingWithQueryString::getQueryStringWithoutSorting($request);

        [$productList, $totalItems, $paginator] = CustomPaginator::makeCustomPaginator($productList, 10, $request, 'search');

        return view('search', compact('productList', 'totalItems', 'paginator', 'favoritesStatusList', 'sortingType', 'requestUri'));
    }


    public function searchApi(Request $request): string
    {

        $data = Product::where('title', 'LIKE', '%' . $request->validate(['search_string' => 'required|string'])['search_string'] . '%')->get();

        return $data ? $data->toJson() : 'No items found';
    }
}