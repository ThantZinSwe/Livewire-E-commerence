<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        View::share( 'popular_products', Product::inRandomOrder()->limit( 4 )->get() );
        View::share( 'sale', Sale::find( 1 ) );
    }
}
