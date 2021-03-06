<?php

Route::group(array('module' => 'EmployeeDocuments', 'middleware' => ['auth:admin'], 'namespace' => 'App\Modules\EmployeeDocuments\Controllers'), function() {

    $getUrl = config("global.getUrl");
    Route::get('/employee-document/manageDocumentExportToExcel', 'EmployeeDocumentsController@manageDocumentExportToExcel');
    Route::get('/employee-document/employeeDocuments', 'EmployeeDocumentsController@employeeDocuments');
    Route::post('/employee-document/deleteEmployeeDocuments', 'EmployeeDocumentsController@deleteEmployeeDocuments');
    Route::resource('/employee-document', 'EmployeeDocumentsController');
});
