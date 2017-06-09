<?php

Route::group(array('module' => 'Marketing', 'middleware' => ['auth:admin'],'namespace' => 'App\Modules\Marketing\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::resource('/promotionalsms', 'PromotionalSMSController');
    
});	