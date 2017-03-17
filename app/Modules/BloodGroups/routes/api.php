<?php

Route::group(array('module' => 'BloodGroups', 'middleware' => ['api'], 'namespace' => 'App\Modules\BloodGroups\Controllers'), function() {

    Route::resource('BloodGroups', 'BloodGroupsController');
    
});	
