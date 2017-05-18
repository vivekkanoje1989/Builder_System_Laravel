<?php

Route::group(array('module' => 'Themes', 'middleware' => 'auth:admin', 'namespace' => 'App\Modules\Themes\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource($getUrl . '/website-themes', 'ThemesController');
    Route::post($getUrl . '/website/getThemes', 'ThemesController@getThemes');
    Route::post($getUrl . '/website-themes/update/{id}', 'ThemesController@update');
    
    
    
});
