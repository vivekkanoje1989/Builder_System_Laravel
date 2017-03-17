<?php

Route::group(array('module' => 'HighestEducation', 'middleware' => ['api'], 'namespace' => 'App\Modules\HighestEducation\Controllers'), function() {

    Route::resource('HighestEducation', 'HighestEducationController');
    
});	
