<?php

Route::group(array('module' => 'WebsiteSettings', 'namespace' => 'App\Modules\WebsiteSettings\Controllers'), function() {
    $getUrl = config('global.getUrl');
    /*******************************UMA*********************************/
    Route::get($getUrl.'/website_settings/managePages', 'ContentPagesController@managePages');
    Route::get($getUrl.'/website_settings/getIndex', 'ContentPagesController@getIndex');
    Route::get($getUrl.'/website_settings/{pageId}/updateContentPage', 'ContentPagesController@updateContentPage');
    Route::post($getUrl.'/website_settings/getContentPage', 'ContentPagesController@getContentPage');
    Route::post($getUrl.'/website_settings/saveContentPageSettings', 'ContentPagesController@saveContentPageSettings');
    Route::post($getUrl.'/website_settings/getImages', 'ContentPagesController@getImages');
    Route::post($getUrl.'/website_settings/saveImagePageSettings', 'ContentPagesController@saveImagePageSettings');
    
    /*******************************UMA*********************************/
    /*******************************MANOJ*********************************/
    Route::get($getUrl.'/website_settings/contactus','ContactUsController@index');
    Route::get($getUrl.'/website_settings/manageContactUs','ContactUsController@manageContactUs');
    Route::post($getUrl.'/website_settings/updateContactUs','ContactUsController@updateContactUs');
    
     
    Route::get($getUrl.'/website_settings/socialweb','SocialwebsiteManagementController@index');
    Route::get($getUrl.'/website_settings/manageSocialWebsite','SocialwebsiteManagementController@manageSocialWebsite');
    Route::post($getUrl.'/website_settings/updateSocialWebsite','SocialwebsiteManagementController@updateSocialWebsite'); 
    /*******************************MANOJ*********************************/
    //Route::resource($getUrl.'/website_settings', 'ContentPagesController');
});
