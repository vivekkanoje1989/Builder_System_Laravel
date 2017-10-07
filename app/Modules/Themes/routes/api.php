<?php

Route::group(array('module' => 'Themes', 'middleware' => ['api'], 'namespace' => 'App\Modules\Themes\Controllers'), function() {

    Route::resource('Themes', 'ThemesController');
    
});	
