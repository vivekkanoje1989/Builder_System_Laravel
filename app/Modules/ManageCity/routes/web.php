<?php

Route::group(array('module' => 'ManageCity','middleware' => 'auth:admin', 'namespace' => 'App\Modules\ManageCity\Controllers'), function() {
 
     $getUrl = config('global.getUrl');
     Route::get($getUrl . '/manage-city/manageCity','ManageCityController@manageCity');
     Route::post($getUrl . '/manage-city/manageStates','ManageCityController@manageStates');
     Route::get($getUrl . '/manage-city/manageCountry','ManageCityController@manageCountry');   
     Route::resource($getUrl . '/manage-city', 'ManageCityController');
});	
