<?php

Route::group(array('module' => 'Testimonials', 'middleware' => ['auth:admin'],'namespace' => 'App\Modules\Testimonials\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource('/testimonials', 'TestimonialsController'); 
    Route::post('/testimonials/getDisapproveList','TestimonialsController@getDisapproveList'); //get disapprove list
    Route::post('/testimonials/getApprovedList','TestimonialsController@getApprovedList'); //get approved list
    Route::post('/testimonials/getTestimonialData','TestimonialsController@getTestimonialData'); //on edit page, get data
    Route::get('/testimonials/create', 'TestimonialsController@create'); //view create page
    Route::get('/testimonials/manage', 'TestimonialsController@show'); //show approved list on manage page
    Route::get('/testimonials/{id}/edit','TestimonialsController@edit'); //show edit page on disapprove list
    Route::put('/testimonials/update/{id}','TestimonialsController@update');//update data on disapprove edit page
    Route::get('/testimonials/{id}/editApproved','TestimonialsController@editApproved');//update data on approved list
});	