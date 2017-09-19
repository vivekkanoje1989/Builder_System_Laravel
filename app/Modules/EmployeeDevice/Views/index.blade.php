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
<div class="row" ng-controller="empDeviceController" ng-init="manageDevice('index', 'index')">
    <div class=" mainDiv col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Device Information</span>                
            </div>
            <div class="widget-body table-responsive">

                <div class="row table-toolbar">
                    <a  href="[[ config('global.backendUrl') ]]#/employeeDevice/create" class="btn btn-default">Add Device</a>
                    <div class="btn-group pull-right filterBtn">
                        <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View Excel" ng-click="employeeDeviceExportToxls()" ng-show="exportData == '1'">
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
                            <b ng-repeat="(key, value) in searchData">
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'device_name'" data-toggle="tooltip" title="Device Name"><strong> Device Name : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'device_type'" data-toggle="tooltip" title="Device Type"><strong> Device Type : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'device_status'" data-toggle="tooltip" title="Device Status"><strong> Device status : </strong> {{ value==1? "Active" : "In active"}}</strong>
                                        <strong ng-if="key === 'employee_id'" data-toggle="tooltip" title="Employee Name"><strong> Employee Name : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'device_mac'" data-toggle="tooltip" title="Mac Address"><strong>  Mac Address : </strong> {{ value}}</strong>
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
                                <th style="width: 5%">Sr. No.</th>
                                <th style="width: 10%">
                                     <a href="javascript:void(0);" ng-click="orderByField('device_name')">Device Name 
                                        <span ><img ng-hide="(sortKey == 'device_name' &&(reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'device_name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'device_name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                <a href="javascript:void(0);" ng-click="orderByField('device_mac')">MAC Address
                                        <span ><img ng-hide="(sortKey == 'device_mac' &&(reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'device_mac' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'device_mac' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 15%">
                                <a href="javascript:void(0);" ng-click="orderByField('employee_id')">Employee Name
                                        <span ><img ng-hide="(sortKey == 'employee_id' &&(reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'employee_id' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'employee_id' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                     <a href="javascript:void(0);" ng-click="orderByField('device_type')">Device Type
                                        <span ><img ng-hide="(sortKey == 'device_type' &&(reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'device_type' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'device_type' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                     <a href="javascript:void(0);" ng-click="orderByField('device_status')">Status
                                        <span ><img ng-hide="(sortKey == 'device_status' &&(reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'device_status' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'device_status' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>                           
                                <th style="width: 10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" dir-paginate="listDevice in listDevices | filter:search |filter:searchData | itemsPerPage:itemsPerPage | orderBy:sortKey:reverseSort">
                                <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                                <td>{{ listDevice.device_name}}</td>
                                <td>{{ listDevice.device_mac}}</td>
                                <td>{{ listDevice.employee_id}}</td>
                                <td ng-if=" listDevice.device_type == 1">desktop</td>
                                <td ng-if=" listDevice.device_type == 2">laptop</td>
                                <td ng-if=" listDevice.device_type == 3">mobile/tablet</td>
                                <td ng-if="listDevice.device_status == 1">Active</td>
                                <td ng-if="listDevice.device_status == 0">Inactive</td>
                                <td class="">
                                    <span class="" tooltip-html-unsafe="Edit Information" ><a href="[[ config('global.backendUrl') ]]#/employeeDevice/update/{{ listDevice.id}}" class="btn-info btn-xs"><i class="fa fa-edit"></i>Edit</a> &nbsp;&nbsp;</span>                               
                                    <span  ng-show="deleteBtn == '1'" class="" tooltip-html-unsafe="Delete"><a href="" ng-click="deleteEmployeeDevice({{listDevice.id}},{{$index}})" class="btn-danger btn-xs"><i class="fa fa-trash-o"></i>Delete</a></span>
                                </td>
                            </tr>
                             <tr>
                                <td colspan="7"  ng-show="(listDevices|filter:search | filter:searchData ).length == 0" align="center">Record Not Found</td>   
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
    </div>

    <!-- Modal -->
    <div class="modal fade mdoal-primary" id="myModal" role="dialog">
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
    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="blockStagesFilter" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row">

                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Device Name</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.device_name" name="device_name" class="form-control">
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Mac Address</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.device_mac" name="device_mac" class="form-control">
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group"  ng-controller="getAllEmployeesCtrl">
                        <label for="">Employee Name</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.employee_id" name="employee_id" class="form-control">
                        </span>
<!--                        <span class="input-icon icon-right">
                            <ui-select multiple ng-model="searchDetails.employee_id" name="employee_id" theme="select2" ng-disabled="disabled" style="width: 300px;" ng-required="true"  ng-change="checkemployee()">
                                <ui-select-match placeholder="Select Employees">{{$item.first_name}} {{$item.last_name}}</ui-select-match>
                                <ui-select-choices repeat="list in employeeList | filter:$select.search">
                                    {{list.first_name}} {{list.last_name}}
                                </ui-select-choices>
                            </ui-select>
                            <i class="fa fa-sort-desc"></i>
                        </span>-->
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Status</label>
                        <span class="input-icon icon-right">
                            <select class="form-control" name="device_status" ng-model="searchDetails.device_status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
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

