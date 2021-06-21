<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        view()->composer('layouts.default', static function($view,) {
            $view->with('categories', Category::getCategoriesForCatalog());
        });
        view()->composer('admin.layouts.default', static function($view,) {
            $view->with('categories', Category::All());
        });
        view()->composer('layouts.default', static function ($view,) {
            $view->with('viewed', Product::getViewedProducts());
        });
    }
}
