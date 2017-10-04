<?php

Route::group(array('module' => 'CareerManagement', 'middleware' => ['api'], 'namespace' => 'App\Modules\CareerManagement\Controllers'), function() {

    Route::post('api/manage-job', 'CareerManagementController@store');
    Route::put('api/manage-job/{id}', 'CareerManagementController@update');
    Route::post('api/manage-job/getCareer', 'CareerManagementController@getCareer');
    Route::post('api/manage-job/manageCareers', 'CareerManagementController@manageCareers');
    Route::resource('careerManagement', 'CareerManagementController');
});
