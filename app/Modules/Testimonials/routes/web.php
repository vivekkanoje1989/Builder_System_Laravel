<?php

Route::group(array('module' => 'Testimonials', 'middleware' => ['auth:admin'],'namespace' => 'App\Modules\Testimonials\Controllers'), function() {

    Route::post('/testimonials/getDisapproveList','TestimonialsController@getDisapproveList')->middleware("permission:060301"); //get disapprove list
    Route::post('/testimonials/getApprovedList','TestimonialsController@getApprovedList')->middleware("permission:060302"); //get approved list
    Route::post('/testimonials/getTestimonialData','TestimonialsController@getTestimonialData')->middleware("permission:060301|060302"); //on edit page, get data
    Route::post('/testimonials/deleteDisApprovedList','TestimonialsController@deleteDisApprovedList')->middleware("permission:060301"); 
    Route::post('/testimonials/deleteApprovedList','TestimonialsController@deleteApprovedList')->middleware("permission:060302"); 
    Route::get('/testimonials/manageTestimonialDisapproveExportToExcel', 'TestimonialsController@manageTestimonialDisapproveExportToExcel')->middleware("permission:060301");
    Route::get('/testimonials/manageTestimonialApproveExportToExcel', 'TestimonialsController@manageTestimonialApproveExportToExcel')->middleware("permission:060302");
    Route::get('/testimonials/{id}/editApproved','TestimonialsController@editApproved')->middleware("permission:060302");//update data on approved list
    Route::get('/testimonials', 'TestimonialsController@index')->middleware("permission:060301"); 
    Route::get('/testimonials/create', 'TestimonialsController@create')->middleware("permission:060302");  //view create page
    Route::get('/testimonials/manage', 'TestimonialsController@show')->middleware("permission:060302"); //show approved list on manage page
    Route::post('/testimonials/', 'TestimonialsController@store')->middleware("permission:060302"); 
    Route::get('/testimonials/{id}/edit', 'TestimonialsController@edit')->middleware("permission:060301"); //show edit page on disapprove list
    Route::put('/testimonials/update/{id}', 'TestimonialsController@update')->middleware("permission:060301"); //update data on disapprove edit page
});	