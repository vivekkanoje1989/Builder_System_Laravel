<?php

Route::group(array('module' => 'ManageCountry','middleware' => 'auth:admin','namespace' => 'App\Modules\ManageCountry\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::get($getUrl .'/manage-country/manageCountry','ManageCountryController@manageCountry');
    Route::resource($getUrl . '/manage-country', 'ManageCountryController');
});	
