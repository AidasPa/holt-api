<?php

namespace App\Providers;

use App\Helpers\BlurhashHelper;
use App\Services\CategoryService;
use App\Services\MenuService;
use App\Services\RestaurantService;
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
        $this->app->singleton(RestaurantService::class);
        $this->app->singleton(MenuService::class);
        $this->app->singleton(CategoryService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
