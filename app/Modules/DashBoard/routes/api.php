<?php

Route::group(array('module' => 'DashBoard', 'middleware' => ['api'], 'namespace' => 'App\Modules\DashBoard\Controllers'), function() {

    Route::resource('DashBoard', 'DashBoardController');
    
});	
