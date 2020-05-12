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
Route::get('/index', 'EventController@index')->name('event.index');
Route::get('/event/create', 'EventController@create')->name('event.create');
Route::post('/event/create', 'EventController@store')->name('event.store');
Route::get('/event/update', 'EventController@update')->name('event.update');
# テスト表示用なのでputは用意しません
Route::get('/event/search', 'EventController@search')->name('event.search');
Route::get('/event/show/{id}', 'EventController@show')->name('event.show');
