<?php

Route::group(array('module' => 'Testimonials', 'middleware' => 'auth:admin','namespace' => 'App\Modules\Testimonials\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource($getUrl.'/testimonials', 'TestimonialsController'); 
    Route::post($getUrl.'/testimonials/getDisapproveList','TestimonialsController@getDisapproveList'); //get disapprove list
    Route::post($getUrl.'/testimonials/getApprovedList','TestimonialsController@getApprovedList'); //get approved list
    Route::post($getUrl.'/testimonials/getTestimonialData','TestimonialsController@getTestimonialData'); //on edit page, get data
    Route::get($getUrl.'/testimonials/create', 'TestimonialsController@create'); //view create page
    Route::get($getUrl.'/testimonials/manage', 'TestimonialsController@show'); //show approved list on manage page
    Route::get($getUrl.'/testimonials/{id}/edit','TestimonialsController@edit'); //show edit page on disapprove list
    Route::put($getUrl.'/testimonials/update/{id}','TestimonialsController@update');//update data on disapprove edit page
    Route::get($getUrl.'/testimonials/{id}/editApproved','TestimonialsController@editApproved');//update data on approved list
});	