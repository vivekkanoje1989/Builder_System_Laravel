<?php

Route::group(array('module' => 'ManageStates','middleware' => 'auth:admin','namespace' => 'App\Modules\ManageStates\Controllers'), function() {

     $getUrl = config('global.getUrl');
     Route::get($getUrl . '/manage-states/manageStates','ManageStatesController@manageStates');
     Route::get($getUrl . '/manage-states/manageCountry','ManageStatesController@manageCountry');
     Route::resource($getUrl . '/manage-states', 'ManageStatesController');
  
    
});	
