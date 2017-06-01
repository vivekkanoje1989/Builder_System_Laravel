<?php

Route::group(array('module' => 'Customers', 'middleware' => ['api'], 'namespace' => 'App\Modules\Customers\Controllers'), function() {

    Route::resource('customers', 'CustomersController');
    
});	
