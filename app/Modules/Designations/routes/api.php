<?php

Route::group(array('module' => 'Designations', 'middleware' => ['api'], 'namespace' => 'App\Modules\Designations\Controllers'), function() {

    Route::resource('designations', 'DesignationsController');
    
});	
