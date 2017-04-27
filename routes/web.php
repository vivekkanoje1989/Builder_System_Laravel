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
$getUrl = config('global.getUrl');
Route::get('/', function () {
   return View::make('backendApp');
});
Route::get($getUrl.'/error500', function () {
   return view('layouts.backend.error500');
});
Route::post($getUrl.'/checkUserCredentials', 'backend\Auth\LoginController@checkUserCredentials');
Route::get($getUrl.'/layout', function () {
   return view('layouts.backend.layout');
});
Route::get($getUrl.'/dashboard', function () {
    return View::make('layouts.backend.dashboard');
});
Route::get($getUrl.'/loading', function () {
    return View::make('layouts.backend.loading');
});
Route::get($getUrl.'/navbar', function () {
    return View::make('layouts.backend.navbar');
});
Route::get($getUrl.'/sidebar', function () {
    return View::make('layouts.backend.sidebar');
});
Route::get($getUrl.'/chatbar', function () {
    return View::make('layouts.backend.chatbar');
});
Route::get($getUrl.'/breadcrumbs', function () {
    return View::make('layouts.backend.breadcrumbs');
});
Route::get($getUrl.'/header', function () {
    return View::make('layouts.backend.header');
});
Route::get($getUrl.'/getToken', 'backend\Auth\LoginController@getToken');

Route::group(['middleware' =>['web']], function () {
    $getUrl = config('global.getUrl');
    // ADMIN
    Route::get($getUrl.'/session', 'backend\Auth\LoginController@getSession');
    Route::get($getUrl.'/login', 'backend\Auth\LoginController@getLoginForm');
    Route::post($getUrl.'/authenticate', 'backend\Auth\LoginController@authenticate');   
    
    Route::get($getUrl.'/register', 'backend\Auth\RegisterController@getRegisterForm');
    Route::post($getUrl.'/saveRegister', 'backend\Auth\RegisterController@saveRegisterForm');
    // Forget Password 
    Route::get($getUrl.'/password/resetLink/{request}', 'backend\Auth\ForgotPasswordController@showLinkRequestForm', function ($request = 'admin') {return $request;});
    Route::post($getUrl.'/password/email', 'backend\Auth\ForgotPasswordController@sendResetLinkEmail');
    // Reset Password
    Route::get($getUrl.'/password/reset/{token}/{checkState?}', 'backend\Auth\ResetPasswordController@showResetForm');
    Route::post($getUrl.'/password/reset', 'backend\Auth\ResetPasswordController@reset');
    
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

Route::group(['middleware' =>['auth:admin']], function () { 
    $getUrl = config('global.getUrl');
    /*************************** Admin Dashboard ****************************/
    Route::get($getUrl.'/dashboard', 'backend\AdminController@dashboard');
    
    /***************************** Admin Logout **********************************/
    Route::post($getUrl.'/logout', 'backend\Auth\LoginController@getLogout');   
    
    /***********************************************************************/
    Route::get($getUrl.'/getMenuItems', 'backend\AdminController@getMenuItems');
    Route::get($getUrl.'/getTitle', 'backend\AdminController@getTitle');
    Route::get($getUrl.'/getGender', 'backend\AdminController@getGender');
    Route::get($getUrl.'/getBloodGroup', 'backend\AdminController@getBloodGroup');
    Route::get($getUrl.'/getDepartments', 'backend\AdminController@getDepartments');
    Route::get($getUrl.'/getEducationList', 'backend\AdminController@getEducationList');
    Route::get($getUrl.'/getProfessionList', 'backend\AdminController@getProfessionList');
    Route::get($getUrl.'/getCountries', 'backend\AdminController@getCountries');
    Route::get($getUrl.'/getWebPageList', 'backend\AdminController@getWebPageList'); //uma 
    Route::get($getUrl.'/getPropertyPortalType', 'backend\AdminController@getPropertyPortalType'); //uma 
    Route::get($getUrl.'/getVerticals', 'backend\AdminController@getVerticals'); //uma
    Route::get($getUrl.'/getDesignations', 'backend\AdminController@getDesignations'); //geeta
    Route::get($getUrl.'/getProjects', 'backend\AdminController@getProjects'); //geeta
    Route::get($getUrl.'/getCompany', 'backend\AdminController@getCompany'); //geeta
    Route::get($getUrl.'/getStationary', 'backend\AdminController@getStationary'); //geeta
    Route::get($getUrl.'/getBlockTypes', 'backend\AdminController@getBlockTypes'); //geeta
    Route::get($getUrl.'/getSalesEnqCategory', 'backend\AdminController@getSalesEnqCategory'); //geeta
    Route::post($getUrl.'/getSubBlocks', 'backend\AdminController@getSubBlocks'); //geeta
    Route::post($getUrl.'/getStates', 'backend\AdminController@getStates');
    Route::post($getUrl.'/getCities', 'backend\AdminController@getCities');
    Route::post($getUrl.'/getLocations', 'backend\AdminController@getLocations');
    Route::post($getUrl.'/checkUniqueEmail', 'backend\AdminController@checkUniqueEmail');
    Route::get($getUrl.'/getEnquirySource', 'backend\AdminController@getEnquirySource');
    Route::post($getUrl.'/getEnquirySubSource', 'backend\AdminController@getEnquirySubSource');
    
    /***********************************MANDAR************************************/
    Route::get($getUrl.'/getClient', 'backend\AdminController@getClient');
    Route::get($getUrl.'/getVehiclebrands', 'backend\AdminController@getVehiclebrands');
    Route::get($getUrl.'/getVehiclemodels', 'backend\AdminController@getVehiclemodels');
    Route::get($getUrl.'/getEmployees', 'backend\AdminController@getEmployees');
    
    /***********************************************************************/
    
    Route::get($getUrl.'/databoxes', function () {
        return View::make('backend.databoxes');
    });
    Route::get($getUrl.'/widgets', function () {
        return View::make('backend.widgets');
    });
    
});

Route::group(['middleware' => ['user']], function () {
    Route::post('user/logout', 'frontend\Auth\LoginController@getLogout');
    Route::get('user/dashboard', 'frontend\UserController@dashboard');
});