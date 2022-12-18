<?php

namespace App\Providers;

use App\Models\ProductType;
use App\Models\Product;
use App\Models\User;

use App\Observers\ProductTypeObserver;
use App\Observers\ProductObserver;
use App\Observers\UserObserver;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        // Register observers
        ProductType::observe(ProductTypeObserver::class);
        Product::observe(ProductObserver::class);
        User::observe(UserObserver::class);

        // Register components
        Blade::component('components.currency', 'currency');
        Blade::component('components.a-order-status', 'aOrderStatus');
        Blade::component('components.order-status', 'orderStatus');
    }
}
