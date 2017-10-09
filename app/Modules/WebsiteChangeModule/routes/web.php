<?php

Route::group(array('module' => 'WebsiteChangeModule',  'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\WebsiteChangeModule\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::post('/websiteChange/getThemes', 'WebsiteChangeModuleController@getThemes');
    Route::resource('/website/change-module', 'WebsiteChangeModuleController');
});	
