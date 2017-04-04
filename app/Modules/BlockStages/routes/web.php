<?php

Route::group(array('module' => 'BlockStages', 'namespace' => 'App\Modules\BlockStages\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::resource($getUrl . '/block-stages', 'BlockStagesController');
    Route::post($getUrl . '/block-stages/manageBlockStages','BlockStagesController@manageBlockStages');
    Route::post($getUrl . '/block-stages/manageProjectTypes','BlockStagesController@manageProjectTypes');
  
});
