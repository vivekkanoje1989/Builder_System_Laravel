<?php

Route::group(array('module' => 'MasterHr', 'namespace' => 'App\Modules\MasterHr\Controllers'), function() {
    $getUrl = config('global.getUrl');
    
    Route::resource($getUrl.'/master-hr', 'MasterHrController');
    Route::post($getUrl.'/master-hr/manageUsers', 'MasterHrController@manageUsers');    
    Route::post($getUrl.'/master-hr/editDepartments', 'MasterHrController@editDepartments');
    Route::post($getUrl.'/master-hr/getDepartmentsToEdit', 'MasterHrController@getDepartmentsToEdit'); 
    Route::post($getUrl.'/master-hr/changePassword', 'MasterHrController@changePassword'); 
    Route::get($getUrl.'/master-hr/orgChart', 'MasterHrController@orgChart'); 
    
    /*********************************************** API **********************************************************/
    
    Route::post('api/master-hr/manageUsers', 'MasterHrController@manageUsers');
    Route::post('api/master-hr/', 'MasterHrController@store');
    
    /*********************************************** API **********************************************************/
});	