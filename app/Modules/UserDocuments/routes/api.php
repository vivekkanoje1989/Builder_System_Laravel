<?php

Route::group(array('module' => 'UserDocuments', 'middleware' => ['api'], 'namespace' => 'App\Modules\UserDocuments\Controllers'), function() {

    Route::resource('UserDocuments', 'UserDocumentsController');
    
});	
