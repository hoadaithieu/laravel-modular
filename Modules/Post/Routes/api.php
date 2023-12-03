<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

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

$router->bind('post', function ($id) {
    return app(\Modules\Post\Repositories\PostRepository::class)->find($id);
});

//Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
//    Route::get('post', fn(Request $request) => $request->user())->name('post');
//});

Route::middleware(['api'])->prefix('/v1/admin/posts')->group(function (Router $router) {

    $router->get('/', [
        'as' => 'api.post.post.list',
        'uses' => 'Api\V1\Admin\PostController@index',
        //'middleware' => 'token-can:listing.listing.index',
    ]);

    $router->get('/{post}', [
        'as' => 'api.post.post.show',
        'uses' => 'Api\V1\Admin\PostController@show',
        //'middleware' => 'token-can:listing.listing.index',
    ]);

    $router->post('/', [
        'as' => 'api.post.post.store',
        'uses' => 'Api\V1\Admin\PostController@store',
        //'middleware' => 'token-can:listing.listing.index',
    ]);

    $router->put('/{post}', [
        'as' => 'api.post.post.update',
        'uses' => 'Api\V1\Admin\PostController@update',
        //'middleware' => 'token-can:listing.listing.index',
    ]);

    /*
    $router->patch('/{post}', [
    'as' => 'api.post.post.update',
    'uses' => 'Api\V1\Admin\PostController@update',
    //'middleware' => 'token-can:listing.listing.index',
    ]);
     */

    $router->delete('/{post}', [
        'as' => 'api.post.post.destroy',
        'uses' => 'Api\V1\Admin\PostController@destroy',
        //'middleware' => 'token-can:listing.listing.index',
    ]);
});

$router->bind('comment', function ($id) {
    return app(\Modules\Post\Repositories\CommentRepository::class)->find($id);
});

Route::middleware(['api'])->prefix('/v1/admin/posts/{post}/comments')->group(function (Router $router) {

    $router->get('/', [
        'as' => 'api.post.comment.list',
        'uses' => 'Api\V1\Admin\CommentController@index',
        //'middleware' => 'token-can:listing.listing.index',
    ]);

    $router->get('/{comment}', [
        'as' => 'api.post.comment.show',
        'uses' => 'Api\V1\Admin\CommentController@show',
        //'middleware' => 'token-can:listing.listing.index',
    ]);

    $router->post('/', [
        'as' => 'api.post.comment.store',
        'uses' => 'Api\V1\Admin\CommentController@store',
        //'middleware' => 'token-can:listing.listing.index',
    ]);

    $router->put('/{comment}', [
        'as' => 'api.post.comment.update',
        'uses' => 'Api\V1\Admin\CommentController@update',
        //'middleware' => 'token-can:listing.listing.index',
    ]);

    $router->delete('/{comment}', [
        'as' => 'api.post.comment.destroy',
        'uses' => 'Api\V1\Admin\CommentController@destroy',
        //'middleware' => 'token-can:listing.listing.index',
    ]);
});
