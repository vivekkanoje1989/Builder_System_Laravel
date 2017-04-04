<?php

Route::group(array('module' => 'ManageDepartment','namespace' => 'App\Modules\ManageDepartment\Controllers'), function() {
    
     $getUrl = config('global.getUrl');
     Route::resource($getUrl.'/manage-department', 'ManageDepartmentController');
     Route::post($getUrl . '/manage-department/manageDepartment','ManageDepartmentController@manageDepartment');   
     Route::post($getUrl . '/manage-department/getDepartment','ManageDepartmentController@getDepartment');   
});	


