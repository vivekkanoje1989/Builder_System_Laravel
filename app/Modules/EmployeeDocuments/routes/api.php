<?php

Route::group(array('module' => 'EmployeeDocuments', 'middleware' => ['api'], 'namespace' => 'App\Modules\EmployeeDocuments\Controllers'), function() {

    Route::resource('EmployeeDocuments', 'EmployeeDocumentsController');
    
});	
