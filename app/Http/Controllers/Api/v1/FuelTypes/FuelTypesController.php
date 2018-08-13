<?php
namespace App\Http\Controllers\Api\v1\FuelTypes;

use App\Modules\FuelTypes\Contracts\IFuelTypeRepository;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Response;


class FuelTypesController extends ApiController {

	/*
	|--------------------------------------------------------------------------
	| Shows Controller
	|--------------------------------------------------------------------------
	|
	|
	*/

	private $fuelTypeRepository;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(IFuelTypeRepository $fuelTypeRepository)
	{
	    $this->fuelTypeRepository = $fuelTypeRepository;
	}

	private function validateFuelType($request)
	{
		$messages = array(
			'*.description.unique' => trans('fuelTypes/model.fuel-type-already-exists')
		);

		return \Validator::make($request->all(), [
			'*.description' => 'unique:fuel-types'
		], $messages);
	}

	/**
	 *
	 * @return Response
	 */
	public function retrieve(Request $request)
	{
		$filter = [
			'description' => $request->input('filter.description'),
			'active' => $request->input('filter.active')
		];

		$orderBy = [
			'column' => $request->input('orderBy.column'),
			'direction' => $request->input('orderBy.direction')
		];

		$pagination = [
			'itemsPerPage' => $request->input('pagination.itemsPerPage'),
			'page' => $request->input('pagination.page')
		];

        return $this->respondSuccess($this->fuelTypeRepository->getFuelTypes($filter, $orderBy, $pagination));
	}

	public function create(Request $request)
	{
		$fuelTypeDto = [
			'description' => $request->input('data.description'),
			'active' => $request->input('data.active')
		];

		$validator = $this->validateFuelType($request);

		if ($validator->fails())
		{
			return $this->respondFail('error', $validator->errors()->all());
		}

		return $this->respondSuccess($this->fuelTypeRepository->create($fuelTypeDto));
	}

	public function update(Request $request)
	{
		$filter = $request->input('filter');

		$fuelTypeDto = [
			'description' => $request->input('data.description'),
			'active' => $request->input('data.active')
		];

		if (!empty($filter)) {
			$id = $filter['id'];

			return $this->respondSuccess($this->fuelTypeRepository->update($id, $fuelTypeDto));
		} else { // create
			return $this->respondFail('error', 'Id not found');
		}
	}
}