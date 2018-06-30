<?php

namespace App\Modules\Catalogs\Contracts;

interface ICatalogRepository {
    public function getBrands($page, $perPage, $search);
}