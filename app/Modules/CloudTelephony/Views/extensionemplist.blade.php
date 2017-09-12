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
<div class="row" ng-controller="extensionemployeeController" ng-init="manageExtEmpLists('', 'index')">
    <div class="col-xs-12 col-md-12 mainDiv">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Employees Extensions</span>
            </div>
            <div class="widget-body table-responsive">
                <!--                <div class="row">
                                    <div class="col-sm-3 col-xs-12">
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
                                            <input type="text" minlength="1" maxlength="3" ng-model="itemsPerPage" ng-model-options="{ updateOn: 'blur' }" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for=""></label>
                                            <span class="input-icon icon-right">
                                                <a href data-toggle="modal" data-target="#addExtensionModal" ng-click="initExtensionModal(ct_employee_extlist)" class="btn btn-primary btn-right">Add New Extension</a>
                                            </span>
                                        </div>
                                    </div>
                                </div><hr>-->
                <div class="widget-body table-responsive">

                    <div class="row table-toolbar">
                         <a href data-toggle="modal" data-target="#addExtensionModal" ng-click="initExtensionModal(ct_employee_extlist)" class="btn btn-default">Add New Extension</a>
                        <!--<a id="editabledatatable_new" href="" class="btn btn-default" data-toggle="modal" data-target="#verticalModal" ng-click="initialModal(0, '', '', '', '')">Add New Vertical</a>-->
                        <div class="btn-group pull-right" ng-click="initExtensionModal(ct_employee_extlist)" >
                            <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                        </div>
                    </div>
                    <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                        <div class="DTTT btn-group">
                            <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View Excel" ng-click="employeeExtExportToxls()" ng-show="exportEmpExtensionData == '1'">
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
                                            <strong ng-if="key === 'extension_no'" data-toggle="tooltip" title="Extension No"><strong> Extension No: </strong>{{value}}</strong>
                                            <strong ng-if="key === 'employee'" data-toggle="tooltip" title="Employee Name"><strong> Employee Name: </strong>{{value}}</strong>
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
                                    <th style="width:7%">Employee Name</th>
                                    <th style="width:7%">Extension Number</th>
                                    <th style="width: 5%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr role="row" dir-paginate="listNumber in ct_employee_extlist | filter:search | filter:searchData | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort" >
                                    <td>{{ itemsPerPage * (noOfRows - 1) + $index + 1}}</td> 
                                    <td>{{ listNumber.employee}}</td>
                                    <td>Extension &nbsp;{{listNumber.extension_no}}</td>
                                    <td class="">
                                        <span class="" tooltip-html-unsafe="Edit" ><a href="javascript:void(0)" data-toggle="modal"  data-target="#addExtensionModal" ng-click="editExtensionModal(ct_employee_extlist, listNumber)" class='btn-info btn-xs'><i class="fa fa-edit"></i>Edit</a> &nbsp;&nbsp;</span>
                                     <span class="" tooltip-html-unsafe="Delete"><a href="" ng-click="deleteEmpExt({{listNumber.id}},{{$index}})" class="btn-danger btn-xs"><i class="fa fa-trash-o"></i>Delete</a></span>
                                </td>
                                </tr>
                                <tr>
                                    <td colspan="5"  ng-show="(listNumbers | filter:search).length == 0" align="center">Record Not Found</td>   
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
                    <!-- Model -->
                    <div class="modal fade modal-primary" id="addExtensionModal" role="dialog" tabindex='-1'>
                        <div class="modal-dialog modal-md">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header navbar-inner">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title" align="center">Add Extension</h4>
                                </div>
                                <form novalidate role="form" name="extensionForm" ng-submit="extensionForm.$valid && createExtension(extensionData)">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-xs-12">
                                            <div class="col-sm-12">
                                                <div class="form-group" >
                                                    <label for="">Employee<span class="sp-err">*</span></label>   
                                                    <select class="form-control"  ng-model="extensionData.employee_id" name="employee_id" id="employee_id" required="">
                                                        <option value="">Select Employee</option>
                                                        <option ng-repeat="item in ext_employee" value="{{item.id}}" ng-selected="{{ item.id == extensionData.employee_id}}" >{{item.first_name}}&nbsp;({{item.designation}})</option>
                                                    </select>
                                                    <div ng-show="sbtBtn" ng-messages="extensionForm.employee_id.$error" class="help-block errMsg">
                                                        <div style="color: red" ng-message="required">This field is required</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="">Extension Number<span class="sp-err">*</span></label>
                                                    <select class="form-control"  ng-model="extensionData.extension_no" name="extension_no" id="extension_no" required="">
                                                        <option value="">Select Extension</option>
                                                        <option ng-repeat="item in ext_number" value="{{item}}" ng-selected="{{ item == extensionData.extension_no}}">Extension&nbsp;{{item}}</option>
                                                    </select>
                                                    <div ng-show="sbtBtn" ng-messages="extensionForm.extension_no.$error" class="help-block errMsg">
                                                        <div style="color: red" ng-message="required">This field is required</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12" >
                                                <div class="form-group">
                                                    <label for=""></label>
                                                    <span class="input-icon icon-right">
                                                        <button type="submit" ng-click="sbtBtn = true" ng-disabled="btnSubmit" class="btn btn-primary pull-right custom-btn">{{btnlable}}</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>                         
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Model -->
                </div>
            </div>
        </div>
    </div>
    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout" ng-controller="adminController" >
        <form name="blockStageFilter" role="form" ng-submit="filterDetails(searchDetails)"  ng-init="getEmployeeData()">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group" >
                        <label for="">Employee<span class="sp-err">*</span></label>   
                        <select class="form-control"  ng-model="searchDetails.employee" name="employee" id="employee_id" >
                            <option value="">Select Employee</option>
                            <option ng-repeat="item in ct_employee" value="{{item.employee}}" ng-selected="{{ item.employee == searchDetails.employee}}" >{{item.employee}}</option>
                        </select>

                    </div>

                </div>
                <div class="col-sm-12" ng-controller="extensionemployeeController" ng-init="getEmployeeExtData()">
                    <div class="form-group">
                        <label for="">Extension Number</label>
                        <select class="form-control"  ng-model="searchDetails.extension_no" name="extension_no" id="extension_no">
                            <option value="">Select Extension</option>
                            <option ng-repeat="item in extNumber" value="{{item}}" ng-selected="{{ item == searchDetails.extension_no}}">Extension&nbsp;{{item}}</option>
                        </select>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" >
                    <div class="form-group">
                        <span class="input-icon icon-right" >
                            <button type="submit"  style="margin-left: 46%;" name="sbtbtn" value="Search" class="btn btn-primary toggleForm" >Search</button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="/js/filterSlider.js"></script>
    <!-- Filter Form End-->
</div>



