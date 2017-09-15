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

    Route::get( '/projects/manageProjectsExportToExcel', 'ProjectsController@manageProjectsExportToExcel'); //for populate dropdown
    Route::get( '/projects/projectType', ['middleware'=>'permission:050102', 'uses' =>'ProjectsController@projectType']); //for populate dropdown
    Route::get( '/projects/projectStatus', ['middleware'=>'permission:050102', 'uses' =>'ProjectsController@projectStatus']); //for populate dropdown
    Route::get( '/projects/getProjects', 'ProjectsController@getProjects'); //for populate dropdown
    Route::get( '/projects/webpageDetails/{id}', 'ProjectsController@webpageDetails')->middleware('permission:050101'); //show page   
    Route::post( '/projects/webpageSettings', 'ProjectsController@webpageSettings'); //get project setting details
    Route::post( '/projects/uploadsData', 'ProjectsController@uploadsData'); //get project upload details
    
    Route::get( '/projects/manageProjects', ['middleware'=>'permission:050101', 'uses' => 'ProjectsController@manageProjects']); //get project details      
    Route::get( '/projects', ['middleware'=>'permission:050101', 'uses' => 'ProjectsController@index']);
//    Route::get( '/projects/create', ['middleware'=>'permission:050102','uses' => 'ProjectsController@create']);
    Route::get( '/projects/create', 'ProjectsController@create')->middleware('permission:050102');
    Route::post( '/projects/', ['middleware'=>'permission:050102', 'uses' => 'ProjectsController@store']);
    
    Route::post( '/projects/inventoryDetails', ['middleware'=>'permission:050103', 'uses' => 'ProjectsController@inventoryDetails']); // get Inventory Details
    Route::post( '/projects/getInventoryDetails', ['middleware'=>'permission:050103', 'uses' => 'ProjectsController@getInventoryDetails']); // get Inventory Details
    Route::post( '/projects/getAmenitiesListOnEdit', ['middleware'=>'permission:050103', 'uses' => 'ProjectsController@getAmenitiesListOnEdit']); //get ameniti list on edit
    Route::post( '/projects/getProjectInventory',['middleware'=>'permission:050103', 'uses' => 'ProjectsController@getProjectInventory']); // getProjectInventory    
    Route::post( '/projects/getWings', 'ProjectsController@getWings'); //get wing name
    Route::post( '/projects/deleteStatus',['middleware'=>'permission:050103', 'uses' => 'ProjectsController@deleteStatus']); //delete status
    Route::post( '/projects/getBlocks', 'ProjectsController@getBlocks'); //get block name
    Route::post( '/projects/deleteImage', ['middleware'=>'permission:050103', 'uses' => 'ProjectsController@deleteImage']); //delete image

});	