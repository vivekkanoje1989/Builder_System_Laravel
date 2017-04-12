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
    Route::get($getUrl.'/projects/uploads/images', function () {
        return View::make('Projects::uploads.images');
    });
    Route::get($getUrl.'/projects/uploads/layouts', function () {
        return View::make('Projects::uploads.layouts');
    });
    Route::get($getUrl.'/projects/uploads/maps', function () {
        return View::make('Projects::uploads.maps');
    });
     Route::get($getUrl.'/projects/uploads/amenities', function () {
        return View::make('Projects::uploads.amenities');
    });
    Route::get($getUrl. '/projects/projectType', 'ProjectsController@projectType'); //for populate dropdown
    Route::get($getUrl. '/projects/projectStatus', 'ProjectsController@projectStatus'); //for populate dropdown
    Route::get($getUrl. '/projects/getProjects', 'ProjectsController@getProjects'); //for populate dropdown
    Route::get($getUrl. '/projects/webPage', 'ProjectsController@webPage'); //show page
    Route::get($getUrl. '/projects/getWings', 'ProjectsController@getWings'); //show page
    Route::resource($getUrl. '/projects', 'ProjectsController');
    Route::post($getUrl. '/projects/basicInfo', 'ProjectsController@basicInfo'); //save basic info
    Route::post($getUrl. '/projects/imagesInfo', 'ProjectsController@imagesInfo'); //save images info
});	
