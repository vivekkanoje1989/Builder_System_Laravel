<?php

Route::group(array('module' => 'MasterSales', 'middleware' => ['api'], 'namespace' => 'App\Modules\MasterSales\Controllers'), function() {

    Route::post('api/master-sales/getCustomerDetails', 'MasterSalesController@getCustomerDetails');
    Route::post('api/master-sales', 'MasterSalesController@store');
});	