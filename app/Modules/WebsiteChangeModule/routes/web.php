<?php

Route::group(array('module' => 'WebsiteChangeModule',  'middleware' => 'auth:admin', 'namespace' => 'App\Modules\WebsiteChangeModule\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource($getUrl.'/website/change-module', 'WebsiteChangeModuleController');
});	
