<?php

namespace App\Modules\Brands\Contracts;

interface IBrandRepository {
    public function getBrands($page, $perPage, $search);
}