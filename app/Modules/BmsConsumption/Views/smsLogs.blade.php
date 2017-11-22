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
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">SMS Logs</span>                
            </div>
            <div class="widget-body table-responsive">
                <div class="row table-toolbar">
                    <div class="btn-group pull-right filterBtn">
                        <a class="btn btn-default toggleForm" href="" ng-hide="disableBtn" data-modal='showSmsFilterModal'><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2" ng-disabled="disableBtn">
                            <span>Actions</span>
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" ng-disabled="disableBtn"><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-default">
                                <li>
                                    <a href="" ng-click="smsLogsExportToxls()" ng-show="exportSmsLogsData == '1'">Export</a>
                                </li>

                            </ul>
                        </a>
                    </div>
                    <div  class="dataTables_filter">
                        <label>
                            <input type="search" ng-disabled="disableBtn" class="form-control input-sm" ng-model="search" name="search" >
                        </label>
                    </div>
                    <!-- filter data-->
                    <div class="row" style="border:2px;" id="filter-show">
                        <div class="col-sm-12 col-xs-12">
                            <b ng-repeat="(key, value) in showFilterData" ng-if="value != 0 && key != 'toDate'">
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeDataFromFilter('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'externalId1'" data-toggle="tooltip" title="Transaction Id"><strong>Transaction Id : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'sms_type'" data-toggle="tooltip" title="SMS Type"><strong>SMS Type : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'mobileNo'"><strong>Mobile Number : </strong>{{ value}}</strong>
                                        <strong ng-if="key === 'fromDate'"  data-toggle="tooltip" title="Log Date"><strong>SMS Date : </strong>{{ showFilterData.fromDate | date:'dd-MM-yyyy' }} <span ng-if="showFilterData.toDate">To</span> {{ showFilterData.toDate |date:'dd-MM-yyyy' }}</strong>
                                    </div>
                                </div>
                            </b>                        
                        </div>
                    </div>
                    <!-- filter data-->
                    <div class="dataTables_length" >
                        <label>
                            <select class="form-control" ng-disabled="disableBtn" ng-model="itemsPerPage" name="itemsPerPage" onchange="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')">
                                <option value="30">30</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                                <option value="300">300</option>
                                <option value="400">400</option>
                                <option value="500">500</option>
                                <option value="600">600</option>
                                <option value="700">700</option>
                                <option value="800">800</option>
                                <option value="900">900</option>
                                <option value="999">999</option>
                            </select>
                        </label>
                    </div>
                    <table class="table table-hover table-striped table-bordered tableHeader" at-config="config">
                        <thead class="bord-bot smslog">
                            <tr>
                                <th style="width:5%">Sr. No.</th>
                                <th style="width: 15%">
                                    <a href="javascript:void(0);" ng-click="orderByField('dateTime')">Sent Date & Time
                                        <span ><img ng-hide="(sortKey == 'dateTime' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'dateTime' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'dateTime' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('externalId1')">Transaction Id
                                        <span ><img ng-hide="(sortKey == 'externalId1' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'externalId1' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'externalId1' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 35%">
                                    <a href="javascript:void(0);" ng-click="orderByField('sms_body')">SMS Body
                                        <span ><img ng-hide="(sortKey == 'sms_body' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'sms_body' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'sms_body' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 7%">
                                    <a href="javascript:void(0);" ng-click="orderByField('sms_type')">SMS Type
                                        <span ><img ng-hide="(sortKey == 'sms_type' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'sms_type' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'sms_type' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 5%">Success</th>
                                <th style="width: 5%">Fail</th>
                                <th style="width: 5%">Total</th>
                                <th style="width: 3%">Credits</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr dir-paginate="smsLog in filtered=(smsLogsList | filter:search) | itemsPerPage: itemsPerPage| orderBy:sortKey:reverseSort" total-items="{{ smsLogLength}}">
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
                        <td colspan="9"  ng-show="(smsLogsList|filter:search | filter:searchData ).length == 0" align="center">Record Not Found</td>   
                        <td colspan="9"  ng-show="totalCount == 0" align="center">Record Not Found</td>   
                    </tr>
                </tbody>
            </table>

            <div class="DTTTFooter">
                <div class="col-sm-6">
                    <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{pageNumber}}</div>
                </div>
                <div class="col-sm-6">
                    <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                        <dir-pagination-controls class="pagination" on-page-change="pageChanged(newPageNumber,'smsLogsLists', [[$loggedInUserId]])" max-size="5" direction-links="true" boundary-links="true" ng-if="smsLogLength"></dir-pagination-controls>
                    </div>  
                </div>
            </div>
<!--
            <div data-ng-include="'/BmsConsumption/showSmsLogFilter'"></div>-->
        </div>
    </div>
</div>
</div>
<!-- Filter Form Start-->
<div class="wrap-filter-form show-widget" id="slideout">
    <form name="calllogsFilter"  role="form" ng-submit="filteredData(filterData, 1, [[ config('global.recordsPerPage') ]])" class="embed-contact-form">
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
                                                <input type="text" ng-model="filterData.fromDate" placeholder="select from date" name="fromDate" id="fromDate" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly/>
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
                                                <input type="text" ng-model="filterData.toDate"  placeholder="select to date" min-date="filterData.fromDate" name="toDate" id="toDate" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly/>
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
                        <select ng-model="filterData.sms_type" name="sms_type" class="form-control">
                            <option value=""> Sms Type</option>
                            <option value="P_sms">P_SMS</option>
                            <option value="T_SMS">T_SMS</option>
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
                        <input type="text" name="externalId1" ng-model="filterData.externalId1" class="form-control">
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




