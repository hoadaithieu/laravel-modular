<?php

use Illuminate\Support\Facades\Route;
use $MODULE_NAMESPACE$\Address\$CONTROLLER_NAMESPACE$\AddressController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], function () {
    Route::resource('address', AddressController::class)->names('address');
});
