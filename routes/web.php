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
    return view('index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Signup, authentication & password reset
Route::get('password/reset-link-sent', 'Auth\ResetPasswordController@resetLinkSent')->name('password.resetlinksent');
Route::get('password/reset-success', 'Auth\ResetPasswordController@resetSuccess')->name('password.resetsuccess');

// OAuth Routes
Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

//service
Route::get('service-pending', 'JobController@pending')->name('pending');
Route::get('service-completed', 'JobController@completed')->name('completed');
Route::post('update_service', 'JobController@updateService')->name('update_service');
Route::post('removeService', 'JobController@removeService')->name('removeService');
Route::post('removeJob', 'JobController@removeJob')->name('removeJob');
Route::get('member-search', 'JobController@memberSearch')->name('member-search');
Route::get('newjob/{id}/{CategoryService}/{vehicleId}', 'JobController@NewJob')->name('newjob');
Route::get('editjob/{id}/{jobid}', 'JobController@EditJob')->name('editjob');
Route::get('newjobbycash/{id}/{CategoryService}/{vehicleId}', 'JobController@NewJobByCash')->name('newjobbycash');
Route::post('membertopup', 'JobController@Topup')->name('membertopup');
Route::get('searchClientName', 'JobController@driverSearch')->name('searchClientName');
Route::get('getClientDetails', 'JobController@getClientDetails')->name('getClientDetails');
Route::get('getProductDetails', 'JobController@getProductDetails')->name('getProductDetails');
Route::get('getProductDetailsByCash', 'JobController@getProductDetailsByCash')->name('getProductDetailsByCash');
Route::post('add_new_job', 'JobController@AddNewJob')->name('add_new_job');
Route::post('add_new_job_by_cash', 'JobController@AddNewJobByCash')->name('add_new_job_by_cash');
Route::post('update_edit_job', 'JobController@UpdateEditJob')->name('update_edit_job');
Route::post('completejob', 'JobController@CompleteJob')->name('completejob');
Route::post('paidjob', 'JobController@PaidJob')->name('paidjob');
Route::post('add-new-member', 'JobController@addNewMember')->name('addNewMember');
Route::get('addjobcash', 'JobController@addjobcash')->name('addjobcash');
Route::post('finduser', 'JobController@findUser')->name('finduser');
Route::post('updateBillingInfo', 'JobController@updateBillingInfo')->name('updateBillingInfo');
Route::get('getDriver', 'JobController@getDriver')->name('getDriver');

//sales
Route::any('sales-list', 'SalesController@SalesList')->name('sales-list');
Route::get('result-sales', 'SalesController@SearchSales')->name('result-sales');
Route::get('sale/{id}', 'SalesController@Sale')->name('sale');
Route::post('update-sale', 'SalesController@UpdateSales')->name('update-sale');
Route::post('print-sale', 'SalesController@PrintSales')->name('print-sale');


// begin of member
Route::get('member', 'MemberController@member')->name('member');
Route::post('add-member', 'MemberController@addMember')->name('addMember');
Route::post('add-car', 'MemberController@addCar')->name('addCar');
Route::post('add-car-member-details', 'MemberController@addCarMemberDetails')->name('addCarMemberDetails');
Route::post('update-member', 'MemberController@updateMember')->name('updateMember');
Route::post('update-car', 'MemberController@updateCar')->name('updateCar');
Route::post('get-member-details', 'MemberController@getMemberDetails')->name('getMemberDetails');
Route::post('get-car-details', 'MemberController@getCarDetails')->name('getCarDetails');
Route::post('delete-car-details', 'MemberController@deleteCarDetails')->name('deleteCarDetails');
Route::post('member-topup', 'MemberController@topup')->name('topup');
Route::get('member-details/{id}', 'MemberController@memberDetails')->name('memberDetails');

// end of member


// begin of catalogues
// catalogues - merchandises
Route::get('catalogues-merchandises', 'CataloguesController@merchandises')->name('merchandises');
Route::post('get-merchandises-details', 'CataloguesController@getMerchandisesDetails')->name('getMerchandisesDetails');
Route::post('add-merchandises', 'CataloguesController@addMerchandises')->name('addMerchandises');
Route::post('update-merchandises', 'CataloguesController@updateMerchandises')->name('updateMerchandises');

// catalogues - services
Route::get('catalogues-services', 'CataloguesController@services')->name('services');
Route::get('view-catalogues-services/{id}', 'CataloguesController@servicesView')->name('servicesView');
Route::post('get-services-details', 'CataloguesController@getServicesDetails')->name('getServicesDetails');
Route::post('add-services', 'CataloguesController@addServices')->name('addServices');
Route::post('update-services', 'CataloguesController@updateServices')->name('updateServices');
// end of catalogues


// begin of settings
// settings - service categories
Route::get('settings-service-categories', 'SettingController@serviceCategory')->name('serviceCategory');
Route::post('get-service-category-details', 'SettingController@getServiceCategoryDetails')->name('getServiceCategoryDetails');
Route::post('add-service-category', 'SettingController@addServiceCategory')->name('addServiceCategory');
Route::post('update-service-category', 'SettingController@updateServiceCategory')->name('updateServiceCategory');

// settings - vehicle types
Route::get('settings-vehicle-types', 'SettingController@vehicleTypes')->name('vehicleTypes');
Route::post('get-vehicle-types-details', 'SettingController@getVehicleTypesDetails')->name('getVehicleTypesDetails');
Route::post('add-vehicle-types', 'SettingController@addVehicleTypes')->name('addVehicleTypes');
Route::post('update-vehicle-types', 'SettingController@updateVehicleTypes')->name('updateVehicleTypes');

// settings - unit of measurements
Route::get('settings-unit-of-measurements', 'SettingController@unitOfMeasurement')->name('unitOfMeasurement');
Route::post('get-unit-of-measurement-details', 'SettingController@getUnitOfMeasurementDetails')->name('getUnitOfMeasurementDetails');
Route::post('add-unit-of-measurement', 'SettingController@addUnitOfMeasurement')->name('addUnitOfMeasurement');
Route::post('update-unit-of-measurement', 'SettingController@updateUnitOfMeasurement')->name('updateUnitOfMeasurement');

// settings - colors
Route::get('settings-colors', 'SettingController@color')->name('color');
Route::post('get-color-details', 'SettingController@getColorDetails')->name('getColorDetails');
Route::post('add-color', 'SettingController@addColor')->name('addColor');
Route::post('update-color', 'SettingController@updateColor')->name('updateColor');
// end of setting



// begin of account settings
// account settings - roles
Route::get('accountsettings-roles', 'AccountSettingsController@roles')->name('roles');
Route::post('accountsettings-roles', 'AccountSettingsController@addRoles')->name('addRoles');
Route::get('accountsettings-roles/{id}/', 'AccountSettingsController@getRolesById')->name('getRolesById');
Route::post('accountsettings-roles/{id}/', 'AccountSettingsController@updateRolesById')->name('updateRolesById');
Route::post('get-roles-details', 'AccountSettingsController@getRolesDetails')->name('getRolesDetails');

// account settings - users
Route::get('accountsettings-users', 'AccountSettingsController@users')->name('users');
Route::post('accountsettings-users', 'AccountSettingsController@addUsers')->name('addUsers');
Route::get('accountsettings-users/{id}/', 'AccountSettingsController@getUsersById')->name('getUsersById');
Route::post('accountsettings-users/{id}/', 'AccountSettingsController@updateUsers')->name('updateUsers');

// account settings - branch
Route::get('accountsettings-branches', 'AccountSettingsController@branches')->name('branches');
Route::post('accountsettings-branches', 'AccountSettingsController@addBranches')->name('addBranches');
Route::get('accountsettings-branches/{id}/', 'AccountSettingsController@getBranchesById')->name('getBranchesById');
Route::post('accountsettings-branches/{id}/', 'AccountSettingsController@updateBranchesById')->name('updateBranchesById');
Route::post('get-branches-details', 'AccountSettingsController@getBranchesDetails')->name('getBranchesDetails');
Route::post('accountsettings-branches-jobqueue-add', 'AccountSettingsController@addJobQueue')->name('addJobQueue');
Route::post('get-jobqueue-details', 'AccountSettingsController@getJobQueueDetails')->name('getJobQueueDetails');
Route::post('accountsettings-branches-jobqueue-update', 'AccountSettingsController@updateJobQueue')->name('updateJobQueue');
Route::post('accountsettings-branches-jobqueue-delete', 'AccountSettingsController@deleteJobQueue')->name('deleteJobQueue');
// end of account settings