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

Route::group(['middleware' => 'api'], function () {
    Route::get('/getMasterData', 'backend\AdminController@getMasterData'); 
    Route::get('/getEnquiryLocation', 'backend\AdminController@getEnquiryLocation'); 
    Route::post('/authenticate', 'backend\Auth\LoginController@authenticate');
    Route::post('/checkUserCredentials', 'backend\Auth\LoginController@checkUserCredentials'); 
    Route::post('/getCities','backend\AdminController@getCities');
    Route::post('/getMenuItems', 'backend\AdminController@getMenuItems');
    Route::post('/checkDomainExists', 'backend\Auth\LoginController@checkDomainExists');
    Route::post('/getnextfollowupTime', 'backend\AdminController@getnextfollowupTime'); // by uma
    Route::get('/getsalesEmployees', 'backend\AdminController@getsalesEmployees'); //uma
    
    Route::get('/getFinanceTieupAgency', 'backend\AdminController@getFinanceTieupAgency'); //uma
    Route::get('/getProjects', 'backend\AdminController@getProjects'); // manoj
    Route::post('/getsalesEmployees', 'backend\AdminController@getsalesEmployees'); //uma    
    Route::post('/getforgotpassword', 'backend\Auth\LoginController@getforgotpassword');
    Route::post('/getSalesEnqSubStatus', 'backend\AdminController@getSalesEnqSubStatus'); //geeta
    Route::get('/getCountries', 'backend\AdminController@getCountries');
});

