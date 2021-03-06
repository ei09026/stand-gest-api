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
    Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1\Users'], function() {
        //Catalogs
        Route::post('users', 'UsersController@postIndex');
    });

    Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1\Brands'], function() {
        //Catalogs
        Route::post('brands', 'BrandsController@postIndex');
    });

    Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1\FuelTypes'], function() {
        //Catalogs
        Route::post('fuel-types', 'FuelTypesController@postIndex');
    });

    Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1\Vehicles'], function() {
        //Catalogs
        Route::post('vehicles', 'VehiclesController@postIndex');
    });

    Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1\Extras'], function() {
        //Catalogs
        Route::post('extras', 'ExtrasController@postIndex');
    });

    Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1\Colors'], function() {
        //Catalogs
        Route::post('colors', 'ColorsController@postIndex');
    });
});