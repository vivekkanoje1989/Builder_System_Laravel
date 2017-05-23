<?php

Route::group(array('module' => 'MasterSales', 'middleware' => ['web'], 'namespace' => 'App\Modules\MasterSales\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::get($getUrl . '/MasterSales/createEnquiry', function () {
        return View::make('MasterSales::createEnquiry');
    });
    Route::get($getUrl . '/MasterSales/createCustomer', function () {
        return View::make('MasterSales::createCustomer');
    });
    Route::get($getUrl . '/MasterSales/enquiryHistory', function () {
        return View::make('MasterSales::enquiryHistory');
    });
    Route::get($getUrl . '/MasterSales/enquiryListing', function () {
        return View::make('MasterSales::enquiryListing');
    });
    Route::get($getUrl . '/MasterSales/enquiryHistory', function () {
        return View::make('MasterSales::enquiryHistory');
    });
    Route::get($getUrl . '/MasterSales/todaysRemark', function () {
        return View::make('MasterSales::todaysRemark');
    });
    /****************************ENQUIRIES****************************/
    Route::get($getUrl . '/master-sales/totalEnquiries', function () {
        return view('MasterSales::totalEnquiries');
    });
    Route::get($getUrl . '/master-sales/lostEnquiries', function () {
        return view('MasterSales::lostEnquiries');
    });
    Route::get($getUrl . '/master-sales/closeEnquiries', function () {
        return view('MasterSales::closeEnquiries');
    });
    /****************************ENQUIRIES****************************/
    
    /****************************FOLLOWUPS****************************/
    Route::get($getUrl . '/master-sales/showTodaysFollowups', function () {
        return view('MasterSales::todaysFollowups');
    });
    Route::get($getUrl . '/master-sales/showPendingFollowups', function () {
        return view('MasterSales::pendingFollowup');
    });
    Route::get($getUrl . '/master-sales/showPreviousFollowups', function () {
        return view('MasterSales::previousFollowup');
    });
    /****************************FOLLOWUPS****************************/
    
    /*********************TEAM ENQUIRIES & FOLLOWUPS*********************/
    Route::get($getUrl . '/master-sales/teamTotalEnquiries', function () {
        return view('MasterSales::teamTotalEnquiries');
    });
    Route::get($getUrl . '/master-sales/teamLostEnquiries', function () {
        return view('MasterSales::teamLostEnquiries');
    });
    Route::get($getUrl . '/master-sales/teamClosedEnquiries', function () {
        return view('MasterSales::teamClosedEnquiries');
    });
    Route::get($getUrl . '/master-sales/teamTodayFollowups', function () {
        return view('MasterSales::teamTodayFollowups');
    });
    Route::get($getUrl . '/master-sales/teamPendingFollowups', function () {
        return view('MasterSales::teamPendingFollowups');
    });
    Route::get($getUrl . '/master-sales/teamPreviousFollowups', function () {
        return view('MasterSales::teamPreviousFollowups');
    });    
    /*********************TEAM ENQUIRIES & FOLLOWUPS*********************/
    
    
    Route::get($getUrl . '/master-sales/updateCustomer/{id}', 'MasterSalesController@updateCustomer');
    Route::get($getUrl . '/master-sales/getEmployees', 'MasterSalesController@getEmployees');  // get all employees    
    Route::get($getUrl . '/master-sales/getEnquiryCity', 'MasterSalesController@getEnquiryCity'); // get enquiry city from table 
    Route::post($getUrl . '/master-sales/getAllLocations', 'MasterSalesController@getAllLocations'); //get all locations of perticular city id
    Route::get($getUrl . '/master-sales/getFinanceEmployees', 'MasterSalesController@getFinanceEmployees'); // get employees whose deparment is finance
    Route::get($getUrl . '/master-sales/showEnquiry/{id}', 'MasterSalesController@showEnquiry'); //show enquiry page
    Route::post($getUrl . '/master-sales/saveEnquiry', 'MasterSalesController@saveEnquiry'); //saveEnquiry
    
    Route::get($getUrl . '/master-sales/editCustomer/cid/{cid}', 'MasterSalesController@editCustomer'); //updateCustomer
    Route::get($getUrl . '/master-sales/editEnquiry/cid/{cid}/eid/{eid}', 'MasterSalesController@editEnquiry'); //updateEnquiry
    Route::put($getUrl . '/master-sales/updateEnquiry/{id}', 'MasterSalesController@updateEnquiry'); //updateEnquiry
    Route::resource($getUrl . '/master-sales', 'MasterSalesController');
    Route::post($getUrl . '/master-sales/getCustomerDetails', 'MasterSalesController@getCustomerDetails'); //get customer details
    Route::post($getUrl . '/master-sales/getEnquiryDetails', 'MasterSalesController@getEnquiryDetails'); //get enquiry details
    Route::post($getUrl . '/master-sales/getCustomerDataWithId', 'MasterSalesController@getCustomerDataWithId'); // getCustomerDataWithId
    Route::post($getUrl . '/master-sales/checkMobileExist', 'MasterSalesController@checkMobileExist');
    Route::post($getUrl . '/master-sales/delEnquiryDetailRow', 'MasterSalesController@delEnquiryDetailRow');
    Route::post($getUrl . '/master-sales/addEnquiryDetailRow', 'MasterSalesController@addEnquiryDetailRow');
    Route::post($getUrl . '/master-sales/getEnquiryHistory', 'MasterSalesController@getEnquiryHistory');
    Route::post($getUrl . '/master-sales/getEnquiryHistory', 'MasterSalesController@getEnquiryHistory');
    
    /****************************ENQUIRIES****************************/
    Route::post($getUrl . '/master-sales/getTotalEnquiries', 'MasterSalesController@getTotalEnquiries'); // total enquiries listing
    Route::post($getUrl . '/master-sales/getLostEnquiries', 'MasterSalesController@getLostEnquiries'); // get all lost enquiries
    Route::post($getUrl . '/master-sales/getClosedEnquiries', 'MasterSalesController@getClosedEnquiries'); // getCloseEnquiries
    /****************************ENQUIRIES****************************/
    
    /****************************FOLLOWUPS****************************/
    Route::post($getUrl . '/master-sales/getTodaysFollowups', 'MasterSalesController@getTodaysFollowups'); // get TodaysFollowups
    Route::post($getUrl . '/master-sales/getPendingFollowups', 'MasterSalesController@getPendingFollowups'); // get getPendingFollowups
    Route::post($getUrl . '/master-sales/getPreviousFollowups', 'MasterSalesController@getPreviousFollowups'); // get getPreviousFollowups
    /****************************FOLLOWUPS****************************/
    
    /*********************TEAM ENQUIRIES & FOLLOWUPS*********************/
    Route::post($getUrl . '/master-sales/getTeamTotalEnquiries', 'MasterSalesController@getTeamTotalEnquiries'); // get team total enquiries 
    Route::post($getUrl . '/master-sales/getTeamLostEnquiries', 'MasterSalesController@getTeamLostEnquiries'); // get team lost enquiries
    Route::post($getUrl . '/master-sales/getTeamClosedEnquiries', 'MasterSalesController@getTeamClosedEnquiries'); // get team closed enquiries
    
    Route::post($getUrl . '/master-sales/getTeamTodayFollowups', 'MasterSalesController@getTeamTodayFollowups'); // get team todays followups
    Route::post($getUrl . '/master-sales/getTeamPendingFollowups', 'MasterSalesController@getTeamPendingFollowups'); // get team pending followups
    Route::post($getUrl . '/master-sales/getTeamPreviousFollowups', 'MasterSalesController@getTeamPreviousFollowups'); // get team previous followups
    /*********************TEAM ENQUIRIES & FOLLOWUPS*********************/
});


