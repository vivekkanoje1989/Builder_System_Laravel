<?php

Route::group(array('module' => 'DashBoard', 'middleware' => ['api'], 'namespace' => 'App\Modules\DashBoard\Controllers'), function() {

    Route::post('api/my-request/getMyRequest', 'DashBoardController@getMyRequest');
        
    Route::post('api/my-request/getRequestForMe', 'DashBoardController@getRequestForMe');
    Route::post('api/my-request/description', 'DashBoardController@description');
    Route::post('api/request-forme/changeStatus', 'DashBoardController@changeStatus');
    
});	
