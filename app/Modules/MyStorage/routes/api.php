<?php

Route::group(array('module' => 'MyStorage', 'middleware' => ['api'], 'namespace' => 'App\Modules\MyStorage\Controllers'), function() {

    Route::resource('MyStorage', 'MyStorageController');
    
});	
