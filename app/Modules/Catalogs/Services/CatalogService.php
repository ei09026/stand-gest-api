<?php

namespace App\Modules\Catalogs\Services;

use App\Modules\Catalogs\Contracts\ICatalogRepository;
use App\Modules\Catalogs\Contracts\ICatalogService;

class CatalogService implements ICatalogService {

    /*
    |--------------------------------------------------------------------------
    | Shows Controller
    |--------------------------------------------------------------------------
    |
    |
    */

    private $catalogRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ICatalogRepository $catalogRepository)
    {
        $this->catalogRepository = $catalogRepository;
    }

    /**
     *
     * @return Response
     */
    public function getBrands($page, $perPage, $search)
    {
        return $this->catalogRepository->getBrands($page, $perPage, $search);
    }
}