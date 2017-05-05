<?php

Route::group(array('module' => 'EmailConfig', 'middleware' => ['api'], 'namespace' => 'App\Modules\EmailConfig\Controllers'), function() {

    Route::resource('email-config', 'EmailConfigController');
    
});	
