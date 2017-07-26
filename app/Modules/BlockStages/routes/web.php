<?php

Route::group(array('module' => 'BlockStages', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\BlockStages\Controllers'), function() {
    $getUrl = config('global.getUrl');
    
    Route::post('/block-stages/manageBlockStages','BlockStagesController@manageBlockStages');
    Route::post('/block-stages/manageProjectTypes','BlockStagesController@manageProjectTypes');
    Route::put('/block-stages/{id}', 'BlockStagesController@update'); //update enquiry data
  Route::resource('/block-stages', 'BlockStagesController');
});
