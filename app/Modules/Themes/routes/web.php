<?php

Route::group(array('module' => 'Themes', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\Themes\Controllers'), function() {

    Route::get('/website-themes/themeExportToxls', 'ThemesController@themeExportToxls');
    Route::post('/website/getThemes', 'ThemesController@getThemes');
    Route::post('/website/deleteTheme', 'ThemesController@deleteTheme');

    Route::post('/website-themes/update/{id}', 'ThemesController@update');
    Route::resource('/website-themes', 'ThemesController');
    Route::post('/website/applyTheme', 'ThemesController@applyTheme');
    Route::post('/website-themes/update/{id}', 'ThemesController@update');
    Route::get('/theme/preview/id/{id}', 'ThemesController@themePreview');

    Route::resource('/website-themes', 'ThemesController');
    Route::get('/Themes/showFilter', function () {
        return View::make('Themes::showFilter');
    });
});
