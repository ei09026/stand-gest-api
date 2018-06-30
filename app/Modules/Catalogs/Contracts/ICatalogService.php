<?php

namespace App\Modules\Catalogs\Contracts;

interface ICatalogService {
    public function getBrands($page, $perPage, $search);
}