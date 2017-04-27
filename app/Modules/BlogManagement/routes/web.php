<?php

Route::group(array('module' => 'BlogManagement','middleware' => 'auth:admin',  'namespace' => 'App\Modules\BlogManagement\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource($getUrl.'/manage-blog', 'BlogManagementController');
    Route::post($getUrl.'/manage-blog/manageBlogs','BlogManagementController@manageBlogs');
    Route::get($getUrl.'/manage-blog/create','BlogManagementController@createBlogs'); 
    
    Route::post($getUrl.'/manage-blog/edit','BlogManagementController@edit');
    Route::post($getUrl.'/manage-blog/update/{id}','BlogManagementController@update');
    
    Route::post($getUrl.'/manage-blog/getBlogsDetail','BlogManagementController@getBlogsDetail');   
    Route::post($getUrl.'/manage-blog/removeBlogImage','BlogManagementController@removeBlogImage');   
});	
