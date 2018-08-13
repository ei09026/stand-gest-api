<?php
namespace App\Http\Controllers\Api\v1\Brands;

use App\Modules\Brands\Contracts\IBrandRepository;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Response;


class BrandsController extends ApiController {

	/*
	|--------------------------------------------------------------------------
	| Shows Controller
	|--------------------------------------------------------------------------
	|
	|
	*/

	private $brandRepository;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(IBrandRepository $brandRepository)
	{
	    $this->brandRepository = $brandRepository;
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

        return $this->respondSuccess($this->brandRepository->getBrands($filter, $orderBy, $pagination));
	}

	public function create(Request $request)
	{
		$brandDto = [
			'description' => $request->input('data.description'),
			'active' => $request->input('data.active')
		];

		$messages = array(
			'*.description.unique' => trans('catalog/brand/model.brand-already-exists')
		);

		$validator = \Validator::make($request->all(), [
			'*.description' => 'unique:brands'
		], $messages);

		if ($validator->fails())
		{
			return $this->respondFail('error', $validator->errors()->all());
		}

		return $this->respondSuccess($this->brandRepository->create($brandDto));
	}

	public function update(Request $request)
	{
		$filter = $request->input('filter');

		$brandDto = [
			'description' => $request->input('data.description'),
			'active' => $request->input('data.active')
		];

		if (!empty($filter)) {
			$id = $filter['id'];

			return $this->respondSuccess($this->brandRepository->update($id, $brandDto));
		} else { // create
			return $this->respondFail('error', 'Id not found');
		}
	}
}