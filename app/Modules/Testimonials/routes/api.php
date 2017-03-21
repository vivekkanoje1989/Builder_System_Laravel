<?php

Route::group(array('module' => 'Testimonials', 'middleware' => ['api'], 'namespace' => 'App\Modules\Testimonials\Controllers'), function() {

    Route::resource('Testimonials', 'TestimonialsController');
    
});	
