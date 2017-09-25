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
    .hrbtn { 
        margin-bottom: -10px;
    }
    .hrbtn a{   
        width: 118px;
        display: block;
        text-align: center;
        margin-bottom:4px !important;
    }
</style>

<div class="row" ng-controller="hrController" ng-init="manageUsers('', 'index')">
    <div class="mainDiv col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-themeprimary ">
                <span class="widget-caption">Manage Users</span>
            </div>
            <div class="widget-body table-responsive">

                <div class="row table-toolbar">
                    <div class="btn-group">
                        <a class="btn btn-default shiny " href="javascript:void(0);">Add Employee</a>
                        <a class="btn btn-default  dropdown-toggle shiny" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="[[ config('global.backendUrl') ]]#/user/create">Add New User</a>
                            </li>
                            <li>
                                <a href="[[ config('global.backendUrl') ]]#/user/quickuser">Quick User</a>
                            </li>
                            <li>
                                <a href="[[ config('global.backendUrl') ]]#/user/showpermissions" >Permission Wise Users</a>
                            </li>

                        </ul>
                    </div>
                    <!---->
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
                                    <a href="" ng-click="hrDetailsExporToxls()" ng-show="exportData == '1'" >Export</a>
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
                            <b ng-repeat="(key, value) in searchData" ng-if="value != 0">
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'firstName'" data-toggle="tooltip" title="Employee Name"><strong>Employee Name : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'designation'" data-toggle="tooltip" title="Designation"><strong>Designation : </strong>{{ value}}</strong>
                                        <strong ng-if="key === 'departmentName'"  data-toggle="tooltip" title="Department"><strong>Department : </strong>{{ value}}</strong>
                                        <strong ng-if="key === 'team_lead_name'"  data-toggle="tooltip" title="Team Lead"><strong>Team Lead : </strong>{{ value}}</strong>
                                        <strong ng-if="key === 'reporting_to_name'"  data-toggle="tooltip" title="Reporting To"><strong>Reporting To : </strong>{{ value}}</strong>
                                        <strong ng-if="key === 'joining_date'"  data-toggle="tooltip" title="Joining Date"><strong>Joining Date : </strong>{{ searchData.joining_date | date:'dd-MM-yyyy' }} </strong>
                                        <strong ng-if="key === 'login_date_time'"  data-toggle="tooltip" title="Last Login Date"><strong>Last Login Date : </strong>{{ value}} </strong>
                                        <strong ng-if="key === 'employee_status'"  data-toggle="tooltip" title=""><strong>Employee Status: </strong>{{ searchData.employee_status == 1? 'Active':'Temporary Suspended'}} </strong>
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
                                <th style="width:5%">SR No.</th>
                                <th style="width: 10%"> 
                                    <a href="javascript:void(0);" ng-click="orderByField('firstName')">Employee Name
                                        <span ><img ng-hide="(sortKey == 'firstName' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'firstName' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'firstName' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('designation')">Designation 
                                        <span ><img ng-hide="(sortKey == 'designation' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'designation' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'designation' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('reporting_to_name')">Reporting To 
                                        <span ><img ng-hide="(sortKey == 'reporting_to_name' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'reporting_to_name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'reporting_to_name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('team_lead_name')">Team Lead 
                                        <span ><img ng-hide="(sortKey == 'team_lead_name' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'team_lead_name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'team_lead_name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 15%">
                                    <a href="javascript:void(0);" ng-click="orderByField('departmentName')">Departments
                                        <span ><img ng-hide="(sortKey == 'departmentName' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'departmentName' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'departmentName' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('joining_date')">Joining Date
                                        <span ><img ng-hide="(sortKey == 'joining_date' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'joining_date' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'joining_date' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 5%">
                                    <a href="javascript:void(0);" ng-click="orderByField('employee_status')">Status
                                        <span ><img ng-hide="(sortKey == 'employee_status' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'employee_status' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'employee_status' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('login_date_time')">Last Login
                                        <span ><img ng-hide="(sortKey == 'login_date_time' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'login_date_time' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'login_date_time' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" dir-paginate="listUser in listUsers | filter:search |filter:searchData | itemsPerPage:itemsPerPage | orderBy:sortKey:reverseSort " >
                                <td>{{ itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                                <td>{{ listUser.firstName}}</td>
                                <td>{{ listUser.designation == null? '-' : listUser.designation}}</td>
                                <td>{{ listUser.reporting_to_name == null? '-': listUser.reporting_to_name}}</td>
                                <td>{{ listUser.team_lead_name == null? '-': listUser.team_lead_name }}</td>
                                <td>{{ listUser.departmentName.split(',').join(', ') == null?'-':listUser.departmentName.split(',').join(', ')}}</td>
                                <td>{{ listUser.joining_date == '0000-00-00' ? '-' : listUser.joining_date | date : "dd-MM-yyyy"  }}</td>
                                <td ng-if="listUser.employee_status == 1">Active</td>
                                <td ng-if="listUser.employee_status == 2">Temporary Suspended</td>
                                <td ng-if="listUser.employee_status == 3">Permanent Suspended</td>
                                <td>{{ listUser.login_date_time == null ? '-' : listUser.login_date_time | date : "dd-MM-yyyy"  }}</td>
                                <td class="">
                                    <div class="hrbtn" tooltip-html-unsafe="Edit User" ><a href="[[ config('global.backendUrl') ]]#/user/update/{{ listUser.id}}" class="btn-info btn-xs"><i class="fa fa-edit"></i>Edit</a> &nbsp;&nbsp;</div>
                                    <div class="hrbtn" tooltip-html-unsafe="User Permissions" tooltip-placement="top" ><a href="[[ config('global.backendUrl') ]]#/user/permissions/{{ listUser.id}}"  class=" btn-success btn-xs"><i class="fa fa-user-plus"></i>Permissions</a> &nbsp;&nbsp;</div>
                                    <div class="hrbtn" tooltip-html-unsafe="Change Password" data-toggle="modal" data-target="#myModal" ><a href="javascript:void(0);" ng-click="manageUsers({{ listUser.id}},'changePassword')"  class="btn-warning btn-xs"><i class="fa fa-lock"></i>Change Password</a>&nbsp;&nbsp;</div>
                                    <div class="hrbtn" tooltip-html-unsafe="Suspend Employee" ><a href ng-click="employeeSuspend({{ listUser.id}},$index)" class="btn-danger btn-xs"><i class="fa fa-user-times"></i>Suspend</a>&nbsp;&nbsp;</div>
                                </td>
                        </tr>
                        <tr>
                            <td colspan="10"  ng-show="(listUsers|filter:search | filter:searchData).length == 0" align="center">Record Not Found</td>   
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
                    <div data-ng-include="'/MasterHr/showFilter'"></div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade modal-primary" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="passwordClosebtn" class="close" ng-click="step1 = false" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">Change Password</h4>
                </div>
                <form name="userForm" novalidate ng-submit="userForm.$valid && changePassword(modal)">
                    <div class="modal-body">

                        <div class="form-group">
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="modal.firstName" name="firstName" placeholder="First Name">
                                <i class="fa fa-user thm-color circular"></i>
                            </span>
                        </div>
                        <div class="form-group">
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="modal.lastName" name="lastName" placeholder="Last Name">
                                <i class="fa fa-user thm-color circular"></i>
                            </span>
                        </div>
                        <div class="form-group">
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="modal.userName" name="userName" placeholder="User Name">
                                <i class="fa fa-user thm-color circular"></i>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer" align="center">
                        <button type="submit" class="btn btn-sub  btn-primary" ng-click="step1 = true">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="BulkModal" role="dialog" tabindex='-1'>
        <div class="modal-dialog modal-md" >
            <!-- Modal content-->
            <div class="modal-content" >
                <div class="modal-header navbar-inner">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center"> Reassign Enquiries</h4>
                </div>
                <form name="bulkForm"   ng-submit="bulkForm.$valid && bulkreasignemployee(bulkData)" novalidate >
                    <div class="modal-body">
                        <div  ng-if="totsalesEnquiries > '0'">
                            <div class="row">
                                <div class="col-sm-4 col-sx-12">
                                    <label for="">Sales Enquiries Reassign To</label>
                                </div>
                                <div class="col-sm-5 col-sx-12">
                                    <div class="form-group" >
                                        <select class="form-control"  ng-model="bulkData.sales_employee_id" name="sales_employee_id" id="sales_employee_id" ng-init="getsalesEmployees(suspendId)" required>
                                            <option value="">Select Employee</option>
                                            <option ng-repeat="item in salesemployeeList" value="{{item.id}}"  >{{item.first_name}} {{item.last_name}} ({{item.designation_name.designation}})</option>
                                        </select>
                                        <div ng-show="sbtBtn" ng-messages="bulkForm.sales_employee_id.$error" class="help-block errMsg">
                                            <div style="sp-err" ng-message="required">Please Select Employee</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3"></div>
                            </div>
                            <div class="">
                                <span><strong>Total Enquires found : {{totsalesEnquiries}}</strong></span>
                            </div>
                            <div class="">
                                <span><strong>Total Deals : </strong></span>
                            </div>
                        </div>
                        <br>
                        <div class="row" ng-if="totpresalesEnquiries > 0">
                            <div class="col-sm-5 col-sx-12">
                                <label for="">Customer Care Enquiries Reassign To</label>  <br> 
                                <span>(<strong>Total Enquires found : {{totpresalesEnquiries}}</strong>)</span>
                            </div>
                            <div class="col-sm-6 col-sx-12">
                                <div class="form-group" >
                                    <label for="">Select Employee <span class="sp-err">*</span></label>   
                                    <select class="form-control"  ng-model="bulkData.cc_presales_employee_id" name="cc_presales_employee_id" id="cc_presales_employee_id" ng-init="getpresalesEmployees(suspendId)" required>
                                        <option value="">Select Employee</option>
                                        <option ng-repeat="item in presalesemployeeList" value="{{item.id}}"  >{{item.first_name}} {{item.last_name}} ({{item.designation_name.designation}})</option>
                                    </select>
                                    <div ng-show="sbtBtn" ng-messages="bulkForm.cc_presales_employee_id.$error" class="help-block errMsg">
                                        <div style="sp-err" ng-message="required">Please Select Employee</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" align="center">
                        <button  type="submit" ng-click="sbtBtn = true" class="btn btn-primary pull-right">Reassign To</button></center>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="hrFilter" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row scrollform">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Employee Name</label>
<!--                        <span class="input-icon icon-right" ng-controller="employeesCtrl">
                            <input type="text" ng-model="searchDetails.employeeName" name="firstName" class="form-control" oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')">
                        </span>-->
                        <span class="input-icon icon-right" ng-controller="employeesCtrl"> 
                            <select class="form-control"  ng-model="searchDetails.firstName" name="firstName" id="application_to" >
                                <option value="">Select Employee</option>
                                <option ng-repeat="item in employeeList" value="{{item.employeeName}}" ng-selected="{{ item.employeeName == searchDetails.firstName}}" >{{item.employeeName}}</option>
                            </select>
                        </span>
                    </div>
                </div>



                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Designation</label>
                        <span class="input-icon icon-right">
                            <select ng-model="searchDetails.designation" name="designation" ng-controller="designationCtrl" class="form-control">
                                <option value="">Please Select Designation</option>
                                <option ng-repeat="list in designationList track by $index" value="{{list.designation}}" ng-selected="{{ userData.designation == list.designation}}">{{list.designation}}</option>
                            </select>
                            <i class="fa fa-sort-desc"></i>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Department</label>
                        <span class="input-icon icon-right" ng-controller="departmentCtrl"> 
                            <select class="form-control"  ng-model="searchDetails.departmentName" name="departmentName" id="reporting_to_name" >
                                <option value="">Select Department</option>
                                <option ng-repeat="item in departments" value="{{item.department_name}}" ng-selected="{{ item.department_name == searchDetails.departmentName}}" >{{item.department_name}}</option>
                            </select>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Team Lead</label>
                        <span class="input-icon icon-right" ng-controller="employeesCtrl"> 
                            <select class="form-control"  ng-model="searchDetails.team_lead_name" name="team_lead_name" id="team_lead_name" >
                                <option value="">Select Team Lead</option>
                                <option ng-repeat="item in employeeList" value="{{item.employeeName}}" ng-selected="{{ item.employeeName == searchDetails.team_lead_name}}" >{{item.employeeName}}</option>
                            </select>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Reporting To</label>
                        <span class="input-icon icon-right" ng-controller="employeesCtrl"> 
                            <select class="form-control"  ng-model="searchDetails.reporting_to_name" name="reporting_to_name" id="reporting_to_name" >
                                <option value="">Select Reporting To</option>
                                <option ng-repeat="item in employeeList" value="{{item.employeeName}}" ng-selected="{{ item.employeeName == searchDetails.reporting_to_name}}" >{{item.employeeName}}</option>
                            </select>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12" ng-controller="DatepickerDemoCtrl">
                    <div class="form-group">
                        <label for="">Joining Date</label>
                        <span class="input-icon icon-right">
                            <p class="input-group">
                                <input type="text" ng-model="searchDetails.joining_date" placeholder="Joining date" name="joining_date" id="fromDate" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12" ng-controller="DatepickerDemoCtrl">
                    <div class="form-group">
                        <label for="">Last Login Date</label>
                        <span class="input-icon icon-right">
                            <p class="input-group">
                                <input type="text" ng-model="searchDetails.login_date_time" placeholder="Last login date" name="login_date_time" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Employee status</label>
                        <span class="input-icon icon-right">
                            <select ng-model="searchDetails.employee_status" name="employee_status" class="form-control">
                                <option value="">Select status </option>
                                <option value="1">Active </option>
                                <option value="2">Temporary Suspended </option>
                            </select>

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
