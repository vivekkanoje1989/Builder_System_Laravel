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
    .smslog th{
        text-align:center;
    }
    .smslog td{
        text-align:center;
    }
</style>
<div class="row" ng-controller="smsController" ng-init="smsLogsDetails([[$transactionId]], 1)">

    <div class="col-xs-12 col-md-12 mainDiv">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">
                    Details View Of Transaction Id :- [[$transactionId]] </span>
            </div>
            <div class="widget-body table-responsive">
                <div class="row table-toolbar">
                    <!--<a href="[[ config('global.backendUrl') ]]#/user/showpermissions" class="btn btn-default">Permission Wise Users</a>-->
                    <div class="btn-group pull-right">
                        <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View Excel" ng-click="smsLogDetailsExportToxls('[[$transactionId]]')" ng-show="smsLogDetailsData=='1'">
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
                                <div class="col-sm-2" data-toggle="tooltip"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'fromDate'"  data-toggle="tooltip" title="From Date"><strong>From Date : </strong>  {{ showFilterData.fromDate | date : 'dd-MM-yyyy' }} <span ng-if="showFilterData.toDate">To  {{ showFilterData.toDate | date : 'dd-MM-yyyy' }}</span></strong>
                                        <strong ng-if="key === 'externalId1'" data-toggle="tooltip" title="Transaction Id"><strong>Transaction Id : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'mobile_number'"><strong>Mobile Number : </strong>{{ value}}</strong>
                                        <strong ng-if="key != 'fromDate' && key != 'toDate' && key != 'mobile_number'" data-toggle="tooltip" title="{{ key}}"> {{ value}}</strong>
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
                        <thead class="bord-bot smslog">
                            <tr>
                                <th style="width:5%">Sr. No.</th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'dateTime'; reverseSort = !reverseSort">Sent Date & Time
                                        <span ng-show="orderByField == 'dateTime'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'mobile_number'; reverseSort = !reverseSort">Mobile Number
                                        <span ng-show="orderByField == 'mobile_number'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a>
                                </th>
                                <th style="width: 30%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'sms_body'; reverseSort = !reverseSort">SMS Body
                                        <span ng-show="orderByField == 'sms_body'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a>
                                </th>
                                <th style="width: 5%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'bulk_file_id'; reverseSort = !reverseSort">Excel file
                                        <span ng-show="orderByField == 'bulk_file_id'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'employee_name'; reverseSort = !reverseSort">Employee
                                        <span ng-show="orderByField == 'employee_name'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a>
                                </th>
                                <th style="width: 5%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'sms_type'; reverseSort = !reverseSort">SMS Type
                                        <span ng-show="orderByField == 'sms_type'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a>
                                </th>
                                <th style="width: 5%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'status'; reverseSort = !reverseSort">Delivery Status
                                        <span ng-show="orderByField == 'status'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'dateTime'; reverseSort = !reverseSort">Date & Time
                                        <span ng-show="orderByField == 'dateTime'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a>
                                </th>
                                <th style="width: 5%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'status'; reverseSort = !reverseSort">Reason
                                        <span ng-show="orderByField == 'status'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a>
                                </th>
                                <th style="width: 5%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'credits_deducted'; reverseSort = !reverseSort">Credits Billed
                                        <span ng-show="orderByField == 'credits_deducted'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="smslog" dir-paginate="smsLogDetails in smsLogsDetails | filter:search |filter:searchData| itemsPerPage: itemsPerPage | orderBy:orderByField:reverseSort">
                                <td>{{ itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                                <td>{{ smsLogDetails.dateTime}}</td>
                                <td>{{ smsLogDetails.mobile_number}}</td>
                                <td>{{ smsLogDetails.sms_body}}</td>
                                <td ng-show="{{smsLogDetails.bulk_file_id.length}}!== 0">
                                    <a href="[[config('global.s3Path')]]bulk_sms_file/{{smsLogDetails.bulk_file_id}}">Download</a>
                                </td>
                                <td ng-show="{{smsLogDetails.bulk_file_id.length}} == 0">--</td>
                                <td>{{ employee_name}}</td>
                                <td>{{ smsLogDetails.sms_type}}</td>
                                <td>{{ smsLogDetails.status}}</td>
                                <td>{{ smsLogDetails.dateTime}}</td>
                                <td>{{ smsLogDetails.status}}</td>
                                <td>{{ smsLogDetails.credits_deducted}}</td>

                            </tr>
                            <tr>
                                <td colspan="11"  ng-show="(smsLogsDetails | filter:search  |filter:searchData).length == 0" align="center">Record Not Found</td>   
                            </tr>
                        </tbody>
                    </table><br>
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
    </div>
    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="hrFilter" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="">Mobile Number </label>
                        <input type="text" ng-model="searchDetails.mobile_number" name="mobile_number" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  maxlength="10">
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" align="right">
                    <div class="form-group">
                        <span class="input-icon icon-right">
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

