<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
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

//Route::middleware('auth:api')->get('/listing', function (Request $request) {
Route::middleware('api')->get('/v1/listing', function (Request $request) {

    return $request->user();
});

//Route::middleware('api')->get('/admin/v1/listing', function (Request $request) {

//return $request->user();
//return '';
//});

Route::middleware(['api'])->prefix('/v1/admin/listing')->group(function (Router $router) {

    $router->get('/', function () {
        // Uses first & second middleware...
        return 'Listing';
    });

    $router->get('/vote', [
        'as' => 'api.listing.listing.index',
        'uses' => 'Api\V1\Admin\ListingController@index',
        //'middleware' => 'token-can:listing.listing.index',
    ]
    );
});
