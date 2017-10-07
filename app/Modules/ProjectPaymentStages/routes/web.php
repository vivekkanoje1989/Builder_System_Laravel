<?php

Route::group(array('module' => 'ProjectPaymentStages', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\ProjectPaymentStages\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::get('/project-payment/projectPaymentStagesExportToxls','ProjectPaymentStagesController@projectPaymentStagesExportToxls');
    Route::post('/project-payment/manageProjectPaymentStages','ProjectPaymentStagesController@manageProjectPaymentStages');
    Route::post('/project-payment/manageProjectTypes','ProjectPaymentStagesController@manageProjectTypes'); 
    Route::post('/project-payment/deleteProjectStages','ProjectPaymentStagesController@deleteProjectStages'); 
    Route::resource('/project-payment', 'ProjectPaymentStagesController');
});	
