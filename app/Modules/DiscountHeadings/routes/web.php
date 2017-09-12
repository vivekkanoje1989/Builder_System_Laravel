<?php

Route::group(array('module' => 'DiscountHeadings', 'middleware' => ['auth:admin'],'namespace' => 'App\Modules\DiscountHeadings\Controllers'), function() {

     $getUrl = config('global.getUrl');
    Route::get('/discount-headings/discountHeadingExportToxls','DiscountHeadingsController@discountHeadingExportToxls');
    Route::post('/discount-headings/manageDiscountHeading','DiscountHeadingsController@manageDiscountHeadings');
    Route::post('/discount-headings/filteredData', 'DiscountHeadingsController@filteredData');
    Route::post('/discount-headings/deleteDiscountHeading', 'DiscountHeadingsController@deleteDiscountHeading');
     Route::get('/DiscountHeadings/showFilter', function () {
        return View::make('DiscountHeadings::showFilter');
    });
    
    Route::resource('/discount-headings', 'DiscountHeadingsController');
});	
