<?php

Route::group(array('module' => 'EmployeeDocuments',  'middleware' => 'auth:admin', 'namespace' => 'App\Modules\EmployeeDocuments\Controllers'), function() {

    $getUrl = config("global.getUrl");
   
    Route::get($getUrl.'/employee-document/employeeDocuments', 'EmployeeDocumentsController@employeeDocuments');
   
    Route::resource($getUrl.'/employee-document', 'EmployeeDocumentsController');
});	
