<?php

Route::group(array('module' => 'EnquiryLocations','middleware' => 'auth:admin', 'namespace' => 'App\Modules\EnquiryLocations\Controllers'), function() {

    $getUrl = config('global.getUrl');

    Route::get($getUrl . '/enquiry-location/enquiryLocation', 'EnquiryLocationsController@enquiryLocation');
    Route::get($getUrl . '/enRoute::post($getUrlquiry-location/manageCity', 'EnquiryLocationsController@manageCity');
    Route::get($getUrl . '/enquiry-location/manageCountry', 'EnquiryLocationsController@manageCountry');
    Route::post($getUrl . '/enquiry-location/manageStates', 'EnquiryLocationsController@manageStates');
    Route::post($getUrl . '/enquiry-location/manageCity', 'EnquiryLocationsController@manageCity');
    Route::resource($getUrl . '/enquiry-location', 'EnquiryLocationsController');
});
