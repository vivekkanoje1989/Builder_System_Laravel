<?php

Route::group(array('module' => 'ManageLocation', 'middleware' => ['auth:admin'],'namespace' => 'App\Modules\ManageLocation\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::resource('/manage-location', 'ManageLocationController');
    Route::post('/manage-location/manageLocation','ManageLocationController@manageLocation');
    Route::post('/manage-location/filteredData', 'ManageLocationController@filteredData');
    
     Route::get('/ManageLocation/showFilter', function () {
        return View::make('ManageLocation::showFilter');
    });
});
