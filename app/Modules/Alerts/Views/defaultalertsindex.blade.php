
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
<div class="row" ng-controller="defaultalertsController" ng-init="manageDafaultAlerts('', 'index')">
    <div class="col-xs-12 col-md-12 mainDiv">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Default Templates</span>

            </div>
            <div class="widget-body table-responsive">
                <div class="row table-toolbar">
                    <div class="btn-group pull-right filterBtn">
                        <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>

                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View Excel" ng-click="defaultTemplatesExportToxls();" ng-show="exportData == '1'">
                            <span>Export</span>
                        </a>
                        <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2">
                            <span>Options</span>
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-default">
                                <li>
                                    <a href="javascript:void(0);">Action</a>
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
                            <b ng-repeat="(key, value) in searchData" >
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'event_name'" data-toggle="tooltip" title="Template For"><strong> Template For : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'template_for'" data-toggle="tooltip" title="Template To"><strong> Template To : </strong> {{ value == '1' ? "Customer":"Employee"}}</strong>
                                        <strong ng-if="key === 'email_subject'" data-toggle="tooltip" title="Email Subject"><strong> Email Subject : </strong> {{ value}}</strong>
                                    </div>
                                </div>
                            </b>                        
                        </div>
                    </div>
                    <!-- filter data-->
                    <div class="dataTables_length" >
                        <label>
                            <select class="form-control" ng-model="itemsPerPage" name="itemsPerPage" onchange="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')">
                                <option value="1">1</option>
                                <option value="5">5</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="100">100</option>
                            </select>
                        </label>
                    </div>
                    <table class="table table-hover table-striped table-bordered tableHeader" at-config="config">
                        <thead class="bord-bot">
                            <tr>
                                <th style="width:5%">Sr. No.</th>
                                <th style="width: 20%">
                                     <a href="javascript:void(0);" ng-click="orderByField('event_name')">Template For
                                        <span ><img ng-hide="(sortKey == 'event_name' &&(reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'event_name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'event_name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 20%">
                                    <a href="javascript:void(0);" ng-click="orderByField('template_for')">Template To
                                        <span ><img ng-hide="(sortKey == 'template_for' &&(reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'template_for' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'template_for' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 30%">
                                     <a href="javascript:void(0);" ng-click="orderByField('email_subject')">Email Subject
                                        <span ><img ng-hide="(sortKey == 'email_subject' &&(reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'email_subject' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'email_subject' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" dir-paginate="listAlert in listdefaultAlerts | filter:search  | filter:searchData | itemsPerPage:itemsPerPage | orderBy:sortKey:reverseSort">
                                <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                                <td>{{ listAlert.event_name}}</td>
                                <td ng-if="listAlert.template_for == 1">Customer</td>
                                <td ng-if="listAlert.template_for == 0">Employee</td>
                                <td>{{ listAlert.email_subject | htmlToPlaintext }}</td>
                                <td class="">
                                    <span class="" tooltip-html-unsafe="Edit User" ><a href="[[ config('global.backendUrl') ]]#/defaultalerts/update/{{ listAlert.id}}" class="btn-info btn-xs"><i class="fa fa-edit"></i>Edit</a> &nbsp;&nbsp;</span>
                                    <span  ng-show="deleteBtn == '1'" class="" tooltip-html-unsafe="Delete"><a href="" ng-click="deleteDefaultTemplate({{listAlert.id}},{{$index}})" class="btn-danger btn-xs"><i class="fa fa-trash-o"></i>Delete</a></span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6"  ng-show="(listdefaultAlerts|filter:search | filter:searchData ).length == 0" align="center">Record Not Found</td>   
                            </tr>
                        </tbody>
                    </table>
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

                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Email Subject</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.email_subject" name="email_subject" class="form-control">
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


