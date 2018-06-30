<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Catalogs
        $this->app->bind(
            'App\Modules\Catalogs\Contracts\ICatalogService',
            'App\Modules\Catalogs\Services\CatalogService'
        );

        $this->app->bind(
            'App\Modules\Catalogs\Contracts\ICatalogRepository',
            'App\Modules\Catalogs\Repositories\CatalogRepository'
        );
    }
}
