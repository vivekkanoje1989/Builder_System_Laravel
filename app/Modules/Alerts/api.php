<?php

Route::group(array('module' => 'Alerts', 'middleware' => ['api'], 'namespace' => 'App\Modules\Alerts\Controllers'), function() {

    Route::resource('Alerts', 'AlertsController');
    
});	