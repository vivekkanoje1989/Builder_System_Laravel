<?php

Route::group(array('module' => 'PaymentHeadings','middleware' => ['auth:admin'], 'namespace' => 'App\Modules\PaymentHeadings\Controllers'), function() {

    $getUrl = config('global.getUrl');
   
    Route::get('/payment-headings/managePaymentHeading','PaymentHeadingsController@managePaymentHeading');
     Route::post('/payment-headings/manageProjectTypes ','PaymentHeadingsController@manageProjectTypes');
     Route::resource('/payment-headings', 'PaymentHeadingsController');
     
     

});	
