<!-- Loading Container -->
<div class="loading-container" data-ng-include=" '[[ config('global.getUrl') ]]/loading' "></div>
<!--  /Loading Container -->

<!-- Navbar -->
<div class="navbar {{settings.fixed.navbar ? 'navbar-fixed-top' : ''}}" data-ng-include=" '[[ config('global.getUrl') ]]/navbar' "></div>
<!-- /Navbar -->

<div class="main-container container-fluid">
    <!-- Page Container -->
    <div class="page-container">
        <!-- Page Sidebar -->
        <div class="page-sidebar {{settings.fixed.sidebar ? 'sidebar-fixed' : ''}}" id="sidebar" data-ng-include=" '[[ config('global.getUrl') ]]/sidebar' ">
        </div>
        <!-- /Page Sidebar -->
        <!-- Chat Bar -->
        <div id="chatbar" class="page-chatbar" data-ng-include=" '[[ config('global.getUrl') ]]/chatbar' ">
        </div>
        <!-- /Chat Bar -->
        <!-- Page Content -->
        <div class="page-content">
            <!-- Page Breadcrumb -->
            <div class="page-breadcrumbs {{settings.fixed.breadcrumbs ? 'breadcrumbs-fixed' : ''}}" data-ng-include=" '[[ config('global.getUrl') ]]/breadcrumbs' ">
            </div>
            <!-- /Page Breadcrumb -->
            <!-- Page Header -->
            <div class="page-header position-relative {{settings.fixed.header ? 'page-header-fixed' : ''}}" data-ng-include=" '[[ config('global.getUrl') ]]/header' ">
            </div>
            <!-- /Page Header -->
            <!-- Page Body -->
            <div class="page-body" ui-view>
                <!-- Your Content Goes Here -->
            </div>
            <!-- /Page Body -->
        </div>
        <!-- /Page Content -->
    </div>
    <!-- /Page Container -->
    <!-- Main Container -->

</div>