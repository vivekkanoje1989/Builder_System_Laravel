<?php
Route::group(array('module' => 'MasterSales', 'middleware' => ['web'], 'namespace' => 'App\Modules\MasterSales\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::get($getUrl . '/master-sales/getEmployees', 'MasterSalesController@getEmployees');  // get all employees
    Route::get($getUrl . '/master-sales/totalEnquiries', 'MasterSalesController@totalEnquiries'); // view of total enquiries
    Route::get($getUrl . '/master-sales/getAllEnquiries', 'MasterSalesController@getAllEnquiries'); // get all getAllEnquiries
    Route::get($getUrl . '/master-sales/getEnquiryCity', 'MasterSalesController@getEnquiryCity'); // get enquiry city from table 
    Route::post($getUrl . '/master-sales/getAllLocations', 'MasterSalesController@getAllLocations'); //get all locations of perticular city id
    Route::get($getUrl . '/master-sales/getFinanceEmployees', 'MasterSalesController@getFinanceEmployees'); // get employees whose deparment is finance
    Route::get($getUrl . '/master-sales/showEnquiry/{id}', 'MasterSalesController@showEnquiry'); //show enquiry page
    Route::post($getUrl . '/master-sales/saveEnquiryData', 'MasterSalesController@saveEnquiryData'); //saveEnquiryData
    Route::resource($getUrl . '/master-sales', 'MasterSalesController');
    Route::post($getUrl . '/master-sales/getCustomerDetails', 'MasterSalesController@getCustomerDetails');
    Route::post($getUrl . '/master-sales/checkMobileExist', 'MasterSalesController@checkMobileExist');
    
});


