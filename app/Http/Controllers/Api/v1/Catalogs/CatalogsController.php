<?php 
namespace App\Http\Controllers\Api\v1;

use App\Modules\Catalogs\Contracts\ICatalogService;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Response;


class CatalogsController extends ApiController {

	/*
	|--------------------------------------------------------------------------
	| Shows Controller
	|--------------------------------------------------------------------------
	|	
	|
	*/

	private $catalogService;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(ICatalogService $catalogService)
	{
	    $this->catalogService = $catalogService;
	}

	/**
	 *
	 * @return Response
	 */
	public function getBrands(Request $request)
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

        return $this->respondSuccess($this->catalogService->getBrands($filter, $orderBy, $pagination));
	}

	public function createBrand(Request $request)
	{	
		$brandDto = [
			'description' => $request->input('data.description'),
			'active' => $request->input('data.active')
		];

        return $this->respondSuccess($this->catalogService->createBrand($brandDto));
	}	
}
