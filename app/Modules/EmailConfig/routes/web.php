<?php

Route::group(array('module' => 'EmailConfig', 'middleware' => ['web'], 'namespace' => 'App\Modules\EmailConfig\Controllers'), function() {
    $getUrl = config('global.getUrl');

    Route::resource($getUrl . '/email-config', 'EmailConfigController');
    Route::post($getUrl . '/email-config/manageEmails', 'EmailConfigController@manageEmails');
});
