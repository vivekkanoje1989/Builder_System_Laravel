<!-- Loading Container -->
<div class="loading-container" data-ng-include=" 'admin/loading' "></div>
<!--  /Loading Container -->

<!-- Navbar -->
<div class="navbar {{settings.fixed.navbar ? 'navbar-fixed-top' : ''}}" data-ng-include=" 'admin/navbar' "></div>
<!-- /Navbar -->

<div class="main-container container-fluid">
    <!-- Page Container -->
    <div class="page-container">
        <!-- Page Sidebar -->
        <div class="page-sidebar {{settings.fixed.sidebar ? 'sidebar-fixed' : ''}}" id="sidebar" data-ng-include=" 'admin/sidebar' ">
        </div>
        <!-- /Page Sidebar -->
        <!-- Chat Bar -->
        <div id="chatbar" class="page-chatbar" data-ng-include=" 'admin/chatbar' ">
        </div>
        <!-- /Chat Bar -->
        <!-- Page Content -->
        <div class="page-content">
            <!-- Page Breadcrumb -->
            <div class="page-breadcrumbs {{settings.fixed.breadcrumbs ? 'breadcrumbs-fixed' : ''}}" data-ng-include=" 'admin/breadcrumbs' ">
            </div>
            <!-- /Page Breadcrumb -->
            <!-- Page Header -->
            <div class="page-header position-relative {{settings.fixed.header ? 'page-header-fixed' : ''}}" data-ng-include=" 'admin/header' ">
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