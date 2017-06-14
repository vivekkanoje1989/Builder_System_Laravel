
<div class="row">
    <div class="widget flat radius-bordered">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="reportsController" ng-init="myFollowupReport([[$loggedInUserID]])">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{headingName}}</h5>
            <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12">
                <div id="followup-report">
                    <div class="widget">    
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered" at-config="config">
                                <thead class="bord-bot">
                                    <tr>
                                        <th>Day</th>
                                        <th>Count</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody ng-repeat="followup in followup_report">
                                    <tr>
                                        <td><b>Same Day</b></td>
                                        <td>{{followup.same_day}}</td>
                                        <td>{{((followup.same_day / followup.total) * 100).toFixed(2)}}</td>
                                    </tr>   
                                    <tr>
                                        <td><b>Second Day</b></td>
                                        <td>{{followup.second_day}}</td>
                                        <td>{{((followup.second_day / followup.total) * 100).toFixed(2)}}</td>
                                    </tr>   
                                    <tr>
                                        <td><b>Third Day</b></td>
                                        <td>{{followup.third_day}}</td>
                                        <td>{{((followup.third_day / followup.total) * 100).toFixed(2)}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>After Third Day</b></td>
                                        <td>{{followup.after_third_day}}</td>
                                        <td>{{((followup.after_third_day / followup.total) * 100).toFixed(2)}}</td>
                                    </tr>
                                    <tr>
                                        <td align="center"><b>Total</b></td>
                                        <td><b>{{followup.total}}</b></td>
                                        <td><b>{{((followup.total / followup.total) * 100).toFixed(2)}}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row"  align="center" >
                            <div class="col-md-12 col-xs-12"  align="center" >
                                <div style="margin:0 auto;padding: 40px; width: 30%">
                                    <canvas id="doughnut" class="chart chart-doughnut" chart-data="followupdata" chart-options="followupoptions" chart-labels="followuplabels" chart-colors="followupcolors"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>