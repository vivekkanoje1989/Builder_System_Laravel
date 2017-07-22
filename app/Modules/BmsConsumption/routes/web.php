<?php

Route::group(array('module' => 'BmsConsumption', 'middleware' => ['web'], 'namespace' => 'App\Modules\BmsConsumption\Controllers'), function() {

    $getUrl = config('global.getUrl');
   
    
//    Route::resource('bmsConsumption', 'BmsConsumptionController');
    Route::get('/bmsConsumption/smsConsumption', 'BmsConsumptionController@smsConsumption');
    Route::get('/bmsConsumption/smsReport', 'BmsConsumptionController@smsReport');
    Route::get('/bmsConsumption/smsLogs', 'BmsConsumptionController@smsLogs');
    Route::post('/bmsConsumption/allSmsLogs', 'BmsConsumptionController@allSmsLogs');
    Route::get('/bmsConsumption/smsLogDetails/{id}', 'BmsConsumptionController@smsLogDetails');
    
    
//     Route::get('/BmsConsumption/smsLogDetails', function () {
//        return View::make('BmsConsumption::smsLogDetails');
//    });
});	
