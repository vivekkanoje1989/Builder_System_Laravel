<?php

Route::group(array('module' => 'ManageLostReason','middleware' => ['auth:admin'], 'namespace' => 'App\Modules\ManageLostReason\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource('/lost-reasons','ManageLostReasonController');
    Route::post('/lost-reasons/manageLostReason', 'ManageLostReasonController@manageLostReason');
});	
