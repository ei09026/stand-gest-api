<?php 
namespace App\Http\Controllers\Api\v1;

use App\Modules\Catalogs\Contracts\ICatalogService;
use Illuminate\Http\Request;
use \Response;
use App\Http\Controllers\Controller;


class CatalogsController extends Controller {

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
		dd('teste');
        $page = $request->input('page');
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        return $this->catalogService->getBrands($page, $perPage, $search);
	}
}
