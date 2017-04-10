<?php

Route::group(array('module' => 'Alerts', 'middleware' => ['web'], 'namespace' => 'App\Modules\Alerts\Controllers'), function() {
	$getUrl = config('global.getUrl');
    Route::resource($getUrl . '/alerts', 'AlertsController');
    Route::resource($getUrl . '/defaultalerts','DefaultAlertsController');
    Route::post($getUrl.'/defaultalerts/updateDefaultAlerts','DefaultAlertsController@updateDefaultAlerts');
    Route::post($getUrl.'/defaultalerts/manageDafaultAlerts', 'DefaultAlertsController@manageDafaultAlerts');    
    Route::post($getUrl.'/alerts/manageAlerts', 'AlertsController@manageAlerts');    
    Route::post($getUrl.'/alerts/changeSmsStatus', 'AlertsController@changeSmsStatus'); 
    Route::post($getUrl.'/alerts/changeTemplateStatus', 'AlertsController@changeTemplateStatus'); 
    Route::post($getUrl.'/alerts/changeEmailStatus', 'AlertsController@changeEmailStatus'); 
    Route::post($getUrl.'/alerts/getTemplatesEvents', 'AlertsController@getTemplatesEvents');
    Route::post($getUrl.'/alerts/getEmailConfig', 'AlertsController@getEmailConfig');
    Route::post($getUrl.'/alerts/getEmployees', 'AlertsController@getEmployees');
    Route::post($getUrl.'/alerts/updateAlerts','AlertsController@updateAlerts');
    Route::post($getUrl.'/alerts/getEmployeesToEdit', 'AlertsController@getEmployeesToEdit'); 
    //Route::post($getUrl.'/master-hr/getDepartmentsToEdit', 'AlertsController@getDepartmentsToEdit'); 
});