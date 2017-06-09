<?php

Route::group(array('module' => 'Companies', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\Companies\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::get('/manage-companies/manageCompany', 'CompaniesController@manageCompany');
    Route::get('/manage-companies/create', 'CompaniesController@create');
    Route::get('/manage-companies/manageBankAccount', 'CompaniesController@manageBankAccount');
    Route::post('/manage-companies/{{companyId}}/edit', 'CompaniesController@edit');
    Route::post('/manage-companies/loadCompanyData', 'CompaniesController@loadCompanyData');

    Route::post('/manage-companies/updateCompany', 'CompaniesController@updateCompany');
    Route::resource('/manage-companies', 'CompaniesController');
});
