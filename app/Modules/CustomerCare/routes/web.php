<?php

Route::group(array('module' => 'CustomerCare',  ['middleware' => 'auth:admin'], 'namespace' => 'App\Modules\CustomerCare\Controllers'), function() {
    
    Route::get('/customer-care/presales/history', function () {
        return View::make('CustomerCare::presales.history');
    });
    
    Route::get('/customer-care/presales/filter', function () {
        return View::make('CustomerCare::presales.filter');
    });
    
    Route::get('/customer-care/presales/todayremarks', function () {
        return View::make('CustomerCare::presales.todayremarks');
    });
    
     Route::get('/customer-care/presales/todayremarks', function () {
        return View::make('CustomerCare::presales.todayremarks');
    });
    
    Route::post('/customer-care/presales/getPresalesTodayremarksEnquiry', 'CustomerCareController@getPresalesTodayremarksEnquiry');
    Route::post('/customer-care/presales/getenquiryHistory', 'CustomerCareController@getEnquiryHistory');
    Route::get('/customer-care/presales/total/{type}', 'CustomerCareController@viewpresalesTotal');
    Route::get('/customer-care/presales/completed/{type}', 'CustomerCareController@viewpresalesCompleted');
    Route::get('/customer-care/presales/previous/{type}', 'CustomerCareController@viewpresalesPrevious');
    Route::get('/customer-care/presales/today/{type}', 'CustomerCareController@viewpresalesToday');
    Route::get('/customer-care/presales/pending/{type}', 'CustomerCareController@viewpresalesPending');
    Route::post('/customer-care/presales/getTotal', 'CustomerCareController@getpresalesTotal');
    Route::post('/customer-care/presales/getCompleted', 'CustomerCareController@getpresalesCompleted');
    Route::post('/customer-care/presales/getPrevious', 'CustomerCareController@getpresalesPrevious');
    Route::post('/customer-care/presales/getToday', 'CustomerCareController@getpresalesToday');
    Route::post('/customer-care/presales/getPending', 'CustomerCareController@getpresalesPending');
    Route::post('/customer-care/presales/insertCcPreSalesRemark', 'CustomerCareController@insertCcPreSalesRemark');
    Route::post('/customer-care/presales/ccfilter', 'CustomerCareController@ccfilter');
    
    Route::resource('Customer_Care', 'CustomerCareController');    
});	
