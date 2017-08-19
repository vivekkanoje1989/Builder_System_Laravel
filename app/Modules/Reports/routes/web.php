<?php

Route::group(array('module' => 'Reports', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\Reports\Controllers'), function() {
    $getUrl = config('global.getUrl');
    //Pre sales my report
    Route::get('/reports/getEnquiryReport', 'ReportsController@getEnquiryReport');
    Route::post('/reports/getCategoryReport', 'ReportsController@getCategoryReport');
    Route::post('/reports/getStatusReport', 'ReportsController@getStatusReport');
    Route::post('/reports/getSourceReport', 'ReportsController@getSourceReport');

    //Pre sales follow up report
    Route::get('/reports/followupReport', 'ReportsController@followupReport'); //show followup report page
    Route::post('/reports/followupReports', 'ReportsController@followupReports'); //show followup report details
    //project wise report
    Route::get('/reports/projectwiseReport', 'ReportsController@projectwiseReport');
    Route::post('/reports/getProjectWiseCategoryReport', 'ReportsController@getProjectWiseCategoryReport');
    Route::post('/reports/getProjectWiseStatusReport', 'ReportsController@getProjectWiseStatusReport');
    Route::post('/reports/getProjectWiseSourceReport', 'ReportsController@getProjectWiseSourceReport');

    //Team
    Route::get('/reports/getTeamEnquiryreports', 'ReportsController@getTeamEnquiryreports');
    Route::post('/reports/getTeamcategoryreports', 'ReportsController@getTeamcategoryreports');
    Route::post('/reports/getTeamstatusreports', 'ReportsController@getTeamstatusreports');
    Route::post('/reports/getTeamsourcereports', 'ReportsController@getTeamsourcereports');
    Route::post('/reports/subCategoryReport', 'ReportsController@subCategoryReport');
    Route::post('/reports/subProjectCategoryReport', 'ReportsController@subProjectCategoryReport');
    Route::post('/reports/subProjectStatusReport', 'ReportsController@subProjectStatusReport');
    Route::post('/reports/getEmpcategoryreports', 'ReportsController@getEmpcategoryreports');
    Route::post('/reports/getTeamsourcereports', 'ReportsController@getTeamsourcereports');
    Route::post('/reports/getTeamsourcereports', 'ReportsController@getTeamsourcereports');
    Route::post('/reports/getsourcereports', 'ReportsController@getsourcereports');
    Route::post('/reports/getSourceWiseReport', 'ReportsController@getSourceWiseReport');
    Route::post('/reports/getSourceWiseGroupReport', 'ReportsController@getSourceWiseGroupReport');
    Route::post('/reports/subSourceReport', 'ReportsController@subSourceReport');
    Route::post('/reports/getEmpStatusreports', 'ReportsController@getEmpStatusreports');
    Route::post('/reports/subStatusReport', 'ReportsController@subStatusReport');
    Route::post('/reports/getEmpFollowUpReports', 'ReportsController@getEmpFollowUpReports');
    Route::post('/reports/projectSourceReport', 'ReportsController@projectSourceReport');
    Route::post('/reports/projectSubSourceReport', 'ReportsController@projectSubSourceReport');

    Route::get('/reports/teamFollowupreports', 'ReportsController@teamFollowupreports');
    Route::post('/reports/getTeamfollowupreports', 'ReportsController@getTeamfollowupreports');
    Route::get('/reports/projectwiseTeamreport', 'ReportsController@projectwiseTeamreport');
    Route::post('/reports/TeamProjectCategotyReport', 'ReportsController@TeamProjectCategotyReport');
    Route::post('/reports/TeamLeadProjectCategotyReport', 'ReportsController@TeamLeadProjectCategotyReport');
    Route::post('/reports/TeamProjectStatusReport', 'ReportsController@TeamProjectStatusReport');
    Route::post('/reports/TeamProjectSourceReport', 'ReportsController@TeamProjectSourceReport');
    Route::post('/reports/getTeamSourcereports', 'ReportsController@getTeamSourcereports');
    Route::post('/reports/teamProjectCategoryReport', 'ReportsController@teamProjectCategoryReport');
    Route::post('/reports/teamProjectStatusEmpReport', 'ReportsController@teamProjectStatusEmpReport');
    Route::get('/reports/teamfollowupReport', 'ReportsController@teamfollowupReport');
    Route::post('/reports/teamProjectSourceEmpReport', 'ReportsController@teamProjectSourceEmpReport');
    Route::get('/reports/projectOverviewReport', 'ReportsController@projectOverviewReport');
    Route::get('/reports/overViewReport', 'ReportsController@overViewReport');
});


