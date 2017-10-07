<?php

Route::group(array('module' => 'ContactUs', 'middleware' => ['auth:admin'],'namespace' => 'App\Modules\ContactUs\Controllers'), function() {

    $getUrl = config('global.getUrl');
     Route::post('/contact-us/getContactUsRow','ContactUsController@getContactUsRow');
      Route::get('/contact-us/contactUsExportToxls','ContactUsController@contactUsExportToxls'); 
    Route::resource('/contact-us', 'ContactUsController');
    
    Route::post('/contact-us/manageContactUs','ContactUsController@manageContactUs');
    
    Route::post('/contact-us/manageStates','ContactUsController@manageStates');
    Route::post('/contact-us/manageCountry','ContactUsController@manageCountry'); 
    Route::post('/contact-us/manageCity','ContactUsController@manageCity'); 
    Route::post('/contact-us/manageLocation','ContactUsController@manageLocation'); 
    Route::post('/contact-us/deleteContact','ContactUsController@deleteContact'); 
   
   
    
    Route::get('/ContactUs/showFilter', function () {
        return View::make('ContactUs::showFilter');
    });
});	
