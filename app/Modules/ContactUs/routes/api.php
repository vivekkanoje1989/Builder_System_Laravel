<?php

Route::group(array('module' => 'ContactUs', 'middleware' => ['api'], 'namespace' => 'App\Modules\ContactUs\Controllers'), function() {

    Route::resource('ContactUs', 'ContactUsController');
    
});	
