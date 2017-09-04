<?php

Route::group(array('module' => 'EmployeeDevice', 'middleware' => ['api'], 'namespace' => 'App\Modules\EmployeeDevice\Controllers'), function() {

    Route::resource('employee-device', 'EmployeeDeviceController');
    
});	
