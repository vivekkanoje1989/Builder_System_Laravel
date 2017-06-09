<div class="row" ng-controller="empDeviceController" ng-init="manageDevice('index', 'index')">
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Employee Device</span>
                <a  href="[[ config('global.backendUrl') ]]#/employeeDevice/create" class="btn btn-info">Add Device</a>&nbsp;&nbsp;&nbsp;
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body table-responsive">
                <div class="row">
                    <div class="col-sm-3 col-xs-12">
                        <label for="search">Search:</label>
                        <input type="text" ng-model="search" class="form-control" placeholder="Search">
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <label for="search">Records per page:</label>
                        <input type="number" min="1" max="50" style="width:30%;" class="form-control" ng-model="itemsPerPage">
                    </div>
                </div><br>
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width: 5%">Sr. No.</th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'device_name'; reverseSort = !reverseSort">Device Name 
                                    <span ng-show="orderByField == 'device_name'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">MAC Address </th>
                            <th style="width: 10%">Employee Name</th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'device_type'; reverseSort = !reverseSort">Device Type
                                    <span ng-show="orderByField == 'device_type'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>
                            <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'device_status'; reverseSort = !reverseSort">Status
                                    <span ng-show="orderByField == 'device_status'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>                           
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="listDevice in listDevices | filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
                            <td>{{itemsPerPage * (noOfRows-1)+$index+1}}</td>
                            <td>{{ listDevice.device_name}}</td>
                            <td>{{ listDevice.device_mac}}</td>
                            <td>{{ listDevice.employee_id}}</td>
                            <td ng-if=" listDevice.device_type == 1">desktop</td>
                            <td ng-if=" listDevice.device_type == 2">laptop</td>
                            <td ng-if=" listDevice.device_type == 3">mobile/tablet</td>
                            <td ng-if="listDevice.device_status == 1">Active</td>
                            <td ng-if="listDevice.device_status == 0">Inactive</td>
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit Information" style="display: block;"><a href="[[ config('global.backendUrl') ]]#/employeeDevice/update/{{ listDevice.id}}"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;</div>                               
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
                    <button type="button" class="btn btn-sub" ng-click="changePassword(modal.empId)">Submit</button>
                </div>
            </div>
        </div>
    </div>

</div>

