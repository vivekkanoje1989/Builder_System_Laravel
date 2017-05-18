<?php

Route::group(array('module' => 'WebsiteChangeModule', 'middleware' => ['api'], 'namespace' => 'App\Modules\WebsiteChangeModule\Controllers'), function() {

    Route::resource('WebsiteChangeModule', 'WebsiteChangeModuleController');
    
});	
