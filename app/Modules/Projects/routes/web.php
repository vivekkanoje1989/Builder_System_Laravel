<?php
Route::group(array('module' => 'Projects', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\Projects\Controllers'), function() {
    $getUrl = config('global.getUrl');
    //'middleware' => ['auth:admin'],
    Route::get('/projects/basicinfo',['middleware'=>'check-permission:050103', function () {
        return View::make('Projects::basicinfo');
    }]);
    Route::get('/projects/uploads',['middleware'=>'check-permission:050103', function () {
        return View::make('Projects::uploads');
    }]);
    Route::get('/projects/inventory',['middleware'=>'check-permission:050103', function () {
        return View::make('Projects::inventory');
    }]);
    Route::get('/projects/uploads/images',['middleware'=>'check-permission:050103', function () {
        return View::make('Projects::uploads.images');
    }]);
    Route::get('/projects/uploads/layouts',['middleware'=>'check-permission:050103', function () {
        return View::make('Projects::uploads.layouts');
    }]);
    Route::get('/projects/uploads/maps',['middleware'=>'check-permission:050103', function () {
        return View::make('Projects::uploads.maps');
    }]);
    Route::get('/projects/uploads/amenities',['middleware'=>'check-permission:050103', function () {
        return View::make('Projects::uploads.amenities');
    }]);
    Route::get('/projects/uploads/gallery',['middleware'=>'check-permission:050103', function () {        
        return View::make('Projects::uploads.gallery');
    }]);
    Route::get('/projects/uploads/status',['middleware'=>'check-permission:050103', function () {
        return View::make('Projects::uploads.status');
    }]);
    Route::get('/projects/uploads/specification',['middleware'=>'check-permission:050103', function () {
        return View::make('Projects::uploads.specification');
    }]);

    Route::get( '/projects/projectType', 'ProjectsController@projectType'); //for populate dropdown
    Route::get( '/projects/projectStatus', 'ProjectsController@projectStatus'); //for populate dropdown
    Route::get( '/projects/getProjects', 'ProjectsController@getProjects'); //for populate dropdown
    Route::get( '/projects/webPage', ['middleware'=>'check-permission:050103', 'uses' => 'ProjectsController@webPage']); //show page
    Route::get( '/projects/getProjectDetails/{id}', 'ProjectsController@getProjectDetails'); //get project details
    Route::get( '/projects/manageProjects', ['middleware'=>'check-permission:050101', 'uses' => 'ProjectsController@manageProjects']); //get project details  
    
//    Route::resource( '/projects', 'ProjectsController');
    
    Route::get( '/projects', ['middleware'=>'check-permission:050101', 'uses' => 'ProjectsController@index']);
    Route::get( '/projects/create', ['middleware'=>'check-permission:050102', 'uses' => 'ProjectsController@create']);
    Route::post( '/projects/', ['middleware'=>'check-permission:050102', 'uses' => 'ProjectsController@store']);
    
    Route::post( '/projects/getInventoryDetails', ['middleware'=>'check-permission:050103', 'uses' => 'ProjectsController@getInventoryDetails']); // get Inventory Details
    Route::post( '/projects/basicInfo', ['middleware'=>'check-permission:050103', 'uses' => 'ProjectsController@basicInfo']); //save basic info
    Route::post( '/projects/getAmenitiesListOnEdit', ['middleware'=>'check-permission:050103', 'uses' => 'ProjectsController@getAmenitiesListOnEdit']); //get ameniti list on edit
    Route::post( '/projects/getProjectInventory',['middleware'=>'check-permission:050103', 'uses' => 'ProjectsController@getProjectInventory']); // getProjectInventory    
    Route::post( '/projects/getWings', 'ProjectsController@getWings'); //get wing name
    Route::post( '/projects/deleteStatus',['middleware'=>'check-permission:050103', 'uses' => 'ProjectsController@deleteStatus']); //delete status
    Route::post( '/projects/getBlocks', 'ProjectsController@getBlocks'); //get block name
    Route::post('/projects/deleteImage', ['middleware'=>'check-permission:050103', 'uses' => 'ProjectsController@deleteImage']); //delete image

});	