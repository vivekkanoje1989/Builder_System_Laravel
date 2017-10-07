<?php

Route::group(array('module' => 'EmployeeDevice', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\EmployeeDevice\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::get('/employee-device/employeeDeviceExportToxls', 'EmployeeDeviceController@employeeDeviceExportToxls');
    Route::get('/employee-device/getAllEmployeesList', 'EmployeeDeviceController@getAllEmployeesList');
    Route::post('/employee-device/manageDevice', 'EmployeeDeviceController@manageDevice');
    Route::post('/employee-device/deleteEmployeeDevice', 'EmployeeDeviceController@deleteEmployeeDevice');
    Route::resource('/employee-device', 'EmployeeDeviceController');
});
