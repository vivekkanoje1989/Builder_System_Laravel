<?php

Route::group(array('module' => 'ManageLocation', 'middleware' => ['api'], 'namespace' => 'App\Modules\ManageLocation\Controllers'), function() {

    Route::resource('ManageLocation', 'ManageLocationController');
    
});	
