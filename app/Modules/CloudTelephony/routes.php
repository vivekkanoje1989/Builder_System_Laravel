<?php

Route::group(array('module' => 'CloudTelephony', 'middleware' => ['auth:admin'],'namespace' => 'App\Modules\CloudTelephony\Controllers'), function() {
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
});	