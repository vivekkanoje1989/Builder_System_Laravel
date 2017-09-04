<?php

Route::group(array('module' => 'OperationalSettings', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\OperationalSettings\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource('/operational-setting', 'OperationalSettingsController');
    Route::post('/operational-setting/update', 'OperationalSettingsController@updatePreEnquiries');
    Route::post('/operational-setting/budgetUpdate', 'OperationalSettingsController@budgetUpdate');
    Route::post('/operational-setting/manageLocation', 'OperationalSettingsController@manageLocation');
    Route::post('/operational-setting/opeartionalArea', 'OperationalSettingsController@opeartionalArea');
    Route::post('/operational-setting/getOperationalSettings', 'OperationalSettingsController@getOperationalSettings');
    Route::post('/operational-setting/delArea', 'OperationalSettingsController@delArea');
});
