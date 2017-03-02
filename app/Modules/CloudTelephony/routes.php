<?php

Route::group(array('module' => 'CloudTelephony', 'namespace' => 'App\Modules\CloudTelephony\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::resource($getUrl.'/cloudtelephony', 'CloudTelephonyController');
    Route::post($getUrl.'/cloudtelephony/manageLists', 'CloudTelephonyController@manageLists');
    Route::resource($getUrl.'/virtualnumber', 'VirtualNumberController');
    Route::post($getUrl.'/virtualnumber/manageLists', 'VirtualNumberController@manageLists');
    Route::post($getUrl.'/virtualnumber/manageextLists', 'VirtualNumberController@manageextLists');
    Route::get($getUrl.'/getCttunetype', 'VirtualNumberController@getCttunetype');
    Route::get($getUrl.'/getCtforwardingtypes', 'VirtualNumberController@getCtforwardingtypes');
    Route::post($getUrl.'/virtualnumber/getEmployeelist', 'VirtualNumberController@getEmployeelist');
    Route::post($getUrl.'/virtualnumber/getSubsources', 'VirtualNumberController@getSubsources');
});	