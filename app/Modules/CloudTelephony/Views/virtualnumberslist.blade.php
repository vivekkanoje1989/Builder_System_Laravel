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
<div class="row" ng-controller="cloudtelephonyController" ng-init="managevLists('', 'index')">    
    <div class="col-xs-12 col-md-12 mainDiv">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Virtual Numbers</span>
            </div>
            <div class="widget-body table-responsive">
                <!--                <div class="row">
                                    <div class="col-md-3 col-xs-12">
                                        <div class="form-group">
                                            <label for="search">Search:</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="search" name="search" class="form-control">
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label for="search">Records per page:</label>
                                            <input type="text" minlength="1" maxlength="3" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" style="width:30%;" class="form-control" ng-model="itemsPerPage">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for=""></label>
                                            <span class="input-icon icon-right">
                                                <a href="[[ config('global.backendUrl') ]]#/cloudtelephony/virtualnumberwiseusers" class="btn btn-primary btn-right">Virtual Number Wise Users</a>&nbsp;&nbsp;&nbsp;
                                            </span>
                                        </div>
                                    </div>
                                </div> -->
                <div class="widget-body table-responsive">

                    <div class="row table-toolbar">
                        <a href="[[ config('global.backendUrl') ]]#/cloudtelephony/virtualnumberwiseusers" class="btn btn-default">Virtual Number Wise Users</a>&nbsp;&nbsp;&nbsp;
                        <!--<a id="editabledatatable_new" href="" class="btn btn-default" data-toggle="modal" data-target="#verticalModal" ng-click="initialModal(0, '', '', '', '')">Add New Vertical</a>-->
                        <div class="btn-group pull-right">
                            <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                        </div>
                    </div>
                    <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                        <div class="DTTT btn-group">
                            <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View Excel" ng-click="virtualNumberExportToxls()" ng-show="exportVirtualData == '1'">
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
                                <b ng-repeat="(key, value) in searchData" ng-if="value != 0 && key != 'toDate'">
                                    <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                        <div class="alert alert-info fade in">
                                            <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                            <strong ng-if="key === 'virtual_display_number'" data-toggle="tooltip" title="Virtual Number"><strong> Virtual Number : </strong> {{ value}}</strong>
                                            <strong ng-if="key === 'source_name'" data-toggle="tooltip" title="Source"><strong> Source: </strong> {{ value}}</strong>
                                            <strong ng-if="key === 'sub_source_id'" data-toggle="tooltip" title="Sub Source"><strong> Sub Source: </strong> {{ value}}</strong>
                                            <strong ng-if="key === 'forwarding_type'" data-toggle="tooltip" title="Forwarding Type"><strong> Forwarding Type: </strong>{{value}}</strong>
                                            <strong ng-if="key === 'employee_name'" data-toggle="tooltip" title="Employee Name"><strong> Employee Name: </strong>{{value}}</strong>
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
                                    <th style="width:7%">
                                        <a href="javascript:void(0);" ng-click="orderByField = 'virtual_display_number'; reverseSort = !reverseSort">Virtual Number
                                            <span ng-show="orderByField == 'virtual_display_number'">
                                                <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                        </a>
                                    </th>
                                    <th style="width:7%">
                                        <a href="javascript:void(0);" ng-click="orderByField = 'source_name'; reverseSort = !reverseSort">Source
                                            <span ng-show="orderByField == 'source_name'">
                                                <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                        </a>
                                    </th>
                                    <th style="width:7%">
                                        <a href="javascript:void(0);" ng-click="orderByField = 'sub_source_id'; reverseSort = !reverseSort">Sub Source
                                            <span ng-show="orderByField == 'sub_source_id'">
                                                <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                        </a>
                                    </th>
                                    <th style="width:10%">
                                        <a href="javascript:void(0);" ng-click="orderByField = 'forwarding_type_id'; reverseSort = !reverseSort">Forwarding Type
                                            <span ng-show="orderByField == 'forwarding_type_id'">
                                                <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                        </a>
                                    </th>
                                    <th style="width:10%">
                                        <a href="javascript:void(0);" ng-click="orderByField = 'menu_status'; reverseSort = !reverseSort">Menu
                                            <span ng-show="orderByField == 'menu_status'">
                                                <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                        </a>
                                    </th>
                                    <th style="width:20%">
                                        <a href="javascript:void(0);" ng-click="orderByField = 'employee_name'; reverseSort = !reverseSort">Employee
                                            <span ng-show="orderByField == 'employee_name'">
                                                <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                        </a>
                                    </th>
                                    <th style="width: 5%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr role="row" dir-paginate="listNumber in listNumbers | filter:search | filter:searchData | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort" >
                                    <td>{{ itemsPerPage * (noOfRows - 1) + $index + 1}}</td> 
                                    <td>{{ listNumber.virtual_display_number}}</td>
                                    <td>{{listNumber.source_name}}</td>
                                    <td ng-if="listNumber.sub_source_id == 0">--</td>
                                    <td ng-if="listNumber.sub_source_id != 0">{{listNumber.subsource}}</td>
                                    <td >{{listNumber.forwarding_type}}</td>

