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

use Illuminate\Support\Facades\Input;
use App\ServiceCategoriesGridRepository;

Route::get('/', function () {
    return view('welcome');
});


/*
 * Гриды
 */
Route::get('/serviceCategories', 'ServiceCategoriesController@index');
Route::get('/services', 'ServicesController@index');

//Route::get('/serviceCategories/gridData', 'ServiceCategoriesController@gridData');
Route::get('/serviceCategories/gridData', function()
{
    GridEncoder::encodeRequestedData(new \App\GridRepositories\ServiceCategoriesGridRepository(), Input::all());
});
Route::get('/services/gridData', function()
{
    GridEncoder::encodeRequestedData(new \App\GridRepositories\ServicesGridRepository(), Input::all());
});


Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
