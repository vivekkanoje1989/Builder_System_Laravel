<?php

Route::group(array('module' => 'MyStorage', 'middleware' => ['auth:admin'],'namespace' => 'App\Modules\MyStorage\Controllers'), function() {

    $getUrl = config('global.getUrl');

    Route::get('/storage-list/getStorage', 'MyStorageController@getStorage');
    Route::get('/storage-list/getMyStorage', 'MyStorageController@getMyStorage');
    Route::get('/recycle-bin/', 'MyStorageController@recycleBin');
    Route::post('/storage-list/deleteFolder', 'MyStorageController@deleteFolder');
    Route::post('/storage-list/restoreFolder', 'MyStorageController@restoreFolder');
    Route::post('/storage-list/allFolderImages', 'MyStorageController@allFolderImages');
    Route::post('/storage-list/getAllList', 'MyStorageController@getAllList');
    Route::get('/storage-list/getRecycle', 'MyStorageController@getRecycleList');
    Route::get('/storage-list/{folderId}/allfiles', 'MyStorageController@allFiles');
    Route::get('/storage-list/{folderId}/allmyfiles', 'MyStorageController@allMyFiles');
    Route::get('/storage-list/{folderId}/getAllListToRestore', 'MyStorageController@getAllListToRestore');
    Route::get('/storage-list/{folderId}/getSubFolderImages', 'MyStorageController@getSubFolderImages');
    Route::get('/storage-list/{folderId}/SubFolderRestore', 'MyStorageController@SubFolderRestore');
    Route::post('/storage-list/subFolder', 'MyStorageController@subFolder');
    Route::post('/storage-list/deleteImages', 'MyStorageController@deleteImages');
    Route::get('/getEmployees', 'MyStorageController@getEmployees');
    Route::post('/storage-list/sharedWith', 'MyStorageController@sharedWith');
    Route::get('/sharedwith-me', 'MyStorageController@sharedWithMe');
    Route::post('/storage-list/folderSharedEmployees', 'MyStorageController@folderSharedEmployees');
    Route::post('/storage-list/removeEmployees', 'MyStorageController@removeEmployees');
    Route::post('/storage-list/folderStorage', 'MyStorageController@folderStorage');
    Route::post('/storage-list/getSubDirectory', 'MyStorageController@getSubDirectory');
    Route::post('/storage-list/sharedImageWith', 'MyStorageController@sharedImageWith');
    Route::post('/storage-list/removeImageSharedEmp', 'MyStorageController@removeImageSharedEmp');
    Route::post('/storage-list/getSharedImagesEmployees', 'MyStorageController@getSharedImagesEmployees');
    Route::post('/storage-list/subImageStorage', 'MyStorageController@subImageStorage');
    Route::get('/storage-list/getMySharedImages', 'MyStorageController@getMySharedImages');
    Route::get('/storage-list/{folderId}/getMySubFolderImages', 'MyStorageController@getMySubFolderImages');
    Route::get('/storage-list/synchedFolderList', 'MyStorageController@synchedFolderList');
    Route::post('/storage-list/insertSyncedData', 'MyStorageController@insertSyncedData');
    Route::post('/storage-list/subDirectoryAdd', 'MyStorageController@subDirectoryAdd');
    Route::post('/storage-list/syncSubFolderCreate', 'MyStorageController@syncSubFolderCreate');
    Route::resource('/storage-list', 'MyStorageController');
});
