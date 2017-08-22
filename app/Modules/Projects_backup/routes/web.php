<?php

Route::group(array('module' => 'Projects', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\Projects\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::get('/projects/basicinfo', function () {
        return View::make('Projects::basicinfo');
    });
    Route::get('/projects/uploads', function () {
        return View::make('Projects::uploads');
    });
    Route::get('/projects/inventory', function () {
        return View::make('Projects::inventory');
    });
    Route::get('/projects/uploads/images', function () {
        return View::make('Projects::uploads.images');
    });
    Route::get('/projects/uploads/layouts', function () {
        return View::make('Projects::uploads.layouts');
    });
    Route::get('/projects/uploads/maps', function () {
        return View::make('Projects::uploads.maps');
    });
    Route::get('/projects/uploads/amenities', function () {
        return View::make('Projects::uploads.amenities');
    });
    Route::get('/projects/uploads/gallery', function () {
        return View::make('Projects::uploads.gallery');
    });
    Route::get('/projects/projectType', 'ProjectsController@projectType'); //for populate dropdown
    Route::get('/projects/projectStatus', 'ProjectsController@projectStatus'); //for populate dropdown
    Route::get('/projects/getProjects', 'ProjectsController@getProjects'); //for populate dropdown
    Route::get('/projects/webPage', 'ProjectsController@webPage'); //show page
    Route::get('/projects/getWings', 'ProjectsController@getWings'); //show page
    Route::get('/projects/getBlocks', 'ProjectsController@getBlocks'); //show page
    Route::resource('/projects', 'ProjectsController');
    Route::post('/projects/showProjectDetails', 'ProjectsController@showProjectDetails'); //save project details

    Route::post('/projects/basicInfo', 'ProjectsController@basicInfo'); //save basic info

    Route::post('/projects/getAmenitiesListOnEdit', 'ProjectsController@getAmenitiesListOnEdit'); //get ameniti list on edit

    Route::post('/projects/imagesInfo', 'ProjectsController@imagesInfo'); //save images info
    Route::post('/projects/getProjectInfo', 'ProjectsController@getProjectInfo');
});
