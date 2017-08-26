<?php

Route::group(array('module' => 'PropertyPortals', 'middleware' => 'auth:admin', 'namespace' => 'App\Modules\PropertyPortals\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::get('/propertyportals/getAllEmployees', 'PropertyPortalsController@getAllEmployees'); // multi list employees
    Route::resource('/propertyportals', 'PropertyPortalsController');
    Route::post('/propertyportals/changePortalTypeStatus', 'PropertyPortalsController@changePortalTypeStatus'); //change protal type status
    Route::post('/propertyportals/changePortalAccountStatus', 'PropertyPortalsController@changePortalAccountStatus'); //change account status
    Route::post('/propertyportals/getProperyAlias', 'PropertyPortalsController@getProperyAlias'); //get property alias
    
        
    Route::get('/propertyportals/{id}/showPortalAccounts', 'PropertyPortalsController@showPortalAccounts'); //View account    
    Route::post('/propertyportals/properyPortalAccount', 'PropertyPortalsController@properyPortalAccount'); //List account
    Route::get('/propertyportals/{id}/createAccount', 'PropertyPortalsController@createAccount'); //View new portal account
    Route::post('/propertyportals/actionPortalAccount', 'PropertyPortalsController@actionPortalAccount'); //Create new portal account
    
    Route::post('/propertyportals/getupdatePortalAccount', 'PropertyPortalsController@getupdatePortalAccount');//edit Account view
    Route::get('/propertyportals/{portaltypeid}/{accountid}/updatePortalAccount', 'PropertyPortalsController@updatePortalAccount'); //update account
    
    
});	