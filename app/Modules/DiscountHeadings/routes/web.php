<?php

Route::group(array('module' => 'DiscountHeadings', 'middleware' => 'auth:admin','namespace' => 'App\Modules\DiscountHeadings\Controllers'), function() {

     $getUrl = config('global.getUrl');
    Route::resource($getUrl .'/discount-headings', 'DiscountHeadingsController');
    Route::post($getUrl . '/discount-headings/manageDiscountHeading','DiscountHeadingsController@manageDiscountHeadings');
    
});	
