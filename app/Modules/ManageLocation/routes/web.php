<?php

Route::group(array('module' => 'ManageLocation', 'namespace' => 'App\Modules\ManageLocation\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::resource($getUrl . '/manage-location', 'ManageLocationController');
    Route::post($getUrl . '/manage-location/manageLocation','ManageLocationController@manageLocation');
});
