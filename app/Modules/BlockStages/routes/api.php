<?php

Route::group(array('module' => 'BlockStages', 'middleware' => ['api'], 'namespace' => 'App\Modules\BlockStages\Controllers'), function() {

    Route::resource('block-stages', 'BlockStagesController');
    
});	
