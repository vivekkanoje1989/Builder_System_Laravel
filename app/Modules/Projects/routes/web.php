<?php

Route::group(array('module' => 'Projects', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\Projects\Controllers'), function() {
    $getUrl = config('global.getUrl');
    //'middleware' => ['auth:admin'],
    Route::get($getUrl.'/projects/basicinfo',['middleware'=>'check-permission:050103', function () {
        return View::make('Projects::basicinfo');
    }]);
    Route::get($getUrl.'/projects/uploads',['middleware'=>'check-permission:050103', function () {
        return View::make('Projects::uploads');
    }]);
    Route::get($getUrl.'/projects/inventory',['middleware'=>'check-permission:050103', function () {
        return View::make('Projects::inventory');
    }]);
    Route::get($getUrl.'/projects/uploads/images',['middleware'=>'check-permission:050103', function () {
        return View::make('Projects::uploads.images');
    }]);
    Route::get($getUrl.'/projects/uploads/layouts',['middleware'=>'check-permission:050103', function () {
        return View::make('Projects::uploads.layouts');
    }]);
    Route::get($getUrl.'/projects/uploads/maps',['middleware'=>'check-permission:050103', function () {
        return View::make('Projects::uploads.maps');
    }]);
    Route::get($getUrl.'/projects/uploads/amenities',['middleware'=>'check-permission:050103', function () {
        return View::make('Projects::uploads.amenities');
    }]);
    Route::get($getUrl.'/projects/uploads/gallery',['middleware'=>'check-permission:050103', function () {        
        return View::make('Projects::uploads.gallery');
    }]);
    Route::get($getUrl.'/projects/uploads/status',['middleware'=>'check-permission:050103', function () {
        return View::make('Projects::uploads.status');
    }]);
    Route::get($getUrl.'/projects/uploads/specification',['middleware'=>'check-permission:050103', function () {
        return View::make('Projects::uploads.specification');
    }]);

    Route::get($getUrl. '/projects/projectType', 'ProjectsController@projectType'); //for populate dropdown
    Route::get($getUrl. '/projects/projectStatus', 'ProjectsController@projectStatus'); //for populate dropdown
    Route::get($getUrl. '/projects/getProjects', 'ProjectsController@getProjects'); //for populate dropdown
    Route::get($getUrl. '/projects/webPage', ['middleware'=>'check-permission:050103', 'uses' => 'ProjectsController@webPage']); //show page
    Route::get($getUrl. '/projects/getProjectDetails/{id}', 'ProjectsController@getProjectDetails'); //get project details
    Route::get($getUrl. '/projects/manageProjects', ['middleware'=>'check-permission:050101', 'uses' => 'ProjectsController@manageProjects']); //get project details  
    
//    Route::resource($getUrl. '/projects', 'ProjectsController');
    
    Route::get($getUrl. '/projects', ['middleware'=>'check-permission:050101', 'uses' => 'ProjectsController@index']);
    Route::get($getUrl. '/projects/create', ['middleware'=>'check-permission:050102', 'uses' => 'ProjectsController@create']);
    Route::post($getUrl. '/projects/', ['middleware'=>'check-permission:050102', 'uses' => 'ProjectsController@store']);
    
    Route::post($getUrl. '/projects/getInventoryDetails', ['middleware'=>'check-permission:050103', 'uses' => 'ProjectsController@getInventoryDetails']); // get Inventory Details
    Route::post($getUrl. '/projects/basicInfo', ['middleware'=>'check-permission:050103', 'uses' => 'ProjectsController@basicInfo']); //save basic info
    Route::post($getUrl. '/projects/getAmenitiesListOnEdit', ['middleware'=>'check-permission:050103', 'uses' => 'ProjectsController@getAmenitiesListOnEdit']); //get ameniti list on edit
    Route::post($getUrl. '/projects/getProjectInventory',['middleware'=>'check-permission:050103', 'uses' => 'ProjectsController@getProjectInventory']); // getProjectInventory    
    Route::post($getUrl. '/projects/getWings', 'ProjectsController@getWings'); //get wing name
    Route::post($getUrl. '/projects/deleteStatus',['middleware'=>'check-permission:050103', 'uses' => 'ProjectsController@deleteStatus']); //delete status
    Route::post($getUrl. '/projects/getBlocks', 'ProjectsController@getBlocks'); //get block name
    Route::post($getUrl.'/projects/deleteImage', ['middleware'=>'check-permission:050103', 'uses' => 'ProjectsController@deleteImage']); //delete image

});	
