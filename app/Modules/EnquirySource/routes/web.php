<?php

Route::group(array('module' => 'EnquirySource',  'namespace' => 'App\Modules\EnquirySource\Controllers'), function() {

      $getUrl = config('global.getUrl');
  
    Route::post($getUrl . '/enquiry-source/manageEnquirySource','EnquirySourceController@manageEnquirySource');
     Route::post($getUrl . '/enquiry-source/manageSubEnquirySource','EnquirySourceController@manageSubEnquirySource');
     Route::post($getUrl . '/enquiry-source/createSubEnquirySource','EnquirySourceController@createSubEnquirySource');
      Route::post($getUrl . '/enquiry-source/updateSubEnquirySource','EnquirySourceController@updateSubEnquirySource');
   
     Route::resource($getUrl . '/enquiry-source', 'EnquirySourceController');
});	
