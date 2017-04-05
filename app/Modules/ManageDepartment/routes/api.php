<?php

Route::group(array('module' => 'ManageDepartment', 'middleware' => ['api'], 'namespace' => 'App\Modules\ManageDepartment\Controllers'), function() {

    Route::resource('ManageDepartment', 'ManageDepartmentController');
    
});	
