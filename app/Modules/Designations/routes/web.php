<?php

Route::group(array('module' => 'Designations', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\Designations\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::post('/manage-designations/manageDesignations', 'DesignationsController@manageDesignations');
    Route::post('/manage-designations/deleteDesignation', 'DesignationsController@deleteDesignation');
    Route::get('/manage-designations/designationExportToxls', 'DesignationsController@designationExportToxls');
    Route::resource('/manage-designations', 'DesignationsController');
});
