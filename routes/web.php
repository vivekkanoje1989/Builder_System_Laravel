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
Route::get('/error500', function () {
    return view('layouts.backend.error500');
});
Route::get('/error401', function () {
    return view('layouts.backend.error401');
});
Route::get('/undercConstruction', function () {
    return view('layouts.backend.pageUnderConstruction');
});
Route::post('/checkUserCredentials', 'backend\Auth\LoginController@checkUserCredentials');
Route::post('/getforgotpassword', 'backend\Auth\LoginController@getforgotpassword');
Route::get('/layout', function () {
    return view('layouts.backend.layout');
});
Route::get('/dashboard', function () {
    return View::make('layouts.backend.dashboard');
});
Route::get('/loading', function () {
    return View::make('layouts.backend.loading');
});
Route::get('/navbar', function () {
    return View::make('layouts.backend.navbar');
});
Route::get('/sidebar', function () {
    return View::make('layouts.backend.sidebar');
});
Route::get('/chatbar', function () {
    return View::make('layouts.backend.chatbar');
});
Route::get('/breadcrumbs', function () {
    return View::make('layouts.backend.breadcrumbs');
});
Route::get('/header', function () {
    return View::make('layouts.backend.header');
});
Route::get('/getToken', 'backend\Auth\LoginController@getToken');

Route::get('website/geeta', function () {
    echo "hhh";
    return View::make('website');
});
Route::group(['middleware' => ['web']], function () {
    $getUrl = config('global.getUrl');

    // ADMIN
    Route::get('/session', 'backend\Auth\LoginController@getSession');
    Route::get('/sessiontimeout', 'backend\AdminController@sessiontimeout');
    Route::get('/login', 'backend\Auth\LoginController@getLoginForm');
    Route::post('/authenticate', 'backend\Auth\LoginController@authenticate');

    Route::get('/register', 'backend\Auth\RegisterController@getRegisterForm');
    Route::post('/saveRegister', 'backend\Auth\RegisterController@saveRegisterForm');
    // Forget Password 
    Route::get('/password/resetLink/{request}', 'backend\Auth\ForgotPasswordController@showLinkRequestForm', function ($request = 'admin') {
        return $request;
    });
    Route::post('/password/email', 'backend\Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/getforgotpassword', 'backend\Auth\LoginController@getforgotpassword');
    // Reset Password
    Route::get('/password/reset/{token}/{checkState?}', 'backend\Auth\ResetPasswordController@showResetForm');
    Route::post('/password/reset', 'backend\Auth\ResetPasswordController@reset');

    //Website frontend
    $frontActions = ["/index", "/about", "/careers", "/blogs", "/contact", "/testimonials", "/projects", "/project-details/{projectId}", "/blog-details/{blogId}",
        "/news", "/news-details/{newsId}", "/press-release", "/events", "/scheduleTestDrive", "/sendwebEnquiry", "/sendwebContact", "/insurance",
        "/sendJobpost", "/sendcontact", "/addAppointment", "/getservicelocation", "getfCities", "getfCountries", "/sendInsurance", "/customerform/{id}", "/scheduletestdriveform/{id}", "getfGender", "getfProfession", '/getemployeedetails/{id}', '/registration/{id}', '/getfBloodGroup', '/getfEducationList', '/thanking-you', '/compassdetails',
        '/getnextfollowupTime', "/index/{id}", '/about/{id}'];

    if (in_array(\Request::server('REQUEST_URI'), $frontActions)) {
        Route::get('/{param}', 'frontend\UserController@onPageReload');
    }
//echo "=".\Request::server('REQUEST_URI');exit;    
    $getWebsiteUrl = config('global.getWebsiteUrl');
    Route::get($getWebsiteUrl . '/index', 'frontend\UserController@index');
    Route::get($getWebsiteUrl . '/about', 'frontend\UserController@about');
    Route::get($getWebsiteUrl . '/careers', 'frontend\UserController@career');
    Route::post($getWebsiteUrl . '/register_applicant', 'frontend\UserController@register_applicant');
    Route::post($getWebsiteUrl . '/addContact', 'frontend\UserController@addContact');
    //Route::post($getWebsiteUrl . '/saveContact', 'frontend\UserController@saveContact');
    Route::get($getWebsiteUrl . '/registration/{id}', 'frontend\UserController@registration');
    Route::get($getWebsiteUrl . '/jobPost', 'frontend\UserController@jobPost');
    Route::get($getWebsiteUrl . '/background', 'frontend\UserController@getBackGroundImages');
    Route::get($getWebsiteUrl . '/contact', 'frontend\UserController@contact');
    Route::get($getWebsiteUrl . '/testimonials', 'frontend\UserController@testimonials');
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
    Route::get($getWebsiteUrl . '/getMenus', 'frontend\UserController@getMenus');
    Route::get($getWebsiteUrl . '/getCareers', 'frontend\UserController@getCareers');
    Route::get($getWebsiteUrl . '/testimonials', 'frontend\UserController@testimonials');
    Route::get($getWebsiteUrl . '/blogs', 'frontend\UserController@blog');
    Route::get($getWebsiteUrl . '/blog-details/{blogId}', 'frontend\UserController@blogdetails');
    Route::get($getWebsiteUrl . '/getBlogs', 'frontend\UserController@getBlogs');
    Route::post($getWebsiteUrl . '/create_testimonials', 'frontend\UserController@create_testimonials');
    Route::post($getWebsiteUrl . '/getBlogDetails', 'frontend\UserController@getBlogDetails');
    Route::get($getWebsiteUrl . '/news', 'frontend\UserController@news');
    Route::get($getWebsiteUrl . '/getNews', 'frontend\UserController@getNews');
    Route::get($getWebsiteUrl . '/news-details/{newsId}', 'frontend\UserController@newsdetails');
    Route::post($getWebsiteUrl . '/getNewsDetails', 'frontend\UserController@getNewsDetails');
    Route::get($getWebsiteUrl . '/press-release', 'frontend\UserController@press_release');
    Route::get($getWebsiteUrl . '/getpressRelease', 'frontend\UserController@getpressRelease');
    Route::get($getWebsiteUrl . '/press-release-details/{Id}', 'frontend\UserController@press_release_details');
    Route::post($getWebsiteUrl . '/getpressReleaseDetails', 'frontend\UserController@getpressReleaseDetails');
    Route::get($getWebsiteUrl . '/events', 'frontend\UserController@events');
    Route::get($getWebsiteUrl . '/getEvents', 'frontend\UserController@getEvents');
    Route::get($getWebsiteUrl . '/event-details/{id}', 'frontend\UserController@eventDetails');
    Route::post($getWebsiteUrl . '/getEventDetails', 'frontend\UserController@getEventDetails');
    Route::get($getWebsiteUrl . '/testimonial/{id}', 'frontend\UserController@testimonialdetail');
    Route::post($getWebsiteUrl . '/getTestimonialDetails', 'frontend\UserController@getTestimonialDetails');
    Route::get($getWebsiteUrl . '/enquiry/{id}', 'frontend\UserController@enquiry');
    Route::get($getWebsiteUrl . '/getfTitle', 'frontend\UserController@getTitle');
    Route::get($getWebsiteUrl . '/getfGender', 'backend\AdminController@getGender');
    Route::get($getWebsiteUrl . '/getfBloodGroup', 'backend\AdminController@getBloodGroup');
    Route::get($getWebsiteUrl . '/getfEducationList', 'backend\AdminController@getEducationList');
    Route::get($getWebsiteUrl . '/getfCountries', 'frontend\UserController@getfCountries');
    Route::post($getWebsiteUrl . '/getemployeedetails', 'frontend\UserController@getEmployee');
    Route::post($getWebsiteUrl . '/getfStates', 'frontend\UserController@getfStates');
    Route::post($getWebsiteUrl . '/getfCities', 'frontend\UserController@getfCities');
    Route::post($getWebsiteUrl . '/updateemployeedetails', 'frontend\UserController@updateEmployee');
    Route::get($getWebsiteUrl . '/thanking-you', 'frontend\UserController@getThankingYou');


    $result = \DB::table('web_themes')->where('status', '1')->select(['id', 'theme_name'])->first();
    $result = json_decode(json_encode($result), true);
    Config::set('global.themeName', $result['theme_name']);
});

