<?php

Route::group(array('module' => 'Themes', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\Themes\Controllers'), function() {

    $getUrl = config('global.getUrl');
   
    Route::get('/website-themes/themeExportToxls', 'ThemesController@themeExportToxls');
    Route::post('/website/getThemes', 'ThemesController@getThemes');
    Route::post('/website/deleteTheme', 'ThemesController@deleteTheme');
    Route::post('/website-themes/update/{id}', 'ThemesController@update');
     Route::resource('/website-themes', 'ThemesController');
     Route::get('/Themes/showFilter', function () {
        return View::make('Themes::showFilter');
    });
    
});
