<?php

Route::group(array('module' => 'ManageLostReason', 'middleware' => ['api'], 'namespace' => 'App\Modules\ManageLostReason\Controllers'), function() {

    Route::resource('ManageLostReason', 'ManageLostReasonController');
    
});	
