<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Global api
/*Route::group(['prefix' => 'v1', 'namespace' => 'Http\Controllers\Api'], function() {
    Route::group(['prefix' => 'v1', 'namespace' => 'v1'], function() {
    });
});*/


/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1'], function() {
    Route::group(['prefix' => 'authentication', 'namespace' => 'Authentication'], function() {
        Route::get('authenticate', ['uses' => 'AuthenticationController@authenticate']);
    });
});

Route::group(['middleware' => ['jwt.auth']], function() {
    Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1\Brands'], function() {
        //Catalogs
        Route::post('brands', 'BrandsController@postIndex');
    });
});