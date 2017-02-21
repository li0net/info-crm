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

Route::get('/v1/widget/show', 'Widget\BaseWidgetController@getDivision');
    //->middleware('auth:api');
Route::post('/v1/widget/showServiceCategories', 'Widget\BaseWidgetController@getServiceCategories')->middleware('auth:api');
Route::post('/v1/widget/showServices', 'Widget\BaseWidgetController@getServices')->middleware('auth:api');
Route::post('/v1/widget/showEmployees', 'Widget\BaseWidgetController@getEmployees')->middleware('auth:api');
Route::post('/v1/widget/showAvailableDays', 'Widget\BaseWidgetController@getAvailableDays')->middleware('auth:api');
Route::post('/v1/widget/showAvailableTime', 'Widget\BaseWidgetController@getAvailableTime')->middleware('auth:api');