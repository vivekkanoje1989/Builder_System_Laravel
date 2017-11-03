<?php

Route::group(array('module' => 'Reports', 'middleware' => ['api'], 'namespace' => 'App\Modules\Reports\Controllers'), function() {

    //Pre Sales My Report
    Route::post('api/reports/getCategoryReport', 'ReportsController@getCategoryReport');
    Route::post('api/reports/getStatusReport', 'ReportsController@getStatusReport');
    Route::post('api/reports/getSourceReport', 'ReportsController@getSourceReport');
    //Pre Sales Followup Report
    Route::post('api/reports/followupReports', 'ReportsController@followupReports');

    Route::post('api/reports/getTeamcategoryreports', 'ReportsController@getTeamcategoryreports');
    Route::post('api/reports/getTeamstatusreports', 'ReportsController@getTeamstatusreports');
    Route::post('api/reports/getTeamsourcereports', 'ReportsController@getTeamsourcereports');

    Route::post('api/reports/getTeamfollowupreports', 'ReportsController@getTeamfollowupreports');
    Route::post('api/reports/getEmpFollowUpReports', 'ReportsController@getEmpFollowUpReports');

    Route::post('api/reports/getProjectWiseCategoryReport', 'ReportsController@getProjectWiseCategoryReport');
    Route::post('api/reports/getProjectWiseSourceReport', 'ReportsController@getProjectWiseSourceReport');
    Route::post('api/reports/getProjectWiseStatusReport', 'ReportsController@getProjectWiseStatusReport');

    Route::post('api/reports/TeamProjectCategotyReport', 'ReportsController@TeamProjectCategotyReport');
    Route::post('api/reports/TeamProjectStatusReport', 'ReportsController@TeamProjectStatusReport');
    Route::post('api/reports/teamProjectSourceReport', 'ReportsController@teamProjectSourceReport');

    Route::post('api/reports/teamProjectCategoryReport', 'ReportsController@teamProjectCategoryReport');
    Route::post('api/reports/teamProjectSourceEmpReport', 'ReportsController@teamProjectSourceEmpReport');
    Route::post('api/reports/teamProjectStatusEmpReport', 'ReportsController@teamProjectStatusEmpReport');

    Route::post('api/reports/getEmpcategoryreports', 'ReportsController@getEmpcategoryreports');


    Route::post('api/reports/getsourcereports', 'ReportsController@getsourcereports');
    Route::post('api/reports/getSourceWiseReport', 'ReportsController@getSourceWiseReport');
    Route::post('api/reports/getEmpStatusreports', 'ReportsController@getEmpStatusreports');

    Route::post('api/reports/TeamLeadProjectCategoryReport', 'ReportsController@TeamLeadProjectCategoryReport');
    Route::post('api/reports/TeamLeadProjectStatusReport', 'ReportsController@TeamLeadProjectStatusReport');
    Route::post('api/reports/TeamLeadProjectSourceReport', 'ReportsController@TeamLeadProjectSourceReport');

    Route::post('api/reports/teamProjectSourceReport', 'ReportsController@teamProjectSourceReport');
    Route::post('api/reports/subCategoryReport', 'ReportsController@subCategoryReport');
    Route::post('api/reports/subSourceReport', 'ReportsController@subSourceReport');
    Route::post('api/reports/projectSubSourceReport', 'ReportsController@projectSubSourceReport');
    Route::post('api/reports/subProjectCategoryReport', 'ReportsController@subProjectCategoryReport');
    Route::post('api/reports/subProjectStatusReport', 'ReportsController@subProjectStatusReport');
    Route::post('api/reports/subStatusReport', 'ReportsController@subStatusReport');
});
