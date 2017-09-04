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
<div class="row" ng-controller="smsController" ng-init="smsLogsLists([[$loggedInUserId]], 1, [[config('global.recordsPerPage')]])">
    <div class="col-xs-12 col-md-12 mainDiv">
        <div class="widget">
            <div class="widget-body table-responsive">
                <!--                <div class="row">
                                    <div class="col-sm-2 ">
                                        <input type="text" minlength="1" maxlength="3" ng-model="itemsPerPage" ng-change="smsLogsLists([[$loggedInUserId]],{{pageNumber}}, itemsPerPage)" ng-model-options="{ updateOn: 'blur' }" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" class="btn btn-primary ng-click-active" style="float: right;margin-left: 10px;" data-toggle="modal" data-target="#showSmsFilterModal" ng-click="procName('proc_sms_logs', 0)">
                                            <i class="btn-label fa fa-filter"></i>Show Filter</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="" class="btn btn-primary" id="downloadExcel" download="{{fileUrl}}"  ng-show="dnExcelSheet">
                                            <i class="btn-label fa fa-file-excel-o"></i>Download excel</a>
                                        <a href="javascript:void(0);" id="exportExcel" uploadfile class="btn btn-primary" ng-click="smsLogexportReport(smsLogsList)" ng-show="btnExport">
                                            <i class="btn-label fa fa-file-excel-o"></i>Export to Excel
                                        </a> 
                                    </div> 
                                    <div class="col-sm-6 col-xs-12 dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                                        <span ng-if="smsLogLength != 0" >&nbsp; &nbsp; &nbsp; Showing {{smsLogsList.length}} Logs Out Of Total {{smsLogLength}} Logs&nbsp;</span>
                                        <dir-pagination-controls class="pull-right pagination" on-page-change="pageChanged(newPageNumber,'smsLogsLists', [[$loggedInUserId]])" template-url="/dirPagination"></dir-pagination-controls>
                                    </div>
                                </div>
                                <hr>
                                 filter data 
                                <div class="row" style="border:2px;" id="filter-show">
                                    <div class="col-sm-12 col-xs-12">
                                        <b ng-repeat="(key, value) in showFilterData" ng-if="value != 0 && key != 'toDate'">
                                            <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                                <div class="alert alert-info fade in">
                                                    <button class="close" ng-click="removeDataFromFilter('{{ key}}');" data-dismiss="alert"> ×</button>
                                                    <strong ng-if="key === 'externalId1'" data-toggle="tooltip" title="Transaction Id"><strong>Transaction Id : </strong> {{ value}}</strong>
                                                    <strong ng-if="key === 'smsType'" data-toggle="tooltip" title="SMS Type"><strong>SMS Type : </strong> {{ value}}</strong>
                                                    <strong ng-if="key === 'mobileNo'"><strong>Mobile Number : </strong>{{ value}}</strong>
                                                    <strong ng-if="key === 'fromDate'"  data-toggle="tooltip" title="Log Date"><strong>SMS Date : </strong>{{ showFilterData.fromDate | date:'dd-MMM-yyyy' }} To {{ showFilterData.toDate |date:'dd-MMM-yyyy' }}</strong>
                                                </div>
                                            </div>
                                        </b>                        
                                    </div>
                                </div>
                                 filter data
                                <br>-->
                <div class="row table-toolbar">
                    <!--<a href="" data-toggle="modal" data-target="#designations" ng-click="initialModal(0, '', '')" class="btn btn-default">Create Designations</a>-->
                    <div class="btn-group pull-right">
                        <a class="btn btn-default toggleForm" href="" style="margin-right: 10px;"><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View print view">
                            <span>Export</span>
                        </a>
                        <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2">
                            <span>Options</span>
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-default">
                                <li>
                                    <a href="javascript:void(0);">Action</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">Another action</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">Something else here</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="javascript:void(0);">Separated link</a>
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
                                        <strong ng-if="key === 'externalId1'" data-toggle="tooltip" title="Transaction Id"><strong>Transaction Id : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'smsType'" data-toggle="tooltip" title="SMS Type"><strong>SMS Type : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'mobileNo'"><strong>Mobile Number : </strong>{{ value}}</strong>
                                        <strong ng-if="key === 'fromDate'"  data-toggle="tooltip" title="Log Date"><strong>SMS Date : </strong>{{ showFilterData.fromDate | date:'dd-MMM-yyyy' }} To {{ showFilterData.toDate |date:'dd-MMM-yyyy' }}</strong>
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
                    <table class="table table-hover table-striped table-bordered" at-config="config">
                        <thead class="bord-bot smslog">
                            <tr>
                                <th style="width:5%">Sr. No.</th>
                                <th style="width: 15%">Sent Date & Time</th>
                                <th style="width: 10%">Transaction Id</th>
                                <th style="width: 35%">SMS Body</th>
                                <th style="width: 5%">SMS Type</th>
                                <th style="width: 5%">Success</th>
                                <th style="width: 5%">Fail</th>
                                <th style="width: 5%">Total</th>
                                <th style="width: 5%">Credits</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="smslog" dir-paginate="smsLog in smsLogsList | filter:search |filter:searchData| itemsPerPage: itemsPerPage" >
                                 <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                                <td>{{ smsLog.dateTime}}</td>
                                <td><a target="_blank" href="[[ config('global.backendUrl') ]]#/bmsConsumption/smsLogDetails/{{smsLog.externalId1}}">{{ smsLog.externalId1}}</a></td>
                                <td>{{ smsLog.sms_body}}</td>
                                <td>{{ smsLog.sms_type}}</td>
                                <td>{{ smsLog.smsDetails.successSms}}</td>
                                <td>{{ smsLog.smsDetails.failSms}}</td>
                                <td>{{ smsLog.smsDetails.totalSms}}</td>
                                <td>{{ smsLog.smsDetails.credits}}</td>
                            </tr>
                            <tr>
                                <td colspan="8"  ng-show="(smsLogsList|filter:search).length == 0" align="center">Record Not Found</td>   
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
                    <div data-ng-include="'/BmsConsumption/showSmsLogFilter'"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="calllogsFilter"  role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <!--<form name="calllogsFilter" role="form" ng-submit="filteredData(filterData, 1, [[ config('global.recordsPerPage') ]])">-->
            <div class="row">
                <div class="col-sm-12 col-xs-12" ng-controller="DatepickerDemoCtrl">
                    <div class="form-group">
                        <label for="">From Date</label>
                        <span class="input-icon icon-right">
                            <p class="input-group">
                                <input type="text" ng-model="searchDetails.fromDate" placeholder="select from date" name="fromDate" id="fromDate" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12" ng-controller="DatepickerDemoCtrl">
                    <div class="form-group">
                        <label for="">To Date</label>
                        <span class="input-icon icon-right">
                            <p class="input-group">
                                <input type="text" ng-model="searchDetails.toDate"  placeholder="select to date" min-date="filterData.fromDate" name="toDate" id="toDate" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </span>
                    </div>
                </div>



                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Sms Type</label>
                        <span class="input-icon icon-right">
                            <select ng-model="searchDetails.sms_type" name="sms_type" class="form-control">
                                <option value=""> Sms Type</option>
                                <option value="0">Regular Sms</option>
                                <option value="1">Flash Sms</option>
                            </select>
                            <i class="fa fa-sort-desc"></i>
                        </span>
                    </div>
                </div>
                <!--                            </div>
                                            <div class="row">-->
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Transaction Id</label>
                        <span class="input-icon icon-right">
                            <input type="text" name="externalId1" ng-model="searchDetails.externalId1" class="form-control">
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" >
                    <div class="form-group">
                        <span class="input-icon icon-right" >
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




