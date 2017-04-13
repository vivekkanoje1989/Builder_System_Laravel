<?php

Route::group(array('module' => 'MasterSales', 'middleware' =>['web'], 'namespace' => 'App\Modules\MasterSales\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::get($getUrl.'/master-sales/showEnquiry/{id}', 'MasterSalesController@showEnquiry'); //show enquiry page
    
    Route::resource($getUrl.'/master-sales', 'MasterSalesController');
    Route::post($getUrl.'/master-sales/getCustomerDetails', 'MasterSalesController@getCustomerDetails');
    Route::post($getUrl.'/master-sales/checkMobileExist', 'MasterSalesController@checkMobileExist');
    
    
});


