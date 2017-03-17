<?php

Route::group(array('module' => 'ContactUs', 'namespace' => 'App\Modules\ContactUs\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource($getUrl.'/contact-us', 'ContactUsController');
    
});	
