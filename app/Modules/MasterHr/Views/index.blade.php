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
<div class="row" ng-controller="hrController" ng-init="manageUsers('', 'index', [[$loggedInUserId]], 1, [[config('global.recordsPerPage')]])">
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Users</span>
            </div>
            <div class="widget-body table-responsive">
                <div class="row">
                    <div class="col-sm-2 ">
                        <input type="text" minlength="1" maxlength="3" ng-model="itemsPerPage" ng-change="manageUsers('','',[[$loggedInUserId]],{{pageNumber}}, itemsPerPage)" ng-model-options="{ updateOn: 'blur' }" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  class="form-control">
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-primary ng-click-active" style="float: right;margin-left: 10px;" data-toggle="modal" data-target="#showFilterModal" ng-click="procName('proc_user_filter', 0)">
                        <i class="btn-label fa fa-filter"></i>Show Filter</button>
                    </div>
                    <div class="col-sm-2">
                        <a href="" class="btn btn-primary" id="downloadExcel" download="{{fileUrl}}"  ng-show="dnExcelSheet">
                            <i class="btn-label fa fa-file-excel-o"></i>Download excel</a>
                        <a href="javascript:void(0);" id="exportExcel" uploadfile class="btn btn-primary" ng-click="inLogexportReport(listUsers)" ng-show="btnExport">
                            <i class="btn-label fa fa-file-excel-o"></i>Export to Excel
                        </a> 
                    </div> 
                    <div class="col-sm-2">
                        <a href="[[ config('global.backendUrl') ]]#/user/showpermissions" class="btn btn-primary">
                            Permission Wise Users</a>
                    </div> 
                    <div class="col-sm-4 col-xs-12 dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                        <span ng-if="listUsersLength != 0" >&nbsp; &nbsp; &nbsp; Showing {{listUsers.length}} Logs Out Of Total {{listUsersLength}} Logs&nbsp;</span>
                        <dir-pagination-controls class="pull-right pagination" on-page-change="pageChanged(newPageNumber,'manageUsers', [[$loggedInUserId]])" template-url="/dirPagination"></dir-pagination-controls>
                    </div>
                </div>
                <hr>
                <!-- filter data--> 
                <div class="row" style="border:2px;" id="filter-show">
                    <div class="col-sm-12 col-xs-12">
                        <b ng-repeat="(key, value) in showFilterData" ng-if="value != 0 && key != 'toDate'">
                            <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                <div class="alert alert-info fade in">
                                    <button class="close" ng-click="removeDataFromFilter('{{ key}}');" data-dismiss="alert"> ×</button>
                                    <strong ng-if="key === 'empId'" ng-repeat='emp in value track by $index'> {{ $index + 1}}){{   emp.first_name}}  {{ emp.last_name}} </strong>
                                    <strong ng-if="key === 'firstName'" data-toggle="tooltip" title="Employee Name"><strong>Employee Name : </strong> {{ value}}</strong>
                                    <strong ng-if="key === 'designation_id'" data-toggle="tooltip" title="Designation"><strong>Designation : </strong>{{ value}}</strong>
                                    <strong ng-if="key === 'department_id'"  data-toggle="tooltip" title="Department"><strong>Department : </strong>{{ value }}</strong>
                                    <strong ng-if="key === 'joining_date'"  data-toggle="tooltip" title="Joining Date"><strong>Joining Date : </strong>{{ showFilterData.joining_date | date:'dd-MMM-yyyy' }} </strong>
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
                        <tr role="row" dir-paginate="listUser in listUsers | filter:search | itemsPerPage:itemsPerPage" total-items="{{ listUsersLength}}">
                            <td>{{ itemsPerPage * (pageNumber - 1) + $index + 1}}</td>
                            <td>{{ listUser.first_name + ' ' + listUser.last_name}}</td>
                            <td>{{ listUser.designation == null? '-' : listUser.designation}}</td>
                            <td>{{ listUser.reporting_to_fname == null? '-': listUser.reporting_to_fname +' '+listUser.reporting_to_lname }}</td>
                            <td>{{ listUser.team_lead_fname == null? '-': listUser.team_lead_fname +' '+listUser.team_lead_lname }}</td>
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
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{pageNumber}}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                            <dir-pagination-controls class="pull-right pagination" on-page-change="pageChanged(newPageNumber,'manageUsers', [[$loggedInUserId]])" template-url="/dirPagination"></dir-pagination-controls>
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
</div>
