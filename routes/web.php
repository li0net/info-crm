<?php

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

Route::get('/serviceCategories', 'ServiceCategoriesController@index');

Route::get('/serviceCategories/gridData', 'ServiceCategoriesController@gridData');

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
