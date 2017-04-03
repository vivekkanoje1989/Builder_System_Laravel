<?php

Route::group(array('module' => 'MasterSales', 'middleware' =>['web'], 'namespace' => 'App\Modules\MasterSales\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource($getUrl.'/master-sales', 'MasterSalesController');
    Route::post($getUrl.'/master-sales/getCustomerDetails', 'MasterSalesController@getCustomerDetails');
    Route::post($getUrl.'/master-sales/checkMobileExist', 'MasterSalesController@checkMobileExist');
});


