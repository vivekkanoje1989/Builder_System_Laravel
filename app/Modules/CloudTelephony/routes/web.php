<?php

Route::group(array('module' => 'CloudTelephony', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\CloudTelephony\Controllers'), function() {
    $getUrl = config('global.getUrl');

    Route::resource('/cloudtelephony', 'CloudTelephonyController');
    Route::post('/cloudtelephony/manageLists', 'CloudTelephonyController@manageLists');
    Route::resource('/virtualnumber', 'VirtualNumberController');
    Route::post('/virtualnumber/manageLists', 'VirtualNumberController@manageLists');
    Route::get('/getCttunetype', 'VirtualNumberController@getCttunetype');
    Route::get('/getCtforwardingtypes', 'VirtualNumberController@getCtforwardingtypes');
    Route::post('/virtualnumber/getEmployeelist', 'VirtualNumberController@getEmployeelist');
    Route::post('/virtualnumber/getSubsources', 'VirtualNumberController@getSubsources');
    Route::resource('/extensionmenu', 'ExtensionMenuController');
    Route::post('/extensionmenu/manageextLists', 'ExtensionMenuController@manageextLists');
    Route::post('/extensionmenu/manageextUpdate', 'ExtensionMenuController@manageextUpdate');
    Route::get('/getCttunetype', 'ExtensionMenuController@getCttunetype');
    Route::get('/getCtforwardingtypes', 'ExtensionMenuController@getCtforwardingtypes');
    Route::post('/extensionmenu/getEmployeelist', 'ExtensionMenuController@getEmployeelist');
    Route::post('/extensionmenu/getSubsources', 'ExtensionMenuController@getSubsources');

    Route::get('/cloudcalling/agentnumbers', 'CloudCallingController@agentnumbers');
    Route::get('/cloudcallinglogs/index', 'CloudCallingLogsController@index');

    Route::get('/extensionmenu/{id}/viewData', 'ExtensionMenuController@viewData');
    Route::get('/virtualnumber/{id}/existingUpdate', 'VirtualNumberController@existingUpdate');

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

    Route::post('/cloudcallinglogs/filteredData', 'CloudCallingLogsController@filteredData');
    Route::post('/cloudcallinglogs/filteredoutboundData', 'CloudCallingLogsController@filteredoutboundData');

    Route::get('/cloudcallinglogs/getVirtualnumbers', 'CloudCallingLogsController@getVirtualnumbers');
    Route::post('/getTeamEmployees', 'CloudCallingLogsController@getTeamEmployees');

    Route::get('/CloudTelephony/showFilter', function () {
        return View::make('CloudTelephony::showFilter');
    });
    Route::get('/CloudTelephony/showoutboundFilter', function () {
        return View::make('CloudTelephony::showoutboundFilter');
    });
});

