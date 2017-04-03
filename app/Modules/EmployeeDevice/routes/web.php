<?php

Route::group(array('module' => 'EmployeeDevice', 'middleware' => ['web'], 'namespace' => 'App\Modules\EmployeeDevice\Controllers'), function() {

    Route::resource('employee-device', 'EmployeeDeviceController');
    
});	
