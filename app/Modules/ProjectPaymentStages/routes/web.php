<?php

Route::group(array('module' => 'ProjectPaymentStages', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\ProjectPaymentStages\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::post('/project-payment/manageProjectPaymentStages','ProjectPaymentStagesController@manageProjectPaymentStages');
    Route::post('/project-payment/manageProjectTypes','ProjectPaymentStagesController@manageProjectTypes'); 
    Route::resource('/project-payment', 'ProjectPaymentStagesController');
});	
