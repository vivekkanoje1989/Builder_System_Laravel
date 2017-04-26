<?php

Route::group(array('module' => 'AssignWebEnquiry', 'middleware' => ['api'], 'namespace' => 'App\Modules\AssignWebEnquiry\Controllers'), function() {

    Route::resource('AssignWebEnquiry', 'AssignWebEnquiryController');
    
});	
