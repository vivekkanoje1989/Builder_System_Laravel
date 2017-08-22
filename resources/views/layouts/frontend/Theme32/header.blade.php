<div class="wrapper">
    <header class="main-header">
        <div class="container">
            <div class="logo">
                <a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/index">
                    <img src="/frontend/Theme32/img/bms_logo.png" alt="Logo">
                    BMS BUILDER
                </a>
            </div>
            <nav class="nav-main" ng-init="getMenus()">
                <ul>
                    <li ng-repeat="menu in getMenus" class="nav-main-item"  ng-click="select(menu.id)" ng-class="{active: isActive(menu.id)}">
                        <a class="nav-main-link"     href="#/{{menu.page_name}}">{{menu.page_name}}</a>
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