<?php

Route::group(array('module' => 'SocialWebsites','middleware' => 'auth:admin','namespace' => 'App\Modules\SocialWebsites\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource($getUrl.'/social-website', 'SocialWebsitesController');
    Route::post($getUrl.'/social-website/manageSocialWebsite','SocialWebsitesController@manageSocialWebsite');
    
});	
