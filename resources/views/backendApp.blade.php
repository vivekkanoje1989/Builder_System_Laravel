<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" ng-app="app" ng-controller="AppCtrl">
    <head>
        <meta charset="utf-8" />        
        <base href="/">
        <meta name="description" content="blank page" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="/backend/assets/img/favicon.png" type="image/x-icon">

        <?php if($_SERVER['REQUEST_URI'] == "/office.php"){ ?>
        <title page-title></title>       
        <!--Basic Styles-->
        <link href="/backend/assets/css/bootstrap.min.css" rel="stylesheet" />
        <link ng-if="settings.rtl" ng-href="/backend/assets/css/bootstrap-rtl.min.css" rel="stylesheet" />
        <link href="/backend/assets/css/font-awesome.min.css" rel="stylesheet" />
        <link href="/backend/assets/css/weather-icons.min.css" rel="stylesheet" />

        <!--Fonts-->
        <style>
            @@font-face {
                font-family: 'WYekan';
                src: url('/backend/assets/fonts/BYekan.woff') format('woff');
                font-weight: normal;
                font-style: normal;
            }
            input[capitalizeFirst]{ text-transform: capitalize; }
    	</style>
        <link href="/backend/assets/css/droidarabickufi.css" rel="stylesheet" type="text/css" />
        <link href="/backend/assets/css/css.css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300" rel="stylesheet" type="text/css">
<!--        <link href="http://fonts.googleapis.com/earlyaccess/droidarabickufi.css" rel="stylesheet" type="text/css" />
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300" rel="stylesheet" type="text/css">-->

        <!--Beyond styles-->
        <link ng-if="!settings.rtl" href="/backend/assets/css/beyond.min.css" rel="stylesheet" />
        <link ng-if="settings.rtl" href="/backend/assets/css/beyond-rtl.min.css" rel="stylesheet" />
        <link href="/backend/assets/css/demo.min.css" rel="stylesheet" />
        <link href="/backend/assets/css/intlTelInput.css" rel="stylesheet" />
        <link href="/backend/assets/css/typicons.min.css" rel="stylesheet" />
        <link href="/backend/assets/css/animate.min.css" rel="stylesheet" />
        <link ng-href="{{settings.skin}}" rel="stylesheet" type="text/css" />
        <link href="/backend/assets/css/loader.css" rel="stylesheet" />
        <link href="/css/filterSlider.css" rel="stylesheet" />
        
        <?php }else{ $getThemeName = config('global.themeName');?>
        <title page-title>BMS Builder</title>  
        <script src="/frontend/angular.min.js"></script>
        <script src="/frontend/angular-route.min.js"></script>
        <script src="/frontend/angular-animate.min.js"></script>
        <script src="/backend/app/ng-file-upload.js"></script>
        <script src="/frontend/route.js"></script> 
        @include('layouts.frontend.'.$getThemeName.'.style') 
        <?php }?>
    </head>
    <body ng-right-click>
        <?php if($_SERVER['REQUEST_URI'] == "/office.php"){ ?>
        <div class="overlay3" ng-show="loader.loading">
            <div class="spinner">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
                <div class="rect4"></div>
                <div class="rect5"></div>
                <!--<b class="loadermsg">Please Wait...</b>-->
            </div>
        </div>    
        @include('layouts.backend.layout')
        <!--<div ui-view ng-show="!loader.loading"></div>-->
       
        <!-- Scripts -->
         <script src="/backend/lib/jquery/jquery.min.js"></script>
        <script src="/backend/lib/jquery/bootstrap.js"></script>
        <script src="/backend/lib/angular/angular.js"></script>
        <script src="/backend/app/ng-file-upload.js"></script>
        <script src="/backend/lib/utilities.js"></script>
        <script src="/backend/app/dirPagination.js"></script>
        <script src="js/Chart.min.js"></script>
        <script src="js/angular-chart.min.js"></script>
        <script src="js/rzslider.min.js"></script>
        
        <script src="/backend/lib/angular/angular-animate/angular-animate.js"></script>
        <script src="/backend/lib/angular/angular-cookies/angular-cookies.js"></script>
        <script src="/backend/lib/angular/angular-resource/angular-resource.js"></script>
        <script src="/backend/lib/angular/angular-sanitize/angular-sanitize.js"></script>
        <script src="/backend/lib/angular/angular-touch/angular-touch.js"></script>

        <script src="/backend/lib/angular/angular-ui-router/angular-ui-router.js"></script>
        <script src="/backend/lib/angular/angular-ocLazyLoad/ocLazyLoad.js"></script>
        <script src="/backend/lib/angular/angular-ngStorage/ngStorage.js"></script>
        <script src="/backend/lib/angular/angular-ui-utils/angular-ui-utils.js"></script>
        <script src="/backend/lib/angular/angular-breadcrumb/angular-breadcrumb.js"></script>

        <script src="/backend/lib/angular/angular-ui-bootstrap/ui-bootstrap.js"></script>
        <script src="/backend/lib/jquery/slimscroll/jquery.slimscroll.js"></script>

        <!-- App Config and Routing Scripts -->
        <script src="/backend/app/app.js"></script>
        <script src="/backend/app/config.js"></script>
        <script src="/backend/app/config.lazyload.js"></script>
        <script src="/backend/app/config.router.js"></script>
        <script src="/backend/app/beyond.js"></script>
        <script src="/backend/app/data.js"></script>
        <script src="/js/angular-messages.js"></script>
        <script src="/backend/lib/angular/angular-messages.min.js"></script>
        <script src="/backend/app/directives.js"></script>        
        <script src="/backend/adminController.js"></script>
        <script src="/backend/hrController.js"></script>
        <script src="/backend/customerController.js"></script>
        <script src="/backend/smsConsumptionController.js"></script>
        
        <!--mandar-->
        <script src="/backend/cloudtelephonyController.js"></script>
        <script src="/backend/promotionalsmsController.js"></script>
        <script src="/backend/alertsController.js"></script>
        <script src="/backend/customalertsController.js"></script>
        
        <!-- Layout Related Directives -->
        <script src="/backend/app/directives/loading.js"></script>
        <script src="/backend/app/directives/skin.js"></script>
        <script src="/backend/app/directives/sidebar.js"></script>
        <script src="/backend/app/directives/header.js"></script>
        <script src="/backend/app/directives/navbar.js"></script>
        <script src="/backend/app/directives/chatbar.js"></script>
        <script src="/backend/app/directives/widget.js"></script>
        <?php }else{ ?>
        <div ng-view></div>
        <?php }?>
    </body>
</html>
