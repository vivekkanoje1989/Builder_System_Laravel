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
<div class="row" ng-controller="cloudtelephonyController" ng-init="outboundLists([[$loggedInUserId]], 1, [[config('global.recordsPerPage')]])">
    <div class="col-xs-12 col-md-12 mainDiv">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">My Outbound Logs</span>
            </div>
            <div class="widget-body table-responsive">
                <!--                <div class="row">
                                    <div class="col-sm-2 ">
                                        <div class="form-group">
                                            <label for="search">Records per page:</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" minlength="1" maxlength="3" ng-model="itemsPerPage" ng-change="outboundLists([[$loggedInUserId]],{{pageNumber}}, itemsPerPage)" ng-model-options="{ updateOn: 'blur' }" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  class="form-control">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="search"></label>
                                            <span class="input-icon icon-right">
                                                <button type="button" class="btn btn-primary ng-click-active" style="float: right;margin-left: 10px;" data-toggle="modal" data-target="#showFilterModal" ng-click="procName('proc_team_outboundlogs', 0)">
                                                <i class="btn-label fa fa-filter"></i>Show Filter</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="search"></label>
                                            <span class="input-icon icon-right">
                                                <a href="" class="btn btn-primary" id="downloadExcel" download="{{fileUrl}}"  ng-show="dnExcelSheet">
                                                    <i class="btn-label fa fa-file-excel-o"></i>Download excel</a>
                                                <a href="javascript:void(0);" id="exportExcel" uploadfile class="btn btn-primary" ng-click="outLogexportReport(outboundList)" ng-show="btnExport">
                                                    <i class="btn-label fa fa-file-excel-o"></i>Export to Excel
                                                </a> 
                                            </span>
                                        </div>
                                    </div>    
                                    <div class="col-sm-6 col-xs-12 dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                                        <div class="form-group">
                                            <label for="search"></label>
                                            <span class="input-icon icon-right">
                                                <span ng-if="outboundLength" >&nbsp; &nbsp; &nbsp; Showing {{outboundList.length}} records out of {{outboundLength}} records&nbsp;</span>
                                                <dir-pagination-controls class="pull-right pagination" on-page-change="pageChanged(newPageNumber,'outboundLists', [[$loggedInUserId]])" template-url="/dirPagination"></dir-pagination-controls>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                 filter data
                                <div class="row" style="border:2px;" id="filter-show">
                                    <div class="col-sm-12 col-xs-12">
                                        <b ng-repeat="(key, value) in showFilterData" ng-if="value != 0 && key != 'toDate'">
                                            <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                                <div class="alert alert-info fade in">
                                                    <button class="close" ng-click="removeoutboundDataFromFilter('{{ key}}');" data-dismiss="alert"> ×</button>
                                                    <strong ng-if="key === 'empId'" ng-repeat='emp in value track by $index'> {{ $index + 1}}){{   emp.first_name}}  {{ emp.last_name}} </strong>
                                                    <strong ng-if="key === 'callstatus'"><strong>Call Status : </strong>{{ value}}</strong>
                                                    <strong ng-if="key === 'customer_number'"><strong>Customer Number : </strong>{{ value}}</strong>
                                                    <strong ng-if="key === 'fromDate'"  data-toggle="tooltip" title="Log Date"><strong>Call Date : </strong>{{ showFilterData.fromDate | date:'dd-MMM-yyyy' }} To {{ showFilterData.toDate |date:'dd-MMM-yyyy' }}</strong>
                                                </div>
                                            </div>
                                        </b>                        
                                    </div>
                                </div>
                                 filter data
                                <br>-->
                <div class="row table-toolbar">
                    <!--<a href="[[ config('global.backendUrl') ]]#/job-posting/create" class="btn btn-default">Post Job</a>-->
                    <div class="btn-group pull-right">
                        <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View Excel" ng-click="myOutboundExportToxls()" ng-show="myOutboundExport == '1'">
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
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'empId'" ng-repeat='emp in value track by $index'> {{ $index + 1}}){{   emp.first_name}}  {{ emp.last_name}} </strong>
                                        <strong ng-if="key === 'customer_call_status'"><strong>Call Status : </strong>{{ value}}</strong>
                                        <strong ng-if="key === 'customer_number'"><strong>Customer Number : </strong>{{ value}}</strong>
                                        <!--<strong ng-if="key === 'fromDate'"  data-toggle="tooltip" title="Log Date"><strong>Call Date : </strong>{{ showFilterData.fromDate | date:'dd-MMM-yyyy' }} To {{ showFilterData.toDate |date:'dd-MMM-yyyy' }}</strong>-->
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
                                <th style="width:5%">Sr. No.</th>
                                <th style="width: 15%">
                                 <a href="javascript:void(0);" ng-click="orderByField = 'call_date'; reverseSort = !reverseSort">Call Date & Time
                                        <span ng-show="orderByField == 'call_date'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                 <a href="javascript:void(0);" ng-click="orderByField = 'customer_number'; reverseSort = !reverseSort">Customer Number
                                        <span ng-show="orderByField == 'customer_number'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'customer_name'; reverseSort = !reverseSort">Customer Name 
                                        <span ng-show="orderByField == 'customer_name'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                 <a href="javascript:void(0);" ng-click="orderByField = 'customer_call_status'; reverseSort = !reverseSort">Call Status
                                        <span ng-show="orderByField == 'customer_call_status'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                 <a href="javascript:void(0);" ng-click="orderByField = 'employee_name'; reverseSort = !reverseSort">Call By
                                        <span ng-show="orderByField == 'employee_name'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                 <a href="javascript:void(0);" ng-click="orderByField = 'customer_call_duration'; reverseSort = !reverseSort">Call Duration
                                        <span ng-show="orderByField == 'customer_call_duration'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a>
                                </th>
                                <th style="width: 10%">Recording</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr dir-paginate="outbound in outboundList | filter:search | filter:searchData | itemsPerPage: itemsPerPage | orderBy:orderByField:reverseSort" >
                               <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}} </td>
                                <td>{{ outbound.call_date + ' @ ' + outbound.call_time}}</td>
                                <td>{{ outbound.customer_number}}</td>
                                <td>{{ outbound.customer_name}}</td>
                                <td>{{ outbound.customer_call_status}}</td>
                                <td>{{ outbound.employee_name}}</td>
                                <td>{{ outbound.customer_call_duration}}</td>
                                <td ng-show="{{outbound.customer_call_status == 'Connected'}}"><audio id="objectout_{{ outbound.id}}" controls></audio></td>
                                <td ng-show="{{outbound.customer_call_status != 'Connected'}}">- NA -</td>
                            </tr>
                            <tr>
                                <td colspan="8" ng-if="!outboundLength" align="center">Record Not Found</td>   
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
                <div data-ng-include="'/cloudtelephony/showoutboundFilter'"></div>
            </div>
        </div>
    </div>
     <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="calllogsFilter" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row" ng-controller="employeesWiseTeamCtrl">
                <div class="col-sm-12 col-sx-12" ng-if="employeesData.length > 0 && type == 1">
                    <div class="form-group">
                        <label for="">Select Call Answered By</label>
                        <span class="input-icon icon-right">                                                
                            <ui-select multiple ng-model="searchDetails.empId" name="empId" theme="select2" ng-disabled="disabled" style="width: 100%;">
                                <ui-select-match placeholder='Select Employee'>{{ $item.first_name}} {{$item.last_name}}</ui-select-match>
                                <ui-select-choices repeat="list in employeesData | filter:$select.search">
                                    <span>
                                        {{ list.first_name}} {{ list.last_name}}
                                    </span>
                                </ui-select-choices>
                            </ui-select>
                            <i class="fa fa-sort-desc"></i>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-sx-12" >
                    <div class="form-group">
                        <label for="">Customer Number</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.customer_number" name="customer_number" class="form-control" value="{{customer_number}}"  oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                        </span>
                    </div>
                </div>    
                
                <div class="col-sm-12 col-xs-12" ng-controller="virtualnumberCtrl">
                    <div class="form-group">
                        <label for="">Call Status</label>
                        <span class="input-icon icon-right">
                            <select ng-model="searchDetails.customer_call_status" name="customer_call_status" class="form-control">
                                <option value="">Select call status</option>
                                <option ng-repeat="status in statuscall track by $index" value="{{status}}">{{status}}</option>
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


