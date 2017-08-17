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
<div class="row" ng-controller="manageDepartmentCtrl" ng-init="manageDepartment()">  
    <div>
        <flash-message duration="5000"></flash-message>
    </div>
    <div class=" mainDiv col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Department</span>                
            </div>
            <div class="widget-body table-responsive">
                <div class="row">
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
                                <a href="" data-toggle="modal" data-target="#departmentModal" ng-click="initialModal(0)" class="btn btn-primary btn-right">Add Department</a>
                                <button type="button" class="btn btn-primary btn-right toggleForm" style="margin-right: 10px;"><i class="btn-label fa fa-filter"></i>Show Filter</button>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- filter data-->
                <div class="row" style="border:2px;" id="filter-show">
                    <div class="col-sm-12 col-xs-12">
                        <b ng-repeat="(key, value) in searchData" ng-if="value != 0">
                            <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                <div class="alert alert-info fade in">
                                    <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                    <strong ng-if="key === 'department_name'" data-toggle="tooltip" title="Department Name"><strong> Department Name : </strong> {{ value}}</strong>
                                    <strong ng-if="key === 'verticalData'" data-toggle="tooltip" title="Vertical"><strong> Vertical : </strong> {{ value}}</strong>
                                </div>
                            </div>
                        </b>                        
                    </div>
                </div>
                <!-- filter data-->
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                        <tr>
                            <th style="width:5%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'id'; reverseSort = !reverseSort">Sr. No.
                                    <span ng-show="orderByField == 'id'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>                 
                            <th style="width: 30%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'department_name'; reverseSort = !reverseSort">Department
                                    <span ng-show="orderByField == 'department_name'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 30%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'vertical_name'; reverseSort = !reverseSort">Vertical Name
                                    <span ng-show="orderByField == 'vertical_name'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th> 
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="list in departmentRow| filter:search |filter:searchData | itemsPerPage:itemsPerPage |orderBy:orderByField:reverseSort" >
                            <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}} </td>
                            <td>{{ list.department_name}}</td>                          
                            <td>{{ list.verticalData}}</td>
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit department" style="display: block;" data-toggle="modal" data-target="#departmentModal"><a href="javascript:void(0);" ng-click="initialModal({{ list.id}},{{list}},{{ itemsPerPage}},{{$index}})"><i class="fa fa-pencil"></i></a></div>
                            </td> 
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
    <div class="modal fade" id="departmentModal" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{heading}}</h4>
                </div>
                <input type="hidden" class="form-control" ng-model="id" name="id">
                <form novalidate ng-submit="departmentForm.$valid && doDepartmentAction(departmentData)" name="departmentForm" role="form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Department Name<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="departmentData.department_name" id="department_name" name="department_name"  ng-change="errorMsg = null" required>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="departmentForm.department_name.$error">
                                    <div ng-message="required">Department is required</div>
                                    <div ng-if="errorMsg" class="err">{{errorMsg}}</div>
                                </div>
                            </span> 
                        </div>
                        <div class="form-group">
                            <label>Select Vertical<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select ng-model="departmentData.vertical_id" name="vertical_id" id="vertical_id" class="form-control" ng-controller="verticalCtrl" ng-change="errorMsg = null"  required>
                                    <option ng-repeat="v in verticals track by $index" value="{{v.id}}"  ng-selected="{{ v.id == departmentData.vertical_id}}">{{v.name}}</option>                                    
                                </select>
                                <i class="fa fa-sort-desc"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="departmentForm.vertical_id.$error" >
                                    <div ng-message="required">Verticals name is required.</div>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer" align="center">
                        <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true" ng-disabled="deptBtn">{{action}}</button>
                    </div> 
                </form>
            </div>
        </div>
    </div>
    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="departmentFilter" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Department</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.department_name" name="department_name" class="form-control">
                        </span>
                    </div>

                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Vertical</label>
                        <span class="input-icon icon-right">
                            <select ng-model="searchDetails.verticalData" name="verticalData" id="vertical_id" class="form-control" ng-controller="verticalCtrl" ng-change="errorMsg = null"  >
                                <option ng-repeat="v in verticals track by $index" value="{{v.name}}"  ng-selected="{{ v.name == departmentData.vertica_name}}">{{v.name}}</option>                                    
                            </select>
                            <i class="fa fa-sort-desc"></i>
                        </span>
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