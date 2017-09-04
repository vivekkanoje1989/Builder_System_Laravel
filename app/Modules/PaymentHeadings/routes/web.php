<?php

Route::group(array('module' => 'PaymentHeadings', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\PaymentHeadings\Controllers'), function() {

    $getUrl = config('global.getUrl');

    Route::post('/payment-headings/managePaymentHeading', 'PaymentHeadingsController@managePaymentHeading');
    Route::post('/payment-headings/manageProjectTypes ', 'PaymentHeadingsController@manageProjectTypes');
    Route::post('/payment-headings/filteredData', 'PaymentHeadingsController@filteredData');
    Route::resource('/payment-headings', 'PaymentHeadingsController');
    Route::get('/PaymentHeadings/showFilter', function () {
        return View::make('PaymentHeadings::showFilter');
    });
});
