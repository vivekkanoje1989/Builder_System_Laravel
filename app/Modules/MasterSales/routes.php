<?php

Route::group(array('module' => 'MasterSales', 'namespace' => 'App\Modules\MasterSales\Controllers', 'middleware' =>['web']), function() {
    
    Route::resource('admin/master-sales', 'MasterSalesController');
    Route::post('admin/master-sales/getCustomerDetails', 'MasterSalesController@getCustomerDetails');
    
});	