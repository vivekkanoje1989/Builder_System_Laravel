<?php

Route::group(array('module' => 'BlogManagement', 'middleware' => ['api'], 'namespace' => 'App\Modules\BlogManagement\Controllers'), function() {

    Route::resource('BlogManagement', 'BlogManagementController');
    
});	
