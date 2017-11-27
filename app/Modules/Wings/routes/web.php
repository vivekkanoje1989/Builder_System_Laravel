<?php

Route::group(array('module' => 'Wings', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\Wings\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::post('/wings/getWingList','WingsController@getWingList');
      Route::get('/wings/projectWingsExportToxls', 'WingsController@projectWingsExportToxls');
      Route::post('/wings/deleteWing', 'WingsController@deleteWing');
    Route::resource( '/wings', 'WingsController');
    
});	
