<?php

Route::group(array('module' => 'BloodGroups', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\BloodGroups\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::get('/blood-groups/bloodGroupExportToxls', 'BloodGroupsController@bloodGroupExportToxls');
    Route::post('/blood-groups/manageBloodGroup', 'BloodGroupsController@manageBloodGroups');
    Route::post('/blood-groups/deleteBloodgrp', 'BloodGroupsController@deleteBloodgrp');
    Route::post('/blood-groups/filteredData', 'BloodGroupsController@filteredData');
    Route::resource('/blood-groups', 'BloodGroupsController');

    Route::get('/BloodGroups/showFilter', function () {
        return View::make('BloodGroups::showFilter');
    });
});
