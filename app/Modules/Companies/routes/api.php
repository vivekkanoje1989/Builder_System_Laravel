<?php

Route::group(array('module' => 'Companies', 'middleware' => ['api'], 'namespace' => 'App\Modules\Companies\Controllers'), function() {

    Route::resource('companies', 'CompaniesController');
    
});	
