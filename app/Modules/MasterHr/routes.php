<?php

Route::group(array('module' => 'MasterHr', 'namespace' => 'App\Modules\MasterHr\Controllers'), function() {

    Route::resource('admin/master-hr', 'MasterHrController');
    Route::post('master-hr/uploadFile', 'MasterHrController@uploadFile');
    Route::post('admin/master-hr/manageUsers', 'MasterHrController@manageUsers');    
    Route::post('admin/master-hr/editDepartments', 'MasterHrController@editDepartments');
    Route::post('admin/master-hr/getDepartmentsToEdit', 'MasterHrController@getDepartmentsToEdit'); 
    Route::post('admin/master-hr/changePassword', 'MasterHrController@changePassword');    
});	