<?php

Route::group(array('module' => 'ManageCountry', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\ManageCountry\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::get('/manage-country/countryExportToxls', 'ManageCountryController@countryExportToxls');
    Route::post('/manage-country/manageCountry', 'ManageCountryController@manageCountry');
    Route::post('/manage-country/deleteCountry', 'ManageCountryController@deleteCountry');
    Route::post('/manage-country/filteredData', 'ManageCountryController@filteredData');
    Route::resource('/manage-country', 'ManageCountryController');
    Route::get('/ManageCountry/showFilter', function () {
        return View::make('ManageCountry::showFilter');
    });
});
