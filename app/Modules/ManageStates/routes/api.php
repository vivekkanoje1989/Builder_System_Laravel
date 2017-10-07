<?php

Route::group(array('module' => 'ManageStates', 'middleware' => ['api'], 'namespace' => 'App\Modules\ManageStates\Controllers'), function() {

    Route::resource('ManageStates', 'ManageStatesController');
    
});	
