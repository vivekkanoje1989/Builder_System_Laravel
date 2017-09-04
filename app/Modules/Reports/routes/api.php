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
     
     
     
    Route::post('api/reports/getProjectWiseCategoryReport', 'ReportsController@getProjectWiseCategoryReport');
    Route::post('api/reports/getProjectWiseSourceReport', 'ReportsController@getProjectWiseSourceReport');
    Route::post('api/reports/getProjectWiseStatusReport', 'ReportsController@getProjectWiseStatusReport');
     
     
     
     
    Route::post('api/reports/TeamProjectCategotyReport', 'ReportsController@TeamProjectCategotyReport');
    Route::post('api/reports/TeamProjectStatusReport', 'ReportsController@TeamProjectStatusReport');
    Route::post('api/reports/TeamProjectSourceReport', 'ReportsController@TeamProjectSourceReport');
    
    
    Route::post('api/reports/teamProjectCategoryReport', 'ReportsController@teamProjectCategoryReport');
    Route::post('api/reports/teamProjectSourceEmpReport', 'ReportsController@teamProjectSourceEmpReport');
    Route::post('api/reports/teamProjectStatusEmpReport', 'ReportsController@teamProjectStatusEmpReport');
     
    
    
     
     
     
});	