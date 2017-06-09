<?php

Route::group(array('module' => 'Wings', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\Wings\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::post('/wings/getWingList','WingsController@getWingList');
    Route::resource( '/wings', 'WingsController');
    
});	
