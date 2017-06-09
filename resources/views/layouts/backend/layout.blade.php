<div ng-if="authenticated == false" ui-view></div>
<!-- Loading Container -->
<div ng-if="authenticated == true" class="loading-container" data-ng-include=" '/loading'"></div>
<!--  /Loading Container -->

<!-- Navbar -->
<div ng-if="authenticated == true" class="navbar {{settings.fixed.navbar ? 'navbar-fixed-top' : ''}}" data-ng-include=" '/navbar'"></div>
<!-- /Navbar -->

<div ng-if="authenticated == true" class="main-container container-fluid">
    <!-- Page Container -->
    <div class="page-container">
        <!-- Page Sidebar -->
        <div class="page-sidebar {{settings.fixed.sidebar ? 'sidebar-fixed' : ''}}" id="sidebar" data-ng-include=" '/sidebar'">
        </div>
        <!-- /Page Sidebar -->
        <!-- Chat Bar -->
        <div id="chatbar" class="page-chatbar" data-ng-include=" '/chatbar'">
        </div>
        <!-- /Chat Bar -->
        <!-- Page Content -->
        <div class="page-content">
            <!-- Page Breadcrumb -->
            <div class="page-breadcrumbs {{settings.fixed.breadcrumbs ? 'breadcrumbs-fixed' : ''}}" data-ng-include=" '/breadcrumbs'">
            </div>
            <!-- /Page Breadcrumb -->
            <!-- Page Header -->
            <div class="page-header position-relative {{settings.fixed.header ? 'page-header-fixed' : ''}}" data-ng-include=" '/header'">
            </div>
            <!-- /Page Header -->
            <!-- Page Body -->
            <div class="page-body" ui-view ng-show="!loader.loading">
                <!-- Your Content Goes Here -->
            </div>
            <!-- /Page Body -->
        </div>
        <!-- /Page Content -->
    </div>
    <!-- /Page Container -->
    <!-- Main Container -->

</div>
<!--<div ui-view ng-show="!loader.loading"></div>-->