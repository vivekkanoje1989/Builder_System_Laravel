<?php

Route::group(array('module' => 'CustomAlerts', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\CustomAlerts\Controllers'), function() {
	$getUrl = config('global.getUrl');
    Route::resource('/customalerts', 'CustomAlertsController');
    Route::post('/customalerts/manageCustomAlerts', 'CustomAlertsController@manageCustomAlerts');    
    Route::post('/customalerts/updateCustomAlerts','CustomAlertsController@updateCustomAlerts');
});	
