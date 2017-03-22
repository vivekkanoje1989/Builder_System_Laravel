<?php

Route::group(array('module' => 'ManageProfession', 'middleware' => ['api'], 'namespace' => 'App\Modules\ManageProfession\Controllers'), function() {

    Route::resource('ManageProfession', 'ManageProfessionController');
    
});	
