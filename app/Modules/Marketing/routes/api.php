<?php
Route::group(array('module' => 'Marketing', 'middleware' => ['api'], 'namespace' => 'App\Modules\Marketing\Controllers'), function() {

    Route::post('api/promotionalsms', 'PromotionalSMSController@store');
    Route::post('api/promotionalsms/fileUpload', 'PromotionalSMSController@fileUpload');
});