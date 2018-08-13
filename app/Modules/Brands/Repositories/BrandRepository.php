<?php

namespace App\Modules\Brands\Repositories;

use App\Modules\Brands\Contracts\IBrandRepository;
use App\Modules\Brands\Models\Brand;
use App\Modules\BaseRepository;
use Paginator;

class BrandRepository extends BaseRepository implements IBrandRepository {

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

        return $query->paginate($pagination['itemsPerPage'], ['*'], 'page', $pagination['page']);
    }

    public function create($brandDto)
    {
        $brand = [
            'description' => $brandDto['description']
        ];

        $brand = $this->setCCreateUpdateDeleteValues($brand, !$brandDto['active']);

        $this->brand->create($brand);

        return $brand;
    }

    public function update($id, $brandDto) {
        $brand = $this->brand->find($id);

        $brand->description = $brandDto['description'];
        
        $brand = $this->setUCreateUpdateDeletedValues($brand);

        if ($brandDto['active'] === false) {
            $brand = $this->setDeletedValues($brand);
        } else {
            $brand = $this->clearDeletedValues($brand);
        }
        
        $brand->save();

        return $brand;
    }
}