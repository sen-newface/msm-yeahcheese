<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::prefix('events')->group(function () {
    Route::get('/', 'EventController@index')->name('events.index');
    Route::get('create', 'EventController@create')->name('events.create');
    Route::post('/', 'EventController@store')->name('events.store');
    Route::get('update', 'EventController@update')->name('events.update');
    # テスト表示用なのでputは用意しません
    Route::get('search', 'EventController@search')->name('events.search');
    Route::get('show', 'EventController@show')->name('events.show');
});
