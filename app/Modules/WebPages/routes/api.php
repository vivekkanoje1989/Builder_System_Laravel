<?php

Route::group(array('module' => 'WebPages', 'middleware' => ['api'], 'namespace' => 'App\Modules\WebPages\Controllers'), function() {

    Route::resource('web-pages', 'WebPagesController');
    
});	
