<?php

Route::group(array('module' => 'PressRelease', 'middleware' => ['api'], 'namespace' => 'App\Modules\PressRelease\Controllers'), function() {

    Route::resource('Press_Release', 'PressReleaseController');
    
});	
