<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('events')->group(function () {
    Route::get('/', 'Api\EventController@fetch')->name('events.fetch');
    Route::put('/', 'Api\EventController@update')->name('events.update');
});

Route::prefix('pictures')->group(function () {
    Route::get('/', 'Api\PictureController@fetch')->name('pictures.fetch');
    Route::post('/', 'Api\PictureController@store')->name('pictures.store');
});
