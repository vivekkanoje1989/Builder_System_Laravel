<?php

Route::group(array('module' => 'BlogManagement','middleware' => ['auth:admin'], 'namespace' => 'App\Modules\BlogManagement\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource('/manage-blog', 'BlogManagementController');
    Route::post('/manage-blog/manageBlogs','BlogManagementController@manageBlogs');
    Route::get('/manage-blog/create','BlogManagementController@createBlogs'); 
    
    Route::post('/manage-blog/edit','BlogManagementController@edit');
    Route::post('/manage-blog/update/{id}','BlogManagementController@update');
    
    Route::post('/manage-blog/getBlogsDetail','BlogManagementController@getBlogsDetail');   
    Route::post('/manage-blog/removeBlogImage','BlogManagementController@removeBlogImage');   
    Route::post('/manage-blog/removeImage','BlogManagementController@removeImage');   
     Route::get('/BlogManagement/showFilter', function () {
        return View::make('BlogManagement::showFilter');
    });
});	
