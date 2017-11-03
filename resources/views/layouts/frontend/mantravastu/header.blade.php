<!DOCTYPE html>
<!--
 * A Design by GraphBerry
 * Author: GraphBerry
 * Author URL: http://graphberry.com
 * License: http://graphberry.com/pages/license
-->
<html lang="en">
    <head>
        <meta charset=utf-8>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ABC Builders</title>
        <!-- Load Roboto font -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <!-- Load css styles -->
        <link rel="stylesheet" type="text/css" href="frontend/mantravastu/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="frontend/mantravastu/css/bootstrap-responsive.css" />
        <link rel="stylesheet" type="text/css" href="frontend/mantravastu/css/style.css" />
        <link rel="stylesheet" type="text/css" href="frontend/mantravastu/css/pluton.css" />
        <!--[if IE 7]>
            <link rel="stylesheet" type="text/css" href="frontend/mantravastu/css/pluton-ie7.css" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="frontend/mantravastu/css/jquery.cslider.css" />
        <!-- bxSlider CSS file -->
        <link href="frontend/mantravastu/css/jquery.bxslider.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="frontend/mantravastu/css/animate.css" />
        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="frontend/mantravastu/images/ico/apple-touch-icon-144.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="frontend/mantravastu/images/ico/apple-touch-icon-114.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="frontend/mantravastu/images/apple-touch-icon-72.png">
        <link rel="apple-touch-icon-precomposed" href="frontend/mantravastu/images/ico/apple-touch-icon-57.png">
        <link rel="shortcut icon" href="frontend/mantravastu/images/ico/favicon.ico">
    </head>
    <body ng-app="app">
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <a href="index.html" class="brand">
                        <img src="frontend/mantravastu/images/logo.png" alt="Logo" />
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

<!--                    <div class="nav-collapse collapse" ng-init="getMenus()"> 
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
                    
                    <div class="nav-collapse collapse pull-right">
                        <ul class="nav" id="top-navigation">
                            <li><a href="" id="home">Home</a></li>
                            <li><a href="projects" target="_self">Projects</a></li>
                            <li><a href="" id="about">About</a></li>
                            <li><a href="" id="clients">Testimonials</a></li>
                            <li><a href="" id="careers">Careers</a></li>
                            <li><a href="" id="contactus">Contact</a></li>
                        </ul>
                    </div>
                    <!-- End main navigation -->
                </div>
            </div>
        </div>