<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/v1/widget/show', 'Widget\BaseWidgetController@getInitScreen');
Route::get('/v1/widget/getDivisions', 'Widget\BaseWidgetController@getDivisions');
Route::post('/v1/widget/getDivisions', 'Widget\BaseWidgetController@getDivisions');
Route::post('/v1/widget/getCategories', 'Widget\BaseWidgetController@getServiceCategories');
Route::post('/v1/widget/getServices', 'Widget\BaseWidgetController@getServices');
Route::post('/v1/widget/getEmployees', 'Widget\BaseWidgetController@getEmployees');
Route::post('/v1/widget/getAvailableDays', 'Widget\BaseWidgetController@getAvailableDays');
Route::post('/v1/widget/getAvailableTime', 'Widget\BaseWidgetController@getAvailableTime');
Route::post('/v1/widget/getUserInformationForm', 'Widget\BaseWidgetController@getUserInformationForm');
Route::get('/v1/widget/handleUserInformationForm', 'Widget\BaseWidgetController@handleUserInformationForm');
Route::post('/v1/widget/getOrgInformation', 'Widget\BaseWidgetController@getOrgInformation');

Route::get('/v1/widget/locale/{locale?}', ['as' => 'locale.setlocale', 'uses' => 'LocaleController@setLocale']);
//->middleware('auth:api');

Route::get('/v1/mobile/clientData', 'Mobile\ApiController@getClientData')->middleware('auth:api');
Route::get('/v1/mobile/searchClient', 'Mobile\ApiController@searchClient')->middleware('auth:api');
Route::get('/v1/mobile/appointmentsForDate', 'Mobile\ApiController@getAppointments')->middleware('auth:api');
Route::get('/v1/mobile/branchesData', 'Mobile\ApiController@getBranches')->middleware('auth:api');
Route::get('/v1/mobile/branchEmployees', 'Mobile\ApiController@getBranchEmployees')->middleware('auth:api');
Route::post('/v1/mobile/appointment', 'Mobile\ApiController@createAppointment')->middleware('auth:api');
Route::get('/v1/mobile/employeeFreeTime', 'Mobile\ApiController@getEmployeeFreeTime')->middleware('auth:api');
Route::get('/v1/mobile/branchServices', 'Mobile\ApiController@getServicesForOrganization')->middleware('auth:api');
Route::get('/v1/mobile/dailyStatistics', 'Mobile\ApiController@getDailyStatistics')->middleware('auth:api');
Route::post('/v1/mobile/client', 'Mobile\ApiController@createClient')->middleware('auth:api');
Route::post('/v1/mobile/editClient', 'Mobile\ApiController@editClient')->middleware('auth:api');
