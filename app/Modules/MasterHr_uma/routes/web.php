<?php

Route::group(array('module' => 'MasterHr', 'middleware' => 'auth:admin', 'namespace' => 'App\Modules\MasterHr\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::get($getUrl.'/master-hr/getTeamLead/{id}', 'MasterHrController@getTeamLead');    
    
    Route::get($getUrl . '/master-hr/orgchart', 'MasterHrController@orgchart'); // show page
    Route::get($getUrl . '/master-hr/getChartData', 'MasterHrController@getChartData'); //show chart
    Route::get($getUrl . '/master-hr/manageRolesPermission', 'MasterHrController@manageRolesPermission'); //show manage role page
    Route::get($getUrl . '/master-hr/getRoles', 'MasterHrController@getRoles'); //get role data from table
    Route::resource($getUrl . '/master-hr', 'MasterHrController');
    Route::post($getUrl . '/master-hr/manageUsers', 'MasterHrController@manageUsers');
    Route::post($getUrl . '/master-hr/editDepartments', 'MasterHrController@editDepartments');
    Route::post($getUrl . '/master-hr/getDepartmentsToEdit', 'MasterHrController@getDepartmentsToEdit');
    Route::post($getUrl . '/master-hr/changePassword', 'MasterHrController@changePassword');
    Route::get($getUrl . '/master-hr/userPermissions/{id}', 'MasterHrController@userPermissions'); //show user permission page
    Route::post($getUrl . '/master-hr/getMenuLists', 'MasterHrController@getMenuLists'); //show submenu list
    Route::post($getUrl . '/master-hr/accessControl', 'MasterHrController@accessControl'); //save multiple comma separated submenu list
    Route::post($getUrl . '/master-hr/updatePermissions', 'MasterHrController@updatePermissions');
    Route::get($getUrl . '/master-hr/rolePermissions/{id}', 'MasterHrController@rolePermissions'); //show user permission page
});


