<?php

Route::group(array('module' => 'ManageProjectTypes','middleware' => ['auth:admin'], 'namespace' => 'App\Modules\ManageProjectTypes\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::post('/project-types/manageProjectTypes','ManageProjectTypesController@manageProjectTypes');
    Route::get('/project-types/projectTypesExportToxls','ManageProjectTypesController@projectTypesExportToxls');
    Route::resource('/project-types', 'ManageProjectTypesController');
});	

