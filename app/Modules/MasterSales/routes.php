<?php

Route::group(array('module' => 'MasterSales', 'namespace' => 'App\Modules\MasterSales\Controllers'), function() {

    Route::resource('admin/master-sales', 'MasterSalesController');
    
});	