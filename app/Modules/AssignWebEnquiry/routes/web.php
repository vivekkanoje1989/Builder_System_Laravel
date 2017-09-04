<?php

Route::group(array('module' => 'AssignWebEnquiry', 'middleware' => ['auth:admin'],'namespace' => 'App\Modules\AssignWebEnquiry\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource('/assign-enquiry', 'AssignWebEnquiryController');
    Route::post('/assign-enquiry/manageAutoEnquiries','AssignWebEnquiryController@manageAutoEnquiries');
     Route::post('/assign-enquiry/updateAutoEnquiries','AssignWebEnquiryController@manageAutoEnquiries');
  
    
});	
