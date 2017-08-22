<?php

Route::group(array('module' => 'WebPages', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\WebPages\Controllers'), function() {

    $getUrl = config('global.getUrl');    
    Route::get('/web-pages/getWebPages', 'WebPagesController@getWebPages'); //get contentpages pages
    Route::resource('/web-pages', 'WebPagesController');
    Route::post('/web-pages/getEditWebPage', 'WebPagesController@getEditWebPage');// get update content page data
    Route::post('/web-pages/updateWebPage', 'WebPagesController@updateWebPage'); //update content management tab page
    Route::post('/web-pages/updateSubWebPages', 'WebPagesController@updateSubWebPage'); //update content management tab page
    Route::post('/web-pages/storeSubWebPage', 'WebPagesController@storeSubWebPage'); //update content management tab page
    Route::post('/web-pages/getImages', 'WebPagesController@getImages');
    Route::post('/web-pages/getSubImages', 'WebPagesController@getSubImages');
    Route::post('/web-pages/updateWebPageImage', 'WebPagesController@updateWebPageImage'); //upload and update images image management tab 
    Route::post('/web-pages/removeWebPageImage', 'WebPagesController@removeWebPageImage');// remove image
    Route::post('/web-pages/removeSubWebPageImage', 'WebPagesController@removeSubWebPageImage');// remove image
    Route::post('/web-pages/getSubPages', 'WebPagesController@getSubPages');// remove image
    
     Route::get('/WebPages/showFilter', function () {
        return View::make('WebPages::showFilter');
    });
});	
