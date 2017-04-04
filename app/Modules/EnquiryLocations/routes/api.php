<?php

Route::group(array('module' => 'EnquiryLocations', 'middleware' => ['api'], 'namespace' => 'App\Modules\EnquiryLocations\Controllers'), function() {

    Route::resource('EnquiryLocations', 'EnquiryLocationsController');
    
});	
