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
Route::get('service-pending', 'ServiceController@pending')->name('pending');
Route::get('service-completed', 'ServiceController@completed')->name('completed');

//member
Route::get('member', 'MemberController@member')->name('member');
Route::post('add-member', 'MemberController@addMember')->name('addMember');
Route::post('add-car', 'MemberController@addCar')->name('addCar');
Route::post('update-member', 'MemberController@updateMember')->name('updateMember');
Route::post('update-car', 'MemberController@updateCar')->name('updateCar');
Route::post('get-member-details', 'MemberController@getMemberDetails')->name('getMemberDetails');
Route::post('get-car-details', 'MemberController@getCarDetails')->name('getCarDetails');
Route::post('member-topup', 'MemberController@topup')->name('topup');
Route::post('member-topup', 'MemberController@topup')->name('topup');

//setting
Route::get('setting-service-categories', 'SettingController@serviceCategory')->name('serviceCategory');
Route::get('setting-vehicle-types', 'SettingController@vehicleType')->name('vehicleType');
Route::get('setting-color', 'SettingController@color')->name('color');




