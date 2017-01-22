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

Route::get('/stub', function () {
    return view('stub');
});

/*
 * Гриды
 */
Route::get('/serviceCategories', 'ServiceCategoriesController@index');
Route::get('/services', 'ServicesController@index');
Route::get('/users', 'UsersController@index');
Route::get('/clients', 'ClientsController@index');

Route::resource('/employee', 'EmployeeController');
Route::put('/employee', 'EmployeeController@store');
Route::resource('/position', 'PositionController');
Route::post('/home', 'homeController@indexFiltered');

//Route::get('/serviceCategories/gridData', 'ServiceCategoriesController@gridData');
Route::get('/serviceCategories/gridData', function()
{
    GridEncoder::encodeRequestedData(new \App\GridRepositories\ServiceCategoriesGridRepository(), Input::all());
});
Route::get('/services/gridData', function()
{
    GridEncoder::encodeRequestedData(new \App\GridRepositories\ServicesGridRepository(), Input::all());
});
Route::get('/users/gridData', function()
{
    GridEncoder::encodeRequestedData(new \App\GridRepositories\UsersGridRepository(), Input::all());
});
Route::get('/clients/gridData', function()
{
    GridEncoderCustom::encodeRequestedData(new \App\GridRepositories\ClientsGridRepository(), Input::all());
});
Route::post('/clients/gridData', function()
{
    GridEncoderCustom::encodeRequestedData(new \App\GridRepositories\ClientsGridRepository(), Input::all());
});

/*
 * Формы
 */
Route::get('/serviceCategories/create', 'ServiceCategoriesController@create');
Route::get('/serviceCategories/edit/{serviceCategory}', 'ServiceCategoriesController@edit');
Route::post('/serviceCategories/save', 'ServiceCategoriesController@save');
Route::get('/serviceCategories/destroy/{scId}', 'ServiceCategoriesController@destroy');

Route::get('/services/create', 'ServicesController@create');
Route::get('/services/edit/{service}', 'ServicesController@edit');
Route::post('/services/save', 'ServicesController@save');
Route::get('/services/destroy/{serviceId}', 'ServicesController@destroy');

Route::get('/organization/edit', 'OrganizationsController@edit');
Route::post('/organization/save', 'OrganizationsController@save');

Route::get('/appointments/create', 'AppointmentsController@create');
Route::get('/appointments/edit/{appt}', 'AppointmentsController@edit');
Route::post('/appointments/save', 'AppointmentsController@save');
Route::post('/appointments/getEmployeesForService/{service}', 'AppointmentsController@getEmployeesForServices');
Route::get('/appointments/getEmployeesForService/{service}', 'AppointmentsController@getEmployeesForServices');
Route::post('/appointments/getClientInfo', 'AppointmentsController@getClientInfo');

Route::get('/users/create', 'UsersController@create');
Route::get('/users/edit/{user}', 'UsersController@edit');
Route::post('/users/save', 'UsersController@save');
Route::post('/users/{user}/savePermissions', 'UsersController@savePermissions');

Route::get('/clients/create', 'ClientsController@create');

Route::post('/image-upload/{id}', ['as' => 'upload', 'uses' => 'UploadImageController@uploadImage']);
Route::get('/image-upload', 'UploadImageController@uploadImage');

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
