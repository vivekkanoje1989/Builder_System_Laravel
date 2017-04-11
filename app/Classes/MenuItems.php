<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Classes;

class MenuItems {

    public static function getMenuItems() {
        $getUrl = config('global.getUrl');
        $menulist = array(
            1 => array('name' => 'Dashborad', 'icon' => 'dash-img menu-icon-sz', 'uiSrefActive' => '', 'url' => '', 'slug' => 'dashboard', 'has_submenu' => true, 'total_submenu' => 1,
                'submenu_ids' => '0101,0102,0103,0104,0105,0106,0107', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu','liClass' => 'open', 'submenu' => array( 
                1 => array('id' => '0101', 'name' => 'My Salary Slips', 'icon' => '', 'url' => '/'.$getUrl.'/databoxes', 'slug' => '.databoxes', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                2 => array('id' => '0102', 'name' => 'Request Leave', 'icon' => '',  'url' => '/'.$getUrl.'/requestLeave/index',  'slug' => '.requestLeaveIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                3 => array('id' => '0103', 'name' => 'Request Other Approval', 'icon' => '', 'url' => '/'.$getUrl.'/requestOtherApproval/index',  'slug' => '.requestOtherApprovalIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                4 => array('id' => '0104', 'name' => 'Requests for Me', 'icon' => '','url' => '/'.$getUrl.'/requestForMe/index',  'slug' => '.requestForMeIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                5 => array('id' => '0105', 'name' => 'My Requests', 'icon' => '', 'url' => '/'.$getUrl.'/myRequest/index',  'slug' => '.myRequestIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                6 => array('id' => '0106', 'name' => 'Configure Dashboard', 'icon' => '#', 'url' => '', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                7 => array('id' => '0107', 'name' => 'My Settings', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
            )),
            2 => array('name' => 'BMS', 'icon' => 'bms-img menu-icon-sz', 'ui-sref-active' => '', 'url' => '', 'slug' => 'bms', 'has_submenu' => true, 'total_submenu' => 3,
                'submenu_ids' => '0201,0202,0203', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(

                    1 => array('id' => '0201', 'name' => 'Website Settings', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 7,
                        'submenu_ids' => '020101,020102,020103,020104,020105,020106,020107', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '020101', 'name' => 'Image Management', 'icon' => '', 'url' => '#', 'slug' => '/' . $getUrl . '/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            2 => array('id' => '020102', 'name' => 'Content Management', 'icon' => '', 'url' => '/' . $getUrl . '/website_settings/contentpages', 'slug' => '.webPagesIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            3 => array('id' => '020103', 'name' => 'Contact Us', 'icon' => '', 'url' => '/' . $getUrl . '/contactUs/index', 'slug' => '.contactusIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            4 => array('id' => '020104', 'name' => 'Website Changing Module', 'icon' => '', 'url' => '#', 'slug' => '/' . $getUrl . '/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            5 => array('id' => '020105', 'name' => 'Webpage Management', 'icon' => '', 'url' => '#', 'slug' => '/' . $getUrl . '/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            6 => array('id' => '020106', 'name' => 'Social Websites Management', 'icon' => '', 'url' => '/' . $getUrl . '/bms_lists/social', 'slug' => '.socialwebIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            7 => array('id' => '020107', 'name' => 'Blogs Management', 'icon' => '', 'url' => '/' . $getUrl . '/manageblog/index', 'slug' => '.manageblogIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),
                    2 => array('id' => '0202', 'name' => 'BMS Settings', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 10,
                        'submenu_ids' => '020201,020202,020203,020204,020205,020206,020207,020208,020209,0202010', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '020201', 'name' => 'SMS & Email Settings', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 3,
                                'submenu_ids' => '02020101,02020102,02020103', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '02020101', 'name' => 'Default Templates & Settings', 'icon' => '', 'url' => '#', 'slug' => '/' . $getUrl . '/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    2 => array('id' => '02020102', 'name' => 'Custom Templates', 'icon' => '', 'url' => '#', 'slug' => '/' . $getUrl . '/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    3 => array('id' => '02020103', 'name' => 'SMS Templates', 'icon' => '', 'url' => '#', 'slug' => '/' . $getUrl . '/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            2 => array('id' => '020202', 'name' => 'BMS Lists Management', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 17,
                                'submenu_ids' => '02020201,02020202,02020203,02020204,02020205,02020206,02020207,02020208,02020209,02020210,02020211,02020212,02020213,02020214,02020215,02020216,02020217,02020218',
                                'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '02020201', 'name' => 'Manage Blood Groups', 'icon' => '', 'url' => '/' . $getUrl . '/bloodgroups/index', 'slug' => '.bloodGroupsIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    2 => array('id' => '02020202', 'name' => 'Manage Highest Education', 'icon' => '', 'url' => '/' . $getUrl . '/highesteducation/index', 'slug' => '.highesteducationIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    3 => array('id' => '02020203', 'name' => 'Manage Departments', 'icon' => '', 'url' => '/' . $getUrl . '/department/index', 'slug' => '.departmentIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    4 => array('id' => '02020204', 'name' => 'Manage Profession', 'icon' => '', 'url' => '/' . $getUrl . '/profession/index', 'slug' => '.professionIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    5 => array('id' => '02020205', 'name' => 'Manage Enquiry Source', 'icon' => '', 'url' => '/' . $getUrl . '/enquirysource/index', 'slug' => '.enquirySourceIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    6 => array('id' => '02020206', 'name' => 'Manage Lost Reasons', 'icon' => '', 'url' => '/' . $getUrl . '/lostreason/index', 'slug' => '.lostreasonsIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    7 => array('id' => '02020207', 'name' => 'Manage Project Types', 'icon' => '', 'url' => '/' . $getUrl . '/projecttypes/index', 'slug' => '.projecttypesIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    8 => array('id' => '02020208', 'name' => 'Manage Project Payment Stages', 'icon' => '', 'url' => '/' . $getUrl . '/projectstages/index', 'slug' => '.projectstagesIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    9 => array('id' => '02020209', 'name' => 'Manage Block Types', 'icon' => '', 'url' => '/' . $getUrl . '/blockTypes/index', 'slug' => '.blocktypesIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    10 => array('id' => '02020210', 'name' => 'Manage Block Stages', 'icon' => '', 'url' => '/' . $getUrl . '/blockstages/index', 'slug' => '.blockStagesIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    11 => array('id' => '02020211', 'name' => 'Manage Payment Headings', 'icon' => '', 'url' => '/' . $getUrl . '/paymentheading/index', 'slug' => '.paymentheadingIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    12 => array('id' => '02020212', 'name' => 'Manage Country', 'icon' => '', 'url' => '/' . $getUrl . '/country/index', 'slug' => '.countryIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    13 => array('id' => '02020213', 'name' => 'Manage States', 'icon' => '', 'url' => '/' . $getUrl . '/states/index', 'slug' => '.statesIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    14 => array('id' => '02020214', 'name' => 'Manage Cities', 'icon' => '', 'url' => '/' . $getUrl . '/city/index', 'slug' => '.cityIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                   // 15 => array('id' => '02020215', 'name' => 'Manage Locations', 'icon' => '', 'url' => '/'.$getUrl.'/location/index', 'slug' => '.locationIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    16 => array('id' => '02020216', 'name' => 'Manage Discount Headings', 'icon' => '', 'url' => '/'.$getUrl.'/discountheading/index', 'slug' => '.discountheadingIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    17 => array('id' => '02020217', 'name' => 'Manage Enquiry Location', 'icon' => '', 'url' => '/' . $getUrl . '/enquirylocation/index', 'slug' => '.enquirylocationIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    18 => array('id' => '02020218', 'name' => 'Manage Designations', 'icon' => '', 'url' => '/' . $getUrl . '/designations/index', 'slug' => '.designationsIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            3 => array('id' => '020203', 'name' => 'Auto Assign Web Enquires', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                                'submenu_ids' => '02020301', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '02020301', 'name' => 'Manage', 'icon' => '', 'url' => '#', 'slug' => '/' . $getUrl . '/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            4 => array('id' => '020204', 'name' => 'Firms & Partners', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                                'submenu_ids' => '02020401', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '02020401', 'name' => 'Manage Companies', 'icon' => '', 'url' => '#', 'slug' => '/' . $getUrl . '/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                             5 => array('id' => '020205', 'name' => 'Operational Settings', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'has_submenu' => true, 'total_submenu' => 1,
                                'submenu_ids' => '02020501', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '02020501', 'name' => 'Manage', 'icon' => '', 'url' => '/' . $getUrl . '/operationalSetting/index', 'slug' => '.operationalSettingIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            6 => array('id' => '020206', 'name' => 'Configure email accounts', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                                'submenu_ids' => '02020601', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '02020601', 'name' => 'Manage', 'icon' => '', 'url' => '/' . $getUrl . '/emailConfig/index', 'slug' => '.emailConfigIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            7 => array('id' => '020207', 'name' => 'API Management', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
                                'submenu_ids' => '02020701,02020702', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '02020701', 'name' => 'New API', 'icon' => '', 'url' => '#', 'slug' => '/' . $getUrl . '/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    2 => array('id' => '02020702', 'name' => 'Manage API', 'icon' => '', 'url' => '#', 'slug' => '/' . $getUrl . '/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            8 => array('id' => '020208', 'name' => 'Property Portals', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                                'submenu_ids' => '02020801', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '02020801', 'name' => 'Manage', 'icon' => '', 'url' => '/' . $getUrl . '/portals/index', 'slug' => '.propertyPortalIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            9 => array('id' => '020209', 'name' => 'Parking management', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
                                'submenu_ids' => '02020901,02020902', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '02020901', 'name' => 'Parking Type', 'icon' => '', 'url' => '#', 'slug' => '/' . $getUrl . '/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                    2 => array('id' => '02020902', 'name' => 'Parking Sub Type', 'icon' => '', 'url' => '#', 'slug' => '/' . $getUrl . '/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                            10 => array('id' => '0202010', 'name' => 'Device Configuration', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                                'submenu_ids' => '020201001', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '020201001', 'name' => 'Manage', 'icon' => '', 'url' => '/' . $getUrl . '/employeeDevice/index', 'slug' => '.employeeDeviceIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                        )),
                    3 => array('id' => '0203', 'name' => 'BMS Consumption', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 3,
                        'submenu_ids' => '020301,020302,020303', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                            1 => array('id' => '020301', 'name' => 'SMS Consumption', 'icon' => '', 'url' => '#', 'slug' => '/' . $getUrl . '/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            2 => array('id' => '020302', 'name' => 'Calls Consumption', 'icon' => '', 'url' => '#', 'slug' => '/' . $getUrl . '/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                            3 => array('id' => '020303', 'name' => 'Email Consumption', 'icon' => '', 'url' => '#', 'slug' => '/' . $getUrl . '/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        )),

                1 => array('id' => '0201', 'name' => 'Website Settings', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 7,
                    'submenu_ids' => '020101,020102,020103,020104,020105,020106,020107', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '020101', 'name' => 'Image Management', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    2 => array('id' => '020102', 'name' => 'Content Management', 'icon' => '', 'url' => '/'.$getUrl.'/website_settings/contentpages', 'slug' => '.webPagesIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),  
                    3 => array('id' => '020103', 'name' => 'Contact Us', 'icon' => '',  'url' => '/'.$getUrl.'/contactUs/index',  'slug' => '.contactusIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    4 => array('id' => '020104', 'name' => 'Website Changing Module', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    5 => array('id' => '020105', 'name' => 'Webpage Management', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    6 => array('id' => '020106', 'name' => 'Social Websites Management', 'icon' => '', 'url' => '/'.$getUrl.'/bms_lists/social',  'slug' => '.socialwebIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    7 => array('id' => '020107', 'name' => 'Blogs Management', 'icon' => '', 'url' => '/'.$getUrl.'/manageblog/index',  'slug' => '.manageblogIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
                    
                2 => array('id' => '0202', 'name' => 'BMS Settings', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 10,
                    'submenu_ids' => '020201,020202,020203,020204,020205,020206,020207,020208,020209,0202010', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(       
                    1 => array('id' => '020201', 'name' => 'SMS & Email Settings', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 3,
                    'submenu_ids' => '02020101,02020102,02020103', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array( 
                        1 => array('id' => '02020101', 'name' => 'Default Templates & Settings', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        2 => array('id' => '02020102', 'name' => 'Custom Templates', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        3 => array('id' => '02020103', 'name' => 'SMS Templates', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    )),
                    2 => array('id' => '020202', 'name' => 'BMS Lists Management', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 17,
                    'submenu_ids' => '02020201,02020202,02020203,02020204,02020205,02020206,02020207,02020208,02020209,02020210,02020211,02020212,02020213,02020214,02020215,02020216,02020217',
                        'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array( 
                        //1 => array('id' => '02020201', 'name' => 'Manage Blood Groups', 'icon' => '', 'url' => '/'.$getUrl.'/bloodgroups/index', 'slug' => '.bloodGroupsIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                       // 2 => array('id' => '02020202', 'name' => 'Manage Highest Education', 'icon' => '', 'url' => '/'.$getUrl.'/highesteducation/index', 'slug' => '.highesteducationIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        3 => array('id' => '02020203', 'name' => 'Manage Departments', 'icon' => '', 'url' => '/'.$getUrl.'/department/index', 'slug' => '.departmentIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        //4 => array('id' => '02020204', 'name' => 'Manage Profession', 'icon' => '', 'url' => '/'.$getUrl.'/profession/index', 'slug' => '.professionIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        //5 => array('id' => '02020205', 'name' => 'Manage Enquiry Source', 'icon' => '', 'url' => '/'.$getUrl.'/enquirysource/index', 'slug' => '.enquirySourceIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        6 => array('id' => '02020206', 'name' => 'Manage Lost Reasons', 'icon' => '',  'url' => '/'.$getUrl.'/lostreason/index', 'slug' => '.lostreasonsIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        7 => array('id' => '02020207', 'name' => 'Manage Project Types', 'icon' => '', 'url' => '/'.$getUrl.'/projecttypes/index', 'slug' => '.projecttypesIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        8 => array('id' => '02020208', 'name' => 'Manage Project Payment Stages', 'icon' => '', 'url' => '/'.$getUrl.'/projectstages/index', 'slug' => '.projectstagesIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        9 => array('id' => '02020209', 'name' => 'Manage Block Types', 'icon' => '', 'url' => '/'.$getUrl.'/blockTypes/index', 'slug' => '.blocktypesIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        10 => array('id' => '02020210', 'name' => 'Manage Block Stages', 'icon' => '',  'url' => '/'.$getUrl.'/blockstages/index', 'slug' => '.blockStagesIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        11 => array('id' => '02020211', 'name' => 'Manage Payment Headings', 'icon' => '',  'url' => '/'.$getUrl.'/paymentheading/index', 'slug' => '.paymentheadingIndex', 'uiSrefActive' => 'active','total_submenu' => 1),
                        //12 => array('id' => '02020212', 'name' => 'Manage Country', 'icon' => '','url' => '/'.$getUrl.'/country/index', 'slug' => '.countryIndex', 'uiSrefActive' => 'active','total_submenu' => 1),
                        //13 => array('id' => '02020213', 'name' => 'Manage States', 'icon' => '', 'url' => '/'.$getUrl.'/states/index', 'slug' => '.statesIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        //14 => array('id' => '02020214', 'name' => 'Manage Cities', 'icon' => '', 'url' => '/'.$getUrl.'/city/index', 'slug' => '.cityIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        //15 => array('id' => '02020215', 'name' => 'Manage Locations', 'icon' => '', 'url' => '/'.$getUrl.'/location/index', 'slug' => '.locationIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        //16 => array('id' => '02020216', 'name' => 'Manage Discount Headings', 'icon' => '', 'url' => '/'.$getUrl.'/discountheading/index', 'slug' => '.discountheadingIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        //17 => array('id' => '02020217', 'name' => 'Manage Enquiry Location', 'icon' => '', 'url' => '/' . $getUrl . '/enquirylocation/index', 'slug' => '.enquirylocationIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    )),
                    3 => array('id' => '020203', 'name' => 'Auto Assign Web Enquires', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                    'submenu_ids' => '02020301', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array( 
                        1 => array('id' => '02020301', 'name' => 'Manage', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    )),
                    4 => array('id' => '020204', 'name' => 'Firms & Partners', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                    'submenu_ids' => '02020401', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array( 
                        1 => array('id' => '02020401', 'name' => 'Manage Companies', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    )),
                     5 => array('id' => '020205', 'name' => 'Operational Settings', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'has_submenu' => true, 'total_submenu' => 1,
                                'submenu_ids' => '02020501', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                                    1 => array('id' => '02020501', 'name' => 'Manage', 'icon' => '', 'url' => '/' . $getUrl . '/operationalSetting/index', 'slug' => '.operationalSettingIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                                )),
                    6 => array('id' => '020206', 'name' => 'Configure email accounts', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                    'submenu_ids' => '02020601', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array( 
                        1 => array('id' => '02020601', 'name' => 'Manage', 'icon' => '','url' => '/'.$getUrl.'/emailConfig/index', 'slug' => '.emailConfigIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    )),
                    7 => array('id' => '020207', 'name' => 'API Management', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
                    'submenu_ids' => '02020701,02020702', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array( 
                        1 => array('id' => '02020701', 'name' => 'New API', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        2 => array('id' => '02020702', 'name' => 'Manage API', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    )),
                    8 => array('id' => '020208', 'name' => 'Property Portals', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                   'submenu_ids' => '02020801', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                        
                        1 => array('id' => '02020801', 'name' => 'Manage', 'icon' => '', 'url' => '/'.$getUrl.'/portals/index', 'slug' => '.propertyPortalIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    )),
                    9 => array('id' => '020209', 'name' => 'Parking management', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
                    'submenu_ids' => '02020901,02020902', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array( 
                        1 => array('id' => '02020901', 'name' => 'Parking Type', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        2 => array('id' => '02020902', 'name' => 'Parking Sub Type', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    )),
                    10 => array('id' => '0202010', 'name' => 'Device Configuration', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                   'submenu_ids' => '020201001', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array( 
                       1 => array('id' => '020201001', 'name' => 'Manage', 'icon' => '', 'url' => '/'.$getUrl.'/employeeDevice/index', 'slug' => '.employeeDeviceIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1), 
                   )),

                )),
                3 => array('id' => '0203', 'name' => 'BMS Consumption', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 3,
                'submenu_ids' => '020301,020302,020303', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '020301', 'name' => 'SMS Consumption', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    2 => array('id' => '020302', 'name' => 'Calls Consumption', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    3 => array('id' => '020303', 'name' => 'Email Consumption', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
            )),
            3 => array('name' => 'HR', 'icon' => 'hr-img menu-icon-sz', 'ui-sref-active' => '', 'url' => '', 'slug' => 'hr', 'has_submenu' => true, 'total_submenu' => 3,
                'submenu_ids' => '0301,0302', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                1 => array('id' => '0301', 'name' => 'User Management', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 4,
                    'submenu_ids' => '030101,030102,030103,030104', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '030101', 'name' => 'List Users', 'icon' => '', 'url' => '/'.$getUrl.'/user/index', 'slug' => '.userIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    2 => array('id' => '030102', 'name' => 'New User', 'icon' => '', 'url' => '/'.$getUrl.'/user', 'slug' => '.user', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    3 => array('id' => '030103', 'name' => 'Reassign Data', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    4 => array('id' => '030104', 'name' => 'Organization Chart', 'icon' => '', 'url' => '/'.$getUrl.'/user/orgchart', 'slug' => '.userChart', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
                2 => array('id' => '0302', 'name' => 'Salary Management', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                    'submenu_ids' => '030201', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '030201', 'name' => 'Salary Slips', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
            )),
            4 => array('name' => 'Sales', 'icon' => 'sale-img menu-icon-sz', 'ui-sref-active' => '', 'url' => '', 'slug' => 'sales', 'has_submenu' => true, 'total_submenu' => 3,
                'submenu_ids' => '0401,0402,0403,0404', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                1 => array('id' => '0401', 'name' => 'Enquiry Management', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 9,
                    'submenu_ids' => '040101,040102,040103,040104,040105,040106,040107,040108,040109', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '040101', 'name' => 'New Enquiry', 'icon' => '', 'url' => '/'.$getUrl.'/sales/create', 'slug' => '.salesCreate', 'uiSrefActive' => 'active'),
                    2 => array('id' => '040102', 'name' => 'My Today\'s Followups', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    3 => array('id' => '040103', 'name' => 'My Pending Followups', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    4 => array('id' => '040104', 'name' => 'My Previous Followups', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    5 => array('id' => '040105', 'name' => 'My Total Enquiries', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    6 => array('id' => '040106', 'name' => 'My Lost Enquiries', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    7 => array('id' => '040107', 'name' => 'My Closed Enquiries', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    8 => array('id' => '040108', 'name' => 'My Reassigned Enquiries', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    9 => array('id' => '040109', 'name' => 'Team\'s Enquiries', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 6,
                        'submenu_ids' => '04010901,04010902,04010903,04010904,04010905,04010906', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                        1 => array('id' => '04010901', 'name' => 'Todays Followups', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        2 => array('id' => '04010902', 'name' => 'Pending Followups', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        3 => array('id' => '04010903', 'name' => 'Previous Followups', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        4 => array('id' => '04010904', 'name' => 'Total Enquiries', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        5 => array('id' => '04010905', 'name' => 'Lost Enquiries', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        6 => array('id' => '04010906', 'name' => 'Closed Enquiries', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    )),
                )),
                2 => array('id' => '0402', 'name' => 'Deal Management', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 4,
                    'submenu_ids' => '040201,040202,040203,040204', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '040201', 'name' => 'New Deal', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    2 => array('id' => '040202', 'name' => 'My Ongoing Deals', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    3 => array('id' => '040203', 'name' => 'My Demand letters', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    4 => array('id' => '040204', 'name' => 'Team\'s Deals', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
                        'submenu_ids' => '04020401,04020402', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                        1 => array('id' => '04020401', 'name' => 'Ongoing Deals', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        2 => array('id' => '04020402', 'name' => 'Demand letters', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    )),
                )),
                3 => array('id' => '0403', 'name' => 'Collection Followup\'s', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 5,
                    'submenu_ids' => '040301,040302,040303,040304,040305', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '040301', 'name' => 'Today\'s Collection\'s ', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    2 => array('id' => '040302', 'name' => 'Pending Collection\'s', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    3 => array('id' => '040303', 'name' => 'Total Collection\'s', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    4 => array('id' => '040304', 'name' => 'Upcoming Collection\'s', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    5 => array('id' => '040305', 'name' => 'Team\'s Collection\'s', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 4,
                        'submenu_ids' => '04030101,04030102,04030103,04030104', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                        1 => array('id' => '04030101', 'name' => 'Today\'s Collection\'s', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        2 => array('id' => '04030102', 'name' => 'Pending Collection\'s', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        3 => array('id' => '04030103', 'name' => 'Total Collection\'s', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        4 => array('id' => '04030104', 'name' => 'Upcoming Collection\'s', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    )),
                )),
                4 => array('id' => '0404', 'name' => 'Customer\'s Data', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
                    'submenu_ids' => '040401,040402', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '040401', 'name' => 'Manage Customer\'s', 'icon' => '', 'url' => '/'.$getUrl.'/customer/index', 'slug' => '.customerDataIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    2 => array('id' => '040402', 'name' => 'Import Enquiries', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
            )),
            5 => array('name' => 'Projects', 'icon' => 'proj-img menu-icon-sz', 'ui-sref-active' => '', 'url' => '', 'slug' => 'projects', 'has_submenu' => true, 'total_submenu' => 3,
                'submenu_ids' => '0501,0502,0503,0504', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                1 => array('id' => '0501', 'name' => 'Projects Management', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 5,
                    'submenu_ids' => '050101,050102,050103,050104,050105', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '050101', 'name' => 'Manage Projects', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    2 => array('id' => '050102', 'name' => 'New Project', 'icon' => '', 'url' => '/'.$getUrl.'/project/create', 'slug' => '.projectCreate', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    3 => array('id' => '050103', 'name' => 'Project Webpage', 'icon' => '', 'url' => '/'.$getUrl.'/project/webpage', 'slug' => '.projectWebPage', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    4 => array('id' => '050104', 'name' => 'Project Wings', 'icon' => '', 'url' => '/'.$getUrl.'/wings/index', 'slug' => '.wingsIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    5 => array('id' => '050105', 'name' => 'Project Availability', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
                2 => array('id' => '0502', 'name' => 'Manage Project Stages', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'has_submenu' => true,'uiSrefActive' => 'active','total_submenu' => 1,
                    'submenu_ids' => '050201', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '050201', 'name' => 'Manage', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
                3 => array('id' => '0503', 'name' => 'Manage Block Stages', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                    'submenu_ids' => '050301', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '050301', 'name' => 'Manage', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
                4 => array('id' => '0504', 'name' => 'Rate Management', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
                    'submenu_ids' => '050401,050402', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '050401', 'name' => 'Manage Rate\'s', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    2 => array('id' => '050402', 'name' => 'Manage Floor Rise', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
            )),
            6 => array('name' => 'Response', 'icon' => 'resp-img menu-icon-sz', 'ui-sref-active' => '', 'url' => '', 'slug' => 'response', 'has_submenu' => true, 'total_submenu' => 4,
                'submenu_ids' => '0601,0602,0603,0604', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                1 => array('id' => '0601', 'name' => 'Web Enquiries', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                    'submenu_ids' => '060101', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '060101', 'name' => 'Manage', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
                2 => array('id' => '0602', 'name' => 'Contact us Queries', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                    'submenu_ids' => '060201', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '060201', 'name' => 'Manage', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
                3 => array('id' => '0603', 'name' => 'Testimonials', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                    'submenu_ids' => '060301,060302,060303', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '060301', 'name' => 'Approve', 'icon' => '','url' => '/'.$getUrl.'/testimonials/index', 'slug' => '.testimonialsIndex', 'uiSrefActive' => 'active'),
                    2 => array('id' => '060302', 'name' => 'Create', 'icon' => '', 'url' => '/'.$getUrl.'/testimonials/create', 'slug' => '.testimonialsCreate', 'uiSrefActive' => 'active'),
                    3 => array('id' => '060303', 'name' => 'Manage', 'icon' => '', 'url' => '/'.$getUrl.'/testimonials/manage', 'slug' => '.testimonialsManage', 'uiSrefActive' => 'active'),
                )),
                4 => array('id' => '0604', 'name' => 'Website Visitors', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                    'submenu_ids' => '060401', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '060401', 'name' => 'Show Visitors', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
            )),
            7 => array('name' => 'Marketing', 'icon' => 'mark-img menu-icon-sz', 'ui-sref-active' => '', 'url' => '', 'slug' => 'marketing', 'has_submenu' => true, 'total_submenu' => 3,
                'submenu_ids' => '0701,0702,0703', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                1 => array('id' => '0701', 'name' => 'Promotional SMS', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 3,
                    'submenu_ids' => '070101,070102,070103', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '070101', 'name' => 'Send SMS', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    2 => array('id' => '070102', 'name' => 'My SMS Report\'s', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    3 => array('id' => '070103', 'name' => 'Team\'s SMS Report\'s', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
                2 => array('id' => '0702', 'name' => 'Email Alerts', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 4,
                    'submenu_ids' => '070201,070202,070203,070204', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '070201', 'name' => 'Email to Ids', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active'),
                    2 => array('id' => '070202', 'name' => 'Emails to Customers', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    3 => array('id' => '070203', 'name' => 'Emails Sent by Me', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    4 => array('id' => '070204', 'name' => 'Emails Sent by Team', 'icon' => '', 'url' => '#', 'slug' => '', 'uiSrefActive' => 'active', 'total_submenu' => 1),                    
                )),
                3 => array('id' => '0703', 'name' => 'Marketing Campaigning', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 3,
                    'submenu_ids' => '070301,070302,070303', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '070301', 'name' => 'Manage landing pages', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    2 => array('id' => '070302', 'name' => 'Create landing page', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    3 => array('id' => '070303', 'name' => 'Short Code Campaign', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
            )),
            8 => array('name' => 'Accounts', 'icon' => 'acc-img menu-icon-sz', 'ui-sref-active' => '', 'url' => '', 'slug' => 'accounts', 'has_submenu' => true, 'total_submenu' => 4,
                'submenu_ids' => '0801,0802,0803,0804', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                1 => array('id' => '0801', 'name' => 'BMS Invoices', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                    'submenu_ids' => '080101', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '080101', 'name' => 'Invoices', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
                2 => array('id' => '0802', 'name' => 'Orders', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 3,
                    'submenu_ids' => '080201,080202,080203', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '080201', 'name' => 'Offers', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    2 => array('id' => '080202', 'name' => 'Place Order', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    3 => array('id' => '080203', 'name' => 'Orders History', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
                3 => array('id' => '0803', 'name' => 'Payment Receipts', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 5,
                    'submenu_ids' => '080301,080302,080303,080304,080305', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '080301', 'name' => 'Rejected Payments', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    2 => array('id' => '080302', 'name' => 'Todays Payment', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    3 => array('id' => '080303', 'name' => 'Payment in Process', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    4 => array('id' => '080304', 'name' => 'Received Payments', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    5 => array('id' => '080305', 'name' => 'Upcoming Payments', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
                4 => array('id' => '0804', 'name' => 'Manage Bank Accounts', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                    'submenu_ids' => '080401', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '080401', 'name' => 'Manage', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
            )),
            9 => array('name' => 'Reports', 'icon' => 'repo-img menu-icon-sz', 'ui-sref-active' => '', 'url' => '', 'slug' => 'reports', 'has_submenu' => true, 'total_submenu' => 2,
                'submenu_ids' => '0901,0902,0903', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                1 => array('id' => '0901', 'name' => 'Pre Sales', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
                    'submenu_ids' => '090101,090102', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '090101', 'name' => 'My Reports', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 3,
                    'submenu_ids' => '09010101,09010102,09010103', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                        1 => array('id' => '09010101', 'name' => 'Enquiry Report', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        2 => array('id' => '09010102', 'name' => 'Followup Report', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        3 => array('id' => '09010103', 'name' => 'Project Wise Report', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    )),
                    2 => array('id' => '090102', 'name' => 'Enquiry Report', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 3,
                    'submenu_ids' => '09010201,09010202,09010203', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                        1 => array('id' => '09010201', 'name' => 'Enquiry Report', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        2 => array('id' => '09010202', 'name' => 'Followup Report', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        3 => array('id' => '09010203', 'name' => 'Project Wise Report', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    )),
                )),
                2 => array('id' => '0903', 'name' => 'Post Sales', 'icon' => 'menu-icon glyphicon glyphicon-home', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 2,
                    'submenu_ids' => '090301,090302', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '090301', 'name' => 'Project Wise Report', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 3,
                    'submenu_ids' => '09030101,09030102,09030103', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                        1 => array('id' => '09030101', 'name' => 'Overview Project Report', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        2 => array('id' => '09030102', 'name' => 'Heading Wise Project Report', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                        3 => array('id' => '09030103', 'name' => 'Stage Wise Project Report', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    )),
                    2 => array('id' => '090302', 'name' => 'All Projects ( Overview Report )', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
            )),
            10 => array('name' => 'Careers', 'icon' => 'care-img menu-icon-sz', 'ui-sref-active' => '', 'url' => '', 'slug' => 'careers', 'has_submenu' => true, 'total_submenu' => 2,
                'submenu_ids' => '01001,01002', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                1 => array('id' => '01001', 'name' => 'Manage Job Postings', 'icon' => '', 'url' => '/'.$getUrl.'/manageCareer/index',  'slug' => '.manageJobIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                2 => array('id' => '01002', 'name' => 'Create Job Posting', 'icon' => '', 'url' => '/'.$getUrl.'/manageCareer/create',  'slug' => '.createJobIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
            )),
            11 => array('name' => 'Cloud Telephony', 'icon' => 'cloud-img menu-icon-sz', 'ui-sref-active' => '', 'url' => '', 'slug' => 'cloud-telephony', 'has_submenu' => true, 'total_submenu' => 3,
                'submenu_ids' => '01101,01102,01103', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(
                1 => array('id' => '01101', 'name' => 'Manage Virtual Numbers', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 3,
                    'submenu_ids' => '0110101,0110102,0110103', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '0110101', 'name' => 'Virtual Numbers', 'icon' => '', 'url' => '/'.$getUrl.'/virtualnumber/index', 'slug' => '.virtualnumberslist', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    2 => array('id' => '0110102', 'name' => 'Manage Templates', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    3 => array('id' => '0110103', 'name' => 'Out-bound Call Log', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
                2 => array('id' => '01102', 'name' => 'Call Logs', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 4,
                    'submenu_ids' => '0110201,0110202,0110203,0110204', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '0110201', 'name' => 'My Incoming Call Logs', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    2 => array('id' => '0110202', 'name' => 'My Outgoing Call Logs', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    3 => array('id' => '0110203', 'name' => 'Team\'s Incoming Call Logs', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                    4 => array('id' => '0110204', 'name' => 'Team\'s Outgoing Call Logs', 'icon' => '', 'url' => '#', 'slug' => '/'.$getUrl.'/', 'uiSrefActive' => 'active', 'total_submenu' => 1),                        
                )),
                3 => array('id' => '01103', 'name' => 'Telephony Registration', 'icon' => '', 'ui-sref-active' => '', 'slug' => '#', 'has_submenu' => true, 'total_submenu' => 1,
                    'submenu_ids' => '0110301', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu', 'liClass' => 'open', 'submenu' => array(                    
                    1 => array('id' => '0110301', 'name' => 'Registration', 'icon' => '', 'url' => '/'.$getUrl.'/cloudtelephony/index', 'slug' => '.numbersIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                )),
            )),
            12 => array('name' => 'My Storage', 'icon' => 'stor-img menu-icon-sz', 'uiSrefActive' => '', 'url' => '', 'slug' => 'my-storage', 'has_submenu' => true, 'total_submenu' => 3,
                'submenu_ids' => '01201,01202,01203', 'anchorClass' => 'menu-dropdown', 'submenuClass' => 'submenu','liClass' => 'open', 'submenu' => array( 
                1 => array('id' => '01201', 'name' => 'Storage List', 'icon' => '','url' => '/'.$getUrl.'/storagelist/index', 'slug' => '.storageListIndex', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                2 => array('id' => '01202', 'name' => 'Shared With Me', 'icon' => '', 'url' => '/'.$getUrl.'/storagelist/index', 'slug' => '.sharedWithMe', 'uiSrefActive' => 'active', 'total_submenu' => 1),
                3 => array('id' => '01203', 'name' => 'Recycle Bin', 'icon' => '', 'url' => '/'.$getUrl.'/recyclebin/index', 'slug' => '.recycleBin', 'uiSrefActive' => 'active', 'total_submenu' => 1),
            )),
        );
        return $menulist;
    }

}

//["0101","0102","0103","0104","0105","0106","0107","0201","020101","020102","020103","020104","020105","020106","020107","0202","020201","02020101","02020102","02020103","020202","02020201","02020202","02020203","02020204","02020205","02020206","02020207","02020208","02020209","02020210","02020211","02020212","02020213","02020214","02020215","020203","02020301","020204","02020401","020205","02020501","020206","02020601","020207","02020701","02020702","020208","02020801","020209","02020901","02020902","0203","020301","020302","020303","0301","030101","030102","030103","030104","0302","030201","0401","040101","040102","040103","040104","040105","040106","040107","040108","040109","0402","040201","040202","040203","040204","0403","040301","040302","040303","040304","040305","0404","040401","040402","0501","050101","050101","050101","050101","0502","0503","050301","0504","050401","050402","0601","060101","0602","060201","0603","060301","060302","060303","0604","060401","0701","070101","070102","070103","0702","070201","070202","070203","070204","0703","070301","070302","070303","0801","080101","0802","080201","080202","080203","0803","080301","080302","080303","080304","080305","0804","080401","0901","090101","09010101","09010102","09010103","090102","0902","090201","090202","090203","0903","090301","09030101","09030102","09030103","090302","01001","01002","01101","0110101","0110102","0110103","01102","0110201","0110202","0110203","0110204","01103","0110301","01201","01202","01203"]
