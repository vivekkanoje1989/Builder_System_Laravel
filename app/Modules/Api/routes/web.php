<?php

Route::group(array('module' => 'Api', 'middleware' => ['web'], 'namespace' => 'App\Modules\Api\Controllers'), function() {

    Route::get('/pushapi/manage', function () {
        return View::make('Api::manage');
    });
    Route::get('/pushapi/create', function () {
        return View::make('Api::new');
    });
    Route::get('/pushapi/listApis', 'ApiController@listApis');
    Route::get('/pushapi/apiExportToxls', 'ApiController@apiExportToxls');
    Route::post('/pushapi/createApi', 'ApiController@createApi');
    Route::post('/pushapi/updateApi', 'ApiController@updateApi');
    Route::get('/pushapi/getEmailConfiguration', 'ApiController@getEmailConfiguration');
    Route::get('/pushapi/{id}/update', 'ApiController@update');
    Route::post('/pushapi/getapiData', 'ApiController@getapiData');
    Route::post('/pushapi/getemployees', 'ApiController@getemployees');
    Route::post('/pushapi/getEmployeesOther', 'ApiController@getEmployeesOther');

    Route::resource('api', 'ApiController');
});
