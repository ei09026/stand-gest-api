<?php

namespace App\Modules\Catalogs\Repositories;

use App\Modules\Catalogs\Contracts\ICatalogRepository;
use App\Modules\Catalogs\Models\Brand;
use App\Modules\BaseRepository;

class CatalogRepository extends BaseRepository implements ICatalogRepository {

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

    public function getBrands($filter, $orderBy, $pagination)
    {
        $search = $filter['description'];
        $active = $filter['active'];

        $query = $this->brand->where('description', 'ILIKE', "%$search%");

        if ($active === true) {
            $query->WhereNull('deleted_at');
        } else if ($active === false){
            $query->WhereNotNull('deleted_at');
        }

        $query->orderBy($orderBy['column'], $orderBy['direction']);

        return $query->paginate($pagination['itemsPerPage']);
    }

    public function createBrand($brandDto)
    {
        $brand = [
            'description' => $brandDto['description']
        ];

        $brand = $this->setCCreateUpdateDeleteValues($brand, !$brandDto['active']);

        $this->brand->create($brand);

        return $brand;

        /*

        if ($brand->hasErrors()) {
            return $brand;
        }

        return $query->paginate($pagination['itemsPerPage']);*/
    }
}