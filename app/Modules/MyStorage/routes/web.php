<?php

Route::group(array('module' => 'MyStorage', 'middleware' => ['auth:admin'],'namespace' => 'App\Modules\MyStorage\Controllers'), function() {

    Route::get('/storage-list/getStorage', 'MyStorageController@getStorage')->middleware("permission:01201"); //for index
    Route::get('/storage-list/getMyStorage', 'MyStorageController@getMyStorage')->middleware("permission:01202"); //for files shared with me list
    Route::get('/recycle-bin/', 'MyStorageController@recycleBin')->middleware("permission:01203");
    Route::post('/storage-list/deleteFolder', 'MyStorageController@deleteFolder')->middleware("permission:01201|01202");
    Route::post('/storage-list/restoreFolder', 'MyStorageController@restoreFolder')->middleware("permission:01203");
    Route::post('/storage-list/allFolderImages', 'MyStorageController@allFolderImages')->middleware("permission:01203");
//    Route::post('/storage-list/getAllList', 'MyStorageController@getAllList')->middleware("permission:01201" | "permission:01202");
    Route::get('/storage-list/getRecycle', 'MyStorageController@getRecycleList')->middleware("permission:01203");
    Route::get('/storage-list/{folderId}/allfiles', 'MyStorageController@allFiles')->middleware("permission:01201|01202");
    Route::get('/storage-list/{folderId}/allmyfiles', 'MyStorageController@allMyFiles')->middleware("permission:01201");
    Route::get('/storage-list/{folderId}/getAllListToRestore', 'MyStorageController@getAllListToRestore')->middleware("permission:01203");
    Route::get('/storage-list/{folderId}/getSubFolderImages', 'MyStorageController@getSubFolderImages')->middleware("permission:01201|01202|01203");
    Route::get('/storage-list/{folderId}/SubFolderRestore', 'MyStorageController@SubFolderRestore')->middleware("permission:01203");
    Route::post('/storage-list/subFolder', 'MyStorageController@subFolder')->middleware("permission:01201|01202");
    Route::post('/storage-list/deleteImages', 'MyStorageController@deleteImages')->middleware("permission:01201|01202|01203");
    Route::get('/getEmployees', 'MyStorageController@getEmployees')->middleware("permission:01201|01202|01203");
    Route::post('/storage-list/sharedWith', 'MyStorageController@sharedWith')->middleware("permission:01202");
    Route::get('/sharedwith-me', 'MyStorageController@sharedWithMe')->middleware("permission:01202");
    Route::post('/storage-list/folderSharedEmployees', 'MyStorageController@folderSharedEmployees')->middleware("permission:01201|01202");
    Route::post('/storage-list/removeEmployees', 'MyStorageController@removeEmployees')->middleware("permission:01201|01202");
    Route::post('/storage-list/folderStorage', 'MyStorageController@folderStorage')->middleware("permission:01201|01202");
    Route::post('/storage-list/getSubDirectory', 'MyStorageController@getSubDirectory')->middleware("permission:01201|01202");
    Route::post('/storage-list/sharedImageWith', 'MyStorageController@sharedImageWith')->middleware("permission:01201|01202");
    Route::post('/storage-list/removeImageSharedEmp', 'MyStorageController@removeImageSharedEmp')->middleware("permission:01201|01202|01203");
    Route::post('/storage-list/getSharedImagesEmployees', 'MyStorageController@getSharedImagesEmployees')->middleware("permission:01201|01202|01203");
    Route::post('/storage-list/subImageStorage', 'MyStorageController@subImageStorage')->middleware("permission:01201|01202");
    Route::get('/storage-list/getMySharedImages', 'MyStorageController@getMySharedImages')->middleware("permission:01201|01202");
    Route::get('/storage-list/{folderId}/getMySubFolderImages', 'MyStorageController@getMySubFolderImages')->middleware("permission:01201|01202|01203");
    Route::get('/storage-list/synchedFolderList', 'MyStorageController@synchedFolderList')->middleware("permission:01201");
    Route::post('/storage-list/insertSyncedData', 'MyStorageController@insertSyncedData')->middleware("permission:01201");
    Route::post('/storage-list/subDirectoryAdd', 'MyStorageController@subDirectoryAdd')->middleware("permission:01201");
    Route::post('/storage-list/syncSubFolderCreate', 'MyStorageController@syncSubFolderCreate')->middleware("permission:01201");
    Route::get('/storage-list', 'MyStorageController@index')->middleware("permission:01201");

    Route::resource('/storage-list', 'MyStorageController');
});
