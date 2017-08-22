<?php

Route::group(array('module' => 'EnquiryLocations','middleware' => ['auth:admin'], 'namespace' => 'App\Modules\EnquiryLocations\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::post('/enquiry-location/enquiryLocation', 'EnquiryLocationsController@enquiryLocation');
    Route::get('/enRoute::post($getUrlquiry-location/manageCity', 'EnquiryLocationsController@manageCity');
    Route::get('/enquiry-location/manageCountry', 'EnquiryLocationsController@manageCountry');
    Route::post('/enquiry-location/manageStates', 'EnquiryLocationsController@manageStates');
    Route::post('/enquiry-location/manageCity', 'EnquiryLocationsController@manageCity');
    Route::post('/enquiry-location/filteredData', 'EnquiryLocationsController@filteredData');
        
    Route::resource('/enquiry-location', 'EnquiryLocationsController');
     Route::get('/EnquiryLocations/showFilter', function () {
        return View::make('EnquiryLocations::showFilter');
    });
});
