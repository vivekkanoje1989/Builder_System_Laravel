<?php

Route::group(array('module' => 'ManageStates','middleware' => ['auth:admin'],'namespace' => 'App\Modules\ManageStates\Controllers'), function() {

     $getUrl = config('global.getUrl');
     Route::get('/manage-states/manageStates','ManageStatesController@manageStates');
     Route::get('/manage-states/manageCountry','ManageStatesController@manageCountry');
     Route::resource('/manage-states', 'ManageStatesController');
  
    
});	
