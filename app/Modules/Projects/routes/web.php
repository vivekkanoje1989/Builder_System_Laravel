<?php

Route::group(array('module' => 'Projects', 'middleware' => ['web'], 'namespace' => 'App\Modules\Projects\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::get($getUrl.'/projects/basicinfo', function () {
        return View::make('Projects::basicinfo');
    });
    Route::get($getUrl.'/projects/uploads', function () {
        return View::make('Projects::uploads');
    });
    Route::get($getUrl.'/projects/inventory', function () {
        return View::make('Projects::inventory');
    });
    Route::get($getUrl. '/projects/projectType', 'ProjectsController@projectType'); //for populate dropdown
    Route::get($getUrl. '/projects/projectStatus', 'ProjectsController@projectStatus'); //for populate dropdown
    Route::get($getUrl. '/projects/getProjects', 'ProjectsController@getProjects'); //for populate dropdown
    Route::get($getUrl. '/projects/webPage', 'ProjectsController@webPage'); //show page
    Route::resource($getUrl. '/projects', 'ProjectsController');
});	
