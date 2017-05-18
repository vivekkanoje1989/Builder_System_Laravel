<!DOCTYPE html>
<html lang="en" class="no-js">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <head>
        <meta charset="utf-8">
        <title>BMS HOME</title>
        <meta name="description" content="Squarefolio HTML Multi-purpose Template">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">

        <!-- Animate.css -->
        <link rel="stylesheet" href="/frontend/Theme32/styles/animate.min.css">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="/frontend/Theme32/styles/font-awesome.min.css">

        <!-- Form Styler -->
        <link rel="stylesheet" href="/frontend/Theme32/plugins/form-styler/jquery.formstyler.css">

        <!-- Magnific Popup -->
        <link rel="stylesheet" href="/frontend/Theme32/plugins/magnific-popup/magnific-popup.css">

        <!-- Normalize -->
        <link rel="stylesheet" href="/frontend/Theme32/styles/normalize.css">

        <!-- Owlcarousel -->
        <link rel="stylesheet" href="/frontend/Theme32/plugins/owl-carousel/owl.carousel.css">

        <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700%7CSatisfy' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="/frontend/Theme32/styles/main.css">
        <link href="/frontend/Theme32/styles/style.css" rel="stylesheet">
        <link rel="shortcut icon" href="/frontend/Theme32/favicon.png">

    </head>
    <body ng-app="app">

        <div class="wrapper" ng-controller="webAppController" >

            <!-- BEGIN HEADER -->
            <header class="main-header">

                <div class="container">

                    <div class="logo">
                        <a href="index.html">
                            <img src="/frontend/Theme32/img/bms_logo.png" alt="Logo">
                            BMS BUILDER
                        </a>
                    </div>
                    <nav class="nav-main" ng-init="getMenus()">
                        <ul>
                            <li ng-repeat="menu in getMenus| orderBy:'parent_page_position'" class="nav-main-item"  ng-class="{'active':$first}">
                                <a class="nav-main-link" href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/{{menu.page_name}}">{{menu.page_name}}</a>
                                <ul>
                                    <li    ng-repeat="subMenu in menu.menu_list">
                                        <a  href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/{{subMenu.page_name}}">{{subMenu.page_name}}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <button class="btn-nav"></button>
                </div>

            </header>