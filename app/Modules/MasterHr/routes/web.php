<?php

Route::group(array('module' => 'MasterHr', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\MasterHr\Controllers'), function() {

    $getUrl = config('global.getUrl');

    Route::get('/master-hr/orgchart', ['middleware' => 'permission:030105', 'uses' => 'MasterHrController@orgchart']); // show page
    Route::get('/master-hr/getChartData', ['middleware' => 'permission:030105', 'uses' => 'MasterHrController@getChartData']); //show chart
    Route::get('/master-hr/manageRolesPermission', ['middleware' => 'permission:030103', 'uses' => 'MasterHrController@manageRolesPermission']); //show manage role page
    Route::get('/master-hr/getRoles', ['middleware' => 'permission:030103', 'uses' => 'MasterHrController@getRoles']); //get role data from table

    Route::get('/master-hr',  'MasterHrController@index');
    Route::get('/master-hr/create', ['middleware' => 'permission:030102', 'uses' => 'MasterHrController@create']);
    Route::post('/master-hr/', ['middleware' => 'permission:030102', 'uses' => 'MasterHrController@store']);
    Route::get('/master-hr/{id}/edit', ['middleware' => 'permission:030101', 'uses' => 'MasterHrController@edit']);
    Route::post('/master-hr/checkUniqueEmpId', ['middleware' => 'permission:030101', 'uses' => 'MasterHrController@checkUniqueEmpId']);
    Route::put('/master-hr/{id}', ['middleware' => 'permission:030101', 'uses' => 'MasterHrController@update']);

    Route::post('/master-hr/updatePassword', 'MasterHrController@updatePassword');
    
    Route::post('/master-hr/checkRole', ['middleware'=>'permission:030101', 'uses' => 'MasterHrController@checkRole']); //get role id
    Route::post('/master-hr/manageUsers', ['middleware'=>'permission:030101', 'uses' => 'MasterHrController@manageUsers']);
    Route::post('/master-hr/editDepartments', ['middleware'=>'permission:030102', 'uses' => 'MasterHrController@editDepartments']);
    Route::post('/master-hr/getDepartmentsToEdit', ['middleware'=>'permission:030102', 'uses' => 'MasterHrController@getDepartmentsToEdit']);
    Route::post('/master-hr/changePassword', ['middleware'=>'permission:030101', 'uses' => 'MasterHrController@changePassword']);
    Route::get('/master-hr/userPermissions/{id}', ['middleware'=>'permission:030101', 'uses' => 'MasterHrController@userPermissions']); //show user permission page
    Route::post('/master-hr/getMenuLists', ['middleware'=>'permission:030101', 'uses' => 'MasterHrController@getMenuLists']); //show submenu list
    Route::post('/master-hr/accessControl', ['middleware'=>'permission:030101', 'uses' => 'MasterHrController@accessControl']); //save multiple comma separated submenu list
    Route::post('/master-hr/updatePermissions', ['middleware'=>'permission:030101', 'uses' => 'MasterHrController@updatePermissions']);
    Route::get('/master-hr/rolePermissions/{id}', ['middleware'=>'permission:030101', 'uses' => 'MasterHrController@rolePermissions']); //show user permission page
    
    Route::get('/master-hr/manageRoleExportToExcel', 'MasterHrController@manageRoleExportToExcel');
    Route::get('/master-hr/hrDetailsExporToxls', 'MasterHrController@hrDetailsExporToxls');
    Route::get('/master-hr/createrole', 'MasterHrController@createRole');
    Route::post('/master-hr/createUserRole', 'MasterHrController@createUserRole'); //create user role
    Route::post('/master-hr/updateUserRole', 'MasterHrController@updateUserRole'); //update user role
    Route::post('/master-hr/bulkreasignemployee', 'MasterHrController@bulkreasignemployee');
    Route::post('/master-hr/getsalesEmployees', 'MasterHrController@getsalesEmployees');
    Route::post('/master-hr/getEnquiriesCnt', 'MasterHrController@getEnquiriesCnt');
    Route::post('/master-hr/getpresalesEmployees', 'MasterHrController@getpresalesEmployees');

    Route::get('/master-hr/showpermissions', 'MasterHrController@showpermissions');
    Route::get('/master-hr/getMenuListsForEmployee', 'MasterHrController@getMenuListsForEmployee');
    Route::post('/master-hr/removeEmpID', 'MasterHrController@removeEmpID');

    Route::post('/master-hr/getProfileInfo', 'MasterHrController@getProfileInfo');
    Route::post('/master-hr/updateProfileInfo', 'MasterHrController@updateProfileInfo');
    Route::get('/master-hr/profile', 'MasterHrController@profile');
    Route::get('/master-hr/quickuser', 'MasterHrController@getquickuser');
    Route::post('/master-hr/createquickuser', 'MasterHrController@createquickuser');

    Route::get('/master-hr/getEmpId', 'MasterHrController@getEmpId'); //get employee id
    Route::post('/master-hr/manageContact', 'MasterHrController@manageContact');
    Route::post('/master-hr/createEducationForm', 'MasterHrController@createEducationForm');
    Route::post('/master-hr/manageJobForm', 'MasterHrController@manageJobForm');
    Route::post('/master-hr/manageStatusForm', 'MasterHrController@manageStatusForm');
    Route::post('/master-hr/update', 'MasterHrController@updateEmployee');

    Route::post('/master-hr/customerDataPermission', 'MasterHrController@customerDataPermission');
    Route::post('/master-hr/storeEmployeeData', 'MasterHrController@storeEmployeeData');
    Route::get('/master-hr/getTeamLeadForQuick', 'MasterHrController@getTeamLeadForQuick');
    Route::get('/master-hr/getTeamLead/{id}', 'MasterHrController@getTeamLead');

    Route::get('/MasterHr/showFilter', function () {
        return View::make('MasterHr::showFilter');
    });
});
