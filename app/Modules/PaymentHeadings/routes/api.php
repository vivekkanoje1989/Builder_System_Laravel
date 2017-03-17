<?php

Route::group(array('module' => 'PaymentHeadings', 'middleware' => ['api'], 'namespace' => 'App\Modules\PaymentHeadings\Controllers'), function() {

    Route::resource('PaymentHeadings', 'PaymentHeadingsController');
    
});	
