
<div class="row">
    <div class="widget flat radius-bordered">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="reportsController" ng-init="overViewReport()">
            <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12">

                <div id="followup-report">
                    <div class="widget">                                
                        <div class="widget-header">
                            <span class="widget-caption" style="font-size: 15px;font-weight: 600 !important;">My Followup's Report</span>
                        </div>
                        <div class="widget-body table-responsive">
                            <table class="table table-hover table-striped table-bordered" at-config="config">
                                <thead class="bord-bot">
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Project Name</th>
                                        <th>Wing</th>
                                        <th>Total Avaliable</th>
                                        <th>Units Sold</th>
                                        <th>Avaliable Units</th>
                                        <th>Total Receivable</th>
                                        <th>Agreement Cost</th>
                                        <th>Received till Date</th>
                                        <th>Balance</th>
                                        <th>Over Due</th>
                                        <th>Stages Not Completed</th>
                                        <th>Value of stock as per todays Min rate</th>
                                        <th>Count</th>
                                        <th>Percentage</th>
                                    </tr>
                                    
                                </thead>
                                <tbody >
                                   <tr ng-repeat="overview in projectOverview">
                                        <td>{{$index +1}}</td>
                                        <td>{{overview.project_name}}</td>
                                        <td><table><tr ng-repeat="wings in overview.wings"><td>{{wings.wing_name}}</td></tr></table></td>
                                    </tr> 
                                </tbody>
                            </table>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>