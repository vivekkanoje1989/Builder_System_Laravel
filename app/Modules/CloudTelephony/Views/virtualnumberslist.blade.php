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
                <div class="widget-body table-responsive">
                    <div class="row table-toolbar">
                        <a href="[[ config('global.backendUrl') ]]#/cloudtelephony/virtualnumberwiseusers" class="btn btn-default">Virtual Number Wise Users</a>&nbsp;&nbsp;&nbsp;
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
                                        <a href="" ng-click="virtualNumberExportToxls()" ng-show="exportVirtualData == '1'">Export</a>
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
                                    <th style="width:5%">Sr. No.</th>
                                    <th style="width:7%">
                                        <a href="javascript:void(0);" ng-click="orderByField('virtual_display_number')">Virtual Number
                                            <span ><img ng-hide="(sortKey == 'virtual_display_number' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                            <span ng-show="(sortKey == 'virtual_display_number' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                            <span ng-show="(sortKey == 'virtual_display_number' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                        </a>
                                    </th>
                                    <th style="width:7%">
                                        <a href="javascript:void(0);" ng-click="orderByField('source_name')">Source
                                            <span ><img ng-hide="(sortKey == 'source_name' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                            <span ng-show="(sortKey == 'source_name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                            <span ng-show="(sortKey == 'source_name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                        </a>
                                    </th>
                                    <th style="width:7%">
                                        <a href="javascript:void(0);" ng-click="orderByField('sub_source_id')">Sub Source
                                            <span ><img ng-hide="(sortKey == 'sub_source_id' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                            <span ng-show="(sortKey == 'sub_source_id' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                            <span ng-show="(sortKey == 'sub_source_id' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                        </a>
                                    </th>
                                    <th style="width:10%">
                                        <a href="javascript:void(0);" ng-click="orderByField('forwarding_type_id')">Forwarding Type
                                            <span ><img ng-hide="(sortKey == 'forwarding_type_id' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                            <span ng-show="(sortKey == 'forwarding_type_id' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                            <span ng-show="(sortKey == 'forwarding_type_id' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                        </a>
                                    </th>
                                    <th style="width:10%">
                                        <a href="javascript:void(0);" ng-click="orderByField('menu_status')">Menu
                                            <span ><img ng-hide="(sortKey == 'menu_status' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                            <span ng-show="(sortKey == 'menu_status' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                            <span ng-show="(sortKey == 'menu_status' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                        </a>
                                    </th>
                                    <th style="width:15%">
                                        <a href="javascript:void(0);" ng-click="orderByField('employee_name')">Employee
                                            <span ><img ng-hide="(sortKey == 'employee_name' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                            <span ng-show="(sortKey == 'employee_name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                            <span ng-show="(sortKey == 'employee_name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                        </a>
                                    </th>
                                    <th style="width: 10%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr role="row" dir-paginate="listNumber in listNumbers | filter:search | filter:searchData | itemsPerPage:itemsPerPage | orderBy:sortKey:reverseSort" >
                                    <td>{{ itemsPerPage * (noOfRows - 1) + $index + 1}}</td> 
                                    <td>{{ listNumber.virtual_display_number}}</td>
                                    <td>{{listNumber.source_name}}</td>
                                    <td ng-if="listNumber.sub_source_id == 0">--</td>
                                    <td ng-if="listNumber.sub_source_id != 0">{{listNumber.subsource}}</td>
                                    <td >{{listNumber.forwarding_type}}</td>
                                    <td ng-if="listNumber.menu_status == 1">
                                        <span ng-bind-html=" listNumber.ext_name"></span>
                                    </td>
                                    <td ng-if="listNumber.menu_status == 0">No</td>
                                    <td><span ng-bind-html=" listNumber.employee_name"></span></td>


                                    <td class="">
                                        <span class="" tooltip-html-unsafe="Edit" ><a href="[[ config('global.backendUrl') ]]#/virtualnumber/update/{{ listNumber.id}}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i>Edit</a></span>
                                        <span ng-show="deleteData == '1'" class="" tooltip-html-unsafe="Delete"><a href="" ng-click="deleteVirtualNumber({{listNumber.id}},{{$index}})" class="btn-danger btn-xs"><i class="fa fa-trash-o"></i>Delete</a></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8"  ng-show="(listNumbers|filter:search | filter:searchData ).length == 0" align="center">Record Not Found</td>   
                                    <td colspan="8"  ng-show="searchLength == 0" align="center">Record Not Found</td>   
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
                <div class=" col-xs-12" >
                    <div class="form-group"   ng-init="getEmployeeData()">
                        <label for="">Employee</label>   
                        <select class="form-control"  ng-model="searchDetails.employee_name" name="employee_name" id="employee_id" >
                            <option value="">Select Employee</option>
                            <option ng-repeat="item in ct_employee" value="{{item.employee}}" ng-selected="{{ item.employee == searchDetails.employee_name}}" >{{item.employee}}</option>
                        </select>

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


