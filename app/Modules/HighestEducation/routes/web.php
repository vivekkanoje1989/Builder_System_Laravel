<?php

Route::group(array('module' => 'HighestEducation', 'namespace' => 'App\Modules\HighestEducation\Controllers'), function() {

     $getUrl = config('global.getUrl');
    Route::resource($getUrl .'/highest-education', 'HighestEducationController');
    Route::post($getUrl . '/highest-education/manageHighestEducation','HighestEducationController@manageHighestEducation');
});	

