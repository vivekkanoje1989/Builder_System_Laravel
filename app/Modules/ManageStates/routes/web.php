<?php

Route::group(array('module' => 'ManageStates','middleware' => ['auth:admin'],'namespace' => 'App\Modules\ManageStates\Controllers'), function() {

     $getUrl = config('global.getUrl');
     Route::post('/manage-states/manageStates','ManageStatesController@manageStates');
    Route::post('/manage-states/filteredData', 'ManageStatesController@filteredData');
     Route::get('/manage-states/manageCountry','ManageStatesController@manageCountry');
     Route::resource('/manage-states', 'ManageStatesController');
     
     Route::get('/ManageStates/showFilter', function () {
        return View::make('ManageStates::showFilter');
    });
  
    
});	
