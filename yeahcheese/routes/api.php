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
    Route::get('/fetch/{id}', 'Api\EventController@fetch')->name('events.fetch');
    Route::put('/update', 'Api\EventController@update')->name('events.update');
});

Route::prefix('pictures')->group(function () {
    Route::get('/list/{event_id}', 'Api\PictureController@list')->name('pictures.list');
    Route::get('/fetch/{picture_id}', 'Api\PictureController@fetch')->name('pictures.fetch');
    Route::post('/store', 'Api\PictureController@store')->name('pictures.store');
    Route::delete('/destroy/{picture_id}', 'Api\PictureController@destroy')->name('pictures.destroy');
});
