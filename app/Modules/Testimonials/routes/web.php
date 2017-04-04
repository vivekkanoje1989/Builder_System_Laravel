<?php

Route::group(array('module' => 'Testimonials', 'middleware' => 'auth:admin','namespace' => 'App\Modules\Testimonials\Controllers'), function() {

    $getUrl = config('global.getUrl');
    Route::resource($getUrl.'/testimonials-approve', 'TestimonialsController');
    Route::get($getUrl.'/testimonials-create', 'TestimonialsController@create');
    Route::get($getUrl.'/testimonials-manage', 'TestimonialsController@manage');
    Route::post($getUrl.'/testimonials/approve','TestimonialsController@getApproveTestimonials');
     
    Route::get($getUrl.'/testimonial-approve/{id}/edit','TestimonialsController@edit');
    Route::post($getUrl.'/testimonials-approve/update','TestimonialsController@update');
   
    Route::post($getUrl.'/testimonials-approve/getTestimonialData','TestimonialsController@getTestimonialData');
    Route::get($getUrl.'/testimonial-manage/{id}/manageEdit','TestimonialsController@manageEdit');
    
     Route::post($getUrl.'/testimonials-approve/manageApproved','TestimonialsController@manageApprovedTestimonials');
     
   
});	