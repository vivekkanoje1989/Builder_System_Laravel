<?php

Route::group(array('module' => 'OperationalSettings', 'middleware' => ['api'], 'namespace' => 'App\Modules\OperationalSettings\Controllers'), function() {

    Route::resource('OperationalSettings', 'OperationalSettingsController');
    
});	
