<?php

Route::group(array('module' => 'BmsConsumption', 'middleware' => ['web'], 'namespace' => 'App\Modules\BmsConsumption\Controllers'), function() {

    $getUrl = config('global.getUrl');
   
    
//    Route::resource('bmsConsumption', 'BmsConsumptionController');
    Route::get('/bmsConsumption/smsConsumption', 'BmsConsumptionController@smsConsumption');
    Route::get('/bmsConsumption/smsReport', 'BmsConsumptionController@smsReport');
    Route::get('/bmsConsumption/smsLogs', 'BmsConsumptionController@smsLogs');
    Route::post('/bmsConsumption/allSmsLogs', 'BmsConsumptionController@allSmsLogs');
    Route::post('/bmsConsumption/allSmsReports', 'BmsConsumptionController@allSmsReports');
    Route::get('/bmsConsumption/smsLogDetails/{id}', 'BmsConsumptionController@smsLogDetails');
    Route::post('/bmsConsumption/smsLogData', 'BmsConsumptionController@smsLogData');
    Route::post('/bmsConsumption/filteredData', 'BmsConsumptionController@filteredData');
    Route::post('/bmsConsumption/filterReportData', 'BmsConsumptionController@filterReportData');
    
    
     Route::get('/BmsConsumption/showSmsLogFilter', function () {
        return View::make('BmsConsumption::showSmsLogFilter');
    });
     Route::get('/BmsConsumption/showSmsReportLogFilter', function () {
        return View::make('BmsConsumption::showSmsReportLogFilter');
    });
});	
