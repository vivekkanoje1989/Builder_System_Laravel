<?php

Route::group(array('module' => 'BankAccounts', 'namespace' => 'App\Modules\BankAccounts\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::get($getUrl . '/bank-account/manageBankAccount', 'BankAccountsController@manageBankAccount');
    Route::get($getUrl . '/bank-account/managePaymentHeading', 'BankAccountsController@managePaymentHeading');
    Route::get($getUrl . '/bank-accounts/getCompany', 'BankAccountsController@getCompany');
    Route::post($getUrl . '/bank-accounts/paymentHeadingEdit', 'BankAccountsController@paymentHeadingEdit');
    Route::post($getUrl . '/bank-accounts/paymentHeadingFiltered', 'BankAccountsController@paymentHeadingFiltered');
    Route::resource($getUrl . '/bank-accounts', 'BankAccountsController');
});
