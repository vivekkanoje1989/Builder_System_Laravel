<?php

Route::group(array('module' => 'MasterHr', 'middleware' => 'auth:admin', 'namespace' => 'App\Modules\MasterHr\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::get($getUrl.'/master-hr/getTeamLead/{id}', 'MasterHrController@getTeamLead');    
    
    Route::get($getUrl . '/master-hr/orgchart', ['middleware'=>'check-permission:030104', 'uses' => 'MasterHrController@orgchart']); // show page
    Route::get($getUrl . '/master-hr/getChartData', ['middleware'=>'check-permission:030104', 'uses' => 'MasterHrController@getChartData']); //show chart
    Route::get($getUrl . '/master-hr/manageRolesPermission', ['middleware'=>'check-permission:030101', 'uses' => 'MasterHrController@manageRolesPermission']); //show manage role page
    Route::get($getUrl . '/master-hr/getRoles', ['middleware'=>'check-permission:030101', 'uses' => 'MasterHrController@getRoles']); //get role data from table
//    Route::resource($getUrl . '/master-hr', 'MasterHrController');
    
    Route::get($getUrl . '/master-hr', ['middleware'=>'check-permission:030101', 'uses' => 'MasterHrController@index']);
    Route::get($getUrl . '/master-hr/create', ['middleware'=>'check-permission:030102', 'uses' => 'MasterHrController@create']);
    Route::post($getUrl . '/master-hr/', ['middleware'=>'check-permission:030102', 'uses' => 'MasterHrController@store']);
    Route::get($getUrl . '/master-hr/{id}/edit', ['middleware'=>'check-permission:030101', 'uses' => 'MasterHrController@edit']);
    Route::put($getUrl . '/master-hr/{id}', ['middleware'=>'check-permission:030101', 'uses' => 'MasterHrController@update']);
    
    Route::post($getUrl . '/master-hr/manageUsers', ['middleware'=>'check-permission:030101', 'uses' => 'MasterHrController@manageUsers']);
    Route::post($getUrl . '/master-hr/editDepartments', ['middleware'=>'check-permission:030102', 'uses' => 'MasterHrController@editDepartments']);
    Route::post($getUrl . '/master-hr/getDepartmentsToEdit', ['middleware'=>'check-permission:030102', 'uses' => 'MasterHrController@getDepartmentsToEdit']);
    Route::post($getUrl . '/master-hr/changePassword', ['middleware'=>'check-permission:030101', 'uses' => 'MasterHrController@changePassword']);
    Route::get($getUrl . '/master-hr/userPermissions/{id}', ['middleware'=>'check-permission:030101', 'uses' => 'MasterHrController@userPermissions']); //show user permission page
    Route::post($getUrl . '/master-hr/getMenuLists', ['middleware'=>'check-permission:030101', 'uses' => 'MasterHrController@getMenuLists']); //show submenu list
    Route::post($getUrl . '/master-hr/accessControl', ['middleware'=>'check-permission:030101', 'uses' => 'MasterHrController@accessControl']); //save multiple comma separated submenu list
    Route::post($getUrl . '/master-hr/updatePermissions', ['middleware'=>'check-permission:030101', 'uses' => 'MasterHrController@updatePermissions']);
    Route::get($getUrl . '/master-hr/rolePermissions/{id}', ['middleware'=>'check-permission:030101', 'uses' => 'MasterHrController@rolePermissions']); //show user permission page
});
