<?php

Route::group(array('module' => 'PropertyPortals', 'namespace' => 'App\Modules\PropertyPortals\Controllers'), function() {
    $getUrl = config('global.getUrl');
    Route::resource($getUrl.'/propertyportals', 'PropertyPortalsController');
    Route::post($getUrl.'/propertyportals/changePortalTypeStatus', 'PropertyPortalsController@changePortalTypeStatus');
    Route::post($getUrl.'/propertyportals/changePortalAccountStatus', 'PropertyPortalsController@changePortalAccountStatus');
    Route::post($getUrl.'/propertyportals/properyPortalAccount', 'PropertyPortalsController@properyPortalAccount');
    Route::post($getUrl.'/propertyportals/getProperyAlias', 'PropertyPortalsController@getProperyAlias');
    Route::post($getUrl.'/propertyportals/createPortalAccount', 'PropertyPortalsController@createPortalAccount');
    Route::post($getUrl.'/propertyportals/getEditAccountsData', 'PropertyPortalsController@getEditAccountsData');
    Route::get($getUrl.'/propertyportals/{id}/showAccounts', 'PropertyPortalsController@showAccounts');
    Route::get($getUrl.'/propertyportals/{id}/createAccount', 'PropertyPortalsController@createAccount');
    Route::get($getUrl.'/propertyportals/{portaltypeid}/{accountid}/updatePortalAccount', 'PropertyPortalsController@updatePortalAccount');
});	