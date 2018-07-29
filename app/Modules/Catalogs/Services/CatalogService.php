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
    public function getBrands($filter, $orderBy, $pagination)
    {
        return $this->catalogRepository->getBrands($filter, $orderBy, $pagination);
    }

    public function createBrand($brandDto)
    {
        return $this->catalogRepository->createBrand($brandDto);
    }    
}