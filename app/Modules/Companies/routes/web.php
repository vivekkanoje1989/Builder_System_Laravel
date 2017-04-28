<?php

Route::group(array('module' => 'Companies', 'middleware' => 'auth:admin', 'namespace' => 'App\Modules\Companies\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::get($getUrl . '/manage-companies/manageCompany', 'CompaniesController@manageCompany');
    Route::get($getUrl . '/manage-companies/create', 'CompaniesController@create');
    Route::get($getUrl . '/manage-companies/manageBankAccount', 'CompaniesController@manageBankAccount');
    Route::post($getUrl . '/manage-companies/{{companyId}}/edit', 'CompaniesController@edit');
    Route::post($getUrl . '/manage-companies/loadCompanyData', 'CompaniesController@loadCompanyData');

    Route::post($getUrl . '/manage-companies/updateCompany', 'CompaniesController@updateCompany');
    Route::resource($getUrl . '/manage-companies', 'CompaniesController');
});
