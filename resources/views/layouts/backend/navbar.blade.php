<div class="navbar-inner">
    <div class="navbar-container">
        <!-- Navbar Barnd -->
        <div class="navbar-header pull-left">
            <a href="/office.php#/dashboard" class="navbar-brand">
                <small>
                    <img src="/backend/assets/img/bms.png" ng-if="!settings.rtl" alt="" />
                    <img src="/backend/assets/img/bms.png" ng-if="settings.rtl" alt="" />
                </small>
            </a>
        </div>
        <!-- /Navbar Barnd -->
        <!-- Sidebar Collapse -->
        <div class="sidebar-collapse"></div>
        <!-- /Sidebar Collapse -->
        <!-- Account Area and Settings --->
        <div class="navbar-header pull-right">
            <div class="navbar-account">
                <ul class="account-area">
<!--                    <li>
                        <a class=" dropdown-toggle" data-toggle="dropdown" title="Help" href="#">
                            <i class="icon fa fa-warning"></i>
                        </a>
                        Notification Dropdown
                        <ul class="pull-right dropdown-menu dropdown-arrow dropdown-notifications">
                            <li>
                                <a href="#">
                                    <div class="clearfix">
                                        <div class="notification-icon">
                                            <i class="fa fa-phone bg-themeprimary white"></i>
                                        </div>
                                        <div class="notification-body">
                                            <span class="title">Skype meeting with Patty</span>
                                            <span class="description">01:00 pm</span>
                                        </div>
                                        <div class="notification-extra">
                                            <i class="fa fa-clock-o themeprimary"></i>
                                            <span class="description">office</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="clearfix">
                                        <div class="notification-icon">
                                            <i class="fa fa-check bg-darkorange white"></i>
                                        </div>
                                        <div class="notification-body">
                                            <span class="title">Uncharted break</span>
                                            <span class="description">03:30 pm - 05:15 pm</span>
                                        </div>
                                        <div class="notification-extra">
                                            <i class="fa fa-clock-o darkorange"></i>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="clearfix">
                                        <div class="notification-icon">
                                            <i class="fa fa-gift bg-warning white"></i>
                                        </div>
                                        <div class="notification-body">
                                            <span class="title">Kate birthday party</span>
                                            <span class="description">08:30 pm</span>
                                        </div>
                                        <div class="notification-extra">
                                            <i class="fa fa-calendar warning"></i>
                                            <i class="fa fa-clock-o warning"></i>
                                            <span class="description">at home</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="clearfix">
                                        <div class="notification-icon">
                                            <i class="fa fa-glass bg-success white"></i>
                                        </div>
                                        <div class="notification-body">
                                            <span class="title">Dinner with friends</span>
                                            <span class="description">10:30 pm</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-footer ">
                                <span>
                                    Today, March 28
                                </span>
                                <span class="pull-right">
                                    10Â°c
                                    <i class="wi wi-cloudy"></i>
                                </span>
                            </li>
                        </ul>
                        /Notification Dropdown
                    </li>
                    <li>
                        <a class="dropdown-toggle" data-toggle="dropdown" title="Mails" href="#">
                            <i class="icon fa fa-envelope"></i>
                            <span class="badge">3</span>
                        </a>
                        Messages Dropdown
                        <ul class="pull-right dropdown-menu dropdown-arrow dropdown-messages">
                            <li>
                                <a href="#">
                                    <img src="/backend/assets/img/avatars/divyia.jpg" class="message-avatar" alt="Divyia Austin">
                                    <div class="message">
                                        <span class="message-sender">
                                            Divyia Austin
                                        </span>
                                        <span class="message-time">
                                            2 minutes ago
                                        </span>
                                        <span class="message-subject">
                                            Here's the recipe for apple pie
                                        </span>
                                        <span class="message-body">
                                            to identify the sending application when the senders image is shown for the main icon
                                        </span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="/backend/assets/img/avatars/bing.png" class="message-avatar" alt="Microsoft Bing">
                                    <div class="message">
                                        <span class="message-sender">
                                            Bing.com
                                        </span>
                                        <span class="message-time">
                                            Yesterday
                                        </span>
                                        <span class="message-subject">
                                            Bing Newsletter: The January Issueâ€�
                                        </span>
                                        <span class="message-body">
                                            Discover new music just in time for the GrammyÂ® Awards.
                                        </span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="/backend/assets/img/avatars/adam-jansen.jpg" class="message-avatar" alt="Divyia Austin">
                                    <div class="message">
                                        <span class="message-sender">
                                            Nicolas
                                        </span>
                                        <span class="message-time">
                                            Friday, September 22
                                        </span>
                                        <span class="message-subject">
                                            New 4K Cameras
                                        </span>
                                        <span class="message-body">
                                            The 4K revolution has come over the horizon and is reaching the general populous
                                        </span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        /Messages Dropdown
                    </li>

                    <li>
                        <a class="dropdown-toggle" data-toggle="dropdown" title="Tasks" href="#">
                            <i class="icon fa fa-tasks"></i>
                            <span class="badge">4</span>
                        </a>
                        Tasks Dropdown
                        <ul class="pull-right dropdown-menu dropdown-tasks dropdown-arrow ">
                            <li class="dropdown-header bordered-darkorange">
                                <i class="fa fa-tasks"></i>
                                4 Tasks In Progress
                            </li>
                            <li>
                                <a href="#">
                                    <div class="clearfix">
                                        <span class="pull-left">Account Creation</span>
                                        <span class="pull-right">65%</span>
                                    </div>
                                    <progressbar class="progress-xs" value="65"></progressbar>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="clearfix">
                                        <span class="pull-left">Profile Data</span>
                                        <span class="pull-right">35%</span>
                                    </div>
                                    <progressbar class="progress-xs" type="success" value="35"></progressbar>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="clearfix">
                                        <span class="pull-left">Updating Resume</span>
                                        <span class="pull-right">75%</span>
                                    </div>
                                    <progressbar class="progress-xs" type="darkorange" value="75"></progressbar>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="clearfix">
                                        <span class="pull-left">Adding Contacts</span>
                                        <span class="pull-right">10%</span>
                                    </div>
                                    <progressbar class="progress-xs" type="warning" value="10"></progressbar>
                                </a>
                            </li>
                            <li class="dropdown-footer">
                                <a href="#">
                                    See All Tasks
                                </a>
                                <button class="btn btn-xs btn-default shiny darkorange icon-only pull-right"><i class="fa fa-check"></i></button>
                            </li>
                        </ul>
                        /Tasks Dropdown
                    </li>
                    <li>
                        <a chat-link class="wave in" title="Chat"></a>
                    </li>-->
                    <li>
                        <a class="login-area dropdown-toggle" data-toggle="dropdown" ng-controller="hrController">
                            <div class="avatar" title="View your public profile">
                                <img ng-if="!imageUrl" src="[[ config('global.s3Path').'/employee-photos/'.Auth::guard('admin')->user()->employee_photo_file_name;]]">
                                <img ng-if="imageUrl" ng-src="/backend/images/user-1.png"  ng-init="reloadphoto();">
                            </div>
                            <section>
                                <h2><span class="profile"><strong>[[Auth::guard('admin')->user()->first_name;]] [[Auth::guard('admin')->user()->last_name;]]</strong></span></h2>
                            </section>
                        </a>
                        <!--Login Area Dropdown-->
                        <ul class="pull-right dropdown-menu dropdown-arrow dropdown-login-area">
                            <li class="username" ><a>[[Auth::guard('admin')->user()->first_name;]]</a></li>
                            <li class="email" ><a style="color:black;"><strong>[[Auth::guard('admin')->user()->username;]]</strong></a></li>
                            <!--Avatar Area-->
                            <li>
                                <div class="avatar-area">
                                    <img ng-if="!imageUrl" src="[[ config('global.s3Path').'/employee-photos/'.Auth::guard('admin')->user()->employee_photo_file_name;]]" class="avatar">
                                    <img ng-if="imageUrl" ng-src="/backend/images/user-1.png" class="avatar">
                                </div>
                            </li>
                            <!--Avatar Area-->
                            <li class="edit">
                                <a href="office.php#/user/profile" class="text-center" style="color:black;text-decoration: underline;"><strong>Manage Profile</strong></a>
                                <!--<a href="#" class="pull-right">Setting</a>-->
                            </li>
                            <!--Theme Selector Area-->
                            <li class="theme-area">
                                <ul class="colorpicker">
                                    <li><a class="colorpick-btn" href="" style="background-color:#5DB2FF;" skin-changer rel="/backend/assets/css/skins/blue.min.css"></a></li>
                                    <li><a class="colorpick-btn" href="" style="background-color:#2dc3e8;" skin-changer rel="/backend/assets/css/skins/azure.min.css"></a></li>
                                    <li><a class="colorpick-btn" href="" style="background-color:#03B3B2;" skin-changer rel="/backend/assets/css/skins/teal.min.css"></a></li>
                                    <li><a class="colorpick-btn" href="" style="background-color:#53a93f;" skin-changer rel="/backend/assets/css/skins/green.min.css"></a></li>
                                    <li><a class="colorpick-btn" href="" style="background-color:#FF8F32;" skin-changer rel="/backend/assets/css/skins/orange.min.css"></a></li>
                                    <li><a class="colorpick-btn" href="" style="background-color:#cc324b;" skin-changer rel="/backend/assets/css/skins/pink.min.css"></a></li>
                                    <li><a class="colorpick-btn" href="" style="background-color:#AC193D;" skin-changer rel="/backend/assets/css/skins/darkred.min.css"></a></li>
                                    <li><a class="colorpick-btn" href="" style="background-color:#8C0095;" skin-changer rel="/backend/assets/css/skins/purple.min.css"></a></li>
                                    <li><a class="colorpick-btn" href="" style="background-color:#0072C6;" skin-changer rel="/backend/assets/css/skins/darkblue.min.css"></a></li>
                                    <li><a class="colorpick-btn" href="" style="background-color:#585858;" skin-changer rel="/backend/assets/css/skins/gray.min.css"></a></li>
                                    <li><a class="colorpick-btn" href="" style="background-color:#474544;" skin-changer rel="/backend/assets/css/skins/black.min.css"></a></li>
                                    <li><a class="colorpick-btn" href="" style="background-color:#001940;" skin-changer rel="/backend/assets/css/skins/deepblue.min.css"></a></li>
                                </ul>
                            </li>
                            <!--/Theme Selector Area-->
                            <li class="dropdown-footer" ng-controller="adminController" >
                                <a href="" ng-click="logout(logoutData)">
                                    Sign out
                                </a>
                                <form id="logout-form" name="logoutForm" method="POST" style="display: none;"  >
                                    <input type="hidden" ng-model="logoutData.csrfToken" name="csrftoken" id="csrftoken" ng-init="logoutData.csrfToken='<?php echo csrf_token(); ?>'" class="form-control">
                                </form>
                            </li>
                        </ul>
                        <!--/Login Area Dropdown-->
                    </li>
                    <!-- /Account Area -->
                    <!--Note: notice that setting div must start right after account area list.
                    no space must be between these elements-->
                    <!-- Settings -->
                </ul>
<!--                <div class="setting">
                </div>-->
                <div class="setting-container">
                    <label>
                        <input type="checkbox" id="checkbox_fixednavbar" ng-model="settings.fixed.navbar">
                        <span class="text">Fixed Navbar</span>
                    </label>
                    <label>
                        <input type="checkbox" id="checkbox_fixedsidebar" ng-model="settings.fixed.sidebar">
                        <span class="text">Fixed SideBar</span>
                    </label>
                    <label>
                        <input type="checkbox" id="checkbox_fixedbreadcrumbs" ng-model="settings.fixed.breadcrumbs">
                        <span class="text">Fixed BreadCrumbs</span>
                    </label>
                    <label>
                        <input type="checkbox" id="checkbox_fixedheader" ng-model="settings.fixed.header">
                        <span class="text">Fixed Header</span>
                    </label>
                </div>
                <!-- Settings -->
            </div>
        </div>
        <!-- /Account Area and Settings -->
    </div>
</div>