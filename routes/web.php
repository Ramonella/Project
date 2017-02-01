<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'MainController@show');

Route::get('add', 'MainController@store');

Route::get('getContact', 'MainController@getContact');

Route::get('update', 'MainController@update');

Route::get('delete', 'MainController@delete');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/got', [
  'middleware' => ['auth'],
  'uses' => function () {
   echo "You are allowed to view this page!";
}]);


Route::post('guardar', "MainController@guardar");

Route::get('buscar', 'MainController@buscar');

Route::post('subir_temp', 'MainController@subirTemp');

Route::post('actualizar', 'MainController@actualizarContacto');

Route::get('getCountries', 'ApiController@getAllCountries');

Route::get('/gmaps', ['as ' => 'gmaps', 'uses' => 'GmapsController@index']);

Route::get('getUserId', 'MainController@getUserId');

Route::post('setMessages', 'ChatController@setMessages');