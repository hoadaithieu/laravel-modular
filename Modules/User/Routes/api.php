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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$router->bind('user', function ($id) {
    return app(\Modules\User\Repositories\UserRepository::class)->find($id);
});

$router->bind('company', function ($id) {
    return app(\Modules\User\Repositories\CompanyRepository::class)->find($id);
});

//Route::middleware(['auth:api'])->prefix('/v1/admin/user')->group(function (Router $router) {
Route::middleware(['api'])->prefix('/v1/admin/company')->group(function (Router $router) {

    // company

    $router->get('/', [
        'as' => 'api.user.company.list',
        'uses' => 'Api\V1\Admin\CompanyController@index',
        //'middleware' => 'token-can:listing.listing.index',
    ]);

    $router->get('/{company}', [
        'as' => 'api.user.company.show',
        'uses' => 'Api\V1\Admin\CompanyController@show',
        //'middleware' => 'token-can:listing.listing.index',
    ]);

    $router->patch('/{company}', [
        'as' => 'api.user.company.update',
        'uses' => 'Api\V1\Admin\CompanyController@update',
        //'middleware' => 'token-can:listing.listing.index',
    ]);

    $router->delete('/{company}', [
        'as' => 'api.user.company.destroy',
        'uses' => 'Api\V1\Admin\CompanyController@destroy',
        //'middleware' => 'token-can:listing.listing.index',
    ]);

});

//Route::middleware(['auth:api'])->prefix('/v1/admin/user')->group(function (Router $router) {
Route::middleware(['api'])->prefix('/v1/admin/users')->group(function (Router $router) {

    $router->get('/', [
        'as' => 'api.user.user.list',
        'uses' => 'Api\V1\Admin\UserController@index',
        //'middleware' => 'token-can:listing.listing.index',
    ]);

    $router->get('/profile', [
        'as' => 'api.user.user.profile',
        'uses' => 'Api\V1\Admin\UserController@profile',
        //'middleware' => 'token-can:listing.listing.index',
    ]);

    $router->get('/{user}', [
        'as' => 'api.user.user.show',
        'uses' => 'Api\V1\Admin\UserController@show',
        //'middleware' => 'token-can:listing.listing.index',
    ]);

    $router->patch('/{user}', [
        'as' => 'api.user.user.update',
        'uses' => 'Api\V1\Admin\UserController@update',
        //'middleware' => 'token-can:listing.listing.index',
    ]);

    $router->delete('/{user}', [
        'as' => 'api.user.user.destroy',
        'uses' => 'Api\V1\Admin\UserController@destroy',
        //'middleware' => 'token-can:listing.listing.index',
    ]);

    $router->post('/media', [
        'as' => 'api.user.user.upload',
        'uses' => 'Api\V1\Admin\UserController@upload',
        //'middleware' => 'token-can:listing.listing.index',
    ]);

    // company

    $router->get('/{user}/company', [
        'as' => 'api.user.company.list',
        'uses' => 'Api\V1\Admin\CompanyController@index',
        //'middleware' => 'token-can:listing.listing.index',
    ]);
});

Route::middleware(['api'])->prefix('/v1/admin/auth')->group(function (Router $router) {

    $router->post('/login', [
        'as' => 'api.user.auth.login',
        'uses' => 'Api\V1\Admin\AuthController@login',
        //'middleware' => 'token-can:listing.listing.index',
    ]);

    $router->post('/register', [
        'as' => 'api.user.auth.register',
        'uses' => 'Api\V1\Admin\AuthController@register',
        //'middleware' => 'token-can:listing.listing.index',
    ]);

});
