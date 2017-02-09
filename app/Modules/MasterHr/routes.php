<?php

Route::group(array('module' => 'MasterHr', 'namespace' => 'App\Modules\MasterHr\Controllers'), function() {

    Route::resource('admin/master-hr', 'MasterHrController');
    Route::post('master-hr/uploadFile', 'MasterHrController@uploadFile');
    Route::get('master-hr/listUsers', 'MasterHrController@listUsers');    
});	