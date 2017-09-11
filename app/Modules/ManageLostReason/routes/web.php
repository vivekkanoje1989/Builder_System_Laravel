<?php

Route::group(array('module' => 'ManageLostReason','middleware' => ['auth:admin'], 'namespace' => 'App\Modules\ManageLostReason\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::get('/lost-reasons/lostReasonExportToxls', 'ManageLostReasonController@lostReasonExportToxls');
    Route::post('/lost-reasons/manageLostReason', 'ManageLostReasonController@manageLostReason');
    Route::resource('/lost-reasons','ManageLostReasonController');
});	
