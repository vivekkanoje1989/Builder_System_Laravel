<?php

Route::group(array('module' => 'Projects', 'middleware' => ['web'], 'namespace' => 'App\Modules\Projects\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::get($getUrl.'/projects/basicinfo', function () {
        return View::make('Projects::basicinfo');
    });
    Route::resource($getUrl. '/projects', 'ProjectsController');
});	
