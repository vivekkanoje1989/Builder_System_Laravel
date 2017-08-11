<?php

Route::group(array('module' => 'CloudTelephony', 'namespace' => 'App\Modules\CloudTelephony\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::resource($getUrl.'/cloudtelephony', 'CloudTelephonyController');
    Route::post($getUrl.'/cloudtelephony/manageLists', 'CloudTelephonyController@manageLists');
    Route::resource($getUrl.'/virtualnumber', 'VirtualNumberController');
    Route::post($getUrl.'/virtualnumber/manageLists', 'VirtualNumberController@manageLists');
    Route::get($getUrl.'/getCttunetype', 'VirtualNumberController@getCttunetype');
    Route::get($getUrl.'/getCtforwardingtypes', 'VirtualNumberController@getCtforwardingtypes');
    Route::post($getUrl.'/virtualnumber/getEmployeelist', 'VirtualNumberController@getEmployeelist');
    Route::post($getUrl.'/virtualnumber/getSubsources', 'VirtualNumberController@getSubsources');
    Route::post($getUrl.'/virtualnumber/getSources', 'VirtualNumberController@getSources');
    Route::resource($getUrl.'/extensionmenu', 'ExtensionMenuController');
    Route::post($getUrl.'/extensionmenu/manageextLists', 'ExtensionMenuController@manageextLists');
    Route::post($getUrl.'/extensionmenu/manageextUpdate', 'ExtensionMenuController@manageextUpdate');
    Route::get($getUrl.'/getCttunetype', 'ExtensionMenuController@getCttunetype');
    Route::get($getUrl.'/getCtforwardingtypes', 'ExtensionMenuController@getCtforwardingtypes');
    Route::post($getUrl.'/extensionmenu/getEmployeelist', 'ExtensionMenuController@getEmployeelist');
    Route::post($getUrl.'/extensionmenu/getSubsources', 'ExtensionMenuController@getSubsources');
    
    Route::get($getUrl.'/cloudcalling/agentnumbers', 'CloudCallingController@agentnumbers');
    Route::get($getUrl.'/cloudcallinglogs/index', 'CloudCallingLogsController@index');
    
    Route::get($getUrl.'/extensionmenu/{id}/viewData', 'ExtensionMenuController@viewData');
    Route::get($getUrl.'/virtualnumber/{id}/existingUpdate', 'VirtualNumberController@existingUpdate');
});	