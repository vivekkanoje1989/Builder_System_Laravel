<?php

Route::group(array('module' => 'Designations', 'middleware' => 'auth:admin', 'namespace' => 'App\Modules\Designations\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource($getUrl . '/manage-designations', 'DesignationsController');
    Route::post($getUrl . '/manage-designations/manageDesignations', 'DesignationsController@manageDesignations');
});
