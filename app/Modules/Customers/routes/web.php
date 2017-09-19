<?php

Route::group(array('module' => 'Customers', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\Customers\Controllers'), function() {

    $getUrl = config('global.getUrl');

    Route::get('/customers/manageCustomer', 'CustomersController@manageCustomer');
    Route::get('/customers/customerDetailsExportToxls', 'CustomersController@customerDetailsExportToxls');
    Route::resource('/customers', 'CustomersController');
    //Route::get('/customers/manageCustomer','CustomersController@manageCustomer');   
    Route::post('/customers/getcustomerData', 'CustomersController@getcustomerData');
    Route::post('/customers/deleteCustomer', 'CustomersController@deleteCustomer');


    Route::post('/customers/update', 'CustomersController@update');
    Route::get('/customers/{id}/edit', 'CustomersController@edit');
});
