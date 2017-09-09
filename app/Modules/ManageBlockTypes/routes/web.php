<?php

Route::group(array('module' => 'ManageBlockTypes','middleware' => ['auth:admin'], 'namespace' => 'App\Modules\ManageBlockTypes\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::get('/block-types/blockTypesExportToxls','ManageBlockTypesController@blockTypesExportToxls');
    Route::post('/block-types/manageBlockTypes','ManageBlockTypesController@manageBlockTypes');
    Route::post('/block-types/manageProjectTypes','ManageBlockTypesController@manageProjectTypes');
    Route::resource('/block-types', 'ManageBlockTypesController');
});	


