<?php

Route::group(array('module' => 'Marketing', ['middleware' => 'auth:admin'], 'namespace' => 'App\Modules\Marketing\Controllers'), function() {
    $getUrl = config('global.getUrl');
     
    Route::get('/Marketing/showFilter', function () {
        return View::make('Marketing::showFilter');
    });
    
    /* Detail log filter*/
     Route::get('/Marketing/showDetailFilter', function () {
        return View::make('Marketing::showDetailFilter');
    });
    
     /* Detail send sms to customer filter*/
     Route::get('/Marketing/enqshowFilter', function () {
        return View::make('Marketing::enqshowFilter');
    });
       
    Route::get('/promotionalsms/smslogs', 'PromotionalSMSController@smslogs');
    Route::get('/promotionalsms/teamsmslogs', 'PromotionalSMSController@teamsmslogs');
    
    Route::get('/promotionalsms/smslogconsumption', 'PromotionalSMSController@smslogconsumption');
    Route::get('/promotionalsms/teamsmslogconsumption', 'PromotionalSMSController@teamsmslogconsumption');
   
    
    Route::post('/promotionalsms/getFilterdata', 'PromotionalSMSController@getFilterdata');
    Route::post('/promotionalsms/fileUpload', 'PromotionalSMSController@fileUpload');
    Route::resource('/promotionalsms', 'PromotionalSMSController');
     
    
    Route::post('/promotionalsms/getSmslogs', 'PromotionalSMSController@getSmslogs');
    
    Route::post('/promotionalsms/getFilterdataconsumption', 'PromotionalSMSController@getFilterdataconsumption');
    Route::post('/promotionalsms/getSmslogsconsumption', 'PromotionalSMSController@getSmslogsconsumption');
    Route::get('/promotionalsms/detaillog/{id}/{eid}', 'PromotionalSMSController@detaillog');
    Route::get('/promotionalsms/detailsmsconsumption/{id}/{eid}', 'PromotionalSMSController@detailsmsconsumption');
    Route::post('/promotionalsms/getDetailFilterdata', 'PromotionalSMSController@getDetailFilterdata');
    Route::post('/promotionalsms/getcustomerFilterdata', 'PromotionalSMSController@getcustomerFilterdata');
   
    
    
        
    Route::post('/promotionalsms/getalllogdetail', 'PromotionalSMSController@getalllogdetail');
    Route::get('/realtimereport/pushgupshupapi', 'RealtimereportController@pushgupshupapi');
   
    Route::get('/dirPagination', function () {
        return View::make('backend.dirPagination');
    });
});