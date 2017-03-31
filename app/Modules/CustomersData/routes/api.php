<?php

Route::group(array('module' => 'CustomersData', 'middleware' => ['api'], 'namespace' => 'App\Modules\CustomersData\Controllers'), function() {

    Route::resource('customers-data', 'CustomersDataController');
    
});	
