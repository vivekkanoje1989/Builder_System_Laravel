<?php

Route::group(array('module' => 'Projects', 'middleware' => ['api'], 'namespace' => 'App\Modules\Projects\Controllers'), function() {

    Route::resource('projects', 'ProjectsController');
    
});	
