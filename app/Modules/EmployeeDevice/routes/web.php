<?php

Route::group(array('module' => 'EmployeeDevice', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\EmployeeDevice\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::get($getUrl . '/employee-device/getAllEmployeesList', 'EmployeeDeviceController@getAllEmployeesList');
    Route::post($getUrl . '/employee-device/manageDevice', 'EmployeeDeviceController@manageDevice');
    Route::resource($getUrl . '/employee-device', 'EmployeeDeviceController');
});
