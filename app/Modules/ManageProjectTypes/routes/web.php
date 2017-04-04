<?php

Route::group(array('module' => 'ManageProjectTypes','middleware' => 'auth:admin', 'namespace' => 'App\Modules\ManageProjectTypes\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource($getUrl.'/project-types', 'ManageProjectTypesController');
    Route::post($getUrl.'/project-types/manageProjectTypes','ManageProjectTypesController@manageProjectTypes');
});	

