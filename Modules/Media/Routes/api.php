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
$router->bind('media', function ($id) {
    return app(\Modules\Media\Repositories\FileRepository::class)->find($id);
});

Route::middleware(['api'])->prefix('/v1/admin/media')->group(function (Router $router) {

    $router->post('/file', ['uses' => 'Api\V1\Admin\MediaController@store', 'as' => 'api.media.store']);

    $router->post('/upload', ['uses' => 'Api\V1\Admin\MediaController@upload', 'as' => 'api.media.upload']);

});
