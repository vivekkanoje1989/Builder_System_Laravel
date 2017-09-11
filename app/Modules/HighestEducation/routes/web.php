<?php

Route::group(array('module' => 'HighestEducation','middleware' => ['auth:admin'], 'namespace' => 'App\Modules\HighestEducation\Controllers'), function() {

     $getUrl = config('global.getUrl');
    Route::post('/highest-education/manageHighestEducation','HighestEducationController@manageHighestEducation');
    Route::get('/highest-education/highestEducationExportToxls','HighestEducationController@highestEducationExportToxls');
    Route::resource('/highest-education', 'HighestEducationController');
});	

