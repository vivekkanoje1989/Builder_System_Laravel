<?php

Route::group(array('module' => 'ManageProfession','namespace' => 'App\Modules\ManageProfession\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource($getUrl.'/manage-profession', 'ManageProfessionController');
     Route::post($getUrl . '/manage-profession/manageProfession','ManageProfessionController@manageProfession');
    
});	
