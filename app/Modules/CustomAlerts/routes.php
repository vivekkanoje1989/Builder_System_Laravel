<?php

Route::group(array('module' => 'CustomAlerts', 'middleware' => ['web'], 'namespace' => 'App\Modules\CustomAlerts\Controllers'), function() {
	$getUrl = config('global.getUrl');
    Route::resource($getUrl .'/customalerts', 'CustomAlertsController');
    Route::post($getUrl.'/customalerts/manageCustomAlerts', 'CustomAlertsController@manageCustomAlerts');    
    Route::post($getUrl.'/customalerts/updateCustomAlerts','CustomAlertsController@updateCustomAlerts');
});	
