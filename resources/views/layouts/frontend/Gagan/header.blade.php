<head>
    <meta name="description" content="Squarefolio HTML Multi-purpose Template">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="/frontend/Gagan/css/modal.css" type="text/css" />
    <link rel="stylesheet" href="/frontend/Gagan/css/rounded.css" type="text/css" />
    <!--<script src="frontend/Gagan/js/modal.js" type="text/javascript"></script>-->


    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="img/favicon.png">
    <!-- html5 support in IE8 and later -->

    <!-- CSS file links -->
    <link href="/frontend/Gagan/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/frontend/Gagan/css/jquery.bxslider.css" rel="stylesheet" media="screen">
    <link href="/frontend/Gagan/css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="/frontend/Gagan/css/responsive.css" rel="stylesheet" type="text/css" media="all" />
    <link href="/frontend/Gagan/css/tabs2.css" rel="stylesheet" type="text/css" />
    <link href="/frontend/Gagan/css/yamm.css" rel="stylesheet" type="text/css" />

    <link href="/frontend/Gagan/css/jquery.nouislider.min.css" rel="stylesheet" type="text/css" media="all" />
    <link href="/frontend/Gagan/css/superfish.css" rel="stylesheet" type="text/css" media="(min-width: 767px)" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:700' rel='stylesheet' type='text/css'>
    <!-- light box -->
    <link rel="stylesheet" type="text/css" href="/frontend/Gagan/img_slide/jquery.fancybox.css" media="screen" />
    
</head>
<div class="wrapper">
    <header class="main-header navbar yamm navbar-default navbar-fixed-top">
        <div class="topBar">
            <div class="container">
                <p class="topBarText"><img class="icon" src="/frontend/Gagan/img/icon-phone.png" alt="Gagan Properties - Phone Icon" /> +91 (0) 20 26133111/ 32111</p>
                <p class="topBarText"><img class="icon" src="/frontend/Gagan/img/icon-mail.png" alt="Gagan Properties - Mail Icon" /> info.sales@gaganproperties.com</p>
                <ul class="socialIcons">
                    <li><a href="https://www.facebook.com/GaganProperties?fref=ts" target="_blank"><img src="/frontend/Gagan/img/fb.jpg" alt="Gagan Properties - FB Icon" /></a></li>
                    <li><a href="https://twitter.com/GaganProperties" target="_blank"><img src="/frontend/Gagan/img/twitter.jpg" alt="Gagan Properties - Twitter Icon" /></a></li>
                    <li><a href="https://plus.google.com/u/7/105210172796842276759/posts" target="_blank"><img src="/frontend/Gagan/img/google.jpg" alt="Gagan Properties - google + Icon" /></a></li>

                </ul>
            </div>
        </div>
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <a class="navbar-brand"  href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/index" style="    margin-left: -70px;">
                    <img  class="hero-site-logo" src="/frontend/Theme32/img/bms_logo.png" alt="Logo">
                </a> 
            </div>
            <div class="navbar-collapse collapse" ng-init="getMenus()"> 
                <ul class="jt-menu  nav navbar-nav">
                    <li ng-repeat="menu in getMenus" class="item-114"  ng-click="select(menu.id)" ng-class="{active: isActive(menu.id)}">
                        <a class="nav-main-link" href="/{{menu.page_name}}">{{menu.page_name}}</a>
                        <ul>
                            <li ng-repeat="subMenu in menu.menu_list">
                                <a  href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/{{subMenu.page_name}}">{{subMenu.page_name}}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div style="clear: both;"></div>
            </div>
            <!--/.navbar-collapse --> 
        </div>
        <!-- end header container --> 

    </header>