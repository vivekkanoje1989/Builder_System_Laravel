 <style>
    .nav .current> a{
    border: 1px solid #FECE1A;
    color: #fff !important;
    background-color: #181A1C!important;
    transition: border-color 1s ease;
    }
    .container{
        /*padding : 0px 0px!important;*/
    }
    </style>
<head>
    <meta charset=utf-8>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABC Builders</title>
    <!-- Load Roboto font -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'/>
    <!-- Load css styles -->
    <link rel="stylesheet" type="text/css" href="frontend/mantra_vastu/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="frontend/mantra_vastu/css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="frontend/mantra_vastu/css/style.css" />
    <link rel="stylesheet" type="text/css" href="frontend/mantra_vastu/css/pluton.css" />
    <!--[if IE 7]>
        <link rel="stylesheet" type="text/css" href="css/pluton-ie7.css" />
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="frontend/mantra_vastu/css/jquery.cslider.css" />
    <!-- bxSlider CSS file -->
    <link href="frontend/mantra_vastu/css/jquery.bxslider.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="frontend/mantra_vastu/css/animate.css" />
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="frontend/mantra_vastu/images/ico/apple-touch-icon-144.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="frontend/mantra_vastu/images/ico/apple-touch-icon-114.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="frontend/mantra_vastu/images/apple-touch-icon-72.png"/>
    <link rel="apple-touch-icon-precomposed" href="frontend/mantra_vastu/images/ico/apple-touch-icon-57.png"/>
    <link rel="shortcut icon" href="frontend/mantra_vastu/images/ico/favicon.ico"/>
</head>
<div class="navbar">
    <div class="navbar-inner">
        <div class="container" style="padding: 0px 0px!important">
            <a href="index.html" class="brand">
                <img src="frontend/mantra_vastu/images/logo.png" alt="Logo" />
                <!-- This is website logo -->
            </a>
            <!-- Navigation button, visible on small resolution -->
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <i class="icon-menu"></i>
            </button>
            <div class="brand-name">
                ABC Builder ABC Builder<br>
                <span>Homes for Life</span>
            </div>                    
            <!-- Main navigation -->
            <div class="navbar-collapse collapse pull-right">
                <ul class="nav" id="top-navigation">
                    <li class="active"><a href="#home" target="_self">Home</a></li>
                    <li><a href="/projects">Projects</a></li>
                    <li><a href="" ng-click="scrollTo('about')">About</a></li>
                    <li><a href="#clients" target="_self">Testimonials</a></li>
                    <li><a href="#careers" target="_self">Careers</a></li>
                    <li><a href="#contact" target="_self">Contact</a></li>
                </ul>
            </div>
<!--                    <div class="navbar-collapse collapse" ng-init="getMenus()"> 
                <ul class="jt-menu  nav navbar-nav">
                    <li ng-repeat="menu in getMenus" class="item-114"  ng-click="select(menu.id)" ng-class="{active: isActive(menu.id)}">
                        <a class="nav-main-link"  href="/{{menu.page_name}}">{{menu.page_name}}</a>
                        <ul class="collapse">
                            <li    ng-repeat="subMenu in menu.menu_list">
                                <a  href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/{{subMenu.page_name}}">{{subMenu.page_name}}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div style="clear: both;"></div>
            </div>-->
            <!-- End main navigation -->
        </div>
    </div>
</div>
