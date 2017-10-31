<?php

Route::group(array('module' => 'Api', 'middleware' => ['api'], 'namespace' => 'App\Modules\Api\Controllers'), function() {

    Route::resource('Api', 'ApiController');
    
});	
