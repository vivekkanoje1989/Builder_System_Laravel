<style>
    .toggleClassActive {font-size:40px !important;cursor:pointer;color: #5cb85c !important;vertical-align: middle;margin-left: 15px;}
    .toggleClassInactive {font-size:40px !important;cursor:pointer;color: #d9534f !important;vertical-align: middle;margin-left: 15px;}
</style>
<style>
    .close {
        color:black;
    }
    .alert.alert-info {
        border-color: 1px solid #d9d9d9;
        /* background: rgba(173, 181, 185, 0.81); */
        background-color: #f5f5f5;
        border: 1px solid #d9d9d9;
        color: black;
        padding: 5px;
        width: 110%;
    }
</style>
<div class="row" ng-controller="alertsController" ng-init="manageAlerts('', 'index')">
    <div class="col-xs-12 col-md-12 mainDiv">
        <div class="widget">
            <div class="widget-header  bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Template Settings</span>
                <span class="helpDescription" ng-mouseover="showHelpTemplateSettings()">Help?</span> 
            </div>
            <div class="widget-body table-responsive">
                <div class="row table-toolbar">
                    <div class="btn-group pull-right filterBtn">
                        <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2">
                            <span>Actions</span>
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-default">
                                <li>
                                    <a href="" ng-click="templatesExportToxls()" ng-show="ExportTemplateData == '1'">Export</a>
                                </li>

                            </ul>
                        </a>
                    </div>
                    <div  class="dataTables_filter">
                        <label>
                            <input type="search" class="form-control input-sm" ng-model="search" name="search" >
                        </label>
                    </div>
                    <!-- filter data--> 
                    <div class="row" style="border:2px;" id="filter-show">
                        <div class="col-sm-12 col-xs-12">
                            <b ng-repeat="(key, value) in searchData">
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'event_name'" data-toggle="tooltip" title="Template For"><strong> Template For : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'template_for'" data-toggle="tooltip" title="Template To"><strong> Template To : </strong> {{ value == '1' ? "Customer":"Employee"}}</strong>
                                        <strong ng-if="key === 'account_number'" data-toggle="tooltip" title="Account Number"><strong> Account Number : </strong> {{ value}}</strong>
                                    </div>
                                </div>
                            </b>                        
                        </div>
                    </div>
                    <!-- filter data-->
                    <div class="dataTables_length" >
                        <label>
                            <select class="form-control" ng-model="itemsPerPage" name="itemsPerPage" onchange="if (/\D/g.test(this.value))this.value = this.value.replace(/\D/g, '')">
                                <option value="30">30</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                                <option value="300">300</option>
                                <option value="400">400</option>
                                <option value="500">500</option>
                                <option value="600">600</option>
                                <option value="700">700</option>
                                <option value="800">800</option>
                                <option value="900">900</option>
                                <option value="999">999</option>
                            </select>
                        </label>
                    </div>
                    <table class="table table-hover table-striped table-bordered tableHeader" at-config="config">
                        <thead class="bord-bot">
                            <tr>
                                <th style="width:3%">Sr. No.</th>
                                <th style="width: 15%">
                                    <a href="javascript:void(0);" ng-click="orderByField('event_name')">  Template For
                                        <span ><img ng-hide="(sortKey == 'event_name' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'event_name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'event_name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 7%">
                                    <a href="javascript:void(0);" ng-click="orderByField('template_for')"> Template To  
                                        <span ><img ng-hide="(sortKey == 'template_for' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'template_for' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'template_for' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>    
                                </th>
                                <th style="width: 10%">
                                    Template Category Default/Custom
                                </th>
                                <th style="width: 15%">
                                    Custom Template Name
                                </th>

                                <th style="width: 7%">
                                    SMS Off/On
                                </th>
                                <th style="width: 10%">
                                    Email Off/On                                
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('module_names')">Department
                                        <span ><img ng-hide="(sortKey == 'module_names' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'module_names' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'module_names' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>                                 
                                </th>
                                <th style="width: 10%">Action</th>

                            </tr>
                        </thead>

                        <tbody>
                            <tr role="row" dir-paginate="listAlert in listAlerts | filter:search | filter:searchData | itemsPerPage:itemsPerPage  | orderBy:sortKey:reverseSort" id='{{listAlert.id}}'>
                                <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                                <td ng-init='(listAlert.template_type == 1) ? template_type_list[listAlert.id] = 1 : template_type_list[listAlert.id] = 0'>{{ listAlert.event_name}}
                                    <span ng-init='(listAlert.email_status == 1) ? template_email_status_list[listAlert.id] = 1 : template_email_status_list[listAlert.id] = 0'></span>
                                    <span ng-init='(listAlert.sms_status == 1) ? template_sms_status_list[listAlert.id] = 1 : template_sms_status_list[listAlert.id] = 0'></span>
                                </td>
                                <td ng-if="listAlert.template_for == 1">Customer</td>
                                <td ng-if="listAlert.template_for == 0">Employee</td>
                                <td ng-if="listAlert.template_for == 1 && template_type_list[listAlert.id] == 1">
                                    <span class="fa fa-toggle-on toggleClassActive" ng-click="changeTemplateStatus(0, $index, listAlert.id)"></span>
                                </td>

                                <td ng-if="listAlert.template_for == 1 && template_type_list[listAlert.id] == 0"> 
                                    <span class="fa fa-toggle-on fa-rotate-180 toggleClassInactive" ng-click="changeTemplateStatus(1, $index, listAlert.id)"></span>
                                </td>



                                <td ng-if="listAlert.template_for == 1 && template_type_list[listAlert.id] == 1">

                                    <span ng-if='displayinit' ng-init='custom_template_disable[listAlert.id] = 1; custom_template_name[listAlert.id] = listAlert.friendly_name'></span>
                                    <span style="cursor: pointer;" ng-click="custom_template_dropdown_dispaly(listAlert.id, 0)">
                                        <div  ng-show='custom_template_name[listAlert.id] != null' class="alert alert-warning fade in" style="background:#e2e2e2;border-color: #5cb85c;">
                                            <button class="close">
                                                ×
                                            </button>
                                            {{custom_template_name[listAlert.id]}}
                                        </div>
                                    </span>
                                    <div ng-hide='custom_template_disable[listAlert.id] == 1'>
                                        <button class="close btn-default purple" style="margin-top: -10px;position: absolute;margin-left: 244px;z-index: 0;" ng-click="custom_template_dropdown_dispaly(listAlert.id, 1)">
                                            ×
                                        </button>
                                        <ui-select ng-model="custom_template_id[listAlert.id]" theme="select2" style='width: 90%;'  ng-change="update_custome_template($index, listAlert.id)" >                                        
                                            <ui-select-match placeholder="Select or search a custom template">{{$select.selected.friendly_name}}</ui-select-match>
                                            <ui-select-choices repeat="item in custom_template_list | filter: $select.search">
                                                <div ng-bind-html="item.friendly_name | highlight: $select.search" ></div>
                                            </ui-select-choices>
                                        </ui-select>
                                        <span>
                                            <br>
                                            <a class="btn btn-default purple" target="_blank" style="margin-top: 5px;" href="[[ config('global.backendUrl') ]]#/customalerts/create"><i class="fa fa-plus"></i> Add Custom Template</a>
                                        </span>

                                    </div>
                                </td>
                                <td ng-if="listAlert.template_for == 1 && template_type_list[listAlert.id] == 0"> </td>
                                <td ng-if="listAlert.template_category == 0 && listAlert.template_for == 0"><b> Default Only </b></td>


                                <td ng-if="listAlert.template_category == 0 && listAlert.template_for == 0"><b> Default Only </b></td>

                                <td ng-if="template_sms_status_list[listAlert.id] == 1">
                                    <span class="fa fa-toggle-on toggleClassActive" ng-click="changeSmsStatus(0, $index, listAlert.id);"></span>
                                </td>
                                <td ng-if="template_sms_status_list[listAlert.id] == 0">
                                    <span class="fa fa-toggle-on fa-rotate-180 toggleClassInactive" ng-click="changeSmsStatus(1, $index, listAlert.id);"></span>
                                </td>
                                <td ng-if="template_email_status_list[listAlert.id] == 1"> 
                                    <span class="fa fa-toggle-on toggleClassActive" ng-click="changeEmailStatus(0, $index, listAlert.id);"></span>
                                </td>
                                <td ng-if="template_email_status_list[listAlert.id] == 0">
                                    <span class="fa fa-toggle-on fa-rotate-180 toggleClassInactive" ng-click="changeEmailStatus(1, $index, listAlert.id);"></span>
                                </td>
                                <td>{{ listAlert.module_names}}</td>
                                <td class="">
                                    <!--div class="fa-hover" tooltip-html-unsafe="User Permissions" tooltip-placement="top" style="display: block;"><a href=""><i class="fa fa-user-plus"></i></a> &nbsp;&nbsp;</div-->
                                    <span class="" tooltip-html-unsafe="Edit User" ><a href="[[ config('global.backendUrl') ]]#/alerts/update/{{ listAlert.id}}" class=" btn-primary btn-xs"><i class="fa fa-edit"></i>Edit</a> &nbsp;&nbsp;</span>
                                    <span  ng-show="deleteBtn == '1'" class="" tooltip-html-unsafe="Delete"><a href="" ng-click="confirm({{listAlert.id}},{{$index}})" class="btn-danger btn-xs"><i class="fa fa-trash-o"></i>Delete</a></span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="15"  ng-show="(listAlerts | filter:search | filter:searchData).length == 0" align="center">Record Not Found</td>   
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <div class="DTTTFooter">
                        <div class="col-sm-6">
                            <!--<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing {{itemsPerPage * (noOfRows-1)+1}} to of {{ listdefaultAlertsLength }} entries</div>-->
                            <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{noOfRows}}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                                <dir-pagination-controls class="pagination" on-page-change="pageChangeHandler(newPageNumber)" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="bloodGroupFilter" role="form" ng-submit="filterDetails(searchDetails)">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>

            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Template For</label>
                        <span class="input-icon icon-right" ng-init="getTemplatesEvents()"> 
                            <select class="form-control"  ng-model="searchDetails.event_name" name="event_name" id="event_name" >
                                <option value="">Select Template</option>
                                <option ng-repeat="item in templateEvents" value="{{item.event_name}}" ng-selected="{{ item.event_name == searchDetails.event_name}}" >{{item.event_name}}</option>
                            </select>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Template To</label>
                        <span class="input-icon icon-right"> 
                            <select class="form-control"  ng-model="searchDetails.template_for" name="template_for" id="template_for" >
                                <option value="">Select</option>
                                <option value="1">Customer</option>
                                <option value="0">Employee</option>
                            </select>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" >
                    <div class="form-group">
                        <span class="input-icon icon-right" >
                            <button type="submit"  style="margin-left: 46%;" name="sbtbtn" value="Search" class="btn btn-primary toggleForm">Search</button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="/js/filterSlider.js"></script>
    <!-- Filter Form End-->
</div>

