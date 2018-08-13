<?php
namespace App\Http\Controllers\Api\v1\Users;

use App\Modules\Users\Contracts\IUserRepository;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Response;


class UsersController extends ApiController {

	/*
	|--------------------------------------------------------------------------
	| Shows Controller
	|--------------------------------------------------------------------------
	|
	|
	*/

	private $userRepository;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(IUserRepository $userRepository)
	{
	    $this->userRepository = $userRepository;
	}

	private function validateUser($request)
	{
		$messages = array(
			'*.username.unique' => trans('users/model.username-already-exists'),
			'*.email.unique' => trans('users/model.email-already-exists'),
		);

		return \Validator::make($request->all(), [
			'*.username' => 'unique:users',
			'*.email' => 'unique:users',
		], $messages);
	}

	/**
	 *
	 * @return Response
	 */
	public function retrieve(Request $request)
	{
		$filter = [
			'name' => $request->input('filter.name'),
			'email' => $request->input('filter.email'),
			'username' => $request->input('filter.username'),
			'active' => $request->input('filter.active'),
		];

		$orderBy = [
			'column' => $request->input('orderBy.column'),
			'direction' => $request->input('orderBy.direction')
		];

		$pagination = [
			'itemsPerPage' => $request->input('pagination.itemsPerPage'),
			'page' => $request->input('pagination.page')
		];

        return $this->respondSuccess($this->userRepository->getUsers($filter, $orderBy, $pagination));
	}

	public function create(Request $request)
	{
		$userDto = [
			'name' => $request->input('data.name'),
			'email' => $request->input('data.email'),
			'username' => $request->input('data.username'),
			'picture' => $request->input('data.picture'),
			'active' => $request->input('data.active'),
			'password' => $request->input('data.password')
		];

		$validator = $this->validateUser($request);

		if ($validator->fails())
		{
			return $this->respondFail('error', $validator->errors()->all());
		}

		return $this->respondSuccess($this->userRepository->create($userDto));
	}

	public function update(Request $request)
	{
		$filter = $request->input('filter');

		$userDto = [
			'name' => $request->input('data.name'),
			'email' => $request->input('data.email'),
			'username' => $request->input('data.username'),
			'picture' => $request->input('data.picture'),
			'active' => $request->input('data.active'),
			'password' => $request->input('data.password')
		];

		if (!empty($filter)) {
			$id = $filter['id'];

			return $this->respondSuccess($this->brandRepository->update($id, $userDto));
		} else { // create
			return $this->respondFail('error', 'Id not found');
		}
	}
}