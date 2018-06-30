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
        Route::get('authenticate', ['uses' => 'AuthenticationController@authenticate']);
    });
});*/


/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1'], function() {
    //Shows
    /*Route::get('shows', 'ShowsController@getPaginated');
    Route::get('shows/all', 'ShowsController@getAll');
    Route::get('shows/poster', 'ShowsController@getPoster');

    //Users
    Route::post('users/context', 'UsersController@context');
    Route::post('users/facebook-login', 'UsersController@facebookLogin');
    Route::post('users/link-user-show', 'UsersController@linkUserShow');

    Route::post('users/remove-spoilers', 'UsersController@removeSpoilers');

    //Spoilers
    Route::post('spoilers', 'SpoilersController@createSpoiler');
    Route::post('spoilers/madness', 'SpoilersController@setMadness');
    Route::get('spoilers/get-spoilers', 'SpoilersController@getSpoilers');*/
        //Catalogs
    Route::get('catalogs/get-brands', 'CatalogsController@getBrands');

    Route::group(['prefix' => 'authentication', 'namespace' => 'Authentication'], function() {
        Route::get('authenticate', ['uses' => 'AuthenticationController@authenticate']);
    });
});