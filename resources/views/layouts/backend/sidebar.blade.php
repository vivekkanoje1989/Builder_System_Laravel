<!-- Page Sidebar Header-->
<div class="sidebar-header-wrapper">
    <input type="text" class="searchinput" />
    <i class="searchicon fa fa-search"></i>
    <div class="searchhelper">Search Reports, Charts, Emails or Notifications</div>
</div>
<!-- /Page Sidebar Header -->
<!-- Sidebar Menu -->

<ul class="nav sidebar-menu" ng-controller="adminController">
    <li ng-repeat="parent in getMenu.mainMenu" ui-sref-active="{{ parent.uiSrefActive }}" class="{{ parent.liclass }}">
        <a ng-if='!parent.has_submenu' ui-sref="admin{{ parent.slug }}" class="{{ parent.anchorClass }}" ng-Click="checkPermission('{{ parent.slug }}')">
            <p class="{{ parent.icon }}"></p>
            <span class="menu-text"> {{ parent.name }} </span>
            <i class="menu-expand"></i>
        </a>
        <a ng-if='parent.has_submenu' href="#" class="{{ parent.anchorClass }}" >
            <p class="{{ parent.icon }}"></p>
            <span class="menu-text"> {{ parent.name }} </span>
            <i class="menu-expand"></i>
        </a>
        <ul ng-if='parent.has_submenu' class="{{ parent.submenuClass }}">
            <li ng-repeat="child1 in parent.submenu" ui-sref-active="{{ child1.uiSrefActive }}" class="{{ child1.liclass }}">
                <a ui-sref="admin{{ child1.slug }}" class="{{ child1.anchorClass }}" ng-if='!child1.has_submenu'>
                    <span class="menu-text"> {{ child1.name }} </span>
                </a>
                <a href="#" class="{{ child1.anchorClass }}" ng-if='child1.has_submenu'>
                    <span class="menu-text"> {{ child1.name }} </span>
                    <i class="menu-expand"></i>
                </a>
                <ul ng-if='child1.has_submenu' class="{{ child1.submenuClass }}">
                    <li ng-repeat="child2 in child1.submenu" ui-sref-active="{{ child2.uiSrefActive }}">
                        <a ng-if='!child2.has_submenu' ui-sref="admin{{ child2.slug }}" class="{{ child2.anchorClass }}">
                            <span class="menu-text"> {{ child2.name }} </span>
                        </a>
                        <a ng-if='child2.has_submenu' href="#" class="{{ child2.anchorClass }}">
                            <span class="menu-text"> {{ child2.name }} </span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul ng-if='child2.has_submenu' class="{{ child2.submenuClass }}">
                            <li ng-repeat="child3 in child2.submenu" ui-sref-active="{{ child3.uiSrefActive }}">
                                <a ng-if='!child3.has_submenu' ui-sref="admin{{ child3.slug }}" class="{{ child3.anchorClass }}">
                                    <span class="menu-text"> {{ child3.name }} </span>
                                </a>
                                <a ng-if='child3.has_submenu' href="#" class="{{ child3.anchorClass }}">
                                    <span class="menu-text"> {{ child3.name }} </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
</ul>
<!-- /Sidebar Menu -->
