<div class="row" ng-controller="wingsController">
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Users</span>
                <a href="#/[[config('global.getUrl')]]/wings/create" class="btn btn-info">Create Wings</a>&nbsp;&nbsp;&nbsp;
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body table-responsive">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                      <label for="search">Search:</label>
                      <input type="text" ng-model="search" class="form-control" style="width:25%;" placeholder="Search">
                    </div>

                    <div class="col-sm-6 col-xs-12">
                      <label for="search">Records per page:</label>
                      <input type="number" min="1" max="50" style="width:25%;" class="form-control" ng-model="itemsPerPage">
                    </div>
                </div><br>
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">SR No.</th>
                            <th style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th></th>
                        </tr>
<!--                        <tr role="row" dir-paginate="listUser in listUsers | filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
                            <td>{{ itemsPerPage * (noOfRows-1)+$index+1 }}</td>
                            <td>{{ listUser.first_name }} {{ listUser.last_name }}</td>
                            <td>{{ listUser.designation }}</td>
                            <td>{{ listUser.reporting_to_fname }} {{ listUser.reporting_to_lname }}</td>
                            <td>{{ listUser.team_lead_fname }} {{ listUser.team_lead_lname }}</td>
                            <td>{{ listUser.department_id }}</td>
                            <td>{{ listUser.joining_date | date:'dd-MM-yyyy' }}</td>
                            <td ng-if="listUser.employee_status == 1">Active</td>
                            <td ng-if="listUser.employee_status == 2">Temporary Suspended</td>
                            <td ng-if="listUser.employee_status == 3">Permanent Suspended</td>
                            <td>{{ listUser.login_date_time | date:'dd-MM-yyyy' }}</td>
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="User Permissions" tooltip-placement="top" style="display: block;"><a href="#/[[config('global.getUrl')]]/user/permissions/{{ listUser.id }}"><i class="fa fa-user-plus"></i></a> &nbsp;&nbsp;</div>
                                <div class="fa-hover" tooltip-html-unsafe="Edit User" style="display: block;"><a href="#/[[config('global.getUrl')]]/user/update/{{ listUser.id }}"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;</div>
                                <div class="fa-hover" tooltip-html-unsafe="Change Password" style="display: block;" data-toggle="modal" data-target="#myModal"><a href="javascript:void(0);" ng-click="manageUsers({{ listUser.id }},'changePassword')"><i class="fa fa-lock"></i></a></div>
                            </td>
                        </tr>-->
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
</div>

