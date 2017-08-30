<div class="wrapper">
    <header class="main-header navbar yamm navbar-default navbar-fixed-top">
        <div class="topBar">
            <div class="container">
                <p class="topBarText"><img class="icon" src="frontend/Gagan/img/icon-phone.png" alt="Gagan Properties - Phone Icon" /> +91 (0) 20 26133111/ 32111</p>
                <p class="topBarText"><img class="icon" src="frontend/Gagan/img/icon-mail.png" alt="Gagan Properties - Mail Icon" /> info.sales@gaganproperties.com</p>
                <ul class="socialIcons">

                    <li><a href="https://www.facebook.com/GaganProperties?fref=ts" target="_blank"><img src="frontend/Gagan/img/fb.jpg" alt="Gagan Properties - FB Icon" /></a></li>
                    <li><a href="https://twitter.com/GaganProperties" target="_blank"><img src="frontend/Gagan/img/twitter.jpg" alt="Gagan Properties - Twitter Icon" /></a></li>
                    <li><a href="https://plus.google.com/u/7/105210172796842276759/posts" target="_blank"><img src="frontend/Gagan/img/google.jpg" alt="Gagan Properties - google + Icon" /></a></li>

                </ul>
            </div>
        </div>
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <a class="navbar-brand"  href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/index" style="    margin-left: -70px;">
                    <img  class="hero-site-logo" src="/frontend/Theme32/img/bms_logo.png" alt="Logo">
                </a> </div>
            <div class="navbar-collapse collapse" ng-init="getMenus()"> 
                <ul class="jt-menu  nav navbar-nav">
                    <li ng-repeat="menu in getMenus" class="item-114"  ng-click="select(menu.id)" ng-class="{active: isActive(menu.id)}">
                        <a class="nav-main-link"     href="#/{{menu.page_name}}">{{menu.page_name}}</a>
                        <ul>
                            <li    ng-repeat="subMenu in menu.menu_list">
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