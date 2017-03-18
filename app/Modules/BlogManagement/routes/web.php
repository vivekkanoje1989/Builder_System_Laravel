<?php

Route::group(array('module' => 'BlogManagement',  'namespace' => 'App\Modules\BlogManagement\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource($getUrl.'/manage-blog', 'BlogManagementController');
    Route::post($getUrl.'/manage-blog/manageBlogs','BlogManagementController@manageBlogs');
    Route::get($getUrl.'/manage-blog/create','BlogManagementController@createBlogs'); 
    
    Route::get($getUrl.'/manage-blog/{id}/edit','BlogManagementController@edit');
    Route::put($getUrl.'/manage-blog/update/{id}','BlogManagementController@updateBlogs');
    
    Route::post($getUrl.'/manage-blog/getBlogsDetail','BlogManagementController@getBlogsDetail');   
 
});	
