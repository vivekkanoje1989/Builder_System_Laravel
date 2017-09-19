<?php

Route::group(array('module' => 'Testimonials', 'middleware' => ['auth:admin'],'namespace' => 'App\Modules\Testimonials\Controllers'), function() {

    Route::post('/testimonials/getDisapproveList','TestimonialsController@getDisapproveList'); //get disapprove list
    Route::post('/testimonials/getApprovedList','TestimonialsController@getApprovedList'); //get approved list
    Route::post('/testimonials/getTestimonialData','TestimonialsController@getTestimonialData'); //on edit page, get data
    Route::post('/testimonials/deleteDisApprovedList','TestimonialsController@deleteDisApprovedList'); 
    Route::post('/testimonials/deleteApprovedList','TestimonialsController@deleteApprovedList'); 
    Route::get('/testimonials/create', 'TestimonialsController@create'); //view create page
    Route::get('/testimonials/manageTestimonialDisapproveExportToExcel', 'TestimonialsController@manageTestimonialDisapproveExportToExcel');
    Route::get('/testimonials/manageTestimonialApproveExportToExcel', 'TestimonialsController@manageTestimonialApproveExportToExcel');
    Route::get('/testimonials/manage', 'TestimonialsController@show'); //show approved list on manage page
    Route::get('/testimonials/{id}/edit','TestimonialsController@edit'); //show edit page on disapprove list
    Route::put('/testimonials/update/{id}','TestimonialsController@update');//update data on disapprove edit page
    Route::get('/testimonials/{id}/editApproved','TestimonialsController@editApproved');//update data on approved list
//    Route::resource('/testimonials', 'TestimonialsController'); 
    Route::get('/testimonials', 'TestimonialsController@index')->middleware("permission:060301"); 
    Route::get('/testimonials/create', 'TestimonialsController@create')->middleware("permission:060301"); 
    Route::get('/testimonials/show', 'TestimonialsController@show')->middleware("permission:060301"); 
    Route::post('/testimonials/', 'TestimonialsController@store')->middleware("permission:060301"); 
    Route::get('/testimonials/{id}/edit', 'TestimonialsController@edit')->middleware("permission:060301"); 
    Route::put('/testimonials/update/{id}', 'TestimonialsController@update')->middleware("permission:060301"); 
});	