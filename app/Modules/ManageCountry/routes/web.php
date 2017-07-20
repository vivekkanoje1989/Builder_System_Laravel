<?php

Route::group(array('module' => 'ManageCountry','middleware' => ['auth:admin'],'namespace' => 'App\Modules\ManageCountry\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::get('/manage-country/manageCountry','ManageCountryController@manageCountry');
    Route::resource('/manage-country', 'ManageCountryController');
});	
