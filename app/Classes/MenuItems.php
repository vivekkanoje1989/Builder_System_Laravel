<?php

namespace App\Classes;

class MenuItems {

    public static function getMenuItems() {
        $getUrl = config('global.getUrl');
        $menulist = array(
            1 => array('name' => 'Dashboard', 'icon' => 'dash-img menu-icon-sz', 'micon' => 'img/dashboard.png', 'uiSrefActive' => '', 'url' => '', 'slug' => 'dashboard', 'has_submenu' => true, 'total_submenu' => 5,
                'submenu_ids' => '0101,0102,0103,0104,0105', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                    1 => array('id' => '0101', 'name' => 'My Salary Slips', 'micon' => 'img/salorySlip.png', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
//                    2 => array('id' => '0102', 'name' => 'Request Leave', 'micon' => 'img/requestLeave.png', 'icon' => '', 'url' => '/requestLeave/index', 'slug' => 'requestLeaveIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
//                    2 => array('id' => '0102', 'name' => 'Request Other Approval', 'micon' => 'img/otherApproval.png', 'icon' => '', 'url' => '/requestOtherApproval/index', 'slug' => 'requestOtherApprovalIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    2 => array('id' => '0102', 'name' => 'Requests For Me', 'micon' => 'img/reqForMe.png', 'icon' => '', 'url' => '/requestForMe/index', 'slug' => 'requestForMeIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    3 => array('id' => '0103', 'name' => 'My Requests', 'micon' => 'img/myRequest.png', 'icon' => '', 'url' => '/myRequest/index', 'slug' => 'myRequestIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    4 => array('id' => '0104', 'name' => 'Configure Dashboard', 'micon' => 'img/configDashboard.png', 'icon' => '#', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    5 => array('id' => '0105', 'name' => 'My Settings', 'icon' => '', 'micon' => 'img/mySettings.png', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
            2 => array('name' => 'BMS', 'icon' => 'bms-img menu-icon-sz', 'micon' => 'img/bms.png','ui-sref-active' => '', 'url' => '', 'slug' => 'bms', 'has_submenu' => true, 'total_submenu' => 3,
                'submenu_ids' => '0201,0202,0203', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                    1 => array('id' => '0201', 'name' => 'Website Settings', 'icon' => 'menu-icon glyphicon glyphicon-home','micon' => 'img/websiteSettings.png', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 7,
                        'submenu_ids' => '020101,020102,020103,020104,020105,020106,020107', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '020101', 'name' => 'Content Management', 'icon' => '','micon' => 'img/contentManagement.png', 'url' => '/website_settings/contentpages', 'slug' => 'webPagesIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            2 => array('id' => '020102', 'name' => 'Contact Us', 'icon' => '','micon' => 'img/contactUs.png', 'url' => '/contactUs/index', 'slug' => 'contactusIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            3 => array('id' => '020103', 'name' => 'Website Changing Module', 'icon' => '','micon' => 'img/websiteChangingModule.png', 'url' => '/website/change-module', 'slug' => 'webChangeModuleIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            4 => array('id' => '020104', 'name' => 'Webpage Management', 'icon' => '', 'micon' => 'img/webpageMgnt.png','url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            5 => array('id' => '020105', 'name' => 'Social Websites Management', 'icon' => '','micon' => 'img/socialWebsitesMgnt.png', 'url' => '/bms_lists/social', 'slug' => 'socialwebIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            6 => array('id' => '020106', 'name' => 'Blogs Management', 'icon' => '', 'micon' => 'img/dashboard.png','url' => '/manageblog/index', 'slug' => 'manageblogIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            7 => array('id' => '020107', 'name' => 'Website Themes', 'icon' => '', 'micon' => 'img/dashboard.png','url' => '/website/themes', 'slug' => 'webThemesIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                    2 => array('id' => '0202', 'name' => 'BMS Settings', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 12,
                        'submenu_ids' => '020201,020202,020203,020204,020205,020206,020207,020208,020209,0202010,0202011,0202012', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open',
                        'api_submenu_ids' => '02020101,02020102,02020103,02020201,02020202,02020203,02020204,02020205,02020206,02020207,02020208,02020209,02020210,02020211,02020212,02020213,02020214,02020215,02020216,02020217,02020218,02020219,02020301,02020401,02020501,02020601,02020701,02020702,02020801,02020901,02020902,020201001,020301,020302,020303',
                        'submenu' => array(
                            1 => array('id' => '020201', 'name' => 'SMS & Email Settings', 'icon' => 'menu-icon glyphicon glyphicon-home', 'micon' => 'img/smsNmail.png', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 3,
                                'submenu_ids' => '02020101,02020102,02020103', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '02020101', 'name' => 'Templates Settings', 'icon' => '', 'micon' => 'img/template.png', 'url' => '/alerts/index', 'slug' => 'alertsIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    2 => array('id' => '02020102', 'name' => 'Default Templates', 'icon' => '', 'micon' => 'img/template.png', 'url' => '/defaultalerts/index', 'slug' => 'defaultalertsIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    3 => array('id' => '02020103', 'name' => 'Custom Templates', 'icon' => '', 'micon' => 'img/template.png', 'url' => '/customalerts/index', 'slug' => 'customalertsIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            2 => array('id' => '020202', 'name' => 'BMS Lists Management', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 18,
                                'submenu_ids' => '02020201,02020202,02020203,02020204,02020205,02020206,02020207,02020208,02020209,02020210,02020211,02020212,02020213,02020214,02020215,02020216,02020217,02020218',
                                'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '02020201', 'name' => 'Manage Blood Groups', 'icon' => '', 'url' => '/bloodgroups/index', 'slug' => 'bloodGroupsIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    2 => array('id' => '02020202', 'name' => 'Manage Highest Education', 'icon' => '', 'url' => '/highesteducation/index', 'slug' => 'highesteducationIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    3 => array('id' => '02020203', 'name' => 'Manage Departments', 'icon' => '', 'url' => '/department/index', 'slug' => 'departmentIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    4 => array('id' => '02020204', 'name' => 'Manage Profession', 'icon' => '', 'url' => '/profession/index', 'slug' => 'professionIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    5 => array('id' => '02020205', 'name' => 'Manage Enquiry Source', 'icon' => '', 'url' => '/enquirysource/index', 'slug' => 'enquirySourceIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    6 => array('id' => '02020206', 'name' => 'Manage Lost Reasons', 'icon' => '', 'url' => '/lostreason/index', 'slug' => 'lostreasonsIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    7 => array('id' => '02020207', 'name' => 'Manage Project Types', 'icon' => '', 'url' => '/projecttypes/index', 'slug' => 'projecttypesIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    8 => array('id' => '02020208', 'name' => 'Manage Project Payment Stages', 'icon' => '', 'url' => '/projectstages/index', 'slug' => 'projectstagesIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    9 => array('id' => '02020209', 'name' => 'Manage Block Types', 'icon' => '', 'url' => '/blockTypes/index', 'slug' => 'blocktypesIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    10 => array('id' => '02020210', 'name' => 'Manage Block Stages', 'icon' => '', 'url' => '/blockstages/index', 'slug' => 'blockStagesIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    11 => array('id' => '02020211', 'name' => 'Manage Payment Headings', 'icon' => '', 'url' => '/paymentheading/index', 'slug' => 'paymentheadingIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    12 => array('id' => '02020212', 'name' => 'Manage Country', 'icon' => '', 'url' => '/country/index', 'slug' => 'countryIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    13 => array('id' => '02020213', 'name' => 'Manage States', 'icon' => '', 'url' => '/states/index', 'slug' => 'statesIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    14 => array('id' => '02020214', 'name' => 'Manage Cities', 'icon' => '', 'url' => '/city/index', 'slug' => 'cityIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    15 => array('id' => '02020215', 'name' => 'Manage Locations', 'icon' => '', 'url' => '/location/index', 'slug' => 'locationIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    16 => array('id' => '02020216', 'name' => 'Manage Discount Headings', 'icon' => '', 'url' => '/discountheading/index', 'slug' => 'discountheadingIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    17 => array('id' => '02020217', 'name' => 'Manage Enquiry Location', 'icon' => '', 'url' => '/enquirylocation/index', 'slug' => 'enquirylocationIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    18 => array('id' => '02020218', 'name' => 'Manage Designations', 'icon' => '', 'url' => '/designations/index', 'slug' => 'designationsIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            3 => array('id' => '020203', 'name' => 'Auto Assign Web Enquires', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                                'submenu_ids' => '02020301', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '02020301', 'name' => 'Manage', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            4 => array('id' => '020204', 'name' => 'Firms & Partners', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                                'submenu_ids' => '02020401', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '02020401', 'name' => 'Manage Companies', 'icon' => '', 'url' => '/manage/company', 'slug' => 'companiesIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            5 => array('id' => '020205', 'name' => 'Operational Settings', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                                'submenu_ids' => '02020501', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '02020501', 'name' => 'Manage', 'icon' => '', 'url' => '/operationalSetting/index', 'slug' => 'operationalSettingIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            6 => array('id' => '020206', 'name' => 'Configure Email Accounts', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                                'submenu_ids' => '02020601', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '02020601', 'name' => 'Manage', 'icon' => '', 'url' => '/emailConfig/index', 'slug' => 'emailConfigIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                           7 => array('id' => '020207', 'name' => 'API Management', 'icon' => 'menu-icon glyphicon glyphicon-home', 'micon' => 'img/api1.png', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                                'submenu_ids' => '02020701', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '02020701', 'name' => 'Manage API', 'icon' => '', 'micon' => 'img/api1.png', 'url' => '/pushapi/manage', 'slug' => 'apilist', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            8 => array('id' => '020208', 'name' => 'Property Portals', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                                'submenu_ids' => '02020801', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '02020801', 'name' => 'Manage', 'icon' => '', 'url' => '/portals/index', 'slug' => 'propertyPortalIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            9 => array('id' => '020209', 'name' => 'Parking Management', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
                                'submenu_ids' => '02020901,02020902', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '02020901', 'name' => 'Parking Type', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    2 => array('id' => '02020902', 'name' => 'Parking Sub Type', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            90 => array('id' => '0202010', 'name' => 'Device Configuration', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                                'submenu_ids' => '020201001', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '020201001', 'name' => 'Manage', 'icon' => '', 'url' => '/employeeDevice/index', 'slug' => 'employeeDeviceIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            91 => array('id' => '0202011', 'name' => 'Bank Accounts', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                                'submenu_ids' => '020201101', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '020201101', 'name' => 'Manage Bank Accounts', 'icon' => '', 'url' => '/bank-accounts/index', 'slug' => 'bankAccountsIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            92 => array('id' => '0202012', 'name' => 'Project Wings', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                                'submenu_ids' => '020201201', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '020201201', 'name' => 'Manage Wings', 'icon' => '', 'url' => '/wings/index', 'slug' => 'wingsIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                        )),
                    3 => array('id' => '0203', 'name' => 'BMS Consumption', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 3,
                        'submenu_ids' => '020301,020302,020303', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '020301', 'name' => 'SMS Consumption', 'icon' => '', 'url' => '/bmsConsumption/smsConsumption', 'slug' => 'smsConsumption', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            2 => array('id' => '020302', 'name' => 'Calls Consumption', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            3 => array('id' => '020303', 'name' => 'Email Consumption', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                )),
            3 => array('name' => 'HR', 'icon' => 'hr-img menu-icon-sz', 'micon' => 'img/human.resource.0.png', 'ui-sref-active' => '', 'url' => '', 'slug' => 'hr', 'has_submenu' => true, 'total_submenu' => 3,
                'submenu_ids' => '0301,0302,0303', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                    1 => array('id' => '0301', 'name' => 'User Management', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 6,
                        'submenu_ids' => '030101,030102,030103,030104,030105,030106', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '030101', 'name' => 'Manage Users', 'micon' => 'img/list.png', 'icon' => '', 'url' => '/user/index', 'slug' => 'userIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
//                            2 => array('id' => '030102', 'name' => 'New User', 'micon' => 'img/newUser.png', 'icon' => '', 'url' => '/user', 'slug' => 'user', 'uiSrefActive' => 'active', 'total_submenu' => 1),
//                            3 => array('id' => '030103', 'name' => 'Quick User', 'micon' => 'img/quickUser.png', 'url' => '/user/quick-user', 'slug' => 'quickUser', 'uiSrefActive' => 'active', 'total_submenu' => 1),
//                            4 => array('id' => '030104', 'name' => 'Manage Roles', 'micon' => 'img/newUser.png', 'icon' => '', 'url' => '/user/manageroles', 'slug' => 'manageRoles', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            2 => array('id' => '030102', 'name' => 'Reassign Data', 'micon' => 'img/reassignData.png', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            3 => array('id' => '030103', 'name' => 'Organization Chart', 'micon' => 'img/chart.png', 'icon' => '', 'url' => '/user/orgchart', 'slug' => 'userChart', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            4 => array('id' => '030104', 'name' => 'User Documents', 'icon' => '','micon' => 'img/userDocument.png', 'url' => '/user/document', 'slug' => 'userDocument', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            5 => array('id' => '030105', 'name' => 'Manage Documents', 'icon' => '','micon' => 'img/manageDocument.png', 'url' => '/manage/document', 'slug' => 'documentIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            6 => array('id' => '030106', 'name' => 'Manage Role', 'icon' => '','micon' => 'img/manageRole.png', 'url' => '/user/manageroles', 'slug' => 'manageRoles', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                    2 => array('id' => '0302', 'name' => 'Salary Management', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                        'submenu_ids' => '030201', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '030201', 'name' => 'Salary Slips', 'icon' => '','micon' => 'img/userSalarySlip.png', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
//                    3 => array('id' => '0303', 'name' => 'Role Management', 'icon' => '', 'micon' => 'img/role.png', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
//                        'submenu_ids' => '030301,030302', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
//                            1 => array('id' => '030301', 'name' => 'Create Role', 'micon' => 'img/createRole.png', 'url' => '/user/createrole', 'slug' => 'createrole', 'uiSrefActive' => 'active', 'total_submenu' => 1),
//                            2 => array('id' => '030302', 'name' => 'Manage Role', 'micon' => 'img/manageRole.png', 'url' => '/user/manageroles', 'slug' => 'manageRoles', 'uiSrefActive' => 'active', 'total_submenu' => 1),
//                        )),
                    
//                    3 => array('id' => '0303', 'name' => 'Manage Role', 'icon' => '', 'url' => '/user/manageroles', 'micon' => 'img/manageRole.png','slug' => 'manageRoles', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
            4 => array('name' => 'Sales', 'icon' => 'sale-img menu-icon-sz', 'micon' => 'img/sales.logo.0.png', 'ui-sref-active' => '', 'url' => '', 'slug' => 'sales', 'has_submenu' => true, 'total_submenu' => 5,
                'submenu_ids' => '0401,0402,0403,0404,0405', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                    1 => array('id' => '0401', 'name' => 'Pre-Sales', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 8,
                        'submenu_ids' => '040101,040102,040103,040104,040105,040106,040107,040108', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            // 1 => array('id' => '040101', 'name' => 'Quick Enquiry', 'micon' => 'img/quickEnq.png', 'icon' => '', 'url' => '/sales/createQuickEnquiry', 'slug' => 'createQuickEnquiry', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            // 2 => array('id' => '040102', 'name' => ' Detailed Enquiry', 'micon' => 'img/detailedEnq.png', 'icon' => '', 'url' => '/sales/create', 'slug' => 'salesCreate', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            1 => array('id' => '040101', 'name' => 'My Today\'s Followups', 'micon' => 'img/myFollow.png', 'icon' => '', 'url' => '/sales/todaysfollowups', 'slug' => 'todaysfollowups', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            2 => array('id' => '040102', 'name' => 'My Pending Followups', 'micon' => 'img/pendingFollow.png', 'icon' => '', 'url' => '/sales/pendingfollowups', 'slug' => 'pendingfollowups', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            3 => array('id' => '040103', 'name' => 'My Previous Followups', 'icon' => '', 'micon' => 'img/previousFollow.png', 'url' => '/sales/previousfollowups', 'slug' => 'previousfollowups', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            4 => array('id' => '040104', 'name' => 'My Total Enquiries', 'icon' => '', 'micon' => 'img/totalEnq.png', 'url' => '/sales/totalenquiries', 'slug' => 'enquiries', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            5 => array('id' => '040105', 'name' => 'My Lost Enquiries', 'icon' => '', 'micon' => 'img/lostEnq.png', 'url' => '/sales/lostenquiries', 'slug' => 'lostenquiries', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            6 => array('id' => '040106', 'name' => 'My Booked Enquiries', 'icon' => '', 'micon' => 'img/bookedEnq.png', 'url' => '/sales/bookedenquiries', 'slug' => 'bookedenquiries', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            7 => array('id' => '040107', 'name' => 'My Reassigned Enquiries', 'icon' => '', 'micon' => 'img/reasignEnq.png', 'url' => '/sales/reassignenquiries', 'slug' => 'reassignenquiries', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            8 => array('id' => '040108', 'name' => 'Team\'s Enquiries', 'icon' => '', 'ui-sref-active' => '', 'slug' => 'Team', 'has_submenu' => true, 'total_submenu' => 6,
                                'submenu_ids' => '04010801,04010802,04010803,04010804,04010805,04010806', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '04010801', 'name' => 'Today\'s Followups', 'icon' => '', 'micon' => 'img/Team_todays_follow_ups.png', 'url' => '/sales/teamtodayfollowups', 'slug' => 'teamtodayfollowups', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    2 => array('id' => '04010802', 'name' => 'Pending Followups', 'icon' => '', 'micon' => 'img/Team_pending_follow_ups.png', 'url' => '/sales/teampendingfollowups', 'slug' => 'teampendingfollowups', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    3 => array('id' => '04010803', 'name' => 'Previous Followups', 'icon' => '', 'micon' => 'img/Team_previous_Follow_ups.png', 'url' => '/sales/teampreviousfollowups', 'slug' => 'teampreviousfollowups', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    4 => array('id' => '04010804', 'name' => 'Total Enquiries', 'icon' => '', 'micon' => 'img/Team_total_followups.png', 'url' => '/sales/teamtotalenquiries', 'slug' => 'teamtotalenquiries', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    5 => array('id' => '04010805', 'name' => 'Lost Enquiries', 'icon' => '', 'micon' => 'img/Team_lost_follow_ups.png', 'url' => '/sales/teamlostenquiries', 'slug' => 'teamlostenquiries', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    6 => array('id' => '04010806', 'name' => 'Booked Enquiries', 'icon' => '', 'micon' => 'img/Team_book_enquiries.png', 'url' => '/sales/teambookedenquiries', 'slug' => 'teambookedenquiries', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                        )),
                    2 => array('id' => '0402', 'name' => 'Post-Sales', 'icon' => '', 'micon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 7,
                        'submenu_ids' => '040201,040202,040203,040204,040205,040206,040207', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '040201', 'name' => 'My Today\'s Collections', 'icon' => '', 'micon' => 'img/myFollow.png', 'url' => '/sales/todays', 'slug' => 'todays', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            2 => array('id' => '040202', 'name' => 'My Pending Collections', 'icon' => '', 'micon' => 'img/pendingFollow.png', 'url' => '/sales/pending', 'slug' => 'pending', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            3 => array('id' => '040203', 'name' => 'My Previous Collections', 'icon' => '', 'micon' => 'img/previousFollow.png', 'url' => '/sales/previous', 'slug' => 'previous', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            4 => array('id' => '040204', 'name' => 'My Total Collections', 'icon' => '', 'micon' => 'img/totalEnq.png', 'url' => '/sales/totalenquiry', 'slug' => 'salesTotalEnquiryIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            5 => array('id' => '040205', 'name' => 'My Completed Collections', 'icon' => '', 'micon' => 'img/bookedEnq.png', 'url' => '/sales/bookedenquiry', 'slug' => 'salesBookedEnquiryIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            6 => array('id' => '040206', 'name' => 'My Reassigned Bookings', 'icon' => '', 'micon' => 'img/reasignEnq.png', 'url' => '#', 'slug' => '#', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            7 => array('id' => '040207', 'name' => 'Team\'s Collections', 'icon' => '', 'micon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 5,
                                'submenu_ids' => '04020701,04020702,04020703,04020704,04020705', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '04020701', 'name' => 'Today\'s Collections', 'icon' => '', 'micon' => 'img/Team_todays_follow_ups.png', 'url' => '/sales/teamtodays', 'slug' => 'teamtodays', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    2 => array('id' => '04020702', 'name' => 'Pending Collections', 'icon' => '', 'micon' => 'img/Team_pending_follow_ups.png', 'url' => '/sales/teampending', 'slug' => 'teampending', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    3 => array('id' => '04020703', 'name' => 'Previous Collections', 'icon' => '', 'micon' => 'img/Team_previous_Follow_ups.png', 'url' => '/sales/teamprevious', 'slug' => 'teamprevious', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    4 => array('id' => '04020704', 'name' => 'Total Collections', 'icon' => '', 'micon' => 'img/Team_total_followups.png', 'url' => '/sales/teamtotalenquiry', 'slug' => 'teamTotalEnquiryIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    5 => array('id' => '04020705', 'name' => 'Completed Collections', 'icon' => '', 'micon' => 'img/Team_book_enquiries.png', 'url' => '/sales/teambookedenquiry', 'slug' => 'teamBookedEnquiryIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                        )),
                    3 => array('id' => '0403', 'name' => 'Deal Management', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 4,
                        'submenu_ids' => '040301,040302,040303,040304', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '040301', 'name' => 'New Deal', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            2 => array('id' => '040302', 'name' => 'My Ongoing Deals', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            3 => array('id' => '040303', 'name' => 'My Demand letters', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            4 => array('id' => '040304', 'name' => 'Team\'s Deals', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
                                'submenu_ids' => '04030401,04030402', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '04030401', 'name' => 'Ongoing Deals', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    2 => array('id' => '04030402', 'name' => 'Demand letters', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                        )),
                    4 => array('id' => '0404', 'name' => 'Collection Followup\'s', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 5,
                        'submenu_ids' => '040401,040402,040403,040404,040405', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '040401', 'name' => 'Today\'s Collection\'s ', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            2 => array('id' => '040402', 'name' => 'Pending Collection\'s', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            3 => array('id' => '040403', 'name' => 'Total Collection\'s', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            4 => array('id' => '040404', 'name' => 'Upcoming Collection\'s', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            5 => array('id' => '040405', 'name' => 'Team\'s Collection\'s', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 4,
                                'submenu_ids' => '04040101,04040102,04040103,04040104', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '04040101', 'name' => 'Today\'s Collection\'s', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    2 => array('id' => '04040102', 'name' => 'Pending Collection\'s', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    3 => array('id' => '04040103', 'name' => 'Total Collection\'s', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    4 => array('id' => '04040104', 'name' => 'Upcoming Collection\'s', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                        )),
                    5 => array('id' => '0405', 'name' => 'Customer\'s Management', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
                        'submenu_ids' => '040501,040502', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '040501', 'name' => 'Manage Customer\'s', 'icon' => '', 'micon' => 'img/manageCustomer.png','url' => '/customers/index', 'slug' => 'customersIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            2 => array('id' => '040502', 'name' => 'Import Enquiries', 'icon' => '', 'micon' => 'img/importEnquiries.png','url' => '/sales/importEnquiry', 'slug' => 'importEnquiryIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                )),
            5 => array('name' => 'Projects', 'icon' => 'proj-img menu-icon-sz', 'ui-sref-active' => '', 'url' => '', 'slug' => 'projects', 'has_submenu' => true, 'total_submenu' => 4,
                'submenu_ids' => '0501,0502,0503,0504', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                    1 => array('id' => '0501', 'name' => 'Projects Management', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
                        'submenu_ids' => '050101,050102', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '050101', 'name' => 'Manage Projects', 'icon' => '', 'url' => '/project/manage', 'slug' => 'manageProjectIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
//                            2 => array('id' => '050102', 'name' => 'New Project', 'icon' => '', 'url' => '/project/create', 'slug' => 'projectCreate', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            2 => array('id' => '050102', 'name' => 'Project Availability', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                    2 => array('id' => '0502', 'name' => 'Manage Project Stages', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'has_submenu' => true, 'uiSrefActive' => 'active', 'total_submenu' => 1,
                        'submenu_ids' => '050201', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '050201', 'name' => 'Manage', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                    3 => array('id' => '0503', 'name' => 'Manage Block Stages', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                        'submenu_ids' => '050301', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '050301', 'name' => 'Manage', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                    4 => array('id' => '0504', 'name' => 'Rate Management', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
                        'submenu_ids' => '050401,050402', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '050401', 'name' => 'Manage Rate\'s', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            2 => array('id' => '050402', 'name' => 'Manage Floor Rise', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                )),
            6 => array('name' => 'Response', 'icon' => 'resp-img menu-icon-sz', 'ui-sref-active' => '', 'url' => '', 'slug' => 'response', 'has_submenu' => true, 'total_submenu' => 4,
                'submenu_ids' => '0601,0602,0603,0604', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                    1 => array('id' => '0601', 'name' => 'Web Enquiries', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                        'submenu_ids' => '060101', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '060101', 'name' => 'Manage', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                    2 => array('id' => '0602', 'name' => 'Contact us Queries', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                        'submenu_ids' => '060201', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '060201', 'name' => 'Manage', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                    3 => array('id' => '0603', 'name' => 'Testimonials', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
                        'submenu_ids' => '060301,060302', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '060301', 'name' => 'Approve', 'icon' => '', 'url' => '/testimonials/index', 'slug' => 'testimonialsIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
//                            2 => array('id' => '060302', 'name' => 'Create', 'icon' => '', 'url' => '/testimonials/create', 'slug' => 'testimonialsCreate', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            2 => array('id' => '060302', 'name' => 'Manage', 'icon' => '', 'url' => '/testimonials/manage', 'slug' => 'testimonialsManage', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                    4 => array('id' => '0604', 'name' => 'Website Visitors', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                        'submenu_ids' => '060401', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '060401', 'name' => 'Show Visitors', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                )),
            7 => array('name' => 'Marketing', 'icon' => 'mark-img menu-icon-sz', 'ui-sref-active' => '', 'url' => '', 'slug' => 'marketing', 'has_submenu' => true, 'total_submenu' => 3,
                'submenu_ids' => '0701,0702,0703', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                    1 => array('id' => '0701', 'name' => 'Promotional SMS', 'icon' => '', 'micon' => 'img/sms.png', 'ui-sref-active' => '', 'slug' => '/', 'has_submenu' => true, 'total_submenu' => 5,
                        'submenu_ids' => '070101,070102,070103,070104,070105', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '070101', 'name' => 'Send SMS', 'icon' => '', 'micon' => 'img/sms.png', 'url' => '/promotionalsms/index', 'slug' => 'promotionalsms', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            2 => array('id' => '070102', 'name' => 'SMS Logs', 'icon' => '', 'micon' => 'img/sms.png', 'url' => '/promotionalsms/smslogs', 'slug' => 'smslogs', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            3 => array('id' => '070103', 'name' => 'Team\'s SMS Log\'s', 'icon' => '', 'micon' => 'img/TeamSMSReport.png', 'url' => '/promotionalsms/teamsmslogs', 'slug' => 'teamsmslogs', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            4 => array('id' => '070104', 'name' => 'My SMS Report\'s', 'icon' => '', 'micon' => 'img/MySMSreportnew.png', 'url' => '#', 'slug' => '/' . $getUrl . '/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            5 => array('id' => '070105', 'name' => 'Team\'s SMS Report\'s', 'icon' => '', 'micon' => 'img/TeamSMSReport.png', 'url' => '#', 'slug' => '/' . $getUrl . '/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                    2 => array('id' => '0702', 'name' => 'Email Alerts', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 4,
                        'submenu_ids' => '070201,070202,070203,070204', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '070201', 'name' => 'Email to Ids', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active'),
                            2 => array('id' => '070202', 'name' => 'Emails to Customers', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            3 => array('id' => '070203', 'name' => 'Emails Sent by Me', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            4 => array('id' => '070204', 'name' => 'Emails Sent by Team', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                    3 => array('id' => '0703', 'name' => 'Marketing Campaigning', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 3,
                        'submenu_ids' => '070301,070302,070303', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '070301', 'name' => 'Manage landing pages', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            2 => array('id' => '070302', 'name' => 'Create landing page', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            3 => array('id' => '070303', 'name' => 'Short Code Campaign', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                )),
            8 => array('name' => 'Accounts', 'icon' => 'acc-img menu-icon-sz', 'ui-sref-active' => '', 'url' => '', 'slug' => 'accounts', 'has_submenu' => true, 'total_submenu' => 4,
                'submenu_ids' => '0801,0802,0803,0804', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                    1 => array('id' => '0801', 'name' => 'BMS Invoices', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                        'submenu_ids' => '080101', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '080101', 'name' => 'Invoices', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                    2 => array('id' => '0802', 'name' => 'Orders', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 3,
                        'submenu_ids' => '080201,080202,080203', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '080201', 'name' => 'Offers', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            2 => array('id' => '080202', 'name' => 'Place Order', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            3 => array('id' => '080203', 'name' => 'Orders History', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                    3 => array('id' => '0803', 'name' => 'Payment Receipts', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 5,
                        'submenu_ids' => '080301,080302,080303,080304,080305', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '080301', 'name' => 'Rejected Payments', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            2 => array('id' => '080302', 'name' => 'Today\'s Payment', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            3 => array('id' => '080303', 'name' => 'Payment in Process', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            4 => array('id' => '080304', 'name' => 'Received Payments', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            5 => array('id' => '080305', 'name' => 'Upcoming Payments', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                    4 => array('id' => '0804', 'name' => 'Manage Bank Accounts', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                        'submenu_ids' => '080401', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '080401', 'name' => 'Manage', 'icon' => '', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                )),
            9 => array('name' => 'Reports', 'icon' => 'repo-img menu-icon-sz', 'ui-sref-active' => '', 'micon' => 'img/report.png','url' => '', 'slug' => 'reports', 'has_submenu' => true, 'total_submenu' => 2,
                'submenu_ids' => '0901,0902,0903', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                    1 => array('id' => '0901', 'name' => 'Pre Sales', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
                        'submenu_ids' => '090101,090102', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '090101', 'name' => 'My Reports', 'icon' => '', 'micon' => 'img/myReports.png','ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 3,
                                'submenu_ids' => '09010101,09010102,09010103', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '09010101', 'name' => 'Enquiry Report', 'icon' => '','micon' => 'img/enquiryReport.png', 'url' => '/reports/enquiryReport', 'slug' => 'enquiryReport', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    2 => array('id' => '09010102', 'name' => 'Followup Report', 'icon' => '', 'micon' => 'img/followupReport.png','url' => '/reports/followupReport', 'slug' => 'followupReport', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    3 => array('id' => '09010103', 'name' => 'Project Wise Report', 'icon' => '','micon' => 'img/projectWiseReport.png', 'url' => '/reports/projectwiseReport', 'slug' => 'projectwiseReport', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            2 => array('id' => '090102', 'name' => 'Team\'s Report', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 3,
                                'submenu_ids' => '09010201,09010202,09010203', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '09010201', 'name' => 'Enquiry Report', 'icon' => '', 'micon' => 'img/teamenquiryReport.png', 'url' => '/reports/teamEnquiryReport', 'slug' => 'teamenquiryReport', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    2 => array('id' => '09010202', 'name' => 'Followup Report', 'icon' => '', 'micon' => 'img/teamfollowupReport.png', 'url' => '/reports/teamFollowupReport', 'slug' => 'teamfollowupReport', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    3 => array('id' => '09010203', 'name' => 'Project Wise Report', 'icon' => '', 'micon' => 'img/teamprojectwiseTeamReport.png','url' => '/reports/projectwiseTeamReport', 'slug' => 'projectwiseTeamreport', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                        )),
                    2 => array('id' => '0903', 'name' => 'Post Sales', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
                        'submenu_ids' => '090301,090302', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '090301', 'name' => 'Project Wise Report', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 3,
                                'submenu_ids' => '09030101,09030102,09030103', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '09030101', 'name' => 'Overview Project Report', 'icon' => '', 'url' => '#', 'slug' => '#' . $getUrl . '/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    2 => array('id' => '09030102', 'name' => 'Heading Wise Project Report', 'icon' => '', 'url' => '#', 'slug' => '#' . $getUrl . '/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    3 => array('id' => '09030103', 'name' => 'Stage Wise Project Report', 'icon' => '', 'url' => '#', 'slug' => '#' . $getUrl . '/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            2 => array('id' => '090302', 'name' => 'All Projects ( Overview Report )', 'icon' => '', 'url' => '/reports/projectOverviewReport', 'slug' => 'projectOverviewReport', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                )),
            10 => array('name' => 'Careers', 'icon' => 'care-img menu-icon-sz', 'micon' => 'img/career.png','ui-sref-active' => '', 'url' => '', 'slug' => 'careers', 'has_submenu' => true, 'total_submenu' => 1,
                'submenu_ids' => '01001', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                    1 => array('id' => '01001', 'name' => 'Manage', 'icon' => '', 'micon' => 'img/manageCareer.png', 'url' => '/manageCareer/index', 'slug' => 'manageJobIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
            11 => array('name' => 'Cloud Telephony', 'icon' => 'cloud-img menu-icon-sz', 'ui-sref-active' => '', 'url' => '', 'slug' => 'cloud-telephony', 'has_submenu' => true, 'total_submenu' => 3,
                'submenu_ids' => '01101,01102,01103', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                    1 => array('id' => '01101', 'name' => 'Virtual Numbers', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 3,
                        'submenu_ids' => '0110101,0110102,0110103', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '0110101', 'name' => 'Manage Virtual Numbers', 'icon' => '', 'micon' => 'img/virtualNumber.png', 'url' => '/virtualnumber/index', 'slug' => 'virtualnumberslist', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            2 => array('id' => '0110102', 'name' => 'Manage Extensions', 'icon' => '', 'micon' => 'img/manageTemplates.png', 'url' => '/extensionemployee/index', 'slug' => 'extensionemplist', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            3 => array('id' => '0110103', 'name' => 'Out-bound Call Log', 'icon' => '', 'micon' => 'img/outBoundCall.png', 'url' => '/underconstruction', 'slug' => 'underconstruction', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                    2 => array('id' => '01102', 'name' => 'Call Logs', 'icon' => '', 'micon' => 'img/callLog.png', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 4,
                        'submenu_ids' => '0110201,0110202,0110203,0110204', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '0110201', 'name' => 'My Incoming Call Logs', 'micon' => 'img/incoming.call.png', 'icon' => '', 'url' => '/cloudcallinglogs/myIncomingLogs', 'slug' => 'inboundLogs', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            2 => array('id' => '0110202', 'name' => 'My Outgoing Call Logs', 'micon' => 'img/Myoutgoingcalls.png', 'icon' => '', 'url' => '/cloudcallinglogs/myOutgoingLogs', 'slug' => 'outboundLogs', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            3 => array('id' => '0110203', 'name' => 'Team\'s Incoming Call Logs', 'micon' => 'img/Teamincomingcalls.png', 'icon' => '', 'url' => '/cloudcallinglogs/teamIncomingLogs', 'slug' => 'teaminboundLogs', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            4 => array('id' => '0110204', 'name' => 'Team\'s Outgoing Call Logs', 'micon' => 'img/Teamoutgoingcalls.png', 'icon' => '', 'url' => '/cloudcallinglogs/teamOutgoingLogs', 'slug' => 'teamoutboundLogs', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                    3 => array('id' => '01103', 'name' => 'Telephony Registration', 'icon' => '', 'micon' => 'img/telephonyRegistration.png','ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                        'submenu_ids' => '0110301', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '0110301', 'name' => 'Manage', 'icon' => '','micon' => 'img/manageTelephony.png', 'url' => '/cloudtelephony/index', 'slug' => 'numbersIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                )),
            12 => array('name' => 'My Storage', 'icon' => 'stor-img menu-icon-sz', 'uiSrefActive' => '', 'url' => '', 'slug' => 'my-storage', 'has_submenu' => true, 'total_submenu' => 3,
                'submenu_ids' => '01201,01202,01203', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                    1 => array('id' => '01201', 'name' => 'Storage List', 'icon' => '', 'url' => '/storagelist/index', 'slug' => 'storageListIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    2 => array('id' => '01202', 'name' => 'Shared With Me', 'icon' => '', 'url' => '/storagelist/index', 'slug' => 'sharedWithMe', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    3 => array('id' => '01203', 'name' => 'Recycle Bin', 'icon' => '', 'url' => '/recyclebin/index', 'slug' => 'recycleBin', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
            13 => array('name' => 'Customer Care', 'icon' => 'sale-img menu-icon-sz', 'micon' => 'img/sales.logo.0.png', 'ui-sref-active' => '', 'url' => '', 'slug' => 'customer-care', 'has_submenu' => true, 'total_submenu' => 3,
                'submenu_ids' => '01301,01302,01303,01304', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                    1 => array('id' => '01301', 'name' => 'Pre-Sales', 'icon' => '', 'micon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
                        'submenu_ids' => '0130101,0130102', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '0130101', 'name' => 'My Followups', 'icon' => '', 'micon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
                                'submenu_ids' => '013010101,013010102,013010103,013010104,013010105', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '013010101', 'name' => 'My Today\'s Followups', 'icon' => '', 'micon' => 'img/myFollow.png', 'url' => '/customer-care/pre-sales/mytoday', 'slug' => 'customer-care-pre-sales-my-today', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    2 => array('id' => '013010102', 'name' => 'My Pending Followups', 'icon' => '', 'micon' => 'img/pendingFollow.png', 'url' => '/customer-care/pre-sales/mypending', 'slug' => 'customer-care-pre-sales-my-pending', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    3 => array('id' => '013010103', 'name' => 'My Previous Followups', 'icon' => '', 'micon' => 'img/previousFollow.png', 'url' => '/customer-care/pre-sales/myprevious', 'slug' => 'customer-care-pre-sales-my-previous', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    4 => array('id' => '013010104', 'name' => 'My Total Followups', 'icon' => '', 'micon' => 'img/totalEnq.png', 'url' => '/customer-care/pre-sales/mytotal', 'slug' => 'customer-care-pre-sales-my-total', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    5 => array('id' => '013010105', 'name' => 'My Completed Followups', 'icon' => '', 'micon' => 'img/bookedEnq.png', 'url' => '/customer-care/pre-sales/mycompleted', 'slug' => 'customer-care-pre-sales-my-completed', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            2 => array('id' => '0130102', 'name' => 'Team\'s  Followups', 'icon' => '', 'micon' => '', 'ui-sref-active' => '', 'slug' => 'Team', 'has_submenu' => true, 'total_submenu' => 2,
                                'submenu_ids' => '013010201,013010202,013010203,013010204,013010205', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '013010201', 'name' => 'Today\'s Followups', 'icon' => '', 'micon' => 'img/Team_todays_follow_ups.png', 'url' => '/customer-care/pre-sales/teamtoday', 'slug' => 'customer-care-pre-sales-team-today', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    2 => array('id' => '013010202', 'name' => 'Pending Followups', 'icon' => '', 'micon' => 'img/Team_pending_follow_ups.png', 'url' => '/customer-care/pre-sales/teampending', 'slug' => 'customer-care-pre-sales-team-pending', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    3 => array('id' => '013010203', 'name' => 'Previous Followups', 'icon' => '', 'micon' => 'img/Team_previous_Follow_ups.png', 'url' => '/customer-care/pre-sales/teamprevious', 'slug' => 'customer-care-pre-sales-team-previous', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    4 => array('id' => '013010204', 'name' => 'Total Followups', 'icon' => '', 'micon' => 'img/Team_total_followups.png', 'url' => '/customer-care/pre-sales/teamtotal', 'slug' => 'customer-care-pre-sales-team-total', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    5 => array('id' => '013010205', 'name' => 'Completed Followups', 'icon' => '', 'micon' => 'img/Team_book_enquiries.png', 'url' => '/customer-care/pre-sales/teamcompleted', 'slug' => 'customer-care-pre-sales-team-completed', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                        )),
                    2 => array('id' => '01302', 'name' => 'Pre-Sales', 'icon' => '', 'micon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
                        'submenu_ids' => '0130201,0130202', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '0130201', 'name' => 'My Followups', 'icon' => '', 'micon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 5,
                                'submenu_ids' => '013020101,013020102,013020103,013020104,013020105', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '013020101', 'name' => 'My Today\'s Followups', 'icon' => '', 'micon' => 'img/myFollow.png', 'url' => '/customer-care/post-sales/mytoday', 'slug' => 'customer-care-post-sales-my-today', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    2 => array('id' => '013020102', 'name' => 'My Pending Followups', 'icon' => '', 'micon' => 'img/pendingFollow.png', 'url' => '/customer-care/post-sales/mypending', 'slug' => 'customer-care-post-sales-my-pending', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    3 => array('id' => '013020103', 'name' => 'My Previous Followups', 'icon' => '', 'micon' => 'img/previousFollow.png', 'url' => '/customer-care/post-sales/myprevious', 'slug' => 'customer-care-post-sales-my-previous', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    4 => array('id' => '013020104', 'name' => 'My Total Followups', 'icon' => '', 'micon' => 'img/totalEnq.png', 'url' => '/customer-care/post-sales/mytotal', 'slug' => 'customer-care-post-sales-my-total', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    5 => array('id' => '013020105', 'name' => 'My Completed Followups', 'icon' => '', 'micon' => 'img/bookedEnq.png', 'url' => '/customer-care/post-sales/mycompleted', 'slug' => 'customer-care-post-sales-my-completed', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            2 => array('id' => '0130102', 'name' => 'Team\'s  Followups', 'icon' => '', 'micon' => 'img/Team_follow_ups.png', 'ui-sref-active' => '', 'slug' => 'Team', 'has_submenu' => true, 'total_submenu' => 5,
                                'submenu_ids' => '013020201,013020202,013020203,013020204,013020205', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '013020201', 'name' => 'Today\'s Followups', 'icon' => '', 'micon' => 'img/Team_todays_follow_ups.png', 'url' => '/customer-care/post-sales/teamtoday', 'slug' => 'customer-care-post-sales-team-today', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    2 => array('id' => '013020202', 'name' => 'Pending Followups', 'icon' => '', 'micon' => 'img/Team_pending_follow_ups.png', 'url' => '/customer-care/post-sales/teampending', 'slug' => 'customer-care-post-sales-team-pending', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    3 => array('id' => '013020203', 'name' => 'Previous Followups', 'icon' => '', 'micon' => 'img/Team_previous_Follow_ups.png', 'url' => '/customer-care/post-sales/teamprevious', 'slug' => 'customer-care-post-sales-team-previous', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    4 => array('id' => '013020204', 'name' => 'Total Followups', 'icon' => '', 'micon' => 'img/Team_total_followups.png', 'url' => '/customer-care/post-sales/teamtotal', 'slug' => 'customer-care-post-sales-team-total', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    5 => array('id' => '013020205', 'name' => 'Completed Followups', 'icon' => '', 'micon' => 'img/Team_book_enquiries.png', 'url' => '/customer-care/post-sales/teamcompleted', 'slug' => 'customer-care-post-sales-team-completed', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                        )),
                    2 => array('id' => '01302', 'name' => 'Post-Sales', 'icon' => '', 'micon' => 'img/ccPostSales.png', 'url' => '#', 'slug' => '#', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    3 => array('id' => '01303', 'name' => 'Pre-Services', 'icon' => '', 'micon' => 'img/ccPreServices.png', 'url' => '#', 'slug' => '#', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    4 => array('id' => '01304', 'name' => 'Post-Services', 'icon' => '', 'micon' => 'img/ccPostServies.png', 'url' => '#', 'slug' => '#', 'uiSrefActive' => 'active', 'total_submenu' => 1)
                )),
            14 => array('name' => 'BMS Other Permission', 'icon' => 'sale-img menu-icon-sz', 'micon' => 'img/sales.logo.0.png', 'ui-sref-active' => '', 'url' => '', 'slug' => 'other', 'has_submenu' => true, 'total_submenu' => 7,
                'submenu_ids' => '01401,01402,01403,01404,01405,01406,01407', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                    1 => array('id' => '01401', 'name' => 'Allow To Export', 'icon' => '', 'micon' => 'img/Todaysappointment.png', 'url' => '#', 'slug' => '#', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    2 => array('id' => '01402', 'name' => 'Allow To Delete', 'icon' => '', 'micon' => 'img/Todaysappointment.png', 'url' => '#', 'slug' => '#', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    3 => array('id' => '01403', 'name' => 'Allow To Call Outbound', 'icon' => '', 'micon' => 'img/Todaysappointment.png', 'url' => '#', 'slug' => '#', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    4 => array('id' => '01404', 'name' => 'Allow to use Mobile App', 'icon' => '', 'micon' => 'img/Todaysappointment.png', 'url' => '#', 'slug' => '#', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    5 => array('id' => '01405', 'name' => 'Track Employee Location', 'icon' => '', 'micon' => 'img/Todaysappointment.png', 'url' => '#', 'slug' => '#', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    6 => array('id' => '01406', 'name' => 'Hide Customer Details', 'icon' => '', 'micon' => 'img/Todaysappointment.png', 'url' => '#', 'slug' => '#', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    7 => array('id' => '01407', 'name' => 'Reassign Enquiries', 'icon' => '', 'micon' => 'img/reassignEnquiries.png', 'url' => '#', 'slug' => '#', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
            15 => array('name' => 'Share Enquiries', 'icon' => 'sale-img menu-icon-sz', 'micon' => 'img/sales.logo.0.png', 'ui-sref-active' => '', 'url' => '', 'slug' => 'enquiryShared', 'has_submenu' => true, 'total_submenu' => 2,
                'submenu_ids' => '01501,01502', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                    1 => array('id' => '01501', 'name' => 'Pre Sales Shared', 'icon' => '', 'micon' => 'img/Todaysappointment.png', 'url' => '#', 'slug' => '#', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    2 => array('id' => '01502', 'name' => 'Post Sales Shared', 'icon' => '', 'micon' => 'img/Todaysappointment.png', 'url' => '#', 'slug' => '#', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
        );
        return $menulist;
    }

}
