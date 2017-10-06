<?php

Route::group(array('module' => 'DashBoard', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\DashBoard\Controllers'), function() {

    Route::get('/my-request/exportToxls', 'DashBoardController@exportToxls');
    Route::get('/request-approval/index', 'DashBoardController@other')->middleware("permission:0103");
    Route::get('/request-for-me/requestForMeExportToxls', 'DashBoardController@requestForMeExportToxls');
    Route::get('/request-for-me/index', 'DashBoardController@requestsForMe')->middleware("permission:0102");
    Route::get('/my-request/index', 'DashBoardController@myRequest')->middleware("permission:0103");
    Route::get('request-leave/getEmployees', 'DashBoardController@getEmployees');
    Route::post('/getEmployeesCC', 'DashBoardController@getEmployeesCC');
    Route::post('/request-approval/other', 'DashBoardController@otherApproval')->middleware("permission:0103");
    Route::post('/my-request/getMyRequest', 'DashBoardController@getMyRequest');
    Route::post('/my-request/description', 'DashBoardController@description');
    Route::get('/my-request/getRequestForMe', 'DashBoardController@getRequestForMe');
    Route::post('/request-for-me/changeStatus', 'DashBoardController@changeStatus');
    Route::get('/request-leave/', 'DashBoardController@index')->middleware("permission:0103");
    Route::post('/request-leave/', 'DashBoardController@store')->middleware("permission:0103");
});
