<div class="row">
    <div class="widget flat radius-bordered">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="reportsController" ng-init="teamEnquiryReport([[$loggedInUserID]])">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>Team's Enquiry Reports</h5>
            <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12">
                <tabset class="col-md-12">
                    <tab heading="Category">
                        <div id="category-report">
                            <div class="widget">                                
                                <div class="widget-header">
                                    <span class="widget-caption" style="font-size: 15px;font-weight: 600 !important;">Category Enquiry Report</span>
                                </div>
                                <div class="widget-body table-responsive">
                                    <table class="table table-hover table-striped table-bordered" at-config="config">
                                        <thead class="bord-bot">
                                            <tr>
                                                <th>Name</th>
                                                <th>Total</th>
                                                <th>New</th>
                                                <th>Hot</th>
                                                <th>Warm</th>
                                                <th>Cold</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="category in team_category_report">
                                                <td ng-if="category.is_parent == 1 && category.employee_id != employee_id"><a href="" ng-if="category.is_parent == 1 && category.employee_id != employee_id" ng-click="teamcategoryEnquiryReport(category)">{{category.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></div>
                                                <td ng-if="category.is_parent == 0 || category.employee_id == employee_id">{{category.name}}</td>
                                                <td><b>{{category.Total}}</b></td>
                                                <td>{{category.New}}</td>
                                                <td>{{category.Hot}}</td>
                                                <td>{{category.Warm}}</td>
                                                <td>{{category.Cold}}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Total</b></td>
                                                <td><b>{{total}}</b></td>
                                                <td><b>{{totalNew}}</b></td>
                                                <td><b>{{totalHot}}</b></td>
                                                <td><b>{{totalWarm}}</b></td>
                                                <td><b>{{totalCold}}</b></td>
                                            </tr>
                                            <tr>
                                                <td><b>Total (%)</b></td>
                                                <td ng-if="total > 0"><b>{{((total / total) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="total == 0"><b>0.00</b></td>
                                                <td ng-if="totalNew > 0"><b>{{((totalNew / total) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="totalNew == 0"><b>0.00</b></td>
                                                <td ng-if="totalHot > 0"><b>{{((totalHot / total) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="totalHot == 0"><b>0.00</b></td>
                                                <td ng-if="totalWarm > 0"><b>{{((totalWarm / total) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="totalWarm == 0"><b>0.00</b></td>
                                                <td ng-if="totalCold > 0"><b>{{((totalCold / total) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="totalCold == 0"><b>0.00</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row"  align="center" >
                                    <div class="col-md-12 col-xs-12"  align="center" >
                                        <div style="margin:0 auto;padding: 40px; width: 30%">
                                            <canvas id="doughnut" class="chart chart-doughnut" chart-data="teamcategorydata" chart-options="categoryoptions" chart-labels="categorylabels" chart-colors="categorycolors"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget" ng-if="subteam_category_report.length > '0'">                                
                                <div class="widget-header">
                                    <span class="widget-caption" style="font-size: 15px;font-weight: 600 !important;">{{emp_name}}</span>
                                </div>
                                <div class="widget-body table-responsive">
                                    <table class="table table-hover table-striped table-bordered" at-config="config">
                                        <thead class="bord-bot">
                                            <tr>
                                                <th>Name</th>
                                                <th>Total</th>
                                                <th>New</th>
                                                <th>Hot</th>
                                                <th>Warm</th>
                                                <th>Cold</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="subcategory in subteam_category_report">
                                                <td ng-if="subcategory.is_parent == 1 && subcategory.employee_id != employee_id"><a href="" ng-if="subcategory.is_parent == 1 && subcategory.employee_id != employee_id" ng-click="teamcategoryEnquiryReport(subcategory)">{{subcategory.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></div>
                                                <td ng-if="subcategory.is_parent == 0 || subcategory.employee_id == employee_id">{{subcategory.name}}</div>
                                                <td><b>{{subcategory.Total}}</b></td>
                                                <td>{{subcategory.New}}</td>
                                                <td>{{subcategory.Hot}}</td>
                                                <td>{{subcategory.Warm}}</td>
                                                <td>{{subcategory.Cold}}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Total</b></td>
                                                <td><b>{{subtotal}}</b></td>
                                                <td><b>{{subtotalNew}}</b></td>
                                                <td><b>{{subtotalHot}}</b></td>
                                                <td><b>{{subtotalWarm}}</b></td>
                                                <td><b>{{subtotalCold}}</b></td>
                                            </tr>
                                            <tr>
                                                <td><b>Total (%)</b></td>
                                                <td ng-if="subtotal > 0"><b>{{((subtotal / subtotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="subtotal == 0"><b>0.00</b></td>
                                                <td ng-if="subtotalNew > 0"><b>{{((subtotalNew / subtotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="subtotalNew == 0"><b>0.00</b></td>
                                                <td ng-if="subtotalHot > 0"><b>{{((subtotalHot / subtotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="subtotalHot == 0"><b>0.00</b></td>
                                                <td ng-if="subtotalWarm > 0"><b>{{((subtotalWarm / subtotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="subtotalWarm == 0"><b>0.00</b></td>
                                                <td ng-if="subtotalCold > 0"><b>{{((subtotalCold / subtotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="subtotalCold == 0"><b>0.00</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row"  align="center" >
                                    <div class="col-md-12 col-xs-12"  align="center" >
                                        <div style="margin:0 auto;padding: 40px; width: 30%">
                                            <canvas id="doughnut" class="chart chart-doughnut" chart-data="subteamcategorydata" chart-options="subcategoryoptions" chart-labels="subcategorylabels" chart-colors="subcategorycolors"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tab>
                    <tab heading="Source" active="source_div">
                        <div id="source-report">
                            <div class="widget">                                
                                <div class="widget-header">
                                    <span class="widget-caption" style="font-size: 15px;font-weight: 600 !important;">Source Enquiry Report</span>
                                </div>
                                <div class="widget-body table-responsive">
                                    <table class="table table-hover table-striped table-bordered" at-config="config">
                                        <thead class="bord-bot">
                                            <tr>
                                                <th>Name</th>
                                                <th>No. of Enquiry</th>
                                                <th>Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="sources in team_source_report">
                                                <td ng-if="sources.is_parent == 1 && sources.employee_id != employee_id"><a href="" ng-if="sources.is_parent == 1" ng-click="getsourceReport(sources, $index)">{{sources.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></div>
                                                <td ng-if="sources.is_parent == 0 || sources.employee_id == employee_id">{{sources.name}}</td>
                                                <td>{{sources.total}}</td>
                                                <td ng-if="sources.total > 0"><b>{{((sources.total / team_source_total) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="sources.total == 0"><b>0.00</b></td>
                                            </tr>
                                            <tr>
                                                <td align="center"><b>Total</b></td>
                                                <td><b>{{team_source_total}}</b></td>
                                                <td ng-if="team_source_total > '0'"><b>{{((team_source_total / team_source_total) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="team_source_total == '0'"><b>0.00</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="widget" ng-if="subteam_source_report.length > '0'">                                
                                <div class="widget-header">
                                    <span class="widget-caption" style="font-size: 15px;font-weight: 600 !important;">{{emp_name}}</span>
                                </div>
                                <div class="widget-body table-responsive">
                                    <table class="table table-hover table-striped table-bordered" at-config="config">
                                        <thead class="bord-bot">
                                            <tr>
                                                <th>Source Name</th>
                                                <th>No. of Enquiry</th>
                                                <th>Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="mysources in subteam_source_report">
                                                <td>{{mysources.source_name}}</div>
                                                <td>{{mysources.val}}</div>
                                                <td ng-if="mysources.val > 0"><b>{{((mysources.val / subteam_source_total) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="mysources.val == 0"><b>0.00</b></td>
                                            </tr> 
                                            <tr>
                                                <td align="center"><b>Total</b></td>
                                                <td><b>{{subteam_source_total}}</b></td>
                                                <td ng-if="subteam_source_total > '0'"><b>{{((subteam_source_total / subteam_source_total) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="subteam_source_total == '0'"><b>0.00</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row"  align="center" >
                                    <div class="col-md-12 col-xs-12"  align="center" >
                                        <div style="margin:0 auto;padding: 40px; width: 30%">
                                            <canvas id="doughnut" class="chart chart-doughnut" chart-data="team_sourcedata" chart-options="team_sourceoptions" chart-labels="team_sourcelabels" chart-colors="team_sourcecolors"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tab>
                    <tab heading="Status" active="status_div">
                        <div id="status-report">
                            <div class="widget">                                
                                <div class="widget-header">
                                    <span class="widget-caption" style="font-size: 15px;font-weight: 600 !important;">Status Enquiry Report</span>
                                </div>
                                <div class="widget-body table-responsive">
                                    <table class="table table-hover table-striped table-bordered" at-config="config">
                                        <thead class="bord-bot">
                                            <tr>
                                                <th>Name</th>
                                                <th>Total</th>
                                                <th>New</th>
                                                <th>Open</th>
                                                <th>Booked</th>
                                                <th>Lost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="status in team_status_report">
                                                <td ng-if="status.is_parent == 1 && status.employee_id != employee_id"><a href="" ng-if="status.is_parent == 1 && status.employee_id != employee_id" ng-click="teamstatusReport(status)">{{status.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></div>
                                                <td ng-if="status.is_parent == 0 || status.employee_id == employee_id">{{status.name}}</div>
                                                <td><b>{{status.total}}</b></td>
                                                <td>{{status.new}}</td>
                                                <td>{{status.open}}</td>
                                                <td>{{status.booked}}</td>
                                                <td>{{status.lost}}</td>
                                            </tr>   
                                            <tr>
                                                <td><b>Total</b></td>
                                                <td><b>{{stotal}}</b></td>
                                                <td><b>{{stotalNew}}</b></td>
                                                <td><b>{{stotalOpen}}</b></td>
                                                <td><b>{{stotalBooked}}</b></td>
                                                <td><b>{{stotalLost}}</b></td>
                                            </tr>  
                                            <tr>
                                                <td><b>Total (%)</b></td>
                                                <td ng-if="stotal > '0'"><b>{{((stotal / stotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="stotal == '0'"><b>0.00</b></td>
                                                <td ng-if="stotalNew > '0'"><b>{{((stotalNew / stotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="stotalNew == '0'"><b>0.00</b></td>
                                                <td ng-if="stotalOpen > '0'"><b>{{((stotalOpen / stotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="stotalOpen == '0'"><b>0.00</b></td>
                                                <td ng-if="stotalBooked > '0'"><b>{{((stotalBooked / stotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="stotalBooked == '0'"><b>0.00</b></td>
                                                <td ng-if="stotalLost > '0'"><b>{{((stotalLost / stotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="stotalLost == '0'"><b>0.00</b></td>
                                            </tr>  
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row"  align="center" >
                                    <div class="col-md-12 col-xs-12"  align="center" >
                                        <div style="margin:0 auto;padding: 40px; width: 30%">
                                            <canvas id="doughnut" class="chart chart-doughnut" chart-data="teamstatusdata" chart-options="teamstatusoptions" chart-labels="teamstatuslabels" chart-colors="teamstatuscolors"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-body table-responsive" ng-if="subteam_status_report.length > 0">
                                    <table class="table table-hover table-striped table-bordered" at-config="config">
                                        <thead class="bord-bot">
                                            <tr>
                                                <th>Name</th>
                                                <th>Total</th>
                                                <th>New</th>
                                                <th>Open</th>
                                                <th>Booked</th>
                                                <th>Lost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="status in subteam_status_report">
                                                <td ng-if="status.is_parent == 1 && status.employee_id != employee_id"><a href="" ng-if="status.is_parent == 1 && status.employee_id != employee_id" ng-click="teamstatusReport(status)">{{status.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></div>
                                                <td ng-if="status.is_parent == 0 || status.employee_id == employee_id">{{status.name}}</div>
                                                <td><b>{{status.total}}</b></td>
                                                <td>{{status.new}}</td>
                                                <td>{{status.open}}</td>
                                                <td>{{status.booked}}</td>
                                                <td>{{status.lost}}</td>
                                            </tr>   
                                            <tr>
                                                <td><b>Total</b></td>
                                                <td><b>{{subtotal}}</b></td>
                                                <td><b>{{subtotalNew}}</b></td>
                                                <td><b>{{subtotalOpen}}</b></td>
                                                <td><b>{{subtotalBooked}}</b></td>
                                                <td><b>{{subtotalLost}}</b></td>
                                            </tr>  
                                            <tr>
                                                <td><b>Total (%)</b></td>
                                                <td ng-if="subtotal > '0'"><b>{{((subtotal / subtotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="subtotal == '0'"><b>0.00</b></td>
                                                <td ng-if="subtotalNew > '0'"><b>{{((subtotalNew / subtotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="subtotalNew == '0'"><b>0.00</b></td>
                                                <td ng-if="subtotalOpen > '0'"><b>{{((subtotalOpen / subtotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="subtotalOpen == '0'"><b>0.00</b></td>
                                                <td ng-if="subtotalBooked > '0'"><b>{{((subtotalBooked / subtotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="subtotalBooked == '0'"><b>0.00</b></td>
                                                <td ng-if="subtotalLost > '0'"><b>{{((subtotalLost / subtotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="subtotalLost == '0'"><b>0.00</b></td>
                                            </tr>  
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row"  align="center" >
                                    <div class="col-md-12 col-xs-12"  align="center" >
                                        <div style="margin:0 auto;padding: 40px; width: 30%">
                                            <canvas id="doughnut" class="chart chart-doughnut" chart-data="subteamstatusdata" chart-options="subteamstatusoptions" chart-labels="subteamstatuslabels" chart-colors="subteamstatuscolors"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tab>
                </tabset>
            </div>
        </div>
    </div>
</div>