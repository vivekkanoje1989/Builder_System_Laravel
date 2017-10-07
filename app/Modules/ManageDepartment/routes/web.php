<?php

Route::group(array('module' => 'ManageDepartment','middleware' => ['auth:admin'],'namespace' => 'App\Modules\ManageDepartment\Controllers'), function() {
    
     $getUrl = config('global.getUrl');
     Route::get('/manage-department/departmentsExportToxls','ManageDepartmentController@departmentsExportToxls');   
     Route::post('/manage-department/manageDepartment','ManageDepartmentController@manageDepartment');   
     Route::post('/manage-department/deleteDepartment','ManageDepartmentController@deleteDepartment');   
     Route::post('/manage-department/getDepartment','ManageDepartmentController@getDepartment');   
     Route::resource('/manage-department', 'ManageDepartmentController');
});	


