<?php
namespace App\Http\Controllers\Api\v1\Extras;

use App\Modules\Extras\Contracts\IExtraRepository;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Response;


class ExtrasController extends ApiController {

	/*
	|--------------------------------------------------------------------------
	| Shows Controller
	|--------------------------------------------------------------------------
	|
	|
	*/

	private $extraRepository;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(IExtraRepository $extraRepository)
	{
	    $this->extraRepository = $extraRepository;
	}

	private function validateExtra($request)
	{
		$messages = array(
			'*.description.unique' => trans('extras/model.extra-already-exists')
		);

		return \Validator::make($request->all(), [
			'*.description' => 'unique:extras'
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

        return $this->respondSuccess($this->extraRepository->getExtras($filter, $orderBy, $pagination));
	}

	public function create(Request $request)
	{
		$extrasDto = [
			'description' => $request->input('data.description'),
			'rankId' => $request->input('data.rankId'),
			'active' => $request->input('data.active')
		];

		$validator = $this->validateExtra($request);

		if ($validator->fails())
		{
			return $this->respondFail('error', $validator->errors()->all());
		}

		return $this->respondSuccess($this->extraRepository->create($extrasDto));
	}

	public function update(Request $request)
	{
		$filter = $request->input('filter');

		$extrasDto = [
			'description' => $request->input('data.description'),
			'rankId' => $request->input('data.rankId'),
			'active' => $request->input('data.active')
		];

		if (!empty($filter)) {
			$id = $filter['id'];

			return $this->respondSuccess($this->extraRepository->update($id, $extrasDto));
		} else { // create
			return $this->respondFail('error', 'Id not found');
		}
	}
}