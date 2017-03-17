<?php

Route::group(array('module' => 'DiscountHeadings', 'middleware' => ['api'], 'namespace' => 'App\Modules\DiscountHeadings\Controllers'), function() {

    Route::resource('DiscountHeadings', 'DiscountHeadingsController');
    
});	
