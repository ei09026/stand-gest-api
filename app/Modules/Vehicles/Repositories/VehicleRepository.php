<?php

namespace App\Modules\Vehicles\Repositories;

use App\Modules\Vehicles\Contracts\IVehicleRepository;
use App\Modules\Vehicles\Models\Vehicle;
use App\Modules\BaseRepository;
use Paginator;

class VehicleRepository extends BaseRepository implements IVehicleRepository {

    /*
    |--------------------------------------------------------------------------
    | User Repository
    |--------------------------------------------------------------------------
    |
    |
    */

    private $vehicle;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function getVehicles($filter, $orderBy, $pagination)
    {
        $plate = $filter['plate'];
        $brandId = $filter['brandId'];

        $query = $this->vehicle
            ->where('plate', 'ILIKE', "%$plate%");

/*        if(!empty($brandId)) {
            $query->where('brand_id', $brandId);
        }

        return $query->toSql();*/

        $query->orderBy($orderBy['column'], $orderBy['direction']);

        return $query->paginate($pagination['itemsPerPage'], ['*'], 'page', $pagination['page']);
    }

    public function create($vehicleDto)
    {
        $vehicle = [
            'description' => $vehicleDto['description']
        ];

        $vehicle = $this->setCCreateUpdateDeleteValues($vehicle, !$vehicleDto['active']);

        $this->vehicle->create($vehicle);

        return $vehicle;
    }

    public function update($id, $vehicleDto) {
        $vehicle = $this->vehicle->find($id);

        $vehicle->description = $vehicleDto['description'];
        
        $vehicle = $this->setUCreateUpdateDeletedValues($vehicle);

        if ($vehicleDto['active'] === false) {
            $vehicle = $this->setDeletedValues($vehicle);
        } else {
            $vehicle = $this->clearDeletedValues($vehicle);
        }
        
        $vehicle->save();

        return $vehicle;
    }
}