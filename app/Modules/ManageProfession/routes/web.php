<?php

Route::group(array('module' => 'ManageProfession', 'middleware' => ['auth:admin'],'namespace' => 'App\Modules\ManageProfession\Controllers'), function() {

    $getUrl = config('global.getUrl');
     Route::post('/manage-profession/manageProfession','ManageProfessionController@manageProfession');
     Route::post('/manage-profession/deleteProfession','ManageProfessionController@deleteProfession');
     Route::get('/manage-profession/professionExportToxls','ManageProfessionController@professionExportToxls');
    Route::resource('/manage-profession', 'ManageProfessionController');
    
});	
