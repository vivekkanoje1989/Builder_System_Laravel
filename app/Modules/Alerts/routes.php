<?php

//Route::group(array('module' => 'Alerts', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\Alerts\Controllers'), function() {
//	$getUrl = config('global.getUrl');
//    Route::resource('/alerts', 'AlertsController');
//    Route::resource('/defaultalerts','DefaultAlertsController');
//    Route::post('/defaultalerts/updateDefaultAlerts','DefaultAlertsController@updateDefaultAlerts');
//    Route::post('/defaultalerts/manageDafaultAlerts', 'DefaultAlertsController@manageDafaultAlerts');    
//    Route::post('/alerts/manageAlerts', 'AlertsController@manageAlerts');    
//    Route::post('/alerts/changeSmsStatus', 'AlertsController@changeSmsStatus'); 
//    Route::post('/alerts/changeTemplateStatus', 'AlertsController@changeTemplateStatus'); 
//    Route::post('/alerts/changeEmailStatus', 'AlertsController@changeEmailStatus'); 
//    Route::post('/alerts/getTemplatesEvents', 'AlertsController@getTemplatesEvents');
//    Route::post('/alerts/getEmailConfig', 'AlertsController@getEmailConfig');
//    Route::post('/alerts/getEmployees', 'AlertsController@getEmployees');
//    Route::post('/alerts/updateAlerts','AlertsController@updateAlerts');
//    Route::post('/alerts/getEmployeesToEdit', 'AlertsController@getEmployeesToEdit'); 
//    //Route::post('/master-hr/getDepartmentsToEdit', 'AlertsController@getDepartmentsToEdit'); 
//});

Route::group(array('module' => 'Alerts', 'middleware' => ['web'], 'namespace' => 'App\Modules\Alerts\Controllers'), function() {
	$getUrl = config('global.getUrl');
    Route::resource('/alerts', 'AlertsController');
    Route::resource('/defaultalerts','DefaultAlertsController');
    Route::post('/defaultalerts/updateDefaultAlerts','DefaultAlertsController@updateDefaultAlerts');
    Route::post('/defaultalerts/manageDafaultAlerts', 'DefaultAlertsController@manageDafaultAlerts');    
    Route::post('/alerts/manageAlerts', 'AlertsController@manageAlerts');    
    Route::post('/alerts/changeSmsStatus', 'AlertsController@changeSmsStatus'); 
    Route::post('/alerts/changeTemplateStatus', 'AlertsController@changeTemplateStatus'); 
    Route::post('/alerts/changeEmailStatus', 'AlertsController@changeEmailStatus'); 
    Route::post('/alerts/getTemplatesEvents', 'AlertsController@getTemplatesEvents');
    Route::post('/alerts/getEmailConfig', 'AlertsController@getEmailConfig');
    Route::post('/alerts/getEmployees', 'AlertsController@getEmployees');
    Route::post('/alerts/updateAlerts','AlertsController@updateAlerts');
    Route::post('/alerts/getEmployeesToEdit', 'AlertsController@getEmployeesToEdit'); 
    //Route::post('/master-hr/getDepartmentsToEdit', 'AlertsController@getDepartmentsToEdit'); 
});