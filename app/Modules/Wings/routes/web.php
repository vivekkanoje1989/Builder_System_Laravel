<?php

Route::group(array('module' => 'Wings', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\Wings\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::post($getUrl.'/wings/getWingList','WingsController@getWingList');
    Route::resource($getUrl. '/wings', 'WingsController');
    
});	
