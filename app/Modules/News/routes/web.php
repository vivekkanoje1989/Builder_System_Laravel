<?php

Route::group(array('module' => 'News', 'middleware' => ['web'], 'namespace' => 'App\Modules\News\Controllers'), function() {

    Route::resource('News', 'NewsController');
    
});	
