<?php

Route::group(array('module' => 'CloudTelephony', 'middleware' => ['api'], 'namespace' => 'App\Modules\CloudTelephony\Controllers'), function() {
    
    Route::resource('api/virtualnumber', 'VirtualNumberController');
    Route::post('api/virtualnumber/fileUpload', 'VirtualNumberController@fileUpload');
    
    Route::post('api/virtualnumber/manageLists', 'VirtualNumberController@manageLists');
    Route::post('api/virtualnumber/getVirtualnoList', 'VirtualNumberController@getVirtualnoList');
    Route::post('api/extensionmenu/getMenuextlist', 'ExtensionMenuController@getMenuextlist');
    Route::post('api/cloudcallinglogs/myInboundLogs', 'CloudCallingLogsController@myInboundLogs');
    Route::post('api/cloudcallinglogs/teamInboundLogs', 'CloudCallingLogsController@teamInboundLogs');
    Route::post('api/cloudcallinglogs/outboundCalltrigger', 'CloudCallingLogsController@outboundCalltrigger');
    
    Route::resource('api/extensionmenu', 'ExtensionMenuController');
    Route::post('api/extensionmenu/menufileUpload', 'ExtensionMenuController@menufileUpload');
});	