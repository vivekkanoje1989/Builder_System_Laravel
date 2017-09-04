<?php

Route::group(array('module' => 'EmailConfig', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\EmailConfig\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::get('/email-config/getDepartments', 'EmailConfigController@getDepartments');
    Route::resource('/email-config', 'EmailConfigController');
    Route::post('/email-config/manageEmails', 'EmailConfigController@manageEmails');
    Route::post('/email-config/testEmail', 'EmailConfigController@testEmail');
});
