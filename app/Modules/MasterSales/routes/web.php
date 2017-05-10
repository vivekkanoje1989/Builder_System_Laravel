<?php
Route::group(array('module' => 'MasterSales', 'middleware' => ['web'], 'namespace' => 'App\Modules\MasterSales\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::get($getUrl.'/MasterSales/createEnquiry', function () {
       return View::make('MasterSales::createEnquiry');
   });
    Route::get($getUrl.'/MasterSales/createGetCustomer', function () {
       return View::make('MasterSales::createGetCustomer');
   });
    Route::get($getUrl.'/MasterSales/enquiryHistory', function () {
       return View::make('MasterSales::enquiryHistory');
   });
    Route::get($getUrl.'/master-sales/showtodaysfollowup', function () {
       return view('MasterSales::todaysFollowups');
   });
    Route::get($getUrl .'/master-sales/updateCustomer/{id}','MasterSalesController@updateCustomer');
    Route::get($getUrl . '/master-sales/getEmployees', 'MasterSalesController@getEmployees');  // get all employees
    Route::get($getUrl . '/master-sales/totalEnquiries', 'MasterSalesController@totalEnquiries'); // view of total enquiries
    Route::get($getUrl . '/master-sales/getAllEnquiries', 'MasterSalesController@getAllEnquiries'); // get all getAllEnquiries
    Route::get($getUrl . '/master-sales/showLostEnquiry', 'MasterSalesController@showLostEnquiry'); // view of showLostEnquiry
    Route::get($getUrl . '/master-sales/getLostEnquiries','MasterSalesController@getLostEnquiries'); // get all lost enquiries
    Route::get($getUrl . '/master-sales/showCloseEnquiry', 'MasterSalesController@showCloseEnquiry'); // view of showCloseEnquiry
    Route::get($getUrl . '/master-sales/getCloseEnquiries', 'MasterSalesController@getCloseEnquiries');// getCloseEnquiries
    Route::get($getUrl . '/master-sales/getEnquiryCity', 'MasterSalesController@getEnquiryCity'); // get enquiry city from table 
    Route::get($getUrl . '/master-sales/getTodaysFollowup', 'MasterSalesController@getTodaysFollowup'); // get TodaysFollowup
    Route::post($getUrl . '/master-sales/getAllLocations', 'MasterSalesController@getAllLocations'); //get all locations of perticular city id
    Route::get($getUrl . '/master-sales/getFinanceEmployees', 'MasterSalesController@getFinanceEmployees'); // get employees whose deparment is finance
    Route::get($getUrl . '/master-sales/showEnquiry/{id}', 'MasterSalesController@showEnquiry'); //show enquiry page
    Route::post($getUrl . '/master-sales/saveEnquiryData', 'MasterSalesController@saveEnquiryData'); //saveEnquiryData
    Route::resource($getUrl . '/master-sales', 'MasterSalesController');
    Route::post($getUrl . '/master-sales/getCustomerDetails', 'MasterSalesController@getCustomerDetails');
    Route::post($getUrl . '/master-sales/getCustomerDataWithId', 'MasterSalesController@getCustomerDataWithId'); // getCustomerDataWithId
    Route::post($getUrl . '/master-sales/checkMobileExist', 'MasterSalesController@checkMobileExist');
    Route::post($getUrl . '/master-sales/getEnquiryHistory','MasterSalesController@getEnquiryHistory');    
    
});


