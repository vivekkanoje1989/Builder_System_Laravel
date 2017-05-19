<?php

Route::group(array('module' => 'Marketing', 'namespace' => 'App\Modules\Marketing\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::resource($getUrl.'/promotionalsms', 'PromotionalSMSController');
    
});	