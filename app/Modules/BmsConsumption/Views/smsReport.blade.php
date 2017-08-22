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
<div class="row" ng-controller="smsController" ng-init="smsLogsReport([[$loggedInUserId]], 1, [[config('global.recordsPerPage')]])">
   
        <div class="widget">
            <div class="widget-header ">
                <div class="" style="float:right">
                    <button type="button" class="btn btn-primary ng-click-active" style="float: right;margin-left: 10px;" data-toggle="modal" data-target="#showSmsReportFilterModal" ng-click="procName('proc_sms_report_logs', 0)">
                        <i class="btn-label fa fa-filter"></i>Show Filter</button>
                </div>
            </div>
            <div class="widget-body">
                <div class="row">
                    <div class="col-md-6"> 
                        <!-- filter data--> 
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
                        <!-- filter data-->
                        <br>
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
                                        <td colspan="8"  ng-show="smsReportLength == 0" align="center">Records Not Found</td>   
                                    </tr>
                                </tbody>
                            </table><br>
                        </div>
                    </div>
                    <div class="col-md-6">
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
                    <div class="col-md-6">
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
    <div data-ng-include="'/BmsConsumption/showSmsReportLogFilter'"></div>

</div>

