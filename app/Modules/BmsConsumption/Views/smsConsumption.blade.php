<style>
    .tabsets ul li{
        width:50%;
    }
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
<div class="row" ng-controller="smsController" ng-init="smsLogsReport([[$loggedInUserId]], 1, [[config('global.recordsPerPage')]])">
    <div class="col-xs-12 col-md-12 mainDiv">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">SMS Consumption</span>                
            </div>
            <div class="widget-body table-responsive">
                <div class="row table-toolbar">
                    <a href="[[ config('global.backendUrl') ]]#/bmsConsumption/smsLogs" class="btn btn-default">SMS Logs</a> <div class="btn-group pull-right filterBtn">
                        <a class="btn btn-default toggleForm" href="" ng-hide="disableBtn" ng-click="procName('proc_sms_report_logs', 0)"><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">

                    <!-- filter data-->
                    <div class="row">
                        <div class="row" style="border:2px;" id="filter-show">
                            <div class="col-sm-12 col-md-12">
                                <b ng-repeat="(key, value) in showFilterData" ng-if="value != 0 && key != 'toDate'">
                                    <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                        <div class="alert alert-info fade in" style="    width: 275%;">
                                            <button class="close" ng-click="removeReportDataFromFilter('{{ key}}');" data-dismiss="alert"> ×</button>
                                            <strong ng-if="key === 'smsType'" data-toggle="tooltip" title="SMS Type"><strong>SMS Type : </strong> {{ value}}</strong>
                                            <strong ng-if="key === 'fromDate'"  data-toggle="tooltip" title="Log Date"><strong>SMS Date : </strong>{{ showFilterData.fromDate | date:'dd-MMM-yyyy' }} To {{ showFilterData.toDate |date:'dd-MMM-yyyy' }}</strong>
                                        </div>
                                    </div>
                                </b>                        
                            </div>
                        </div>
                        <br>
                        <div>
                            <p ng-if="smsReportLength != 0" style=" font-weight: 600; font-size: 20px;margin-left: 20px;"><span>Report for {{firstDateofThisMonth}}<span><span ng-if="currentDate"> To {{currentDate}}</span></p>
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class=" table-responsive">
                                                <table class="table table-hover table-striped table-bordered" at-config="config">
                                                    <thead class="bord-bot smslog">
                                                        <tr>
                                                            <th style="width:40%"></th>
                                                            <th style="width: 20%">Total</th>
                                                            <th style="width: 20%">Delivered</th>
                                                            <th style="width: 20%">Undelivered</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="smslog" dir-paginate="smsLog in totalSms | filter:search | itemsPerPage: itemsPerPage" ng-hide="smsReportLength == 0" total-items="{{ smsReportLength}}">
                                                            <td>SMS Requested</td>  
                                                            <td>{{ smsLog.total}}</td>
                                                            <td>{{ smsLog.success}}</td>
                                                            <td>{{ smsLog.fail}}</td>
                                                        </tr>
                                                        <tr class="smslog" dir-paginate="smsLogP in smsPercentage | filter:search | itemsPerPage: itemsPerPage" ng-hide="smsReportLength == 0" total-items="{{ smsReportLength}}">
                                                            <td>Percentage</td> 
                                                            <td>{{ smsLogP.totalPercentage}}%</td>
                                                            <td>{{ smsLogP.successPercentage}}%</td>
                                                            <td>{{ smsLogP.failPercentage}} %</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4"  ng-show="smsReportLength == 0" align="center">Records Not Found</td>  
                                                            <td colspan="4"  ng-show="(totalSms|filter:search).length == 0" align="center">Record Not Found</td>   
                                                            <td colspan="4"  ng-show="totalCount == 0" align="center">Record Not Found</td>   
                                                        </tr>
                                                    </tbody>
                                                </table><br>
                                            </div>
                                        </div>
                                        <div class="col-md-6" ng-if="smsReportLength != 0">
                                            <div class="row"  align="center" >
                                                <div class="col-md-12 col-xs-12"  align="center" >
                                                    <div style="margin:0 auto;padding: 40px; width: 30%">
                                                        <canvas id="doughnut" class="chart chart-doughnut" chart-data="categorydata" chart-options="categoryoptions" chart-labels="categorylabels" chart-colors="categorycolors"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="widget">
                                                    <div class=" table-responsive">
                                                        <table class="table table-hover table-striped table-bordered" at-config="config">
                                                            <thead class="bord-bot smslog">
                                                                <tr>
                                                                    <th style="width:50%">Undelivered Reason</th>
                                                                    <th style="width: 25%">SMS Count</th>
                                                                    <th style="width: 25%">Percentage</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="smslog"  ng-show="(fail | filter:search) != 0" ng-hide="smsReportLength == 0">
                                                                    <td>Operator issue</td>  
                                                                    <td>{{fail}}</td>
                                                                    <td>{{failP}}%</td>
                                                                </tr>
                                                                <tr class="smslog" total-items="{{ smsLogLength}}" ng-hide="smsReportLength == 0">
                                                                    <td>Total</td>  
                                                                    <td>{{ fail}}</td>
                                                                    <td>{{failP}}%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="8"  ng-show="smsReportLength == 0" align="center">Record Not Found</td>   
                                                                </tr>
                                                            </tbody>
                                                        </table><br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6" ng-if="smsReportLength !=0">
                                                <div class="row"  align="center" >
                                                    <div class="col-md-12 col-xs-12"  align="center" >
                                                        <div style="margin:0 auto;padding: 40px; width: 30%">
                                                            <canvas id="doughnut" class="chart chart-doughnut" chart-data="categorydata1" chart-options="categoryoptions1" chart-labels="categorylabels1" chart-colors="categorycolors1"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        </div>
                                        <!--<div data-ng-include="'/BmsConsumption/showSmsReportLogFilter'"></div>-->
                                        </div>
                                        </div>
                                        <!-- Filter Form Start-->
                                        <div class="wrap-filter-form show-widget" id="slideout">
                                            <form name="calllogsFilter" role="form" ng-submit="filteredReportData(filterData, 1, [[ config('global.recordsPerPage') ]])">
                                                <strong>Filter</strong>   
                                                <button type="button" class="close toggleForm" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button><hr>

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
                                                                    <input type="text" ng-model="filterData.toDate"  placeholder="select to date" min-date="filterReportData.fromDate" name="toDate" id="toDate" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly/>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                                    </span>
                                                                </p>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>                                   
                                                <!--            <div class="row">
                                                                <div class="col-sm-12 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label for="">Sms Type</label>
                                                                        <span class="input-icon icon-right">
                                                                            <select ng-model="filterData.sms_type" name="sms_type" class="form-control">
                                                                                <option value=""> Sms Type</option>
                                                                                <option value="0">Regular Sms</option>
                                                                                <option value="1">Flash Sms</option>
                                                                            </select>
                                                                            <i class="fa fa-sort-desc"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>-->
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12" >
                                                        <div class="form-group">
                                                            <span class="input-icon icon-right" >
                                                                <button type="submit"  style="margin-left: 46%;" name="sbtbtn" value="Search" class="btn btn-primary toggleForm">Search</button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                        <script src="/js/filterSlider.js"></script>
                                        <!-- Filter Form End-->
                                        </div>




