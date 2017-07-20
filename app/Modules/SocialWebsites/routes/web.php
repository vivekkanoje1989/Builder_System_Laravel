<?php

Route::group(array('module' => 'SocialWebsites','middleware' => ['auth:admin'],'namespace' => 'App\Modules\SocialWebsites\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource('/social-website', 'SocialWebsitesController');
    Route::post('/social-website/manageSocialWebsite','SocialWebsitesController@manageSocialWebsite');
    
});	
