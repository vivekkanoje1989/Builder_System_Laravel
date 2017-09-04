<?php

Route::group(array('module' => 'DiscountHeadings', 'middleware' => ['auth:admin'],'namespace' => 'App\Modules\DiscountHeadings\Controllers'), function() {

     $getUrl = config('global.getUrl');
    Route::resource('/discount-headings', 'DiscountHeadingsController');
    Route::post('/discount-headings/manageDiscountHeading','DiscountHeadingsController@manageDiscountHeadings');
    Route::post('/discount-headings/filteredData', 'DiscountHeadingsController@filteredData');
     Route::get('/DiscountHeadings/showFilter', function () {
        return View::make('DiscountHeadings::showFilter');
    });
});	
