<?php

Route::group(array('module' => 'MasterSales', 'namespace' => 'App\Modules\MasterSales\Controllers', 'middleware' =>['web']), function() {
    $getUrl = config('global.getUrl');
    
    Route::resource($getUrl.'/master-sales', 'MasterSalesController');
    Route::post($getUrl.'/master-sales/getCustomerDetails', 'MasterSalesController@getCustomerDetails');
    Route::post($getUrl.'/master-sales/checkMobileExist', 'MasterSalesController@checkMobileExist');
    
    /*********************************************** API **********************************************************/
    Route::post('api/master-sales/getCustomerDetails', 'MasterSalesController@getCustomerDetails');
    Route::post('api/master-sales', 'MasterSalesController@store');
        
    /*********************************************** API **********************************************************/
});	