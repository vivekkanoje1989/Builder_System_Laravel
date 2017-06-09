<?php

Route::group(array('module' => 'DashBoard', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\DashBoard\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource('/request-leave', 'DashBoardController');
    Route::get('/request-approval/index', 'DashBoardController@other');
    Route::get('/request-for-me/index', 'DashBoardController@requestsForMe');
    Route::get('/my-request/index', 'DashBoardController@myRequest');
    Route::get('/getEmployees', 'DashBoardController@getEmployees');
    Route::post('/getEmployeesCC', 'DashBoardController@getEmployeesCC');
    Route::post('/request-approval/other', 'DashBoardController@otherApproval');
    Route::post('/my-request/getMyRequest', 'DashBoardController@getMyRequest');
    Route::post('/my-request/description', 'DashBoardController@description');
    Route::get('/my-request/getRequestForMe', 'DashBoardController@getRequestForMe');
    Route::post('/request-for-me/changeStatus', 'DashBoardController@changeStatus');
});
