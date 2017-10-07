<?php

Route::group(array('module' => 'MasterSales', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\MasterSales\Controllers'), function() {

    Route::get('/dirPagination', function () {
        return View::make('backend.dirPagination');
    });
    Route::get('/MasterSales/createEnquiry', function () {
        return View::make('MasterSales::createEnquiry');
    })->middleware("permission:040102|040103|040104|040105|040106|040107|040108|040109|040101004|040101005|040101006|040101001|040101002|040101003");

    Route::get('/MasterSales/createCustomer', function () {
        return View::make('MasterSales::createCustomer');
    })->middleware("permission:040102|040103|040104|040105|040106|040107|040108|040109|040101004|040101005|040101006|040101001|040101002|040101003");

    Route::get('/MasterSales/enquiryHistory', function () {
        return View::make('MasterSales::enquiryHistory');
    });
    Route::get('/MasterSales/bulkreassign', function () {
        return View::make('MasterSales::bulkreassign');
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
    Route::get('/MasterSales/sendDocument', function () {
        return View::make('MasterSales::sendDocument');
    });
    Route::get('/master-sales/createQuickEnquiry', 'MasterSalesController@createQuickEnquiry')->middleware("permission:040101");

    Route::get('/master-sales/import', ['middleware' => 'permission:040502', function () {
            return View::make('MasterSales::import');
        }]);

    /*     * ********************************************************* */
    Route::get('/master-sales/updateCustomer/{id}', 'MasterSalesController@updateCustomer'); //update customer data
    Route::get('/master-sales/getEmployees', 'MasterSalesController@getEmployees');  // get all employees    
    Route::get('/master-sales/getEnquiryCity', 'MasterSalesController@getEnquiryCity'); // get enquiry city from table 
    Route::post('/master-sales/getAllLocations', 'MasterSalesController@getAllLocations'); //get all locations of perticular city id
    Route::get('/master-sales/getFinanceEmployees', 'MasterSalesController@getFinanceEmployees'); // get employees whose deparment is finance
    Route::get('/master-sales/showEnquiry/{id}', 'MasterSalesController@showEnquiry'); //show enquiry page
    Route::post('/master-sales/saveEnquiry', 'MasterSalesController@saveEnquiry'); //save enquiry data

    Route::get('/master-sales/editCustomer/cid/{cid}', 'MasterSalesController@editCustomer')->middleware("permission:040102|040103|040104|040105|040106|040107|040108|040109|040101004|040101005|040101006|040101001|040101002|040101003"); //updateCustomer
    Route::get('/master-sales/editEnquiry/cid/{cid}/eid/{eid}', 'MasterSalesController@editEnquiry'); //update enquiry data
    Route::put('/master-sales/updateEnquiry/{id}', 'MasterSalesController@updateEnquiry'); //update enquiry data

    Route::get('/master-sales/create', 'MasterSalesController@create')->middleware("permission:040102");
    Route::get('/master-sales/', 'MasterSalesController@index')->middleware("permission:040102");
    Route::put('/master-sales/update/{id}', 'MasterSalesController@update');
    Route::post('/master-sales', 'MasterSalesController@store');

    Route::post('/master-sales/getCustomerDetails', 'MasterSalesController@getCustomerDetails'); //get customer details
    Route::post('/master-sales/getEnquiryDetails', 'MasterSalesController@getEnquiryDetails'); //get enquiry details
    Route::post('/master-sales/getCustomerDataWithId', 'MasterSalesController@getCustomerDataWithId'); // get Customer Data With Id
    Route::post('/master-sales/checkMobileExist', 'MasterSalesController@checkMobileExist');
    Route::post('/master-sales/checkEmailExist', 'MasterSalesController@checkEmailExist');
    Route::post('/master-sales/delEnquiryDetailRow', 'MasterSalesController@delEnquiryDetailRow');
    Route::post('/master-sales/addEnquiryDetailRow', 'MasterSalesController@addEnquiryDetailRow');
    Route::post('/master-sales/getEnquiryHistory', 'MasterSalesController@getEnquiryHistory');
    Route::post('/master-sales/getTodayRemark', 'MasterSalesController@getTodayRemark');
    Route::post('/master-sales/insertTodayRemark', 'MasterSalesController@insertTodayRemark');
    Route::post('/master-sales/BulkReasignEmployee', 'MasterSalesController@BulkReasignEmployee'); // uma
    Route::post('/master-sales/exportToExcel', 'MasterSalesController@exportToExcel'); //export data in excel sheet    
    Route::post('/master-sales/filteredData', 'MasterSalesController@filteredData'); //filtered data
    Route::post('/master-sales/sendDocuments', 'MasterSalesController@sendDocuments'); // get customer data send document
    Route::post('/master-sales/getDocumentsList', 'MasterSalesController@getDocumentsList'); // get documents  //uma 
    Route::post('/master-sales/insertSendDocument', 'MasterSalesController@insertSendDocument'); // get documents  //uma 
    Route::post('/master-sales/sendDocList', 'MasterSalesController@sendDocList'); // get documents  //uma 


    /*     * **************************ENQUIRIES*************************** */

    Route::get('/master-sales/totalEnquiry/{type}', 'MasterSalesController@totalEnquiry')->middleware("permission:040106"); // get total enq with type
    Route::get('/master-sales/teamTotalEnquiry/{type}', 'MasterSalesController@teamTotalEnquiry')->middleware("permission:040101004"); // get total enq with type
    Route::post('/master-sales/getTotalEnquiries', 'MasterSalesController@getTotalEnquiries')->middleware("permission:040106|040101004"); // total enquiries listing
    Route::get('/master-sales/reassignEnquiry/{type}', 'MasterSalesController@reassignEnquiry')->middleware("permission:040109"); //  reassign enquiries
    Route::post('/master-sales/getReassignEnquiry', 'MasterSalesController@getReassignEnquiry')->middleware("permission:040109"); // listing for reassign enquiries
    Route::get('/master-sales/lostEnquiries/{type}', 'MasterSalesController@lostEnquiries')->middleware("permission:040107"); // get all lost enquiries
    Route::get('/master-sales/teamLostEnquiries/{type}', 'MasterSalesController@lostEnquiries')->middleware("permission:040101005"); // get all lost enquiries
    Route::post('/master-sales/getLostEnquiries', 'MasterSalesController@getLostEnquiries')->middleware("permission:040107|040101005"); // get lost enquiries listing
    Route::get('/master-sales/bookedEnquiries/{type}', 'MasterSalesController@bookedEnquiries')->middleware("permission:040108|040101006"); // get all booked enquiries 
    Route::get('/master-sales/teamBookedEnquiries/{type}', 'MasterSalesController@bookedEnquiries')->middleware("permission:040108|040101006"); // get all booked enquiries 
    Route::post('/master-sales/getBookedEnquiries', 'MasterSalesController@getBookedEnquiries')->middleware("permission:040108|040101006"); // get Booked  Enquiries
    /*     * **************************ENQUIRIES*************************** */

    /*     * **************************FOLLOWUPS*************************** */
    Route::get('/master-sales/showTodaysFollowups/{type}', 'MasterSalesController@showTodaysFollowups')->middleware("permission:040103"); // today followups with type
    Route::get('/master-sales/showTeamTodaysFollowups/{type}', 'MasterSalesController@showTodaysFollowups')->middleware("permission:040101001"); // team today followups with type
    Route::get('/master-sales/showPendingFollowups/{type}', 'MasterSalesController@showPendingFollowups')->middleware("permission:040104"); // pending followups with type
    Route::get('/master-sales/showTeamPendingFollowups/{type}', 'MasterSalesController@showPendingFollowups')->middleware("permission:040101002"); // team pending followups with type
    Route::get('/master-sales/showPreviousFollowups/{type}', 'MasterSalesController@showPreviousFollowups')->middleware("permission:040105"); // previous followups with type
    Route::get('/master-sales/showTeamPreviousFollowups/{type}', 'MasterSalesController@showPreviousFollowups')->middleware("permission:040101003"); // team previous followups with type
    Route::post('/master-sales/getTodaysFollowups', 'MasterSalesController@getTodaysFollowups')->middleware("permission:040103|040101001"); // get TodaysFollowups    
    Route::post('/master-sales/getPendingFollowups', 'MasterSalesController@getPendingFollowups')->middleware("permission:040104|040101002"); // get getPendingFollowups
    Route::post('/master-sales/previousFollowups', 'MasterSalesController@previousFollowups')->middleware("permission:040105|040101003"); // get getPreviousFollowups
    /*     * **************************FOLLOWUPS*************************** */

    /*     * *******************IMPORT ENQUIRIES******************** */
    Route::post('/master-sales/importEnquiry', 'MasterSalesController@importEnquiry')->middleware("permission:040502");
    Route::post('/master-sales/getImportHistory', 'MasterSalesController@getImportHistory')->middleware("permission:040502");
    /*     * *******************IMPORT ENQUIRIES******************** */

    /*     * *******************TODAY REMARK******************** */
    Route::post('/master-sales/addInfo', 'MasterSalesController@addInfo');
    Route::post('/master-sales/getCollectionDetails', 'MasterSalesController@getCollectionDetails');
    Route::post('/master-sales/manageCollection', 'MasterSalesController@manageCollection');
    Route::post('/master-sales/getrCollectionReceipt', 'MasterSalesController@getrCollectionReceipt');
    Route::post('/master-sales/insertCollection', 'MasterSalesController@insertCollection');
    Route::post('/master-sales/insertReceipt', 'MasterSalesController@insertReceipt');

    
     Route::post('/master-sales/sharedEnquiriesEmployee', 'MasterSalesController@sharedEnquiriesEmployee');
     
      Route::get('/master-sales/getEmployeeData', 'MasterSalesController@getEmployeeData');
     Route::post('/master-sales/preSalesShareEnquiry', 'MasterSalesController@preSalesShareEnquiry');

});


