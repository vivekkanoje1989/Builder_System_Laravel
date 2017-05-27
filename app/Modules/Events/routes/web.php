<?php

Route::group(array('module' => 'Events', 'middleware' => ['web'], 'namespace' => 'App\Modules\Events\Controllers'), function() {

    Route::resource('Events', 'EventsController');
    
});	
