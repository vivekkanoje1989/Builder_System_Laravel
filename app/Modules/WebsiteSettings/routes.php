<?php

Route::group(array('module' => 'WebsiteSettings', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\WebsiteSettings\Controllers'), function() {
    $getUrl = config('global.getUrl');
    /*******************************UMA*********************************/
    Route::get('/website_settings/managePages', 'ContentPagesController@managePages');
    Route::get('/website_settings/getIndex', 'ContentPagesController@getIndex');
    Route::get('/website_settings/{pageId}/updateContentPage', 'ContentPagesController@updateContentPage');
    Route::post('/website_settings/getContentPage', 'ContentPagesController@getContentPage');
    Route::post('/website_settings/saveContentPageSettings', 'ContentPagesController@saveContentPageSettings');
    Route::post('/website_settings/getImages', 'ContentPagesController@getImages');
    Route::post('/website_settings/saveImagePageSettings', 'ContentPagesController@saveImagePageSettings');
    
    /*******************************UMA*********************************/
    /*******************************MANOJ*********************************/
    Route::get('/website_settings/contactus','ContactUsController@index');
    Route::get('/website_settings/manageContactUs','ContactUsController@manageContactUs');
    Route::post('/website_settings/updateContactUs','ContactUsController@updateContactUs');
    
     
    Route::get('/website_settings/socialweb','SocialwebsiteManagementController@index');
    Route::get('/website_settings/manageSocialWebsite','SocialwebsiteManagementController@manageSocialWebsite');
    Route::post('/website_settings/updateSocialWebsite','SocialwebsiteManagementController@updateSocialWebsite'); 
    /*******************************MANOJ*********************************/
    //Route::resource('/website_settings', 'ContentPagesController');
});
