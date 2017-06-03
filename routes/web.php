<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of the routes that are handled
  | by your application. Just tell Laravel the URIs it should respond
  | to using a Closure or controller method. Build something great!
  |
 */
$getUrl = config('global.getUrl');
$getWebsiteUrl = config('global.getWebsiteUrl');

Route::get('/', function () {
    return View::make('backendApp');
});
Route::get($getUrl . '/error500', function () {
    return view('layouts.backend.error500');
});
Route::post($getUrl . '/checkUserCredentials', 'backend\Auth\LoginController@checkUserCredentials');
Route::get($getUrl . '/layout', function () {
    return view('layouts.backend.layout');
});
Route::get($getWebsiteUrl . '/websitelayout', function () {
    return view('layouts.frontend.main');
});
Route::get($getUrl . '/dashboard', function () {
    return View::make('layouts.backend.dashboard');
});
Route::get($getUrl . '/loading', function () {
    return View::make('layouts.backend.loading');
});
Route::get($getUrl . '/navbar', function () {
    return View::make('layouts.backend.navbar');
});
Route::get($getUrl . '/sidebar', function () {
    return View::make('layouts.backend.sidebar');
});
Route::get($getUrl . '/chatbar', function () {
    return View::make('layouts.backend.chatbar');
});
Route::get($getUrl . '/breadcrumbs', function () {
    return View::make('layouts.backend.breadcrumbs');
});
Route::get($getUrl . '/header', function () {
    return View::make('layouts.backend.header');
});
Route::get($getUrl . '/getToken', 'backend\Auth\LoginController@getToken');

