<?php

Route::group(array('module' => 'EnquirySource', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\EnquirySource\Controllers'), function() {

      $getUrl = config('global.getUrl');
  
    Route::post('/enquiry-source/manageEnquirySource','EnquirySourceController@manageEnquirySource');
     Route::post('/enquiry-source/manageSubEnquirySource','EnquirySourceController@manageSubEnquirySource');
     Route::post('/enquiry-source/createSubEnquirySource','EnquirySourceController@createSubEnquirySource');
      Route::post('/enquiry-source/updateSubEnquirySource','EnquirySourceController@updateSubEnquirySource');
   
     Route::resource('/enquiry-source', 'EnquirySourceController');
});	
