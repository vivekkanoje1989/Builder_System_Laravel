<?php

Route::group(array('module' => 'UserDocuments', 'middleware' => ['auth:admin'],'namespace' => 'App\Modules\UserDocuments\Controllers'), function() {

    $getUrl = config('global.getUrl');

    Route::get('/getUsers', 'UserDocumentsController@getUsers');
    Route::post('/user-document/userDocumentLists', 'UserDocumentsController@userDocumentLists');
    Route::get('/user-document/documents', 'UserDocumentsController@getdocuments');
    Route::post('/user-document/edit', 'UserDocumentsController@edit');
    Route::post('/user-document/removeImage', 'UserDocumentsController@removeImage');
    
    Route::resource('/user-document', 'UserDocumentsController');
});
