<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Category;
use App\Subcategory;

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
        View::composer(['Users.Navbar','Users.index'], function ($view) {
            $view->with('categories', Category::with('subcategories')->get());
        });

        View::composer('Users.Navbar', function ($view) {
            $subcategories = Subcategory::take(4)->get();
            $view->with('subcategories', $subcategories);
             });

             View::composer('Users.index', function ($view) {
                $view->with('categories', Category::withCount('products')->take(6)->get());
                 });
        
        View::composer('Users.all_products', function ($view) {
            $view->with('categories', Category::withCount('products')->get());
        });
       
    }
}
