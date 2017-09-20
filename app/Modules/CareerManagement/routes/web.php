<?php
Route::group(array('module' => 'CareerManagement', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\CareerManagement\Controllers'), function() {

    Route::get('/manage-job/jobPostingExportToxls', 'CareerManagementController@jobPostingExportToxls')->middleware("permission:01001");
    Route::get('/manage-job/jobPostingApplicationExportToxls/{id}', 'CareerManagementController@jobPostingApplicationExportToxls')->middleware("permission:01001");
    Route::get('/manage-job/manageCareers', 'CareerManagementController@manageCareers')->middleware("permission:01001");
    Route::get('/download/{file}', 'CareerManagementController@download')->middleware("permission:01001");
    
    Route::get('/manage-job', 'CareerManagementController@index')->middleware("permission:01001");
    Route::get('/manage-job/create', 'CareerManagementController@create')->middleware("permission:01002");
    Route::post('/manage-job', 'CareerManagementController@store')->middleware("permission:01002");
    Route::get('/manage-job/{id}/show', 'CareerManagementController@show')->middleware("permission:01001");
    Route::get('/manage-job/{id}/edit', 'CareerManagementController@edit')->middleware("permission:01001");
    Route::put('/manage-job/{id}', 'CareerManagementController@update')->middleware("permission:01001");
    
    Route::post('/manage-job/getCareer', 'CareerManagementController@getCareer')->middleware("permission:01001");
    Route::post('/manage-job/deleteJob', 'CareerManagementController@deleteJob')->middleware("permission:01001");
    Route::post('/manage-job/viewapplicants', 'CareerManagementController@viewapplicants')->middleware("permission:01001");
});

