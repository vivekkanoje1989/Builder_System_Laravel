<?php

Route::group(array('module' => 'WebPages', 'middleware' => ['web'], 'namespace' => 'App\Modules\WebPages\Controllers'), function() {

    $getUrl = config('global.getUrl');    
    Route::get($getUrl.'/web-pages/getWebPages', 'WebPagesController@getWebPages'); //get contentpages pages
    Route::resource($getUrl.'/web-pages', 'WebPagesController');
    Route::post($getUrl.'/web-pages/getEditWebPage', 'WebPagesController@getEditWebPage');// get update content page data
    Route::post($getUrl.'/web-pages/updateWebPage', 'WebPagesController@updateWebPage'); //update content management tab page
    Route::post($getUrl.'/web-pages/getImages', 'WebPagesController@getImages');
    Route::post($getUrl.'/web-pages/updateWebPageImage', 'WebPagesController@updateWebPageImage'); //upload and update images image management tab 
    Route::post($getUrl.'/web-pages/removeWebPageImage', 'WebPagesController@removeWebPageImage');// remove image
    
});	
