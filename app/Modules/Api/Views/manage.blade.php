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
<div class="row" ng-controller="apiController" >
    <div class="mainDiv col-xs-12 col-md-12" ng-init="manageApis('', 'index')">
        <div class="widget">
            <div class="widget-header  bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Push API</span>

            </div>
            <div class="widget-body table-responsive">

                <div class="row table-toolbar">
                    <a href="[[ config('global.backendUrl') ]]#/pushapi/create" class="btn btn-default">Add New API</a>
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
                                    <a href="" ng-click="ApiExportToxls()" ng-show="exportData == '1'">Export</a>
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
                                        <strong ng-if="key === 'api_name'" data-toggle="tooltip" title="API Name"><strong> API Name : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'key'" data-toggle="tooltip" title="Key"><strong> Key : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'empName'" data-toggle="tooltip" title="Created by"><strong> Created By : </strong> {{ value}}</strong>
                                    </div>
                                </div>
                            </b>                        
                        </div>
                    </div>
                    <!-- filter data-->
                    <div class="dataTables_length" >
                        <label>
                            <select class="form-control" ng-model="itemsPerPage" name="itemsPerPage" onchange="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')">
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
                </div>
                <table class="table table-hover table-striped table-bordered tableHeader" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">Sr. No.</th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField('api_name')">API Name
                                    <span ><img ng-hide="(sortKey == 'api_name' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                    <span ng-show="(sortKey == 'api_name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                    <span ng-show="(sortKey == 'api_name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                </a> 
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField('key')">Key
                                    <span ><img ng-hide="(sortKey == 'key' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                    <span ng-show="(sortKey == 'key' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                    <span ng-show="(sortKey == 'key' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                </a>   
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField('key')">Created By 
                                    <span ><img ng-hide="(sortKey == 'empName' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                    <span ng-show="(sortKey == 'empName' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                    <span ng-show="(sortKey == 'empName' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                </a>   
                            </th>
                            <th style="width: 10%">
                                Document
                            </th>
                            <th style="width: 10%">
                                Status
                            </th>
                            <th style="width: 10%">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="list in listApis| filter:search |filter:searchData | itemsPerPage:itemsPerPage | orderBy:sortKey:reverseSort">
                            <td>{{ itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                            <td>{{ list.api_name}}</td>
                            <td>{{ list.key}}</td>
                            <td>{{ list.empName}}</td>
                            <td><p ng-if="list.pdf_name"> <a target="_blank" href="<?php echo config('global.s3Path') . "/Push-Apis/"; ?>{{ list.pdf_name}}">Download</a></p></td>
                            <td ng-if="list.status == 1">Active</td>
                            <td ng-if="list.status == 2">Deactive</td>
                            <td class="">
                                <div class="" tooltip-html-unsafe="Edit API" style="display: block;"><a href="[[ config('global.backendUrl') ]]#/pushapi/edit/{{ list.id}}" class="btn-primary btn-xs"><i class="fa fa-edit"></i>Edit</a> &nbsp;&nbsp;</div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10"  ng-show="(listUsers|filter:search).length == 0" align="center">Record Not Found</td>   
                        </tr>
                    </tbody>
                </table>
                <div class="DTTTFooter">
                    <div class="col-sm-6">
                        <!--<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing {{itemsPerPage * (noOfRows-1)+1}} to of {{ listUsersLength }} entries</div>-->
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

    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="firm&partnersFilter" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Api Name</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.api_name" name="api_name" class="form-control">
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Key</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.key" name="key" class="form-control">
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12" ng-controller="employeesCtrl">
                    <div class="form-group" >
                        <label for="">Created by</label>	
                        <select ng-model="searchDetails.empName" class="form-control" name="empName">
                            <option value="">Select Employee</option>
                            <option ng-repeat="list in employeeList"  value=" {{list.first_name}} {{list.last_name}}"> {{list.first_name}} {{list.last_name}}</option>
                        </select>
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" >
                    <div class="form-group">
                        <span class="input-icon icon-right" align="center">
                            <button type="submit" name="sbtbtn" value="Search" class="btn btn-primary toggleForm">Search</button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="/js/filterSlider.js"></script>
    <!-- Filter Form End-->

</div>
