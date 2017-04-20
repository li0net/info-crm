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
use Carbon\Carbon;
use App\Service;

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', 'LandingController@index');

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
Route::get('/clientCategories', 'ClientCategoriesController@index');

Route::resource('/employee', 'EmployeeController');
Route::put('/employee', 'EmployeeController@store');
Route::post('/employees/saveWageScheme', 'EmployeeController@updateWageScheme');
Route::post('/employees/updateServices', ['as' => 'employee.update_services', 'uses' => 'EmployeeController@updateServices']);
Route::get('/employees/serviceOptions', 'EmployeeController@getServiceOptions');

Route::get('/employees/getSchedule', 'EmployeeController@getSchedule');
Route::post('/employees/updateSchedule', 'EmployeeController@updateSchedule');

Route::resource('/position', 'PositionController');
Route::resource('/account', 'AccountController');

Route::resource('/product', 'ProductController');
Route::get('/storagebalance', 'ProductController@storagebalance');
Route::post('/storagebalance/list', ['as' => 'storagebalance.list', 'uses' => 'ProductController@storagebalanceFiltered']);

Route::get('salesanalysis', 'ProductController@salesanalysis');
Route::post('/salesanalysis/sales', ['as' => 'salesanalysis.sales', 'uses' => 'ProductController@salesanalysisFiltered']);

Route::resource('/productCategories', 'ProductCategoriesController');
Route::resource('/partner', 'PartnerController');
Route::resource('/item', 'ItemController');
Route::resource('/wage_scheme', 'WageSchemesController');
Route::resource('/unit', 'UnitController');
Route::resource('/storage', 'StorageController');
Route::resource('/payment', 'PaymentController');
Route::resource('/resource', 'ResourceController');
Route::resource('/storagetransaction', 'StorageTransactionController');
Route::post('/storagetransaction/list', ['as' => 'storagetransaction.list', 'uses' => 'StorageTransactionController@indexFiltered']);

Route::get('/storageData', 'StorageController@getStorageData');
Route::get('/productCategoriesData', 'ProductCategoriesController@getProductCategoriesData');
Route::resource('/card', 'CardController');
Route::post('/home', ['as' => 'appointments.index', 'uses' =>'HomeController@indexFiltered']);
Route::post('/payment/list', ['as' => 'payment.list', 'uses' => 'PaymentController@indexFiltered']);
Route::post('/payment/beneficiaryOptions', ['as' => 'payment.beneficiaryOptions', 'uses' => 'PaymentController@populateBeneficiaryOptions']);
Route::post('/wage_scheme/detailedServiceOptions', ['as' => 'wage_scheme.detailedServiceOptions', 
                                                    'uses' => 'WageSchemesController@populateDetailedServiceOptions']);
Route::post('/wage_scheme/detailedProductOptions', ['as' => 'wage_scheme.detailedProductOptions', 
                                                    'uses' => 'WageSchemesController@populateDetailedProductOptions']);
Route::post('/card/productOptions', ['as' => 'card.productOptions', 
                                     'uses' => 'CardController@populateProductOptions']);

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
Route::get('/clientCategories/gridData', function()
{
    GridEncoder::encodeRequestedData(new \App\GridRepositories\ClientsCategoriesGridRepository(), Input::all());
});

/*
 * Формы
 */
Route::get('/serviceCategories/create', 'ServiceCategoriesController@create');
Route::get('/serviceCategories/edit/{serviceCategory}', 'ServiceCategoriesController@edit');
Route::post('/serviceCategories/save', 'ServiceCategoriesController@save');
Route::get('/serviceCategories/destroy/{scId}', 'ServiceCategoriesController@destroy');

Route::get('/productCategories/store', 'ProductCategoriesController@store');


//Route::get('/test', function (){
//            $service = Service::find(20);
//
//            //$service->employees()->detach();
//            // dd($service->employees);
//     });

// Route::get('/test', function (){
//           TG::sendMsg('user#320015266', 'Hello + there!');
//      });

Route::get('/services/create', 'ServicesController@create');
Route::get('/services/edit/{service}', 'ServicesController@edit');
Route::post('/services/save', 'ServicesController@save');
Route::get('/services/destroy/{serviceId}', 'ServicesController@destroy');
Route::get('/service/employeeOptions', ['as' => 'service.employeeOptions', 'uses' => 'ServicesController@populateEmployeeOptions']);
Route::get('/service/routingOptions', ['as' => 'service.routingOptions', 'uses' => 'ServicesController@populateRoutingOptions']);
Route::get('/service/resourceOptions', ['as' => 'service.resourceOptions', 'uses' => 'ServicesController@populateResourceOptions']);

Route::get('/organization/edit', ['as' => 'organization.edit', 'uses' => 'OrganizationsController@edit']);
Route::post('/organization/save', ['as' => 'organization.save', 'uses' => 'OrganizationsController@save']);

