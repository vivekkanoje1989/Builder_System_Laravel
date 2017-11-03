<?php

Route::group(array('module' => 'Api', 'middleware' => ['api'], 'namespace' => 'App\Modules\Api\Controllers'), function() {
    
       Route::get('api/pushapi/BmsPushApi', 'ApiController@actionIndex');

});	
