<?php

Route::group(array('module' => 'CustomAlerts', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\CustomAlerts\Controllers'), function() {
	$getUrl = config('global.getUrl');
    Route::get('/customalerts/customTemplatesExportToxls', 'CustomAlertsController@customTemplatesExportToxls');
    
    Route::post('/customalerts/manageCustomAlerts', 'CustomAlertsController@manageCustomAlerts');    
    Route::post('/customalerts/updateCustomAlerts','CustomAlertsController@updateCustomAlerts');
    Route::post('/customalerts/deleteCustomTemplate','CustomAlertsController@deleteCustomTemplate');
    Route::resource('/customalerts', 'CustomAlertsController');
});	
