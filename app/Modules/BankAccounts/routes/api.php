<?php

Route::group(array('module' => 'BankAccounts', 'middleware' => ['api'], 'namespace' => 'App\Modules\BankAccounts\Controllers'), function() {

    Route::resource('BankAccounts', 'BankAccountsController');
    
});	
