<?php

Route::group(array('module' => 'Reports', 'namespace' => 'App\Modules\Reports\Controllers'), function() {
    $getUrl = config('global.getUrl');
    //Pre sales my report
    Route::get($getUrl.'/reports/getEnquiryReport', 'ReportsController@getEnquiryReport');
    Route::post($getUrl.'/reports/getCategoryReport', 'ReportsController@getCategoryReport');
    Route::post($getUrl.'/reports/getStatusReport', 'ReportsController@getStatusReport');
    Route::post($getUrl.'/reports/getSourceReport', 'ReportsController@getSourceReport');
    
     //Pre sales follow up report
    Route::get($getUrl.'/report/followupReport', 'ReportsController@followupReport'); //show followup report page
    Route::post($getUrl.'/reports/followupReports', 'ReportsController@followupReports'); //show followup report details
    
    //project wise report
    Route::get($getUrl.'/reports/projectwiseReport', 'ReportsController@projectwiseReport');   
    
    Route::post($getUrl.'/reports/getProjectWiseCategoryReport', 'ReportsController@getProjectWiseCategoryReport');   
    Route::post($getUrl.'/reports/getProjectWiseStatusReport', 'ReportsController@getProjectWiseStatusReport');   
    Route::post($getUrl.'/reports/getProjectWiseSourceReport', 'ReportsController@getProjectWiseSourceReport');   

    
    //Team
    Route::get($getUrl.'/reports/getTeamEnquiryreports', 'ReportsController@getTeamEnquiryreports');
    Route::post($getUrl.'/reports/getTeamcategoryreports', 'ReportsController@getTeamcategoryreports');
    Route::post($getUrl.'/reports/getTeamstatusreports', 'ReportsController@getTeamstatusreports');
    Route::post($getUrl.'/reports/getTeamsourcereports', 'ReportsController@getTeamsourcereports');
    
    Route::get($getUrl.'/reports/teamFollowupreports', 'ReportsController@teamFollowupreports');   
     
    Route::post($getUrl.'/reports/getTeamfollowupreports', 'ReportsController@getTeamfollowupreports');   
    
    
    
    
    
});	


