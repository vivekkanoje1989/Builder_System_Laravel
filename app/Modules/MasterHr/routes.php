<?php

Route::group(array('module' => 'MasterHr', 'namespace' => 'App\Modules\MasterHr\Controllers'), function() {
    $getUrl = config('global.getUrl');
    
    Route::get($getUrl.'/master-hr/orgchart', 'MasterHrController@orgchart');
    Route::get($getUrl.'/master-hr/getChartData', 'MasterHrController@getChartData');
    Route::resource($getUrl.'/master-hr', 'MasterHrController');
    Route::post($getUrl.'/master-hr/manageUsers', 'MasterHrController@manageUsers');    
    Route::post($getUrl.'/master-hr/editDepartments', 'MasterHrController@editDepartments');
    Route::post($getUrl.'/master-hr/getDepartmentsToEdit', 'MasterHrController@getDepartmentsToEdit'); 
    Route::post($getUrl.'/master-hr/changePassword', 'MasterHrController@changePassword'); 
    
    /*********************************************** API **********************************************************/
    
    Route::post('api/master-hr/manageUsers', 'MasterHrController@manageUsers');
    Route::post('api/master-hr/', 'MasterHrController@store');
    
    /*********************************************** API **********************************************************/
});	