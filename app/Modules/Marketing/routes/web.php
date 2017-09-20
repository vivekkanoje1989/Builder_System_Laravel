<?php
Route::group(array('module' => 'Marketing', ['middleware' => 'auth:admin'], 'namespace' => 'App\Modules\Marketing\Controllers'), function() {
     
    Route::get('/Marketing/showFilter', function () {
        return View::make('Marketing::showFilter');
    });
    
    /* Detail log filter*/
     Route::get('/Marketing/showDetailFilter', function () {
        return View::make('Marketing::showDetailFilter');
    });
    
    Route::get('/dirPagination', function () {
        return View::make('backend.dirPagination');
    });
    
    Route::get('/promotionalsms/smslogs', 'PromotionalSMSController@smslogs')->middleware("permission:070102");
    Route::get('/promotionalsms/smsLogsExpotToxls', 'PromotionalSMSController@smsLogsExpotToxls')->middleware("permission:070102");
    Route::get('/promotionalsms/logDetailsExportToxls/{transId}', 'PromotionalSMSController@logDetailsExportToxls');
    Route::get('/promotionalsms/teamSmsLogsExpotToxls', 'PromotionalSMSController@teamSmsLogsExpotToxls')->middleware("permission:070103");
    Route::get('/promotionalsms/teamsmslogs', 'PromotionalSMSController@teamsmslogs')->middleware("permission:070103");
    
    Route::post('/promotionalsms/getFilterdata', 'PromotionalSMSController@getFilterdata');
    Route::get('/promotionalsms/', 'PromotionalSMSController@index')->middleware("permission:070101");
    Route::post('/promotionalsms', 'PromotionalSMSController@store')->middleware("permission:070101");
    
    Route::post('/promotionalsms/getSmslogs', 'PromotionalSMSController@getSmslogs')->middleware("permission:070102");    
    Route::get('/promotionalsms/detaillog/{id}/{eid}', 'PromotionalSMSController@detaillog')->middleware("permission:070102|070103");
    Route::get('/promotionalsms/detailsmsconsumption/{id}/{eid}', 'PromotionalSMSController@detailsmsconsumption');
    Route::post('/promotionalsms/getDetailFilterdata', 'PromotionalSMSController@getDetailFilterdata');        
    Route::post('/promotionalsms/getalllogdetail', 'PromotionalSMSController@getalllogdetail')->middleware("permission:070102|070103");   
});