Route::group(['middleware' => ['web']], function () {
    $getUrl = config('global.getUrl');
    
    // ADMIN
    Route::get($getUrl . '/session', 'backend\Auth\LoginController@getSession');
    Route::get($getUrl . '/sessiontimeout', 'backend\AdminController@sessiontimeout');
    Route::get($getUrl . '/login', 'backend\Auth\LoginController@getLoginForm');
    Route::post($getUrl . '/authenticate', 'backend\Auth\LoginController@authenticate');

    Route::get($getUrl . '/register', 'backend\Auth\RegisterController@getRegisterForm');
    Route::post($getUrl . '/saveRegister', 'backend\Auth\RegisterController@saveRegisterForm');
    // Forget Password 
    Route::get($getUrl . '/password/resetLink/{request}', 'backend\Auth\ForgotPasswordController@showLinkRequestForm', function ($request = 'admin') {
        return $request;
    });
    Route::post($getUrl . '/password/email', 'backend\Auth\ForgotPasswordController@sendResetLinkEmail');
    // Reset Password
    Route::get($getUrl . '/password/reset/{token}/{checkState?}', 'backend\Auth\ResetPasswordController@showResetForm');
    Route::post($getUrl . '/password/reset', 'backend\Auth\ResetPasswordController@reset');
    
    //Website frontend
    $getWebsiteUrl = config('global.getWebsiteUrl');
    
    Route::get($getWebsiteUrl . '/','frontend\UserController@index');
    Route::get($getWebsiteUrl . '/index', 'frontend\UserController@index');
    Route::get($getWebsiteUrl . '/about', 'frontend\UserController@about');
    Route::get($getWebsiteUrl . '/career', 'frontend\UserController@career');    
    Route::post($getWebsiteUrl . '/register_applicant', 'frontend\UserController@register_applicant');
    Route::get($getWebsiteUrl . '/jobPost', 'frontend\UserController@jobPost');    
    Route::get($getWebsiteUrl . '/background', 'frontend\UserController@getBackGroundImages');    
    Route::get($getWebsiteUrl . '/contact', 'frontend\UserController@contact');    
    Route::get($getWebsiteUrl. '/testimonials','frontend\UserController@testimonials');
    Route::get($getWebsiteUrl . '/projects', 'frontend\UserController@projects');    
    Route::get($getWebsiteUrl . '/getProjectsAllProjects', 'frontend\UserController@getProjectsAllProjects');
    Route::get($getWebsiteUrl . '/project-details/{projectId}', 'frontend\UserController@projectdetails');    
    Route::post($getWebsiteUrl . '/getProjectDetails', 'frontend\UserController@getProjectDetails');    
    Route::post($getWebsiteUrl . '/getAvailbility', 'frontend\UserController@getAvailbility');    
    Route::get($getWebsiteUrl . '/getCurrentProjectDetails', 'frontend\UserController@getCurrentProjectDetails');    
    Route::get($getWebsiteUrl . '/getContactDetails', 'frontend\UserController@getContactDetails');   
    Route::get($getWebsiteUrl . '/getAboutPageContent', 'frontend\UserController@getAboutPageContent');    
    Route::get($getWebsiteUrl . '/getEmployees', 'frontend\UserController@getEmployees');    
    Route::get($getWebsiteUrl . '/getTestimonials', 'frontend\UserController@getTestimonials');    
    Route::get($getWebsiteUrl . '/getMenus','frontend\UserController@getMenus');    
    Route::get($getWebsiteUrl . '/getCareers','frontend\UserController@getCareers');    
    Route::get($getWebsiteUrl . '/testimonials','frontend\UserController@testimonials');    
    Route::get($getWebsiteUrl . '/blog','frontend\UserController@blog');    
    Route::get($getWebsiteUrl . '/blog-details/{blogId}','frontend\UserController@blogdetails');    
    Route::get($getWebsiteUrl . '/getBlogs','frontend\UserController@getBlogs');    
    Route::post($getWebsiteUrl . '/create_testimonials','frontend\UserController@create_testimonials');    
    Route::post($getWebsiteUrl . '/getBlogDetails','frontend\UserController@getBlogDetails');    
    Route::get($getWebsiteUrl . '/news','frontend\UserController@news');        
    Route::get($getWebsiteUrl . '/getNews','frontend\UserController@getNews');    
    Route::get($getWebsiteUrl . '/news-details/{newsId}','frontend\UserController@newsdetails');    
    Route::post($getWebsiteUrl . '/getNewsDetails','frontend\UserController@getNewsDetails');    
    Route::get($getWebsiteUrl . '/press-release','frontend\UserController@press_release');        
    Route::get($getWebsiteUrl . '/getpressRelease','frontend\UserController@getpressRelease');    
    Route::get($getWebsiteUrl . '/press-release-details/{Id}','frontend\UserController@press_release_details');    
    Route::post($getWebsiteUrl . '/getpressReleaseDetails','frontend\UserController@getpressReleaseDetails');    
    Route::get($getWebsiteUrl . '/events','frontend\UserController@events');        
    Route::get($getWebsiteUrl . '/getEvents','frontend\UserController@getEvents');    
    Route::get($getWebsiteUrl . '/event-details/{id}','frontend\UserController@eventDetails');    
    Route::post($getWebsiteUrl . '/getEventDetails','frontend\UserController@getEventDetails');    
    Route::get($getWebsiteUrl . '/testimonial/{id}','frontend\UserController@testimonialdetail');    
    Route::post($getWebsiteUrl . '/getTestimonialDetails','frontend\UserController@getTestimonialDetails');    
    Route::get($getWebsiteUrl . '/enquiry/{id}','frontend\UserController@enquiry');
});

