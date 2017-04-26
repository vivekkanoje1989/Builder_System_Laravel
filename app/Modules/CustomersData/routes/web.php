<?php

Route::group(array('module' => 'CustomersData', 'namespace' => 'App\Modules\CustomersData\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::resource($getUrl.'/customers-data', 'CustomersDataController');
});	
