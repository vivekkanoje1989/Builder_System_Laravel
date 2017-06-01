<?php

Route::group(array('module' => 'Customers', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\Customers\Controllers'), function() {

    $getUrl = config('global.getUrl');
    
    Route::get($getUrl.'/customers/manageCustomer','CustomersController@manageCustomer');
    
    Route::resource($getUrl.'/customers', 'CustomersController');
    //Route::get($getUrl.'/customers/manageCustomer','CustomersController@manageCustomer');   
    Route::post($getUrl.'/customers/getcustomerData','CustomersController@getcustomerData');
    
    Route::post($getUrl.'/customers/update','CustomersController@update');
    Route::get($getUrl.'/customers/{id}/edit','CustomersController@edit');
    
});	
