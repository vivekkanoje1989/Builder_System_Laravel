<?php

Route::group(array('module' => 'DashBoard', 'middleware' => 'auth:admin', 'namespace' => 'App\Modules\DashBoard\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource($getUrl . '/request-leave', 'DashBoardController');
    Route::get($getUrl . '/request-approval/index', 'DashBoardController@other');
    Route::get($getUrl . '/request-forme/index', 'DashBoardController@requestsForMe');
    Route::get($getUrl . '/my-request/index', 'DashBoardController@myRequest');
    Route::get($getUrl . '/getEmployees', 'DashBoardController@getEmployees');
    Route::post($getUrl . '/getEmployeesCC', 'DashBoardController@getEmployeesCC');
    Route::post($getUrl . '/request-approval/other', 'DashBoardController@otherApproval');
    Route::post($getUrl . '/my-request/getMyRequest', 'DashBoardController@getMyRequest');
    Route::post($getUrl . '/my-request/description', 'DashBoardController@description');
    Route::get($getUrl . '/my-request/getRequestForMe', 'DashBoardController@getRequestForMe');
    Route::post($getUrl . '/request-forme/changeStatus', 'DashBoardController@changeStatus');
});
