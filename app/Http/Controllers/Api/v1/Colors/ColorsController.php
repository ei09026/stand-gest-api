<?php
namespace App\Http\Controllers\Api\v1\Colors;

use App\Modules\Colors\Contracts\IColorRepository;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Response;


class ColorsController extends ApiController {

	/*
	|--------------------------------------------------------------------------
	| Shows Controller
	|--------------------------------------------------------------------------
	|
	|
	*/

	private $colorRepository;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(IColorRepository $colorRepository)
	{
	    $this->colorRepository = $colorRepository;
	}

	private function validateColor($request)
	{
		$messages = array(
			'*.description.unique' => trans('colors/model.color-already-exists')
		);

		return \Validator::make($request->all(), [
			'*.description' => 'unique:colors'
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
			'rankId' => $request->input('filter.rankId'),
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

        return $this->respondSuccess($this->colorRepository->getColors($filter, $orderBy, $pagination));
	}

	public function create(Request $request)
	{
		$colorsDto = [
			'description' => $request->input('data.description'),
			'rankId' => $request->input('data.rankId'),
			'active' => $request->input('data.active')
		];

		$validator = $this->validateColor($request);

		if ($validator->fails())
		{
			return $this->respondFail('error', $validator->errors()->all());
		}

		return $this->respondSuccess($this->colorRepository->create($colorsDto));
	}

	public function update(Request $request)
	{
		$filter = $request->input('filter');

		$colorsDto = [
			'description' => $request->input('data.description'),
			'rankId' => $request->input('data.rankId'),
			'active' => $request->input('data.active')
		];

		if (!empty($filter)) {
			$id = $filter['id'];

			return $this->respondSuccess($this->colorRepository->update($id, $colorsDto));
		} else { // create
			return $this->respondFail('error', 'Id not found');
		}
	}
}