<?php

namespace App\Modules\FuelTypes\Repositories;

use App\Modules\FuelTypes\Contracts\IFuelTypeRepository;
use App\Modules\FuelTypes\Models\FuelType;
use App\Modules\BaseRepository;
use Paginator;

class FuelTypeRepository extends BaseRepository implements IFuelTypeRepository {

    /*
    |--------------------------------------------------------------------------
    | User Repository
    |--------------------------------------------------------------------------
    |
    |
    */

    private $fuelType;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FuelType $fuelType)
    {
        $this->fuelType = $fuelType;
    }

    public function getFuelTypes($filter, $orderBy, $pagination)
    {
        $search = $filter['description'];
        $active = $filter['active'];

        $query = $this->fuelType->where('description', 'ILIKE', "%$search%");

        if ($active === true) {
            $query->WhereNull('deleted_at');
        } else if ($active === false){
            $query->WhereNotNull('deleted_at');
        }

        $query->orderBy($orderBy['column'], $orderBy['direction']);

        return $query->paginate($pagination['itemsPerPage'], ['*'], 'page', $pagination['page']);
    }

    public function create($fuelTypeDto)
    {
        $fuelType = [
            'description' => $fuelTypeDto['description']
        ];

        $fuelType = $this->setCCreateUpdateDeleteValues($fuelType, !$fuelTypeDto['active']);

        $this->fuelType->create($fuelType);

        return $fuelType;
    }

    public function update($id, $fuelTypeDto) {
        $fuelType = $this->fuelType->find($id);

        $fuelType->description = $fuelTypeDto['description'];

        $fuelType = $this->setUCreateUpdateDeletedValues($fuelType);

        if ($fuelTypeDto['active'] === false) {
            $fuelType = $this->setDeletedValues($fuelType);
        } else {
            $fuelType = $this->clearDeletedValues($fuelType);
        }

        $fuelType->save();

        return $fuelType;
    }
}