Route::group(['middleware' => ['auth:admin']], function () {
    $getUrl = config('global.getUrl');
    /*     * ************************* Admin Dashboard *************************** */
    Route::get('/dashboard', 'backend\AdminController@dashboard');
    Route::post('/logout', 'backend\Auth\LoginController@getLogout');

    /*     * ******************************************************************** */
    Route::get('/getMenuItems', 'backend\AdminController@getMenuItems');

    Route::get('/getTitle', 'backend\AdminController@getTitle');
    Route::get('/getGender', 'backend\AdminController@getGender');
    Route::get('/getBloodGroup', 'backend\AdminController@getBloodGroup');
    Route::get('/getDepartments', 'backend\AdminController@getDepartments');
    Route::get('/getEducationList', 'backend\AdminController@getEducationList');
    Route::get('/getProfessionList', 'backend\AdminController@getProfessionList');
    Route::get('/getCountries', 'backend\AdminController@getCountries');
    Route::get('/getWebPageList', 'backend\AdminController@getWebPageList'); //uma 
    Route::get('/getPropertyPortalType', 'backend\AdminController@getPropertyPortalType'); //uma 
    Route::get('/getVerticals', 'backend\AdminController@getVerticals'); //uma  
    Route::get('/getFinanceTieupAgency', 'backend\AdminController@getFinanceTieupAgency'); //uma
    Route::post('/getsalesEmployees', 'backend\AdminController@getsalesEmployees'); //uma
    Route::get('/getDesignations', 'backend\AdminController@getDesignations'); //geeta
    Route::get('/getProjects', 'backend\AdminController@getProjects'); //geeta
    Route::get('/getCompany', 'backend\AdminController@getCompany'); //geeta
    Route::get('/getStationary', 'backend\AdminController@getStationary'); //geeta
    Route::get('/getEnquirySource', 'backend\AdminController@getEnquirySource');
    Route::get('/getSalesEnqCategory', 'backend\AdminController@getSalesEnqCategory'); //geeta    
    Route::get('/getSalesEnqStatus', 'backend\AdminController@getSalesEnqStatus'); //geeta    
    Route::get('/getAmenitiesList', 'backend\AdminController@getAmenitiesList'); //geeta
    Route::get('/getChannelList', 'backend\AdminController@getChannelList'); //geeta
    Route::get('/getEmployeeData', 'backend\AdminController@getEmployeeData'); //geeta
    Route::get('/getSalesStatus', 'backend\AdminController@getSalesStatus'); //manoj
    Route::post('/getBlockTypes', 'backend\AdminController@getBlockTypes'); //geeta
    Route::post('/getSubBlocks', 'backend\AdminController@getSubBlocks'); //geeta
    Route::get('/manageBlockStages', 'backend\AdminController@manageBlockStages'); //archana
    Route::post('/getStates', 'backend\AdminController@getStates');
    Route::post('/getCities', 'backend\AdminController@getCities');
    Route::post('/getLocations', 'backend\AdminController@getLocations');
    Route::post('/checkUniqueEmail', 'backend\AdminController@checkUniqueEmail');
    Route::post('/checkUniqueMobile1', 'backend\AdminController@checkUniqueMobile1');
    Route::post('/checkUniqueMobile', 'backend\AdminController@checkUniqueMobile');
    Route::get('/getTeamLead/{id}', 'backend\AdminController@getTeamLead');
    Route::post('/editDepartments', 'backend\AdminController@editDepartments');
    Route::post('/getEnquirySubSource', 'backend\AdminController@getEnquirySubSource');
    Route::post('/getSalesEnqSubStatus', 'backend\AdminController@getSalesEnqSubStatus'); //geeta
    Route::post('/getSalesEnqSubCategory', 'backend\AdminController@getSalesEnqSubCategory'); //geeta
    Route::post('/checkOldPassword', 'backend\AdminController@checkOldPassword');
    Route::post('/checkUniqueEmployeeId', 'backend\AdminController@checkUniqueEmployeeId');
    Route::get('/getSalesSource', 'backend\AdminController@getSalesSource');
    Route::get('/getCompanyList', 'backend\AdminController@getCompanyList');
    Route::get('/getSalesLostReason', 'backend\AdminController@getSalesLostReason');
    Route::post('/getSalesLostSubReason', 'backend\AdminController@getSalesLostSubReason');
    Route::get('/getpaymentModeList', 'backend\AdminController@getpaymentModeList');
    Route::post('/getTeamEmployees', 'CloudCallingLogsController@getTeamEmployees'); // by uma
    Route::post('/getnextfollowupTime', 'backend\AdminController@getnextfollowupTime'); // by uma
    Route::post('/getProjectWings', 'backend\AdminController@getProjectWings'); // by geeta
    Route::post('/getBlocks', 'backend\AdminController@getBlocks'); // by geeta
    Route::post('/getSubBlocksList', 'backend\AdminController@getSubBlocksList'); // by geeta
    Route::get('/getccPreSalesStatus', 'backend\AdminController@getccPreSalesStatus');
    Route::get('/getccPreSalesCategory', 'backend\AdminController@getccPreSalesCategory');
    Route::post('/getccpresalesSubtatus', 'backend\AdminController@getccpresalesSubtatus');
    Route::post('/getccPreSalesSubCategory', 'backend\AdminController@getccPreSalesSubCategory');

    Route::get('/dirPagination', function () {
        return View::make('backend.dirPagination');
    });
    /*     * *********************************MANDAR****************************** */
    Route::get('/getClient', 'backend\AdminController@getClient');
    Route::get('/getVehiclebrands', 'backend\AdminController@getVehiclebrands');
    Route::get('/getVehiclemodels', 'backend\AdminController@getVehiclemodels');
    Route::get('/getEmployeesDetails', 'backend\AdminController@getEmployeesDetails');

    /*     * *********************************MANDAR****************************** */

    Route::get('/databoxes', function () {
        return View::make('backend.databoxes');
    });
    Route::get('/widgets', function () {
        return View::make('backend.widgets');
    });
});


Route::get('/api/allEmployeesSmsReport', 'backend\smsReportController@allEmployeesSmsReport');
Route::get('/api/allTeamLeadSmsReport', 'backend\smsReportController@allTeamLeadSmsReport');
Route::get('/api/allEmployeesMorningSmsReport', 'backend\smsReportController@allEmployeesMorningSmsReport');
Route::get('/api/allTeamLeadMorningSmsReport', 'backend\smsReportController@allTeamLeadMorningSmsReport');


Route::group(['middleware' => ['user']], function () {
    Route::post('user/logout', 'frontend\Auth\LoginController@getLogout');
    Route::get('user/dashboard', 'frontend\UserController@dashboard');
});
