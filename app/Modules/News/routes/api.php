<?php

Route::group(array('module' => 'News', 'middleware' => ['api'], 'namespace' => 'App\Modules\News\Controllers'), function() {

    Route::resource('News', 'NewsController');
    
});	
