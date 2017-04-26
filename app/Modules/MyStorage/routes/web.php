<?php

Route::group(array('module' => 'MyStorage', 'namespace' => 'App\Modules\MyStorage\Controllers'), function() {

    $getUrl = config('global.getUrl');

    Route::get($getUrl . '/storage-list/getStorage', 'MyStorageController@getStorage');
    Route::get($getUrl . '/storage-list/getMyStorage', 'MyStorageController@getMyStorage');
    Route::get($getUrl . '/recycle-bin/', 'MyStorageController@recycleBin');
    Route::post($getUrl . '/storage-list/deleteFolder', 'MyStorageController@deleteFolder');
    Route::post($getUrl . '/storage-list/deleteFolder', 'MyStorageController@deleteFolder');
    Route::post($getUrl . '/storage-list/restoreFolder', 'MyStorageController@restoreFolder');
    Route::post($getUrl . '/storage-list/allFolderImages', 'MyStorageController@allFolderImages');
    Route::post($getUrl . '/storage-list/getAllList', 'MyStorageController@getAllList');
    Route::get($getUrl . '/storage-list/getRecycle', 'MyStorageController@getRecycleList');
    Route::get($getUrl . '/storage-list/{filename}/allfiles', 'MyStorageController@allFiles');
    Route::get($getUrl . '/storage-list/{filename}/allmyfiles', 'MyStorageController@allMyFiles');
    Route::get($getUrl . '/storage-list/{filename}/getAllListToRestore', 'MyStorageController@getAllListToRestore');
    Route::resource($getUrl . '/storage-list', 'MyStorageController');
    Route::post($getUrl . '/storage-list/subFolder', 'MyStorageController@subFolder');
    Route::post($getUrl . '/storage-list/deleteImages', 'MyStorageController@deleteImages');
    Route::get($getUrl . '/getEmployees', 'MyStorageController@getEmployees');
    Route::post($getUrl . '/storage-list/sharedWith', 'MyStorageController@sharedWith');
    Route::get($getUrl . '/sharedwith-me', 'MyStorageController@sharedWithMe');
    Route::post($getUrl . '/storage-list/folderSharedEmployees', 'MyStorageController@folderSharedEmployees');
    Route::post($getUrl . '/storage-list/removeEmployees', 'MyStorageController@removeEmployees');
});