Route::get('/organization/info/edit', ['as' => 'info.edit', 'uses' => 'OrganizationsController@editInfo']);
Route::put('/organization/info/save', ['as' => 'info.save', 'uses' => 'OrganizationsController@saveInfo']);
Route::post('/organization/info/save', ['as' => 'info.save', 'uses' => 'OrganizationsController@saveInfo']);
Route::get('/organization/updateShowWelcome', 'OrganizationsController@updateShowWelcome');

Route::get('/appointments/create', ['as' => 'appointments.create', 'uses' => 'AppointmentsController@create']);
Route::get('/appointments/edit/{appt}', ['as' => 'appointments.edit', 'uses' => 'AppointmentsController@edit']);
Route::post('/appointments/save', 'AppointmentsController@save');
Route::get('/appointments/destroy/{appt}', ['as' => 'appointments.destroy', 'uses' => 'AppointmentsController@destroy']);
Route::post('/appointments/getEmployeesForService/{service}', 'AppointmentsController@getEmployeesForServices');
Route::get('/appointments/getEmployeesForService/{service}', 'AppointmentsController@getEmployeesForServices');
Route::post('/appointments/getClientInfo', 'AppointmentsController@getClientInfo');
Route::get('/appointments/e', ['as' => 'appointments.employeeOptions', 'uses' => 'AppointmentsController@populateEmployeeOptions']);

Route::get('/users/create', 'UsersController@create');
Route::get('/users/edit/{user}', 'UsersController@edit');
Route::post('/users/save', 'UsersController@save');
Route::post('/users/{user}/savePermissions', 'UsersController@savePermissions');
Route::get('/user/cabinet', 'UsersController@editOwnSettings');
Route::post('/user/saveAvatar', 'UsersController@saveAvatar');
Route::post('/user/saveMailingSettings', 'UsersController@saveMailingSettings');
Route::post('/user/saveMainInfo', 'UsersController@saveMainInfo');
Route::post('/user/updatePassword', 'UsersController@updatePassword');
Route::post('/user/updatePhone', 'UsersController@updatePhone');
Route::post('/user/updateEmail', 'UsersController@updateEmail');
Route::get('/user/confirmEmailChange/{uid}/{code}', 'SysConfirmActionsController@confirmEmailChange');

Route::get('/clients/create', 'ClientsController@create');
Route::get('/clients/edit/{client}', 'ClientsController@edit');
Route::get('/client/{client}', 'ClientsController@show');
Route::post('/clients/save', 'ClientsController@save');
Route::post('/clients/destroy', 'ClientsController@destroy');
Route::post('/clients/destroyFiltered/', 'ClientsController@destroyFiltered');
Route::post('/clients/addSelToCategory', 'ClientsController@addSelectedToCategory');
Route::post('/clients/addToCategory', 'ClientsController@addFilteredToCategory');

Route::post('/schedule/create', 'ScheduleController@create');

Route::get('/clientCategories/create', 'ClientCategoriesController@create');
Route::get('/clientCategories/edit/{clientCategory}', 'ClientCategoriesController@edit');
Route::post('/clientCategories/save', 'ClientCategoriesController@save');
Route::get('/clientCategories/destroy/{ccId}', 'ClientCategoriesController@destroy');
Route::post('/clientCategories/getList', 'ClientsController@getClientCategories');

Route::post('/image-upload/{id}', ['as' => 'upload', 'uses' => 'UploadImageController@uploadImage']);
Route::get('/image-upload', 'UploadImageController@uploadImage');

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
// Route::post('changelocale', ['as' => 'changelocale', 'uses' => 'TranslationController@changeLocale']);

Route::get('locale/{locale?}', ['as' => 'locale.setlocale', 'uses' => 'LocaleController@setLocale']);

// Passport token manage GUI
Route::get('/oauth/manageUsers', function() {
    if (Input::user()->is_admin != true) {
        return 'You dont have permission to access this page';
    }
    return view('passport.main', [
        'header'                => trans('main.passport:manage_clients_title'),
        'passportVueComponent'  => '<passport-clients></passport-clients>'
    ]);
})->middleware('auth');

Route::get('/oauth/manageAuthorizedUsers', function() {
    if (Input::user()->is_admin != true) {
        return 'You dont have permission to access this page';
    }
    return view('passport.main', [
        'header'                => trans('main.passport:manage_authorized_clients_title'),
        'passportVueComponent'  => '<passport-authorized-clients></passport-authorized-clients>'
    ]);
})->middleware('auth');

Route::get('/oauth/managePersonalTokens', function() {
    if (Input::user()->is_admin != true) {
        return 'You dont have permission to access this page';
    }
    return view('passport.main', [
        'header'                => trans('main.passport:manage_personal_access_tokens_title'),
        'passportVueComponent'  => '<passport-personal-access-tokens></passport-personal-access-tokens>'
    ]);
})->middleware('auth');

Route::get('/employees/getPayroll', '\App\Http\Controllers\EmployeeController@getPayroll');
Route::post('/employees/calculateWage', '\App\Http\Controllers\EmployeeController@calculateWage');