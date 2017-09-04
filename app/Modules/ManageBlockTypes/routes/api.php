<?php

Route::group(array('module' => 'ManageBlockTypes', 'middleware' => ['api'], 'namespace' => 'App\Modules\ManageBlockTypes\Controllers'), function() {

    Route::resource('ManageBlockTypes', 'ManageBlockTypesController');
    
});	
