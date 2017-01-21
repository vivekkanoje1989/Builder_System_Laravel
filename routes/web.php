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

Route::get('/', function () {
   return View::make('backendapp');
});
Route::get('/layout', function () {
   return view('layouts.backend.layout');
});
Route::get('/dashboard', function () {
    return View::make('layouts.backend.dashboard');
});
Route::get('loading', function () {
    return View::make('layouts.backend.loading');
});
Route::get('navbar', function () {
    return View::make('layouts.backend.navbar');
});
Route::get('sidebar', function () {
    return View::make('layouts.backend.sidebar');
});
Route::get('chatbar', function () {
    return View::make('layouts.backend.chatbar');
});
Route::get('breadcrumbs', function () {
    return View::make('layouts.backend.breadcrumbs');
});
Route::get('header', function () {
    return View::make('layouts.backend.header');
});

Route::group(['before' => ['guest']], function () {
    
    // ADMIN
    Route::get('admin/session', 'backend\Auth\LoginController@getSession');
    Route::get('admin/login', 'backend\Auth\LoginController@getLoginForm');
    Route::post('admin/authenticate', 'backend\Auth\LoginController@authenticate');
    Route::get('admin/register', 'backend\Auth\RegisterController@getRegisterForm');
    Route::post('admin/saveRegister', 'backend\Auth\RegisterController@saveRegisterForm');
    // Forget Password 
    Route::get('admin/password/resetLink/{request}', 'backend\Auth\ForgotPasswordController@showLinkRequestForm', function ($request = 'admin') {return $request;});
    Route::post('admin/password/email', 'backend\Auth\ForgotPasswordController@sendResetLinkEmail');
    // Reset Password
    Route::get('admin/password/reset/{token}/{checkState?}', 'backend\Auth\ResetPasswordController@showResetForm');
    Route::post('admin/password/reset', 'backend\Auth\ResetPasswordController@reset');
    
    /*********************************************************************************************************/
    
    // USER 
    Route::get('user/login', 'frontend\Auth\LoginController@getLoginForm');
    Route::post('user/authenticate', 'frontend\Auth\LoginController@authenticate');
    Route::get('user/register', 'frontend\Auth\RegisterController@getRegisterForm');
    Route::post('user/saveregister', 'frontend\Auth\RegisterController@saveRegisterForm');    
    // Forget Password
    Route::get('user/password/reset/{request}', 'frontend\Auth\ForgotPasswordController@showLinkRequestForm', function ($request = 'user') {return $request;});
    Route::post('user/password/email', 'frontend\Auth\ForgotPasswordController@sendResetLinkEmail');
    // Reset Password
    Route::get('user/password/reset/{token}', 'frontend\Auth\ResetPasswordController@showResetForm');
    Route::post('user/password/reset', 'frontend\Auth\ResetPasswordController@reset');
});

Route::group(['middleware' => ['admin']], function () {
    
    /*************************** Admin Dashboard ****************************/
    Route::get('admin/dashboard', 'backend\AdminController@dashboard');
    
    /***************************** Admin Logout **********************************/
    Route::post('admin/logout', 'backend\Auth\LoginController@getLogout');   
    
    /***********************************************************************/
    Route::get('admin/getMenuItems', 'backend\AdminController@getMenuItems');
    Route::get('admin/getTitle', 'backend\AdminController@getTitle');
    Route::get('admin/getGender', 'backend\AdminController@getGender');
    Route::get('admin/getBloodGroup', 'backend\AdminController@getBloodGroup');
    Route::get('admin/getDepartments', 'backend\AdminController@getDepartments');
    Route::get('admin/getEducationList', 'backend\AdminController@getEducationList');
    Route::get('admin/getCountries', 'backend\AdminController@getCountries');
    Route::get('admin/getStates', 'backend\AdminController@getStates');
    Route::get('admin/getCities', 'backend\AdminController@getCities');
    /***********************************************************************/
    
    /***************************** HR **********************************/
    Route::resource('admin/user', 'backend\hr\HrController');
    
    Route::get('admin/databoxes', function () {
        return View::make('backend.databoxes');
    });
    Route::get('admin/widgets', function () {
        return View::make('backend.widgets');
    });
    
});

Route::group(['middleware' => ['user']], function () {
    Route::post('user/logout', 'frontend\Auth\LoginController@getLogout');
    Route::get('user/dashboard', 'frontend\UserController@dashboard');
});