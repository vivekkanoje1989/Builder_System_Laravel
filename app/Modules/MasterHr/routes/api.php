<?php

Route::group(array('module' => 'MasterHr', 'middleware' => ['api'], 'namespace' => 'App\Modules\MasterHr\Controllers'), function() {

    Route::get('api/master-hr/getChartData', 'MasterHrController@getChartData'); //show chart
    Route::post('api/master-hr/manageUsers', 'MasterHrController@manageUsers');
    Route::post('api/master-hr/', 'MasterHrController@store');
    Route::put('api/master-hr/{id}', 'MasterHrController@update');
    Route::post('api/master-hr/photoUpload', 'MasterHrController@photoUpload');
    Route::post('api/master-hr/getMenuLists', 'MasterHrController@getMenuLists');
});	