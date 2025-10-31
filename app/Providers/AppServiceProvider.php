<?php

namespace App\Providers;

use App\Models\Categories;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         $setting = Setting::first();
         
        $category = Categories::with('children')->whereNull('parent_id')->get();
        $products = Product::orderBy('id', 'desc')->get(); 
          View::share([
        'setting' => $setting,
        'category' => $category,
        'products' => $products,
    ]);
    }
}
