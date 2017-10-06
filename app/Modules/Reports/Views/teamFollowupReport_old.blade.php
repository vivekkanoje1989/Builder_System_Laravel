<div class="row">
    <div class="widget flat radius-bordered">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="reportsController" ng-init="teamFollowupReport([[$loggedInUserID]])">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{headingName}}</h5>
            <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12">
                <div id="status-report">
                    <div class="widget"> 
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered" at-config="config">
                                <thead class="bord-bot">
                                    <tr>
                                        <th>Name</th>
                                        <th>Total</th>
                                        <th>Same Day</th>
                                        <th>Second Day</th>
                                        <th>Third Day</th>
                                        <th>After Third Day</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="followup in team_followup_report">
                                        <td ng-if="followup.is_parent == 1 && followup.employee_id != employee_id"><a href="" ng-if="followup.is_parent == 1 && followup.employee_id != employee_id" ng-click="getteamfollowupReport(followup)">{{followup.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></div>
                                        <td ng-if="followup.is_parent == 0 || followup.employee_id == employee_id">{{followup.name}}</div>
                                        <td><b>{{followup.total}}</b></td>
                                        <td>{{followup.sameday}}</td>
                                        <td>{{followup.secondday}}</td>
                                        <td>{{followup.thirdday}}</td>
                                        <td>{{followup.afterthirdday}}</td>
                                    </tr>   
                                    <tr>
                                        <td><b>Total</b></td>
                                        <td><b>{{total}}</b></td>
                                        <td><b>{{totalSame}}</b></td>
                                        <td><b>{{totalSecond}}</b></td>
                                        <td><b>{{totalThird}}</b></td>
                                        <td><b>{{totalAfter}}</b></td>
                                    </tr>  
                                    <tr>
                                        <td><b>Total (%)</b></td>
                                        <td ng-if="total > '0'"><b>{{((total / total) * 100).toFixed(2)}}</b></td>
                                        <td ng-if="total == '0'"><b>0.00</b></td>
                                        <td ng-if="totalSame > '0'"><b>{{((totalSame / total) * 100).toFixed(2)}}</b></td>
                                        <td ng-if="totalSame == '0'"><b>0.00</b></td>
                                        <td ng-if="totalSecond > '0'"><b>{{((totalSecond / total) * 100).toFixed(2)}}</b></td>
                                        <td ng-if="totalSecond == '0'"><b>0.00</b></td>
                                        <td ng-if="totalThird > '0'"><b>{{((totalThird / total) * 100).toFixed(2)}}</b></td>
                                        <td ng-if="totalThird == '0'"><b>0.00</b></td>
                                        <td ng-if="totalAfter > '0'"><b>{{((totalAfter / total) * 100).toFixed(2)}}</b></td>
                                        <td ng-if="totalAfter == '0'"><b>0.00</b></td>
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
                
                
                
                
                         <div class="widget-body table-responsive" ng-if="subteam_followup_report.length > 0">
                            <table class="table table-hover table-striped table-bordered" at-config="config">
                                <thead class="bord-bot">
                                    <tr>
                                        <th>Name</th>
                                        <th>Total</th>
                                        <th>Same Day</th>
                                        <th>Second Day</th>
                                        <th>Third Day</th>
                                        <th>After Third Day</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="followup in subteam_followup_report">
                                        <td ng-if="followup.is_parent == 1 && followup.employee_id != employee_id"><a href="" ng-if="followup.is_parent == 1 && followup.employee_id != employee_id" ng-click="getteamfollowupReport(followup)">{{followup.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></div>
                                        <td ng-if="followup.is_parent == 0 || followup.employee_id == employee_id">{{followup.name}}</div>
                                        <td><b>{{followup.total}}</b></td>
                                        <td>{{followup.sameday}}</td>
                                        <td>{{followup.secondday}}</td>
                                        <td>{{followup.thirdday}}</td>
                                        <td>{{followup.afterthirdday}}</td>
                                    </tr>   
                                    <tr>
                                        <td><b>Total</b></td>
                                        <td><b>{{subtotal}}</b></td>
                                        <td><b>{{subtotalSame}}</b></td>
                                        <td><b>{{subtotalSecond}}</b></td>
                                        <td><b>{{subtotalThird}}</b></td>
                                        <td><b>{{subtotalAfter}}</b></td>
                                    </tr>  
                                    <tr>
                                        <td><b>Total (%)</b></td>
                                        <td ng-if="subtotal > '0'"><b>{{((subtotal / subtotal) * 100).toFixed(2)}}</b></td>
                                        <td ng-if="subtotal == '0'"><b>0.00</b></td>
                                        <td ng-if="subtotalSame > '0'"><b>{{((subtotalSame / subtotal) * 100).toFixed(2)}}</b></td>
                                        <td ng-if="subtotalSame == '0'"><b>0.00</b></td>
                                        <td ng-if="subtotalSecond > '0'"><b>{{((subtotalSecond / subtotal) * 100).toFixed(2)}}</b></td>
                                        <td ng-if="subtotalSecond == '0'"><b>0.00</b></td>
                                        <td ng-if="subtotalThird > '0'"><b>{{((subtotalThird / subtotal) * 100).toFixed(2)}}</b></td>
                                        <td ng-if="subtotalThird == '0'"><b>0.00</b></td>
                                        <td ng-if="subtotalAfter > '0'"><b>{{((subtotalAfter / subtotal) * 100).toFixed(2)}}</b></td>
                                        <td ng-if="subtotalAfter == '0'"><b>0.00</b></td>
                                    </tr>  
                                </tbody>
                            </table>
                        </div>
                        <div class="row"  align="center" >
                            <div class="col-md-12 col-xs-12"  align="center" >
                                <div style="margin:0 auto;padding: 40px; width: 30%">
                                    <canvas id="doughnut" class="chart chart-doughnut" chart-data="subfollowupdata" chart-options="subfollowupoptions" chart-labels="subfollowuplabels" chart-colors="subfollowupcolors"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>