<?php

Route::group(array('module' => 'Events', 'middleware' => ['api'], 'namespace' => 'App\Modules\Events\Controllers'), function() {

    Route::resource('Events', 'EventsController');
    
});	
