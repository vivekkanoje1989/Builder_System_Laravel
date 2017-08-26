<?php

Route::group(array('module' => 'BlockStages', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\BlockStages\Controllers'), function() {
    $getUrl = config('global.getUrl');

    Route::post('/block-stages/manageBlockStages', 'BlockStagesController@manageBlockStages');
    Route::post('/block-stages/manageProjectTypes', 'BlockStagesController@manageProjectTypes');
    Route::post('/block-stages/filteredData', 'BlockStagesController@filteredData');
    Route::put('/block-stages/{id}', 'BlockStagesController@update'); //update block data
    Route::resource('/block-stages', 'BlockStagesController');
    Route::get('/BlockStages/showFilter', function () {
        return View::make('BlockStages::showFilter');
    });
});
