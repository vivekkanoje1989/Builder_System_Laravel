<?php

Route::group(array('module' => 'AssignWebEnquiry', 'namespace' => 'App\Modules\AssignWebEnquiry\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource($getUrl.'/assign-enquiry', 'AssignWebEnquiryController');
    Route::post($getUrl.'/assign-enquiry/manageAutoEnquiries','AssignWebEnquiryController@manageAutoEnquiries');
     Route::post($getUrl.'/assign-enquiry/updateAutoEnquiries','AssignWebEnquiryController@manageAutoEnquiries');
  
    
});	
