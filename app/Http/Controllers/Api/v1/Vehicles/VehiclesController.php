<?php
namespace App\Http\Controllers\Api\v1\Vehicles;

use App\Modules\Vehicles\Contracts\IVehicleRepository;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Response;


class VehiclesController extends ApiController {

	/*
	|--------------------------------------------------------------------------
	| Shows Controller
	|--------------------------------------------------------------------------
	|
	|
	*/

	private $vehicleRepository;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(IVehicleRepository $vehicleRepository)
	{
	    $this->vehicleRepository = $vehicleRepository;
	}

	private function validateVehicle($request)
	{
		$messages = array(
			'*.description.unique' => trans('vehicles/model.vehicle-already-exists')
		);

		return \Validator::make($request->all(), [
			'*.description' => 'unique:vehicles'
		], $messages);
	}

	/**
	 *
	 * @return Response
	 */
	public function retrieve(Request $request)
	{
		$filter = [
			'plate' => $request->input('filter.plate'),
			'brandId' => $request->input('filter.brand_id')
		];

		$orderBy = [
			'column' => $request->input('orderBy.column'),
			'direction' => $request->input('orderBy.direction')
		];

		$pagination = [
			'itemsPerPage' => $request->input('pagination.itemsPerPage'),
			'page' => $request->input('pagination.page')
		];

        return $this->respondSuccess($this->vehicleRepository->getVehicles($filter, $orderBy, $pagination));
	}

	public function create(Request $request)
	{
		$vehicleDto = [
			'description' => $request->input('data.description'),
			'active' => $request->input('data.active')
		];

		$validator = $this->validateVehicle($request);

		if ($validator->fails())
		{
			return $this->respondFail('error', $validator->errors()->all());
		}

		return $this->respondSuccess($this->vehicleRepository->create($vehicleDto));
	}

	public function update(Request $request)
	{
		$filter = $request->input('filter');

		$vehicleDto = [
			'description' => $request->input('data.description'),
			'active' => $request->input('data.active')
		];

		if (!empty($filter)) {
			$id = $filter['id'];

			return $this->respondSuccess($this->vehicleRepository->update($id, $vehicleDto));
		} else { // create
			return $this->respondFail('error', 'Id not found');
		}
	}
}