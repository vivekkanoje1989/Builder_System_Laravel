<?php

Route::group(array('module' => 'ManageCountry', 'middleware' => ['api'], 'namespace' => 'App\Modules\ManageCountry\Controllers'), function() {

    Route::resource('ManageCountry', 'ManageCountryController');
    
});	
