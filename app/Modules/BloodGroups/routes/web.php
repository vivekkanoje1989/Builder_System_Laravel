<?php

Route::group(array('module' => 'BloodGroups','namespace' => 'App\Modules\BloodGroups\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource($getUrl . '/blood-groups', 'BloodGroupsController');
    Route::post($getUrl . '/blood-groups/manageBloodGroup','BloodGroupsController@manageBloodGroups');
    
});	
