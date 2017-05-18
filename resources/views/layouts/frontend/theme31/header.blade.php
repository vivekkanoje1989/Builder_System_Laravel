<html lang="en"  >
    <head>
        <title>BMS</title>
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="shortcut icon" href="assets/ico/favicon.ico">
        <link href="/frontend/theme31/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/frontend/theme31/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet">
        <link href="/frontend/theme31/assets/plugins/fontawesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="/frontend/theme31/assets/plugins/prettyphoto/css/prettyPhoto.css" rel="stylesheet">
        <link href="/frontend/theme31/assets/plugins/owl-carousel2/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="/frontend/theme31/assets/plugins/owl-carousel2/assets/owl.theme.default.min.css" rel="stylesheet">
        <link href="/frontend/theme31/assets/plugins/animate/animate.min.css" rel="stylesheet">
        <link href="/frontend/theme31/assets/plugins/swiper/css/swiper.min.css" rel="stylesheet">
        <link href="/frontend/theme31/assets/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
        <link href="/frontend/theme31/assets/css/theme.css" rel="stylesheet">
        <link href="/frontend/theme31/assets/css/style.css" rel="stylesheet">
        <script src="/frontend/theme31/assets/plugins/modernizr.custom.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script> 
    </head>
    <body id="home" class="wide" ng-app="app">
        <div id="preloader">
            <div id="preloader-status">
                <div class="spinner">
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>
                </div>
                <div id="preloader-title">Loading</div>
            </div>
        </div>
        <div class="head-menu">
            <i class="fa fa-bars menu-bar"></i>
            <ul class="nav sf-menu">                                               
                <li><a href="#" title="HOME"><i class="fa fa-university"></i></a>
                    <ul class="menu-titl">
                        <li><a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/index">Home</a></li>
                    </ul>
                </li>
                <li><a href="#" title="All Projects"><i class="fa fa-building"></i></a>
                    <ul class="menu-titl">
                        <li><a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/projects">All Projects</a></li>
                    </ul>
                </li>
                <li><a href="#" title="Who We Are"><i class="fa fa-file-text"></i></a>
                    <ul class="menu-titl">
                        <li><a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/about">What We Are</a></li>
                        <li><a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/career">Career With Us</a></li>
                    </ul>
                </li>	
                <li><a href="contact" title="Contact"><i class="fa fa-phone"></i></a>	
                    <ul class="menu-titl">
                        <li><a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/contact">Contact</a></li>
                    </ul>
                </li>
            </ul>									
        </div>
        <div class="wrapper">  