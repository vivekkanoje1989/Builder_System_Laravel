<?php

Route::group(array('module' => 'Projects', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\Projects\Controllers'), function() {
  
    Route::get('/projects/basicinfo',['middleware'=>'permission:050101', function () {
        return View::make('Projects::basicinfo');
    }]);
    Route::get('/projects/uploads',['middleware'=>'permission:050101', function () {
        return View::make('Projects::uploads');
    }]);
    Route::get('/projects/inventory',['middleware'=>'permission:050101', function () {
        return View::make('Projects::inventory');
    }]);
    Route::get('/projects/uploads/images',['middleware'=>'permission:050101', function () {
        return View::make('Projects::uploads.images');
    }]);
    Route::get('/projects/uploads/layouts',['middleware'=>'permission:050101', function () {
        return View::make('Projects::uploads.layouts');
    }]);
    Route::get('/projects/uploads/maps',['middleware'=>'permission:050101', function () {
        return View::make('Projects::uploads.maps');
    }]);
    Route::get('/projects/uploads/amenities',['middleware'=>'permission:050101', function () {
        return View::make('Projects::uploads.amenities');
    }]);
    Route::get('/projects/uploads/gallery',['middleware'=>'permission:050101', function () {        
        return View::make('Projects::uploads.gallery');
    }]);
    Route::get('/projects/uploads/status',['middleware'=>'permission:050101', function () {
        return View::make('Projects::uploads.status');
    }]);
    Route::get('/projects/uploads/specification',['middleware'=>'permission:050101', function () {
        return View::make('Projects::uploads.specification');
    }]);

    Route::get( '/projects/manageProjectsExportToExcel', 'ProjectsController@manageProjectsExportToExcel')->middleware('permission:050101'); //for populate dropdown
    Route::get( '/projects/projectType', 'ProjectsController@projectType')->middleware('permission:050102'); //for populate dropdown
    Route::get( '/projects/projectStatus', 'ProjectsController@projectStatus')->middleware('permission:05012'); //for populate dropdown
    Route::get( '/projects/getProjects', 'ProjectsController@getProjects'); //for populate dropdown
    Route::get( '/projects/webpageDetails/{id}', 'ProjectsController@webpageDetails')->middleware('permission:050101'); //show page   
    Route::post( '/projects/webpageSettings', 'ProjectsController@webpageSettings')->middleware('permission:050101'); //get project setting details
    Route::post( '/projects/uploadsData', 'ProjectsController@uploadsData')->middleware('permission:050101'); //get project upload details
    
    Route::get( '/projects/manageProjects', 'ProjectsController@manageProjects')->middleware('permission:050101'); //get project details      
    Route::get( '/projects', 'ProjectsController@index')->middleware('permission:050101');
    Route::get( '/projects/create', 'ProjectsController@create')->middleware('permission:050102');
    Route::post( '/projects/', 'ProjectsController@store')->middleware('permission:050102');
    
    Route::post( '/projects/inventoryDetails', 'ProjectsController@inventoryDetails')->middleware('permission:050101'); // get Inventory Details
    Route::post( '/projects/getInventoryDetails', 'ProjectsController@getInventoryDetails')->middleware('permission:050101'); // get Inventory Details
    Route::post( '/projects/getAmenitiesListOnEdit','ProjectsController@getAmenitiesListOnEdit')->middleware('permission:050101'); //get ameniti list on edit
    Route::post( '/projects/getProjectInventory', 'ProjectsController@getProjectInventory')->middleware('permission:050101'); // getProjectInventory    
    Route::post( '/projects/getWings', 'ProjectsController@getWings')->middleware('permission:050101'); //get wing name
    Route::post( '/projects/deleteStatus', 'ProjectsController@deleteStatus')->middleware('permission:050101'); //delete status
    Route::post( '/projects/getBlocks', 'ProjectsController@getBlocks')->middleware('permission:050101'); //get block name
    Route::post( '/projects/deleteImage',  'ProjectsController@deleteImage')->middleware('permission:050101'); //delete image

});	