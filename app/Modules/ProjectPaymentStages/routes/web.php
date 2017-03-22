<?php

Route::group(array('module' => 'ProjectPaymentStages',  'namespace' => 'App\Modules\ProjectPaymentStages\Controllers'), function() {

    $getUrl = config('global.getUrl');
   
    Route::post($getUrl.'/project-payment/manageProjectPaymentStages','ProjectPaymentStagesController@manageProjectPaymentStages');
    Route::post($getUrl.'/project-payment/manageProjectTypes','ProjectPaymentStagesController@manageProjectTypes'); 
     Route::resource($getUrl.'/project-payment', 'ProjectPaymentStagesController');
    
    
});	
