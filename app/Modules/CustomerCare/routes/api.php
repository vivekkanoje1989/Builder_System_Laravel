<?php

Route::group(array('module' => 'CustomerCare', 'middleware' => ['api'], 'namespace' => 'App\Modules\CustomerCare\Controllers'), function() {

    Route::post('api/customer-care/presales/getTotal', 'CustomerCareController@getpresalesTotal');
    Route::post('api/customer-care/presales/getPrevious', 'CustomerCareController@getpresalesPrevious');
    Route::post('api/customer-care/presales/getToday', 'CustomerCareController@getpresalesToday');
    Route::post('api/customer-care/presales/getPending', 'CustomerCareController@getpresalesPending');
    Route::post('api/customer-care/presales/getCompleted', 'CustomerCareController@getpresalesCompleted');
    Route::post('api/customer-care/presales/getenquiryHistory', 'CustomerCareController@getEnquiryHistory');
    Route::post('api/customer-care/presales/insertCcPreSalesRemark', 'CustomerCareController@insertCcPreSalesRemark');
    Route::post('api/customer-care/presales/getPresalesTodayremarksEnquiry', 'CustomerCareController@getPresalesTodayremarksEnquiry');
        
    Route::resource('Customer_Care', 'CustomerCareController');
    
});	
