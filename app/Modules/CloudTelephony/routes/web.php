<?php

Route::group(array('module' => 'CloudTelephony', 'namespace' => 'App\Modules\CloudTelephony\Controllers', 'middleware' =>['auth:admin']), function() {
    $getUrl = config('global.getUrl');
     Route::get('/cloudtelephony/showFilter', function () {
        return View::make('CloudTelephony::showFilter');
    });
    Route::get('/cloudtelephony/showoutboundFilter', function () {
        return View::make('CloudTelephony::showoutboundFilter');
    });
    Route::resource('/cloudtelephony', 'CloudTelephonyController');
    Route::post('/cloudtelephony/manageLists', 'CloudTelephonyController@manageLists');
    Route::resource('/virtualnumber', 'VirtualNumberController');
    Route::post('/virtualnumber/manageLists', 'VirtualNumberController@manageLists');
    Route::get('/getCttunetype', 'VirtualNumberController@getCttunetype');
    Route::get('/getCtforwardingtypes', 'VirtualNumberController@getCtforwardingtypes');
    Route::post('/virtualnumber/getEmployeelist', 'VirtualNumberController@getEmployeelist');
    Route::post('/virtualnumber/editEmp', 'VirtualNumberController@editEmp');
    Route::post('/virtualnumber/changeEmployees', 'VirtualNumberController@changeEmployees');
    Route::post('/virtualnumber/getSubsources', 'VirtualNumberController@getSubsources');
    Route::post('/virtualnumber/getSources', 'VirtualNumberController@getSources');
     
    Route::resource('/extensionmenu', 'ExtensionMenuController');
    Route::post('/extensionmenu/manageextLists', 'ExtensionMenuController@manageextLists');
    Route::post('/extensionmenu/manageextUpdate', 'ExtensionMenuController@manageextUpdate');
    Route::get('/getCttunetype', 'ExtensionMenuController@getCttunetype');
    Route::get('/getCtforwardingtypes', 'ExtensionMenuController@getCtforwardingtypes');
    Route::post('/extensionmenu/getEmployeelist', 'ExtensionMenuController@getEmployeelist');
    Route::post('/extensionmenu/editEmp', 'ExtensionMenuController@editEmp');
    Route::post('/extensionmenu/getSubsources', 'ExtensionMenuController@getSubsources');
    
    Route::get('/cloudcalling/agentnumbers', 'CloudCallingController@agentnumbers');
    Route::get('/cloudcallinglogs/index', 'CloudCallingLogsController@index');
    Route::get('/cloudcallinglogs/outbound', 'CloudCallingLogsController@outbound');
    Route::post('/cloudcallinglogs/outboundCalltrigger', 'CloudCallingLogsController@outboundCalltrigger');
    
    
    Route::get('/extensionmenu/{id}/viewData', 'ExtensionMenuController@viewData');
    Route::get('/virtualnumber/{id}/existingUpdate', 'VirtualNumberController@existingUpdate');
    Route::get('/virtualnumber/{id}/nonworkinghoursUpdate', 'VirtualNumberController@nonworkingUpdate');
    Route::post('virtualnumber/updateNonworkinghours', 'VirtualNumberController@updateNonworkinghours');
    
    
    Route::get('/cloudcallinglogs/myIncomingLogs', 'CloudCallingLogsController@myIncomingLogs');
    Route::post('/cloudcallinglogs/myInboundLogs', 'CloudCallingLogsController@myInboundLogs');
    Route::get('/cloudcallinglogs/teamIncomingLogs', 'CloudCallingLogsController@teamIncomingLogs');
    Route::post('/cloudcallinglogs/teamInboundLogs', 'CloudCallingLogsController@teamInboundLogs');
    
    Route::get('/cloudcallinglogs/myOutgoingLogs', 'CloudCallingLogsController@myOutgoingLogs');
    Route::post('/cloudcallinglogs/myOutboundLogs', 'CloudCallingLogsController@myOutboundLogs');
    Route::get('/cloudcallinglogs/teamOutgoingLogs', 'CloudCallingLogsController@teamOutgoingLogs');
    Route::post('/cloudcallinglogs/teamOutboundLogs', 'CloudCallingLogsController@teamOutboundLogs');
    Route::post('/cloudcallinglogs/inLogexportToExcel', 'CloudCallingLogsController@inLogexportToExcel');
    Route::post('/cloudcallinglogs/outLogexportToExcel', 'CloudCallingLogsController@outLogexportToExcel');
    
     Route::get('/extensionemployee/viewextemployee', 'ExtensionEmployeeController@viewextemployee');
     Route::get('/getCtEmployeeExtension', 'ExtensionEmployeeController@getCtEmployeeExtension');
     Route::post('/getExtensionEmployee', 'ExtensionEmployeeController@getExtensionEmployee');
     Route::post('/createExtEmployee', 'ExtensionEmployeeController@createExtEmployee');
    
     Route::get('/getVirtualnumbers', 'CloudCallingLogsController@getVirtualnumbers');
     Route::post('/getTeamEmployees', 'CloudCallingLogsController@getTeamEmployees');
     Route::post('/cloudcallinglogs/filteredData', 'CloudCallingLogsController@filteredData');
     Route::post('/cloudcallinglogs/filteredoutboundData', 'CloudCallingLogsController@filteredoutboundData');
    
    
});	


