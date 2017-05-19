<style>
	.toggleClassActive {font-size:40px !important;cursor:pointer;color: #5cb85c !important;vertical-align: middle;margin-left: 15px;}
    .toggleClassInactive {font-size:40px !important;cursor:pointer;color: #d9534f !important;vertical-align: middle;margin-left: 15px;}
</style>
<div class="row" ng-controller="alertsController" ng-init="manageAlerts('','index')">
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Alerts</span>
                
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
                            <th style="width: 5%">
                                <a href="javascript:void(0);" ng-click="orderByField='id'; reverseSort = !reverseSort">Id 
                                    <span ng-show="orderByField == 'id'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField='first_name'; reverseSort = !reverseSort">Alert For
                                    <span ng-show="orderByField == 'first_name'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField='designation'; reverseSort = !reverseSort">Alter Category Default/Custom
                                    <span ng-show="orderByField == 'designation'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField='reporting_to_id'; reverseSort = !reverseSort">Alert To 
                                    <span ng-show="orderByField == 'reporting_to_id'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField='team_lead_id'; reverseSort = !reverseSort">SMS On/Off
                                    <span ng-show="orderByField == 'team_lead_id'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField='department_name'; reverseSort = !reverseSort">Email On/Off
                                    <span ng-show="orderByField == 'department_name'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField='joining_date'; reverseSort = !reverseSort">Module
                                    <span ng-show="orderByField == 'joining_date'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="listAlert in listAlerts | filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
                            <td>{{itemsPerPage * (noOfRows-1)+$index+1}}</td>
                            <td>{{ listAlert.id }}</td>
                            <td>{{ listAlert.event_name }}</td>
                            <td ng-if="listAlert.template_category == 1 && listAlert.template_for == 1">Custome
                                <span class="fa fa-toggle-on toggleClassActive" ng-click="changeTemplateStatus(0,$index,listAlert.id)"></span>
                            </td>
                            <td ng-if="listAlert.template_category == 0 && listAlert.template_for == 1"> Default
                                <span class="fa fa-toggle-on fa-rotate-180 toggleClassInactive" ng-click="changeTemplateStatus(1,$index,listAlert.id)"></span>
                            </td>
                            <td ng-if="listAlert.template_category == 0 && listAlert.template_for == 0"><b> Default Only </b></td>
                            <td ng-if="listAlert.template_for == 1">Customer</td>
                            <td ng-if="listAlert.template_for == 0">Employee</td>
                            <td ng-if="listAlert.sms_status == 1">
                         		<span class="fa fa-toggle-on toggleClassActive" ng-click="changeSmsStatus(0,$index,listAlert.id);"></span>
                            </td>
                            <td ng-if="listAlert.sms_status == 0">
                            	<span class="fa fa-toggle-on fa-rotate-180 toggleClassInactive" ng-click="changeSmsStatus(1,$index,listAlert.id);"></span>
                            </td>
                            <td ng-if="listAlert.email_status == 1"> 
                            	<span class="fa fa-toggle-on toggleClassActive" ng-click="changeEmailStatus(0,$index,listAlert.id);"></span>
                            </td>
                            <td ng-if="listAlert.email_status == 0">
                            	<span class="fa fa-toggle-on fa-rotate-180 toggleClassInactive" ng-click="changeEmailStatus(1,$index,listAlert.id);"></span>
                            </td>
                            <td>{{ listAlert.module_names }}</td>
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="User Permissions" tooltip-placement="top" style="display: block;"><a href=""><i class="fa fa-user-plus"></i></a> &nbsp;&nbsp;</div>
                                <div class="fa-hover" tooltip-html-unsafe="Edit User" style="display: block;"><a href="#/[[config('global.getUrl')]]/alerts/update/{{ listAlert.id }}"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="DTTTFooter">
                    <div class="col-sm-6">
                        <!--<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing {{itemsPerPage * (noOfRows-1)+1}} to of {{ listAlertsLength }} entries</div>-->
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

