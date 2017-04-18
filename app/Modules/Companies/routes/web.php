<?php

Route::group(array('module' => 'Companies', 'middleware' => 'auth:admin', 'namespace' => 'App\Modules\Companies\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource($getUrl.'/manage-company', 'CompaniesController');
});
