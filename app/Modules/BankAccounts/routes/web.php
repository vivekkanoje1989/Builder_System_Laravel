<?php

Route::group(array('module' => 'BankAccounts', 'middleware' => ['auth:admin'],'namespace' => 'App\Modules\BankAccounts\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::get('/bank-account/manageBankAccount', 'BankAccountsController@manageBankAccount');
    Route::get('/bank-account/managePaymentHeading', 'BankAccountsController@managePaymentHeading');
    Route::get('/bank-accounts/getCompany', 'BankAccountsController@getCompany');
    Route::post('/bank-accounts/paymentHeadingEdit', 'BankAccountsController@paymentHeadingEdit');
    Route::post('/bank-accounts/paymentHeadingFiltered', 'BankAccountsController@paymentHeadingFiltered');
    Route::resource('/bank-accounts', 'BankAccountsController');
});
