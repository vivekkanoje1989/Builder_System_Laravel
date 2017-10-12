<?php

Route::group(array('module' => 'Themes', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\Themes\Controllers'), function() {

    Route::get('/website-themes/themeExportToxls', 'ThemesController@themeExportToxls');
    Route::post('/website/getThemes', 'ThemesController@getThemes');
    Route::post('/website/deleteTheme', 'ThemesController@deleteTheme');
    Route::post('/website-themes/update/{id}', 'ThemesController@up0date');
    Route::resource('/website-themes', 'ThemesController');
    Route::get('/Themes/showFilter', function () {
        return View::make('Themes::showFilter');
    });
    Route::get('/website/theme', 'frontend\UserController@index');
});
