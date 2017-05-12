<?php

Route::group(array('module' => 'MasterSales', 'middleware' => ['api'], 'namespace' => 'App\Modules\MasterSales\Controllers'), function() {
    Route::get('api/master-sales/getAllEnquiries', 'MasterSalesController@getAllEnquiries'); // get all getAllEnquiries
    Route::get('api/master-sales/getCloseEnquiries', 'MasterSalesController@getCloseEnquiries'); // get all getCloseEnquiries
    Route::post('api/master-sales/getCustomerDetails', 'MasterSalesController@getCustomerDetails');
    Route::post('api/master-sales', 'MasterSalesController@store');
    Route::put('api/master-sales/{id}', 'MasterSalesController@update');
    Route::post('api/master-sales/checkMobileExist', 'MasterSalesController@checkMobileExist');
    Route::post('api/master-sales/saveEnquiryData', 'MasterSalesController@saveEnquiryData');
    
    /****************************ENQUIRIES****************************/
    Route::post('api/master-sales/getTotalEnquiries', 'MasterSalesController@getTotalEnquiries'); // total enquiries listing
    Route::post('api/master-sales/getLostEnquiries', 'MasterSalesController@getLostEnquiries'); // get all lost enquiries
    Route::post('api/master-sales/getClosedEnquiries', 'MasterSalesController@getClosedEnquiries'); // getCloseEnquiries
    /****************************ENQUIRIES****************************/
    
    /****************************FOLLOWUPS****************************/
    Route::post('api/master-sales/getTodaysFollowups', 'MasterSalesController@getTodaysFollowups'); // get TodaysFollowups
    Route::post('api/master-sales/getPendingFollowups', 'MasterSalesController@getPendingFollowups'); // get getPendingFollowups
    Route::post('api/master-sales/getPreviousFollowups', 'MasterSalesController@getPreviousFollowups'); // get getPreviousFollowups
    /****************************FOLLOWUPS****************************/
    
    /*********************TEAM ENQUIRIES & FOLLOWUPS*********************/
    Route::post('api/master-sales/getTeamTotalEnquiries', 'MasterSalesController@getTeamTotalEnquiries'); // get team total enquiries 
    Route::post('api/master-sales/getTeamLostEnquiries', 'MasterSalesController@getTeamLostEnquiries'); // get team lost enquiries
    Route::post('api/master-sales/getTeamClosedEnquiries', 'MasterSalesController@getTeamClosedEnquiries'); // get team closed enquiries
    /*********************TEAM ENQUIRIES & FOLLOWUPS*********************/
    
    /*********************TEAM ENQUIRIES & FOLLOWUPS*********************/
    Route::post('api/master-sales/getTeamTotalEnquiries', 'MasterSalesController@getTeamTotalEnquiries'); // get team total enquiries 
    Route::post('api/master-sales/getTeamLostEnquiries', 'MasterSalesController@getTeamLostEnquiries'); // get team lost enquiries
    Route::post('api/master-sales/getTeamClosedEnquiries', 'MasterSalesController@getTeamClosedEnquiries'); // get team closed enquiries
    
    Route::post('api/master-sales/getTeamTodayFollowups', 'MasterSalesController@getTeamTodayFollowups'); // get team todays followups
    Route::post('api/master-sales/getTeamPendingFollowups', 'MasterSalesController@getTeamPendingFollowups'); // get team pending followups
    Route::post('api/master-sales/getTeamPreviousFollowups', 'MasterSalesController@getTeamPreviousFollowups'); // get team previous followups
    /*********************TEAM ENQUIRIES & FOLLOWUPS*********************/
});	