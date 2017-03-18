<?php

Route::group(array('module' => 'SocialWebsites', 'middleware' => ['api'], 'namespace' => 'App\Modules\SocialWebsites\Controllers'), function() {

    Route::resource('SocialWebsites', 'SocialWebsitesController');
    
});	
