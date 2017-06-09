<?php

Route::group(array('module' => 'ManageCity','middleware' => ['auth:admin'], 'namespace' => 'App\Modules\ManageCity\Controllers'), function() {
 
     $getUrl = config('global.getUrl');
     Route::get('/manage-city/manageCity','ManageCityController@manageCity');
     Route::post('/manage-city/manageStates','ManageCityController@manageStates');
     Route::get('/manage-city/manageCountry','ManageCityController@manageCountry');   
     Route::resource('/manage-city', 'ManageCityController');
});	
