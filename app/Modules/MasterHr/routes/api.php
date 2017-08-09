<?php

Route::group(array('module' => 'MasterHr', 'middleware' => ['api'], 'namespace' => 'App\Modules\MasterHr\Controllers'), function() {

    Route::get('api/master-hr/getChartData', 'MasterHrController@getChartData'); //show chart
    Route::post('api/master-hr/manageUsers', 'MasterHrController@manageUsers');
    Route::post('api/master-hr/', 'MasterHrController@store');
    Route::put('api/master-hr/{id}', 'MasterHrController@update');
    Route::post('api/master-hr/photoUpload', 'MasterHrController@photoUpload');
    Route::post('api/master-hr/getMenuLists', 'MasterHrController@getMenuLists');
    Route::post('api/master-hr/appAccessControl', 'MasterHrController@appAccessControl');
    Route::post('api/master-hr/appProfile', 'MasterHrController@appProfile');

    Route::post('api/master-hr/appCreateUser', 'MasterHrController@appCreateUser');
    Route::post('api/master-hr/createquickuser', 'MasterHrController@createquickuser');
    Route::post('api/master-hr/updatePassword', 'MasterHrController@updatePassword'); 
     Route::get('api/master-hr/getRoles', 'MasterHrController@getRoles'); 
});	