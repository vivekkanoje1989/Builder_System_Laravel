<?php

Route::group(array('module' => 'PaymentHeadings', 'namespace' => 'App\Modules\PaymentHeadings\Controllers'), function() {

    $getUrl = config('global.getUrl');
   
    Route::get($getUrl . '/payment-headings/managePaymentHeading','PaymentHeadingsController@managePaymentHeading');
     Route::post($getUrl . '/payment-headings/manageProjectTypes ','PaymentHeadingsController@manageProjectTypes');
     Route::resource($getUrl.'/payment-headings', 'PaymentHeadingsController');
     
     

});	
