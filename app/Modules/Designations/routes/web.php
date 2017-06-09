<?php

Route::group(array('module' => 'Designations', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\Designations\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource('/manage-designations', 'DesignationsController');
    Route::post('/manage-designations/manageDesignations', 'DesignationsController@manageDesignations');
});
