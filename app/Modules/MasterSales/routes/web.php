<?php

Route::group(array('module' => 'MasterSales', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\MasterSales\Controllers'), function() {
    $getUrl = config('global.getUrl');
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
    /****************************ENQUIRIES****************************/
    Route::get('/master-sales/totalEnquiries', function () {
        return view('MasterSales::totalEnquiries');
    });
    Route::get('/master-sales/lostEnquiries', function () {
        return view('MasterSales::lostEnquiries');
    });
    Route::get('/master-sales/closeEnquiries', function () {
        return view('MasterSales::closeEnquiries');
    });
    /****************************ENQUIRIES****************************/
    
    /****************************FOLLOWUPS****************************/
    Route::get('/master-sales/showTodaysFollowups', function () {
        return view('MasterSales::todaysFollowups');
    });
    Route::get('/master-sales/showPendingFollowups', function () {
        return view('MasterSales::pendingFollowup');
    });
    Route::get('/master-sales/showPreviousFollowups', function () {
        return view('MasterSales::previousFollowup');
    });
    /****************************FOLLOWUPS****************************/
    
    /*********************TEAM ENQUIRIES & FOLLOWUPS*********************/
    Route::get('/master-sales/teamTotalEnquiries', function () {
        return view('MasterSales::teamTotalEnquiries');
    });
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
    Route::post('/master-sales/getTotalEnquiries', 'MasterSalesController@getTotalEnquiries'); // total enquiries listing
    Route::post('/master-sales/getLostEnquiries', 'MasterSalesController@getLostEnquiries'); // get all lost enquiries
    Route::post('/master-sales/getClosedEnquiries', 'MasterSalesController@getClosedEnquiries'); // getCloseEnquiries
    /****************************ENQUIRIES****************************/
    
    /****************************FOLLOWUPS****************************/
    Route::post('/master-sales/getTodaysFollowups', 'MasterSalesController@getTodaysFollowups'); // get TodaysFollowups
    Route::post('/master-sales/getPendingFollowups', 'MasterSalesController@getPendingFollowups'); // get getPendingFollowups
    Route::post('/master-sales/getPreviousFollowups', 'MasterSalesController@getPreviousFollowups'); // get getPreviousFollowups
    /****************************FOLLOWUPS****************************/
    
    /*********************TEAM ENQUIRIES & FOLLOWUPS*********************/
    Route::post('/master-sales/getTeamTotalEnquiries', 'MasterSalesController@getTeamTotalEnquiries'); // get team total enquiries 
    Route::post('/master-sales/getTeamLostEnquiries', 'MasterSalesController@getTeamLostEnquiries'); // get team lost enquiries
    Route::post('/master-sales/getTeamClosedEnquiries', 'MasterSalesController@getTeamClosedEnquiries'); // get team closed enquiries
    
    Route::post('/master-sales/getTeamTodayFollowups', 'MasterSalesController@getTeamTodayFollowups'); // get team todays followups
    Route::post('/master-sales/getTeamPendingFollowups', 'MasterSalesController@getTeamPendingFollowups'); // get team pending followups
    Route::post('/master-sales/getTeamPreviousFollowups', 'MasterSalesController@getTeamPreviousFollowups'); // get team previous followups
    /*********************TEAM ENQUIRIES & FOLLOWUPS*********************/
});


