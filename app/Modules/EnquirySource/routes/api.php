<?php

Route::group(array('module' => 'EnquirySource', 'middleware' => ['api'], 'namespace' => 'App\Modules\EnquirySource\Controllers'), function() {

    Route::resource('EnquirySource', 'EnquirySourceController');
    
});	
