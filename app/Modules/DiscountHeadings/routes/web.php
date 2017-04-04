<?php

Route::group(array('module' => 'DiscountHeadings', 'namespace' => 'App\Modules\DiscountHeadings\Controllers'), function() {

     $getUrl = config('global.getUrl');
    Route::resource($getUrl .'/discount-headings', 'DiscountHeadingsController');
    Route::post($getUrl . '/discount-headings/manageDiscountHeading','DiscountHeadingsController@manageDiscountHeadings');
    
});	
