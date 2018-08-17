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

        $this->app->bind(
            'App\Modules\Brands\Contracts\IBrandRepository',
            'App\Modules\Brands\Repositories\BrandRepository'
        );
        
        $this->app->bind(
            'App\Modules\FuelTypes\Contracts\IFuelTypeRepository',
            'App\Modules\FuelTypes\Repositories\FuelTypeRepository'
        );

        $this->app->bind(
            'App\Modules\Users\Contracts\IUserRepository',
            'App\Modules\Users\Repositories\UserRepository'
        );

        $this->app->bind(
            'App\Modules\Vehicles\Contracts\IVehicleRepository',
            'App\Modules\Vehicles\Repositories\VehicleRepository'
        );

        $this->app->bind(
            'App\Modules\Extras\Contracts\IExtraRepository',
            'App\Modules\Extras\Repositories\ExtraRepository'
        );

        $this->app->bind(
            'App\Modules\Colors\Contracts\IColorRepository',
            'App\Modules\Colors\Repositories\ColorRepository'
        );
    }
}
