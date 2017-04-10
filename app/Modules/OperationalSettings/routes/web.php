<?php

Route::group(array('module' => 'OperationalSettings', 'middleware' => 'auth:admin', 'namespace' => 'App\Modules\OperationalSettings\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource($getUrl . '/operational-setting', 'OperationalSettingsController');
    Route::post($getUrl . '/operational-setting/update', 'OperationalSettingsController@updatePreEnquiries');
    Route::post($getUrl . '/operational-setting/budgetUpdate', 'OperationalSettingsController@budgetUpdate');
    Route::post($getUrl . '/operational-setting/manageLocation', 'OperationalSettingsController@manageLocation');
    Route::post($getUrl . '/operational-setting/opeartionalArea', 'OperationalSettingsController@opeartionalArea');
    Route::post($getUrl . '/operational-setting/getOperationalSettings', 'OperationalSettingsController@getOperationalSettings');
    Route::post($getUrl . '/operational-setting/delArea', 'OperationalSettingsController@delArea');
});
