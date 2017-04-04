<?php

Route::group(array('module' => 'CareerManagement', 'middleware' => 'auth:admin','namespace' => 'App\Modules\CareerManagement\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::get($getUrl.'/manage-job/manageCareers', 'CareerManagementController@manageCareers');
     Route::get($getUrl.'/manage-Job/{id}/edit', 'CareerManagementController@edit');
     Route::get($getUrl.'/manage-job/{id}/show', 'CareerManagementController@show');
       Route::get('/download/{file}', 'CareerManagementController@download');
     Route::resource($getUrl.'/manage-job', 'CareerManagementController');
    Route::get($getUrl.'/create-Job', 'CareerManagementController@create');  
    Route::post($getUrl.'/manage-job/getCareer', 'CareerManagementController@getCareer');
    Route::post($getUrl.'/manage-job/deleteJob', 'CareerManagementController@deleteJob');
     Route::post($getUrl.'/manage-job/viewapplicants', 'CareerManagementController@viewapplicants');
     
     
   
});

