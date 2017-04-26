<?php

Route::group(array('module' => 'PropertyPortals', 'middleware' => 'auth:admin', 'namespace' => 'App\Modules\PropertyPortals\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::get($getUrl.'/propertyportals/getAllEmployees', 'PropertyPortalsController@getAllEmployees'); // multi list employees
    Route::resource($getUrl.'/propertyportals', 'PropertyPortalsController');
    Route::post($getUrl.'/propertyportals/changePortalTypeStatus', 'PropertyPortalsController@changePortalTypeStatus'); //change protal type status
    Route::post($getUrl.'/propertyportals/changePortalAccountStatus', 'PropertyPortalsController@changePortalAccountStatus'); //change account status
    Route::post($getUrl.'/propertyportals/getProperyAlias', 'PropertyPortalsController@getProperyAlias'); //get property alias
    
        
    Route::get($getUrl.'/propertyportals/{id}/showPortalAccounts', 'PropertyPortalsController@showPortalAccounts'); //View account    
    Route::post($getUrl.'/propertyportals/properyPortalAccount', 'PropertyPortalsController@properyPortalAccount'); //List account
    Route::get($getUrl.'/propertyportals/{id}/createAccount', 'PropertyPortalsController@createAccount'); //View new portal account
    Route::post($getUrl.'/propertyportals/actionPortalAccount', 'PropertyPortalsController@actionPortalAccount'); //Create new portal account
    
    Route::post($getUrl.'/propertyportals/getupdatePortalAccount', 'PropertyPortalsController@getupdatePortalAccount');//edit Account view
    Route::get($getUrl.'/propertyportals/{portaltypeid}/{accountid}/updatePortalAccount', 'PropertyPortalsController@updatePortalAccount'); //update account
    
    
});	