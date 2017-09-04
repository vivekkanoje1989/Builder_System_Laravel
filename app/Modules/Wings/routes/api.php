<?php

Route::group(array('module' => 'Wings', 'middleware' => ['api'], 'namespace' => 'App\Modules\Wings\Controllers'), function() {

    Route::resource('wings', 'WingsController');
    
});	
