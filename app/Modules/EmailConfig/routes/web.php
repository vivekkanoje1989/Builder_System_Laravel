<?php

Route::group(array('module' => 'EmailConfig', 'middleware' => ['web'], 'namespace' => 'App\Modules\EmailConfig\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::get($getUrl . '/email-config/getDepartments', 'EmailConfigController@getDepartments');
    Route::resource($getUrl . '/email-config', 'EmailConfigController');
    Route::post($getUrl . '/email-config/manageEmails', 'EmailConfigController@manageEmails');
    Route::post($getUrl . '/email-config/testEmail', 'EmailConfigController@testEmail');
});
