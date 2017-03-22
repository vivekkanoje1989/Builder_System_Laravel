<?php

Route::group(array('module' => 'MasterHr', 'namespace' => 'App\Modules\MasterHr\Controllers'), function() {
    $getUrl = config('global.getUrl');
    
    Route::get($getUrl.'/master-hr/orgchart', 'MasterHrController@orgchart');
    Route::get($getUrl.'/master-hr/getChartData', 'MasterHrController@getChartData');
    Route::get($getUrl.'/master-hr/getMenuLists/{id}', 'MasterHrController@getMenuLists'); 
    Route::resource($getUrl.'/master-hr', 'MasterHrController');
    Route::post($getUrl.'/master-hr/manageUsers', 'MasterHrController@manageUsers');    
    Route::post($getUrl.'/master-hr/editDepartments', 'MasterHrController@editDepartments');
    Route::post($getUrl.'/master-hr/getDepartmentsToEdit', 'MasterHrController@getDepartmentsToEdit'); 
    Route::post($getUrl.'/master-hr/changePassword', 'MasterHrController@changePassword'); 
    Route::get($getUrl.'/master-hr/userPermissions/{id}', 'MasterHrController@userPermissions'); 
    Route::post($getUrl.'/master-hr/accessControl', 'MasterHrController@accessControl'); 
    
    /*********************************************** API **********************************************************/
    
    Route::post('api/master-hr/manageUsers', 'MasterHrController@manageUsers');
    Route::post('api/master-hr/', 'MasterHrController@store');
    Route::put('api/master-hr/{id}', 'MasterHrController@update');
    Route::post('api/master-hr/photoUpload', 'MasterHrController@photoUpload');
        
    /*********************************************** API **********************************************************/
});	