<?php

Route::group(array('module' => 'CustomersData','middleware' => 'auth:admin', 'namespace' => 'App\Modules\CustomersData\Controllers'), function() {
   
    $getUrl = config('global.getUrl');
    Route::resource($getUrl.'/customers-data', 'CustomersDataController');
    Route::get($getUrl.'/customer-data/customerData','CustomersDataController@customerData');
    Route::post($getUrl.'/customer-data/getcustomerData','CustomersDataController@getcustomerData');
    
    Route::post($getUrl.'/customer-data/update','CustomersDataController@update');
    Route::get($getUrl.'/customer-data/{id}/edit','CustomersDataController@edit');
});


