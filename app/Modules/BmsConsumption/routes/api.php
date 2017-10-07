<?php

Route::group(array('module' => 'BmsConsumption', 'middleware' => ['api'], 'namespace' => 'App\Modules\BmsConsumption\Controllers'), function() {

    Route::resource('bmsConsumption', 'BmsConsumptionController');
    
});	
