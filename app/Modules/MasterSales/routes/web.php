<?php

Route::group(array('module' => 'MasterSales', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\MasterSales\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::get('/dirPagination', function () {
        return View::make('backend.dirPagination');
    });
    Route::get('/MasterSales/createEnquiry', function () {
        return View::make('MasterSales::createEnquiry');
    });
    Route::get('/MasterSales/createCustomer', function () {
        return View::make('MasterSales::createCustomer');
    });
    Route::get('/MasterSales/enquiryHistory', function () {
        return View::make('MasterSales::enquiryHistory');
    });
    Route::get('/MasterSales/enquiryListing', function () {
        return View::make('MasterSales::enquiryListing');
    });
    Route::get('/MasterSales/todaysRemark', function () {
        return View::make('MasterSales::todaysRemark');
    });
    Route::get('/MasterSales/showFilter', function () {
        return View::make('MasterSales::showFilter');
    });    
    Route::get('/MasterSales/scheduletestdrive', function () {
        return View::make('MasterSales::scheduletestdrive');
    });
    Route::get('/master-sales/createQuickEnquiry','MasterSalesController@createQuickEnquiry');
 
    
    /*********************TEAM ENQUIRIES & FOLLOWUPS*********************/
    Route::get('/master-sales/teamLostEnquiries', function () {
        return view('MasterSales::teamLostEnquiries');
    });
    Route::get('/master-sales/teamClosedEnquiries', function () {
        return view('MasterSales::teamClosedEnquiries');
    });
    Route::get('/master-sales/teamTodayFollowups', function () {
        return view('MasterSales::teamTodayFollowups');
    });
    Route::get('/master-sales/teamPendingFollowups', function () {
        return view('MasterSales::teamPendingFollowups');
    });
    Route::get('/master-sales/teamPreviousFollowups', function () {
        return view('MasterSales::teamPreviousFollowups');
    });    
    Route::get('/master-sales/import', function () {
        return View::make('MasterSales::import');
    });
    /*********************TEAM ENQUIRIES & FOLLOWUPS*********************/    
    Route::get('/master-sales/updateCustomer/{id}', 'MasterSalesController@updateCustomer'); //update customer data
    Route::get('/master-sales/getEmployees', 'MasterSalesController@getEmployees');  // get all employees    
    Route::get('/master-sales/getEnquiryCity', 'MasterSalesController@getEnquiryCity'); // get enquiry city from table 
    Route::post('/master-sales/getAllLocations', 'MasterSalesController@getAllLocations'); //get all locations of perticular city id
    Route::get('/master-sales/getFinanceEmployees', 'MasterSalesController@getFinanceEmployees'); // get employees whose deparment is finance
    Route::get('/master-sales/showEnquiry/{id}', 'MasterSalesController@showEnquiry'); //show enquiry page
    Route::post('/master-sales/saveEnquiry', 'MasterSalesController@saveEnquiry'); //save enquiry data
    
    Route::get('/master-sales/editCustomer/cid/{cid}', 'MasterSalesController@editCustomer'); //updateCustomer
    Route::get('/master-sales/editEnquiry/cid/{cid}/eid/{eid}', 'MasterSalesController@editEnquiry'); //update enquiry data
    Route::put('/master-sales/updateEnquiry/{id}', 'MasterSalesController@updateEnquiry'); //update enquiry data
    Route::resource('/master-sales', 'MasterSalesController');
    Route::post('/master-sales/getCustomerDetails', 'MasterSalesController@getCustomerDetails'); //get customer details
    Route::post('/master-sales/getEnquiryDetails', 'MasterSalesController@getEnquiryDetails'); //get enquiry details
    Route::post('/master-sales/getCustomerDataWithId', 'MasterSalesController@getCustomerDataWithId'); // get Customer Data With Id
    Route::post('/master-sales/checkMobileExist', 'MasterSalesController@checkMobileExist');
    Route::post('/master-sales/delEnquiryDetailRow', 'MasterSalesController@delEnquiryDetailRow');
    Route::post('/master-sales/addEnquiryDetailRow', 'MasterSalesController@addEnquiryDetailRow');
    Route::post('/master-sales/getEnquiryHistory', 'MasterSalesController@getEnquiryHistory');
    Route::post('/master-sales/getDataForTodayRemark', 'MasterSalesController@getDataForTodayRemark');
    Route::post('/master-sales/insertTodayRemark', 'MasterSalesController@insertTodayRemark');
    Route::post('/master-sales/exportToExcel', 'MasterSalesController@exportToExcel');//export data in excel sheet    
    Route::post('/master-sales/filteredData', 'MasterSalesController@filteredData');//filtered data
    
    /****************************ENQUIRIES****************************/
    Route::get('/master-sales/totalEnquiry/{type}', 'MasterSalesController@totalEnquiry'); // get total enq with type
    Route::post('/master-sales/getTotalEnquiries', 'MasterSalesController@getTotalEnquiries'); // total enquiries listing
    Route::get('/master-sales/reassignEnquiry/{type}', 'MasterSalesController@reassignEnquiry'); //  reassign enquiries
    Route::post('/master-sales/getReassignEnquiry', 'MasterSalesController@getReassignEnquiry'); // listing for reassign enquiries
    Route::get('/master-sales/lostEnquiries/{type}', 'MasterSalesController@lostEnquiries'); // get all lost enquiries
    Route::post('/master-sales/getLostEnquiries', 'MasterSalesController@getLostEnquiries'); // get lost enquiries listing
    Route::get('/master-sales/bookedEnquiries/{type}', 'MasterSalesController@bookedEnquiries'); // get all booked enquiries 
    Route::post('/master-sales/getBookedEnquiries', 'MasterSalesController@getBookedEnquiries'); // get Booked  Enquiries
    /****************************ENQUIRIES****************************/
    
    /****************************FOLLOWUPS****************************/
    Route::get('/master-sales/showTodaysFollowups/{type}', 'MasterSalesController@showTodaysFollowups');// today followups with type
    Route::get('/master-sales/showPendingFollowups/{type}', 'MasterSalesController@showPendingFollowups');// pending followups with type
    Route::get('/master-sales/showPreviousFollowups/{type}', 'MasterSalesController@showPreviousFollowups');// pending followups with type
    Route::post('/master-sales/getTodaysFollowups', 'MasterSalesController@getTodaysFollowups'); // get TodaysFollowups    
    Route::post('/master-sales/getPendingFollowups', 'MasterSalesController@getPendingFollowups'); // get getPendingFollowups
    Route::post('/master-sales/previousFollowups', 'MasterSalesController@previousFollowups'); // get getPreviousFollowups
    /****************************FOLLOWUPS****************************/
    
    /*********************TEAM ENQUIRIES & FOLLOWUPS*********************/
    Route::post('/master-sales/getTeamTotalEnquiries', 'MasterSalesController@getTeamTotalEnquiries'); // get team total enquiries 
    Route::post('/master-sales/getTeamLostEnquiries', 'MasterSalesController@getTeamLostEnquiries'); // get team lost enquiries
    Route::post('/master-sales/getTeamClosedEnquiries', 'MasterSalesController@getTeamClosedEnquiries'); // get team closed enquiries
    
    Route::post('/master-sales/getTeamTodayFollowups', 'MasterSalesController@getTeamTodayFollowups'); // get team todays followups
    Route::post('/master-sales/getTeamPendingFollowups', 'MasterSalesController@getTeamPendingFollowups'); // get team pending followups
    Route::post('/master-sales/getTeamPreviousFollowups', 'MasterSalesController@getTeamPreviousFollowups'); // get team previous followups
    /*********************TEAM ENQUIRIES & FOLLOWUPS*********************/
    
    /*********************IMPORT ENQUIRIES*********************/

    Route::post('/master-sales/importEnquiry', 'MasterSalesController@importEnquiry');
    Route::post('/master-sales/getImportHistory', 'MasterSalesController@getImportHistory');
    /*********************IMPORT ENQUIRIES*********************/
});


