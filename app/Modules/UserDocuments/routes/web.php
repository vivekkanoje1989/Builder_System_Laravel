<?php

Route::group(array('module' => 'UserDocuments', 'middleware' => 'auth:admin', 'namespace' => 'App\Modules\UserDocuments\Controllers'), function() {

    $getUrl = config('global.getUrl');

    Route::get($getUrl . '/getUsers', 'UserDocumentsController@getUsers');
    Route::post($getUrl . '/user-document/userDocumentLists', 'UserDocumentsController@userDocumentLists');
    Route::get($getUrl . '/user-document/documents', 'UserDocumentsController@getdocuments');
    Route::resource($getUrl . '/user-document', 'UserDocumentsController');
});
