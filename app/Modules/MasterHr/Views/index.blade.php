<div class="row" ng-controller="hrController" ng-init="manageUsers('','index')">
    <div  class="col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
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
                                <a href="[[ config('global.backendUrl') ]]#/user/showpermissions" class="btn btn-primary btn-right">Permission Wise Users</a>
                            </span>
                        </div>
                    </div>
                </div>
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">Sr. No.</th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField='first_name'; reverseSort = !reverseSort">Employee Name 
                                    <span ng-show="orderByField == 'first_name'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField='designation'; reverseSort = !reverseSort">Designation 
                                    <span ng-show="orderByField == 'designation'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField='reporting_to_id'; reverseSort = !reverseSort">Reporting To 
                                    <span ng-show="orderByField == 'reporting_to_id'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField='team_lead_id'; reverseSort = !reverseSort">Team Lead 
                                    <span ng-show="orderByField == 'team_lead_id'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField='department_name'; reverseSort = !reverseSort">Department
                                    <span ng-show="orderByField == 'department_name'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField='joining_date'; reverseSort = !reverseSort">Joining Date 
                                    <span ng-show="orderByField == 'joining_date'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a></th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField='employee_status'; reverseSort = !reverseSort">Status of User 
                                    <span ng-show="orderByField == 'employee_status'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">Last Login</th>
                            <th style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="listUser in listUsers | filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
                            <td>{{ itemsPerPage * (noOfRows-1)+$index+1 }}</td>
                            <td>{{ listUser.first_name }} {{ listUser.last_name }}</td>
                            <td>{{ listUser.designation }}</td>
                            <td>{{ listUser.reporting_to_fname }} {{ listUser.reporting_to_lname }}</td>
                            <td>{{ listUser.team_lead_fname }} {{ listUser.team_lead_lname }}</td>
                            <td>{{ listUser.departmentName }}</td>
                            <td>{{ listUser.joining_date | date:'dd-MM-yyyy' }}</td>
                            <td ng-if="listUser.employee_status == 1">Active</td>
                            <td ng-if="listUser.employee_status == 2">Temporary Suspended</td>
                            <td ng-if="listUser.employee_status == 3">Permanent Suspended</td>
                            <td>{{ (listUser.login_date_time) ? listUser.login_date_time : "-" }}</td>
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="User Permissions" tooltip-placement="top" style="display: block;"><a href="[[ config('global.backendUrl') ]]#/user/permissions/{{ listUser.id }}"><i class="fa fa-user-plus"></i></a> &nbsp;&nbsp;</div>
                                <div class="fa-hover" tooltip-html-unsafe="Edit User" style="display: block;"><a href="[[ config('global.backendUrl') ]]#/user/update/{{ listUser.id }}"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;</div>
                                <div class="fa-hover" tooltip-html-unsafe="Change Password" style="display: block;" data-toggle="modal" data-target="#myModal"><a href="javascript:void(0);" ng-click="manageUsers({{ listUser.id }},'changePassword')"><i class="fa fa-lock"></i></a></div>
                            </td>
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

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center">Change Password</h4>
            </div>
            <div class="modal-body">
                <form>
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
                </form>
            </div>
            <div class="modal-footer" align="center">
                <button type="button" class="btn btn-sub" ng-click="changePassword(modal.empId,modal.userName)">Submit</button>
            </div>
        </div>
    </div>
</div>

</div>

