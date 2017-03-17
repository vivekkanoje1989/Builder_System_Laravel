<?php

Route::group(array('module' => 'ManageCity', 'middleware' => ['api'], 'namespace' => 'App\Modules\ManageCity\Controllers'), function() {

    Route::resource('ManageCity', 'ManageCityController');
    
});	
