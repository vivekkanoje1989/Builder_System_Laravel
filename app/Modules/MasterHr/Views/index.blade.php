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

<div class="row" ng-controller="hrController" ng-init="manageUsers('', 'index')">
    <div class="mainDiv col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Users</span>
            </div>
            <div class="widget-body table-responsive">
                <div class="row">
                    <div class="col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label for="search">Search:</label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="search" name="search" class="form-control">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-12">
                        <div class="form-group">
                            <label for="search">Records per page:</label>
                            <input type="text" minlength="1" maxlength="3" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" style="width:30%;" class="form-control" ng-model="itemsPerPage">
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-12">
                        <div class="form-group">
                            <label for=""></label>
                            <span class="input-icon icon-right">
                                <a href="[[ config('global.backendUrl') ]]#/user/showpermissions" class="btn btn-primary btn-right">Permission Wise Users</a>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label for=""></label>
                            <span class="input-icon icon-right">
                                <button type="button" class="btn btn-primary btn-right toggleForm" style="margin-right: 10px;"><i class="btn-label fa fa-filter"></i>Show Filter</button>
                            </span>
                        </div>
                    </div>
                </div>
                <hr>
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
                                    <strong ng-if="key === 'login_date_time'"  data-toggle="tooltip" title="Last Login Date"><strong>Last Login Date : </strong>{{ value }} </strong>
                                    <strong ng-if="key === 'employee_status'"  data-toggle="tooltip" title=""><strong>Employee Status: </strong>{{ searchData.employee_status == 1? 'Active':'Temporary Suspended'}} </strong>


                                </div>
                            </div>
                        </b>                        
                    </div>
                </div>
                <!-- filter data-->
                <br>
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">SR No.</th>
                            <th style="width: 10%">Employee Name</th>
                            <th style="width: 10%">Designation</th>
                            <th style="width: 10%">Reporting To</th>
                            <th style="width: 10%">Team Lead</th>
                            <th style="width: 10%">Departments</th>
                            <th style="width: 10%">Joining Date</th>
                            <th style="width: 10%">Status of User</th>
                            <th style="width: 10%">Last Login</th>
                            <th style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="listUser in listUsers | filter:search |filter:searchData | itemsPerPage:itemsPerPage" >
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
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="User Permissions" tooltip-placement="top" style="display: block;"><a href="[[ config('global.backendUrl') ]]#/user/permissions/{{ listUser.id}}"><i class="fa fa-user-plus"></i></a> &nbsp;&nbsp;</div>
                                <div class="fa-hover" tooltip-html-unsafe="Edit User" style="display: block;"><a href="[[ config('global.backendUrl') ]]#/user/update/{{ listUser.id}}"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;</div>
                                <div class="fa-hover" tooltip-html-unsafe="Change Password" style="display: block;" data-toggle="modal" data-target="#myModal"><a href="javascript:void(0);" ng-click="manageUsers({{ listUser.id}},'changePassword')"><i class="fa fa-lock"></i></a></div>
                            </td>

                        </tr>
                        <tr>
                            <td colspan="10"  ng-show="(listUsers|filter:search).length == 0" align="center">Record Not Found</td>   
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


    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
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
                        <button type="submit" class="btn btn-sub" ng-click="step1 = true">Submit</button>
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
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.firstName" name="firstName" class="form-control" oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')">
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
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.departmentName" name="departmentName" class="form-control" oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')">
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Team Lead</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.team_lead_name" name="team_lead_name" class="form-control" oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')">
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Reporting To</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.reporting_to_name" name="reporting_to_name" class="form-control" oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')">
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
