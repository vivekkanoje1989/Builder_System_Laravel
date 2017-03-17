<?php

Route::group(array('module' => 'ManageBlockTypes', 'namespace' => 'App\Modules\ManageBlockTypes\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource($getUrl .'/block-types', 'ManageBlockTypesController');
    Route::post($getUrl . '/block-types/manageBlockTypes','ManageBlockTypesController@manageBlockTypes');
    Route::post($getUrl . '/block-types/manageProjectTypes','ManageBlockTypesController@manageProjectTypes');
});	


