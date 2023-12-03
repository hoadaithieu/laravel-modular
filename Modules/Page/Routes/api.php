<?php

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

//Route::middleware('auth:api')->get('/page', function (Request $request) {
//    return $request->page();
//});

$router->bind('page', function ($id) {
    return app(\Modules\Page\Repositories\PageRepository::class)->find($id);
});

Route::middleware(['api'])->prefix('/v1/admin/pages')->group(function (Router $router) {

    $router->get('/', [
        'as' => 'api.page.page.list',
        'uses' => 'Api\V1\Admin\PageController@index',
    ]);

    $router->get('/homing-page/posts', [
        'as' => 'api.page.post.list',
        'uses' => 'Api\V1\Admin\PageController@postsAtHomePage',
    ]);

    $router->get('/{page}', [
        'as' => 'api.page.page.show',
        'uses' => 'Api\V1\Admin\PageController@show',
    ]);

    $router->post('/', [
        'as' => 'api.page.page.create',
        'uses' => 'Api\V1\Admin\PageController@store',
    ]);

    $router->patch('/{page}', [
        'as' => 'api.page.page.update',
        'uses' => 'Api\V1\Admin\PageController@update',
    ]);

    $router->delete('/{page}', [
        'as' => 'api.page.page.destroy',
        'uses' => 'Api\V1\Admin\PageController@destroy',
    ]);

});