Route::group(['middleware' => ['auth:admin']], function () {
    $getUrl = config('global.getUrl');
    /*************************** Admin Dashboard ****************************/
    Route::get($getUrl . '/dashboard', 'backend\AdminController@dashboard');
    Route::post($getUrl . '/logout', 'backend\Auth\LoginController@getLogout');

    /***********************************************************************/
    Route::get($getUrl . '/getMenuItems', 'backend\AdminController@getMenuItems');
    Route::get($getUrl . '/getTitle', 'backend\AdminController@getTitle');
    Route::get($getUrl . '/getGender', 'backend\AdminController@getGender');
    Route::get($getUrl . '/getBloodGroup', 'backend\AdminController@getBloodGroup');
    Route::get($getUrl . '/getDepartments', 'backend\AdminController@getDepartments');
    Route::get($getUrl . '/getEducationList', 'backend\AdminController@getEducationList');
    Route::get($getUrl . '/getProfessionList', 'backend\AdminController@getProfessionList');
    Route::get($getUrl . '/getCountries', 'backend\AdminController@getCountries');
    Route::get($getUrl . '/getWebPageList', 'backend\AdminController@getWebPageList'); //uma 
    Route::get($getUrl . '/getPropertyPortalType', 'backend\AdminController@getPropertyPortalType'); //uma 
    Route::get($getUrl . '/getVerticals', 'backend\AdminController@getVerticals'); //uma  
    Route::get($getUrl . '/getFinanceTieupAgency', 'backend\AdminController@getFinanceTieupAgency'); //uma
    Route::get($getUrl . '/getDesignations', 'backend\AdminController@getDesignations'); //geeta
    Route::get($getUrl . '/getProjects', 'backend\AdminController@getProjects'); //geeta
    Route::get($getUrl . '/getCompany', 'backend\AdminController@getCompany'); //geeta
    Route::get($getUrl . '/getStationary', 'backend\AdminController@getStationary'); //geeta
    Route::get($getUrl . '/getEnquirySource', 'backend\AdminController@getEnquirySource');
    Route::get($getUrl . '/getSalesEnqCategory', 'backend\AdminController@getSalesEnqCategory'); //geeta    
    Route::get($getUrl . '/getSalesEnqStatus', 'backend\AdminController@getSalesEnqStatus'); //geeta    
    Route::get($getUrl . '/getAmenitiesList', 'backend\AdminController@getAmenitiesList'); //geeta
    Route::get($getUrl . '/getChannelList', 'backend\AdminController@getChannelList'); //geeta
    
    Route::post($getUrl . '/getBlockTypes', 'backend\AdminController@getBlockTypes'); //geeta
    Route::post($getUrl . '/getSubBlocks', 'backend\AdminController@getSubBlocks'); //geeta
    Route::post($getUrl . '/getStates', 'backend\AdminController@getStates');
    Route::post($getUrl . '/getCities', 'backend\AdminController@getCities');
    Route::post($getUrl . '/getLocations', 'backend\AdminController@getLocations');
    Route::post($getUrl . '/checkUniqueEmail', 'backend\AdminController@checkUniqueEmail');    
    Route::post($getUrl . '/getEnquirySubSource', 'backend\AdminController@getEnquirySubSource');        
    Route::post($getUrl . '/getSalesEnqSubStatus', 'backend\AdminController@getSalesEnqSubStatus'); //geeta
    Route::post($getUrl . '/getSalesEnqSubCategory', 'backend\AdminController@getSalesEnqSubCategory'); //geeta
    
    /***********************************MANDAR*******************************/
    Route::get($getUrl . '/getClient', 'backend\AdminController@getClient');
    Route::get($getUrl . '/getVehiclebrands', 'backend\AdminController@getVehiclebrands');
    Route::get($getUrl . '/getVehiclemodels', 'backend\AdminController@getVehiclemodels');
    Route::get($getUrl . '/getEmployees', 'backend\AdminController@getEmployees');

    /***********************************MANDAR*******************************/

    Route::get($getUrl . '/databoxes', function () {
        return View::make('backend.databoxes');
    });
    Route::get($getUrl . '/widgets', function () {
        return View::make('backend.widgets');
    });
});

Route::group(['middleware' => ['user']], function () {
    Route::post('user/logout', 'frontend\Auth\LoginController@getLogout');
    Route::get('user/dashboard', 'frontend\UserController@dashboard');
});
