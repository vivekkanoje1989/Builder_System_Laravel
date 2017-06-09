<?php

Route::group(array('module' => 'CareerManagement', 'middleware' => ['auth:admin'],'namespace' => 'App\Modules\CareerManagement\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::get('/manage-job/manageCareers', 'CareerManagementController@manageCareers');
     Route::get('/manage-Job/{id}/edit', 'CareerManagementController@edit');
     Route::get('/manage-job/{id}/show', 'CareerManagementController@show');
       Route::get('/download/{file}', 'CareerManagementController@download');
     Route::resource('/manage-job', 'CareerManagementController');
    Route::get('/create-Job', 'CareerManagementController@create');  
    Route::post('/manage-job/getCareer', 'CareerManagementController@getCareer');
    Route::post('/manage-job/deleteJob', 'CareerManagementController@deleteJob');
     Route::post('/manage-job/viewapplicants', 'CareerManagementController@viewapplicants');
     
     
   
});

