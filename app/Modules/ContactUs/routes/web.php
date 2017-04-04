<?php

Route::group(array('module' => 'ContactUs', 'namespace' => 'App\Modules\ContactUs\Controllers'), function() {

    $getUrl = config('global.getUrl');
     Route::post($getUrl . '/contact-us/getContactUsRow','ContactUsController@getContactUsRow');
    Route::resource($getUrl.'/contact-us', 'ContactUsController');
    
    Route::post($getUrl.'/contact-us/manageContactUs','ContactUsController@manageContactUs');
    
    Route::post($getUrl . '/contact-us/manageStates','ContactUsController@manageStates');
    Route::post($getUrl . '/contact-us/manageCountry','ContactUsController@manageCountry'); 
    Route::post($getUrl . '/contact-us/manageCity','ContactUsController@manageCity'); 
    Route::post($getUrl . '/contact-us/manageLocation','ContactUsController@manageLocation'); 
   
});	
