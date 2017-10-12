<style>
    .navbar {
        margin-top: -20px;
    }
    </style>
<!DOCTYPE html>
<html lang="en">
  <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $this->pageTitle; ?></title>
        <?php echo $this->META_KEYWORDS; ?>
        <meta name="description" content="<?php echo $this->META_DESCRIPTION; ?>"/>
        <link href="<?php echo $this->CANONICAL_TAG; ?>" rel="canonical"/>        
        <link rel="shortcut icon" href="<?php echo FAVICON; ?>" type="image/x-icon">
        <link rel="apple-touch-icon" href="<?php echo FAVICON; ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo FAVICON; ?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo FAVICON; ?>">  
        <link rel="icon" href="<?php echo $this->image_path . "builder_uploads/" . $this->builderInfo['favicon']; ?>" type="image/x-icon" />
    </head>
    <body>
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
                        <a class="nav-main-link"     href="/{{menu.page_name}}">{{menu.page_name}}</a>
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