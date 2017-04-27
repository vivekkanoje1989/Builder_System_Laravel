<?php

Route::group(array('module' => 'MyStorage', 'namespace' => 'App\Modules\MyStorage\Controllers'), function() {

    $getUrl = config('global.getUrl');

    Route::get($getUrl . '/storage-list/getStorage', 'MyStorageController@getStorage');
    Route::get($getUrl . '/storage-list/getMyStorage', 'MyStorageController@getMyStorage');
    Route::get($getUrl . '/recycle-bin/', 'MyStorageController@recycleBin');
    Route::post($getUrl . '/storage-list/deleteFolder', 'MyStorageController@deleteFolder');
    Route::post($getUrl . '/storage-list/restoreFolder', 'MyStorageController@restoreFolder');
    Route::post($getUrl . '/storage-list/allFolderImages', 'MyStorageController@allFolderImages');
    Route::post($getUrl . '/storage-list/getAllList', 'MyStorageController@getAllList');
    Route::get($getUrl . '/storage-list/getRecycle', 'MyStorageController@getRecycleList');
    Route::get($getUrl . '/storage-list/{folderId}/allfiles', 'MyStorageController@allFiles');
    Route::get($getUrl . '/storage-list/{folderId}/allmyfiles', 'MyStorageController@allMyFiles');
    Route::get($getUrl . '/storage-list/{folderId}/getAllListToRestore', 'MyStorageController@getAllListToRestore');
    Route::get($getUrl . '/storage-list/{folderId}/getSubFolderImages', 'MyStorageController@getSubFolderImages');
    Route::get($getUrl . '/storage-list/{folderId}/SubFolderRestore', 'MyStorageController@SubFolderRestore');
    Route::post($getUrl . '/storage-list/subFolder', 'MyStorageController@subFolder');
    Route::post($getUrl . '/storage-list/deleteImages', 'MyStorageController@deleteImages');
    Route::get($getUrl . '/getEmployees', 'MyStorageController@getEmployees');
    Route::post($getUrl . '/storage-list/sharedWith', 'MyStorageController@sharedWith');
    Route::get($getUrl . '/sharedwith-me', 'MyStorageController@sharedWithMe');
    Route::post($getUrl . '/storage-list/folderSharedEmployees', 'MyStorageController@folderSharedEmployees');
    Route::post($getUrl . '/storage-list/removeEmployees', 'MyStorageController@removeEmployees');
    Route::post($getUrl . '/storage-list/folderStorage', 'MyStorageController@folderStorage');
    Route::post($getUrl . '/storage-list/getSubDirectory', 'MyStorageController@getSubDirectory');
    Route::post($getUrl . '/storage-list/sharedImageWith', 'MyStorageController@sharedImageWith');
    Route::post($getUrl . '/storage-list/removeImageSharedEmp', 'MyStorageController@removeImageSharedEmp');
    Route::post($getUrl . '/storage-list/getSharedImagesEmployees', 'MyStorageController@getSharedImagesEmployees');
    Route::post($getUrl . '/storage-list/subImageStorage', 'MyStorageController@subImageStorage');
    Route::get($getUrl . '/storage-list/getMySharedImages', 'MyStorageController@getMySharedImages');
    Route::get($getUrl . '/storage-list/{folderId}/getMySubFolderImages', 'MyStorageController@getMySubFolderImages');
    Route::get($getUrl . '/storage-list/synchedFolderList', 'MyStorageController@synchedFolderList');
    Route::post($getUrl . '/storage-list/insertSyncedData', 'MyStorageController@insertSyncedData');
    Route::post($getUrl . '/storage-list/subDirectoryAdd', 'MyStorageController@subDirectoryAdd');
    Route::post($getUrl . '/storage-list/syncSubFolderCreate', 'MyStorageController@syncSubFolderCreate');
    Route::resource($getUrl . '/storage-list', 'MyStorageController');
});
