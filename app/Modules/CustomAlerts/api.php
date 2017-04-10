<?php

Route::group(array('module' => 'CustomAlerts', 'middleware' => ['api'], 'namespace' => 'App\Modules\CustomAlerts\Controllers'), function() {

    Route::resource('CustomAlerts', 'CustomAlertsController');
    
});	
