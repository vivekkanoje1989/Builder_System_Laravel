<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" ng-app="app" ng-controller="AppCtrl" data-ng-init="init()">
    <head>
        <meta charset="utf-8" />
        <title page-title></title>
        
        <meta name="description" content="blank page" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="/backend/assets/img/favicon.png" type="image/x-icon">

        <!--Basic Styles-->
        <link href="/backend/assets/css/bootstrap.min.css" rel="stylesheet" />
        <link ng-if="settings.rtl" ng-href="/backend/assets/css/bootstrap-rtl.min.css" rel="stylesheet" />
        <link href="/backend/assets/css/font-awesome.min.css" rel="stylesheet" />
        <link href="/backend/assets/css/weather-icons.min.css" rel="stylesheet" />

        <!--Fonts-->
        <style>
            @@font-face {
                font-family: 'WYekan';
                src: url('/assets/fonts/BYekan.woff') format('woff');
                font-weight: normal;
                font-style: normal;
            }
            input[capitalizeFirst]{ text-transform: capitalize; }
    	</style>
        <link href="http://fonts.googleapis.com/earlyaccess/droidarabickufi.css" rel="stylesheet" type="text/css" />
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300"
              rel="stylesheet" type="text/css">

        <!--Beyond styles-->
        <link ng-if="!settings.rtl" href="/backend/assets/css/beyond.min.css" rel="stylesheet" />
        <link ng-if="settings.rtl" href="/backend/assets/css/beyond-rtl.min.css" rel="stylesheet" />
        <link href="/backend/assets/css/demo.min.css" rel="stylesheet" />
         <link href="/backend/assets/css/intlTelInput.css" rel="stylesheet" />
        <link href="/backend/assets/css/typicons.min.css" rel="stylesheet" />
        <link href="/backend/assets/css/animate.min.css" rel="stylesheet" />
        <link ng-href="{{settings.skin}}" rel="stylesheet" type="text/css" />
    </head>
    <body ng-right-click>
        <div ui-view></div>

        <!-- Scripts -->
        <script src="/backend/lib/jquery/jquery.min.js"></script>
        <script src="/backend/lib/jquery/bootstrap.js"></script>
        <script src="/backend/lib/angular/angular.js"></script>
        <script src="/backend/app/ng-file-upload.js"></script>
        <script src="/backend/lib/utilities.js"></script>
        <script src="/backend/app/dirPagination.js"></script>
        
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
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-messages.min.js"></script>
        <script src="/backend/app/directives.js"></script>        
        <script src="/backend/adminController.js"></script>
        <script src="/backend/hrController.js"></script>
        <script src="/backend/cloudtelephonyController.js"></script>
        
        <!-- Layout Related Directives -->
        <script src="/backend/app/directives/loading.js"></script>
        <script src="/backend/app/directives/skin.js"></script>
        <script src="/backend/app/directives/sidebar.js"></script>
        <script src="/backend/app/directives/header.js"></script>
        <script src="/backend/app/directives/navbar.js"></script>
        <script src="/backend/app/directives/chatbar.js"></script>
        <script src="/backend/app/directives/widget.js"></script>
        
    </body>               
</html>
