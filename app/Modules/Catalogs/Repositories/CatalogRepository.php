<?php

namespace App\Modules\Catalogs\Repositories;

use App\Modules\Catalogs\Contracts\ICatalogRepository;
use App\Modules\Catalogs\Models\Brand;

class CatalogRepository implements ICatalogRepository {

    /*
    |--------------------------------------------------------------------------
    | User Repository
    |--------------------------------------------------------------------------
    |
    |
    */

    private $brand;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    public function getBrands($page, $perPage, $search)
    {
        if(empty($perPage)) {
            $perPage = 10;
        }

        return $this->brand->where('description', 'ILIKE', "%$search%")->paginate($perPage);
    }
}