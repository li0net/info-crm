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