<!--                                    <td ng-if="listNumber.forwarding_type_id == 1">Parallel Forwarding</td>
                                    <td ng-if="listNumber.forwarding_type_id == 2">Sequential Forwarding</td>
                                    <td ng-if="listNumber.forwarding_type_id == 3">Round Robin Forwarding</td>
                                    <td ng-if="listNumber.forwarding_type_id == 0">--</td>-->

                                    <td ng-if="listNumber.menu_status == 1">
                                        <span ng-bind-html=" listNumber.ext_name"></span>
                                    </td>
                                    <td ng-if="listNumber.menu_status == 0">No</td>
                                    <td><span ng-bind-html=" listNumber.employee_name"></span></td>


                                    <td class="">
                                        <div class="" tooltip-html-unsafe="Edit" style="display: block;"><a href="[[ config('global.backendUrl') ]]#/virtualnumber/update/{{ listNumber.id}}" class="btn-info btn-xs"><i class="fa fa-edit"></i>Edit</a></div>
                                    </td>
                                </tr>
                                <tr>
                                    <!--<td colspan="8"  ng-show="searchLength == undefined || searchLength== 0" align="center">Record Not Found</td>-->   
                                </tr>
                            </tbody>
                        </table>
                        <div class="DTTTFooter">
                            <div class="col-sm-6">
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
    </div>

    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="virtualNumberFilter" role="form" ng-submit="filterDetails(searchDetails)">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Virtual Number</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.virtual_display_number" name="virtual_display_number" class="form-control">

                        </span>
                    </div>

                </div>
                <div class="col-sm-12 col-xs-12" ng-controller="salesSourceCtrl">
                    <div class="form-group">
                        <label for="">Select source</label>
                        <span class="input-icon icon-right">
                            <select class="form-control" ng-change="onsalesSoucesChange(searchDetails.source_name)" ng-model="searchDetails.source_name" name="source_name" id="source_id" >
                                <option value="">Select Source</option>
                                <option ng-repeat="source in salessources" value="{{source.sales_source_name}}" ng-selected="{{source.sales_source_name == searchDetails.source_name}}">{{source.sales_source_name}}</option>
                            </select>
                            <i class="fa fa-sort-desc"></i>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12" ng-controller="salesSourceCtrl">
                    <div class="form-group">
                        <label for="">Select subsource</label>
                        <span class="input-icon icon-right">
                            <select class="form-control" ng-model="searchDetails.sub_source_id" name="sub_source_id" id="sales_subsource_id">
                                <option value="">Select Subsource</option>
                                <option ng-repeat="subSource in subSourceList" value="{{subSource.enquiry_subsource}}" ng-selected="{{subSource.id == searchDetails.sub_source_id}}">{{subSource.enquiry_subsource}}</option>
                            </select>   
                            <i class="fa fa-sort-desc"></i>

                        </span>                                            
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group" >
                        <label for="">Forwarding Type </label>
                        <span class="input-icon icon-right">
                            <select ng-model="searchDetails.forwarding_type" name="forwarding_type" ng-init="ct_forwarding_types()" class="form-control" >
                                <option value="">Select Forwarding Type</option>
                                <option ng-repeat="ct_forwarding_type in ct_forwarding_types" value="{{ct_forwarding_type.type}}">{{ct_forwarding_type.type}}</option>
                            </select>
                            <i class="fa fa-sort-desc"></i>
                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.forwarding_type_id}} </span>
                        </span>
                    </div>
                </div>
                <!--                <div class=" col-xs-12" ng-controller="getEmployeeCtrl">
                                    <div class="form-group" >
                                        <label for="">Select Employees</label>	
                                        <span class="input-icon icon-right">
                                            <ui-select multiple ng-model="searchDetails.employee_name" name="employee_name" theme="select2" ui-select-required ng-disabled="disabled" style="width: 100%;">
                                                <ui-select-match placeholder="Select Employees">{{$item.first_name}} {{$item.last_name}}&nbsp;( {{$item.designation_name.designation}} )</ui-select-match>
                                                <ui-select-choices repeat="list in employees1 | filter:$select.search">
                                                    {{list.first_name}}  {{list.last_name}}&nbsp;( {{list.designation_name.designation}} )
                                                </ui-select-choices>
                                            </ui-select>
                                            <i class="fa fa-sort-desc"></i>
                
                                        </span>
                                    </div>
                                </div> -->
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


