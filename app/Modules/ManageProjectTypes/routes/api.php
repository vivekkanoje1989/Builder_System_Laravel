<?php

Route::group(array('module' => 'ManageProjectTypes', 'middleware' => ['api'], 'namespace' => 'App\Modules\ManageProjectTypes\Controllers'), function() {

    Route::resource('ManageProjectTypes', 'ManageProjectTypesController');
    
});	
