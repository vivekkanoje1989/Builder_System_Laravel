<?php

   Route::group(array('module' => 'BmsLists', 'namespace' => 'App\Modules\BmsLists\Controllers'), function() {
    $getUrl = config('global.getUrl');

    Route::resource('bms_lists', 'BloodGroupsController');
    Route::get($getUrl.'/bms_lists/bloodGroup', 'BloodGroupsController@index');Route::get($getUrl.'/bms_lists/manageBloodGroup','BloodGroupsController@manageBloodGroup');
    Route::post($getUrl.'/bms_lists/createBloodGroup','BloodGroupsController@createBloodGroup');
    Route::post($getUrl.'/bms_lists/updateBloodGroup','BloodGroupsController@updateBloodGroup');

   
    Route::get($getUrl.'/bms_lists/country','ManageCountryController@index');
    Route::get($getUrl.'/bms_lists/manageCountry','ManageCountryController@manageCountry');
    Route::post($getUrl.'/bms_lists/createCountry','ManageCountryController@createCountry');
    Route::post($getUrl.'/bms_lists/updateCountry','ManageCountryController@updateCountry'); 

   
    Route::get($getUrl.'/bms_lists/states','ManageStatesController@index');
    Route::get($getUrl.'/bms_lists/manageStates','ManageStatesController@manageStates');
    Route::post($getUrl.'/bms_lists/createStates','ManageStatesController@createStates');
    Route::post($getUrl.'/bms_lists/updateStates','ManageStatesController@updateStates'); 


    Route::get($getUrl.'/bms_lists/cities','ManageCitiesController@index');
    Route::get($getUrl.'/bms_lists/manageCities','ManageCitiesController@manageCities');
    Route::post($getUrl.'/bms_lists/createCities','ManageCitiesController@createCities');
    Route::post($getUrl.'/bms_lists/updatecities','ManageCitiesController@updateCities'); 


    Route::get($getUrl.'/bms_lists/location','ManageLocationController@index');
    Route::get($getUrl.'/bms_lists/manageLocation','ManageLocationController@manageLocation');
    Route::post($getUrl.'/bms_lists/createLocation','ManageLocationController@createLocation');
    Route::post($getUrl.'/bms_lists/updateLocation','ManageLocationController@updateLocation');

    Route::get($getUrl.'/bms_lists/highestEducation', 'HighestEducationController@index');
    Route::get($getUrl.'/bms_lists/manageHighestEducation','HighestEducationController@manageHighestEducation');
    Route::post($getUrl.'/bms_lists/createHighestEducation','HighestEducationController@createHighestEducation');
    Route::post($getUrl.'/bms_lists/updateHighestEducation','HighestEducationController@updateHighestEducation'); 


    Route::get($getUrl.'/bms_lists/department', 'ManageDepartmentController@index');
    Route::get($getUrl.'/bms_lists/manageDepartment','ManageDepartmentController@manageDepartment');
    Route::post($getUrl.'/bms_lists/createDepartment','ManageDepartmentController@createDepartment');
    Route::post($getUrl.'/bms_lists/updateDepartment','ManageDepartmentController@updateDepartment'); 


    Route::get($getUrl.'/bms_lists/profession', 'ManageProfessionController@index');
    Route::get($getUrl.'/bms_lists/manageProfession','ManageProfessionController@manageProfession');
    Route::post($getUrl.'/bms_lists/createProfession','ManageProfessionController@createProfession');
    Route::post($getUrl.'/bms_lists/updateProfession','ManageProfessionController@updateProfession'); 

    Route::get($getUrl.'/bmslists/lostreason', 'LostReasonsController@index');
    Route::post($getUrl.'/bmslists/manageLostReasons', 'LostReasonsController@manageLostReasons'); 
    Route::post($getUrl.'/bmslists/updateLostReasons', 'LostReasonsController@updateLostReasons');
    Route::post($getUrl.'/bmslists/createLostReasons', 'LostReasonsController@createLostReasons');


    Route::get($getUrl.'/bms_lists/blockstages','BlockStagesController@index');
    Route::post($getUrl.'/bms_lists/manageBlockStages','BlockStagesController@manageBlockStages'); 
    Route::post($getUrl.'/bms_lists/updateBlockStage','BlockStagesController@updateBlockStage');
    Route::post($getUrl.'/bms_lists/createBlockStages','BlockStagesController@createBlockStages');

    Route::get($getUrl.'/bms_lists/enquirysource','EnquirySourceController@index');
    Route::post($getUrl.'/bms_lists/manageEnquirySource','EnquirySourceController@manageEnquirySource'); 
    Route::post($getUrl.'/bms_lists/manageSubEnquirySource','EnquirySourceController@manageSubEnquirySource'); 
    Route::post($getUrl.'/bms_lists/updateSubEnquirySource','EnquirySourceController@updateSubEnquirySource');
    Route::post($getUrl.'/bms_lists/createEnquirySource','EnquirySourceController@createEnquirySource');
    Route::post($getUrl.'/bms_lists/createsubEnquirySource','EnquirySourceController@createsubEnquirySource');


    Route::get($getUrl.'/bms_lists/discountheading','ManageDiscountHeadingController@index');
    Route::post($getUrl.'/bms_lists/manageDiscountHeading','ManageDiscountHeadingController@manageDiscountHeading'); 
    Route::post($getUrl.'/bms_lists/updateDiscountHeading','ManageDiscountHeadingController@updateDiscountHeading');
    Route::post($getUrl.'/bms_lists/createDiscountHeading','ManageDiscountHeadingController@createDiscountHeading');


    Route::get($getUrl.'/bms_lists/projectpayment','ManageProjectPaymentController@index');
    Route::post($getUrl.'/bms_lists/manageProjectPaymentStages','ManageProjectPaymentController@manageProjectPaymentStages'); 
    Route::post($getUrl.'/bms_lists/updateProjectPaymentStages','ManageProjectPaymentController@updateProjectPaymentStages');
    Route::post($getUrl.'/bms_lists/createProjectPaymentStages ','ManageProjectPaymentController@createProjectPaymentStages');
    
    Route::get($getUrl.'/bms_lists/projecttypes','ManageProjectTypesController@index');
    Route::post($getUrl.'/bms_lists/manageProjectTypes','ManageProjectTypesController@manageProjectTypes'); 
    Route::post($getUrl.'/bms_lists/updateProjectTypes','ManageProjectTypesController@updateProjectTypes');
    Route::post($getUrl.'/bms_lists/createProjectTypes','ManageProjectTypesController@createProjectTypes');
    
    
    Route::get($getUrl.'/bms_lists/blockTypes','ManageBlockTypesController@index');
    Route::post($getUrl.'/bms_lists/manageBlockTypes','ManageBlockTypesController@manageBlockTypes'); 
    Route::post($getUrl.'/bms_lists/updateBlockTypes','ManageBlockTypesController@updateBlockTypes');
    Route::post($getUrl.'/bms_lists/createBlockTypes','ManageBlockTypesController@createBlockTypes');
    
    
    Route::get($getUrl.'/bms_lists/paymentheading','ManagePaymentHeadingController@index');
    Route::post($getUrl.'/bms_lists/managePaymentHeading','ManagePaymentHeadingController@managePaymentHeading'); 
    Route::post($getUrl.'/bms_lists/updatePaymentHeading','ManagePaymentHeadingController@updatePaymentHeading');
    Route::post($getUrl.'/bms_lists/createPaymentHeading','ManagePaymentHeadingController@createPaymentHeading');

});	 
   