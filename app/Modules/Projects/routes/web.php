<?php

Route::group(array('module' => 'Projects', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\Projects\Controllers'), function() {
    $getUrl = config('global.getUrl');
    //'middleware' => ['auth:admin'],
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
    Route::get($getUrl.'/projects/uploads/gallery', function () {        
        return View::make('Projects::uploads.gallery');
    });
    Route::get($getUrl.'/projects/uploads/status', function () {
        return View::make('Projects::uploads.status');
    });
    Route::get($getUrl.'/projects/uploads/specification', function () {
        return View::make('Projects::uploads.specification');
    });

    Route::get($getUrl. '/projects/projectType', 'ProjectsController@projectType'); //for populate dropdown
    Route::get($getUrl. '/projects/projectStatus', 'ProjectsController@projectStatus'); //for populate dropdown
    Route::get($getUrl. '/projects/getProjects', 'ProjectsController@getProjects'); //for populate dropdown
    Route::get($getUrl. '/projects/webPage', ['middleware'=>'check-permission:050103', 'uses' => 'ProjectsController@webPage']); //show page
    Route::get($getUrl. '/projects/getProjectDetails/{id}', 'ProjectsController@getProjectDetails'); //get project details
    Route::get($getUrl. '/projects/manageProjects', 'ProjectsController@manageProjects'); //get project details  
    
    Route::resource($getUrl. '/projects', 'ProjectsController');
    Route::post($getUrl. '/projects/getInventoryDetails', 'ProjectsController@getInventoryDetails'); // get Inventory Details
    Route::post($getUrl. '/projects/basicInfo', 'ProjectsController@basicInfo'); //save basic info
    Route::post($getUrl. '/projects/getAmenitiesListOnEdit', 'ProjectsController@getAmenitiesListOnEdit'); //get ameniti list on edit
    Route::post($getUrl. '/projects/getProjectInventory', 'ProjectsController@getProjectInventory'); // getProjectInventory    
    Route::post($getUrl. '/projects/getWings', 'ProjectsController@getWings'); //get wing name
    Route::post($getUrl. '/projects/deleteStatus', 'ProjectsController@deleteStatus'); //delete status
    Route::post($getUrl. '/projects/getBlocks', 'ProjectsController@getBlocks'); //get block name
    Route::post($getUrl.'/projects/deleteImage', 'ProjectsController@deleteImage'); //delete image

});	
