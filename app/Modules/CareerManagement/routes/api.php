<?php

Route::group(array('module' => 'CareerManagement', 'middleware' => ['api'], 'namespace' => 'App\Modules\CareerManagement\Controllers'), function() {

    Route::resource('careerManagement', 'CareerManagementController');
    
});	
