<?php

Route::group(array('module' => 'ProjectPaymentStages', 'middleware' => ['api'], 'namespace' => 'App\Modules\ProjectPaymentStages\Controllers'), function() {

    Route::resource('ProjectPaymentStages', 'ProjectPaymentStagesController');
    
});	
