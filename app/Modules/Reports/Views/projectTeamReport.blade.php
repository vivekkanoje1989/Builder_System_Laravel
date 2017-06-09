<div class="row">
    <div class="widget flat radius-bordered">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="reportsController">
            <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12">
                <div class="col-sm-3 col-xs-12" ng-controller="projectCtrl">
                    <label for="search">Select Project:</label>
                    <select id="project" name="project" class="form-control" ng-model="project"  ng-change="projectWiseTeamReports(project, '[[$loggedInUserID]]')" >
                        <option value="">Select Projects</option>
                        <option ng-repeat="item in projectList" value="{{item.id}}">{{item.project_name}}</option>
                    </select>
                    <br/> </div>
                <tabset class="col-md-12" ng-if="project_id > 0">
                    <tab heading="Category">
                        <div id="category-report">
                            <div class="widget">                                
                                <div class="widget-header">
                                    <span class="widget-caption" style="font-size: 15px;font-weight: 600 !important;">Team's Category-Wise Enquiry Report</span>
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
                                                <td ng-if="category.is_parent == 1 && category.employee_id != employee_id"><a href="" ng-if="category.is_parent == 1 && category.employee_id != employee_id" ng-click="teamProjectCategoryReport(category)">{{category.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></div>
                                                <td ng-if="category.is_parent == 0 || category.employee_id == employee_id">{{category.name}}</div>
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
                                                <td ng-if="subcategory.is_parent == 1 && subcategory.employee_id != employee_id"><a href="" ng-if="subcategory.is_parent == 1 && subcategory.employee_id != employee_id" ng-click="teamProjectCategoryReport(subcategory)">{{subcategory.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></div>
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
                                    <span class="widget-caption" style="font-size: 15px;font-weight: 600 !important;">Team's Source-Wise Enquiry Report</span>
                                </div>
                                <div class="widget-body table-responsive">
                                    <table class="table table-hover table-striped table-bordered" at-config="config">
                                        <thead class="bord-bot">
                                            <tr>
                                                <th>Name</th>
                                                <th>Total</th>
                                                <th ng-repeat="(key ,value) in source_wise_report['0'].source">{{key.split("_").join(" ")}}</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="sources in source_wise_report track by $index">
                                                <td ng-if="sources.is_parent == 1 && sources.employee_id != employee_id"><a href="" ng-if="sources.is_parent == 1 && sources.employee_id != employee_id" ng-click="teamProjectSourceEmpReport(sources)">{{sources.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></div>
                                                <td ng-if="sources.is_parent == 0 || sources.employee_id == employee_id">{{sources.name}}</div>
                                                <td>{{sources.Total}}</td>
                                                <td ng-repeat="(key,value) in source_wise_report[$index].source">{{value}}</td>
                                            </tr>
                                            <tr>
                                                <td align="center"><b>Total</b></td>
                                                <td>{{SourceTotal}}</td>
                                                <td ng-repeat="data in sourceApp">{{data}}</td>
                                            </tr>
                                            <tr>
                                                <td align="center"><b>Percent</b></td>
                                                <td>{{((SourceTotal / SourceTotal * 100).toFixed(2))}}</td>
                                                <td  ng-repeat="data in sourceApp"> <span ng-if="data != 0">{{ ((data / SourceTotal * 100).toFixed(2))}}</span> <span ng-if="data == 0">00.00</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row"  align="center" >
                                    <div class="col-md-12 col-xs-12"  align="center" >
                                        <div style="margin:0 auto;padding: 40px; width: 30%">
                                            <canvas id="doughnut" class="chart chart-doughnut" chart-data="teamsourcedata" chart-options="sourceoptions" chart-labels="teamSourcelabels" chart-colors="sourcecolors"></canvas>
                                        </div>
                                    </div>
                                </div>




                                <div class="widget-body table-responsive" ng-if="subsource_wise_report.length > 0">
                                    <table class="table table-hover table-striped table-bordered" at-config="config">
                                        <thead class="bord-bot">
                                            <tr>
                                                <th>Name</th>
                                                <th>Total</th>
                                                <th ng-repeat="(key ,value) in subsource_wise_report['0'].source">{{key.split("_").join(" ")}}</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="sources in subsource_wise_report track by $index">
                                                <td ng-if="sources.is_parent == 1 && sources.employee_id != employee_id"><a href="" ng-if="sources.is_parent == 1 && sources.employee_id != employee_id" ng-click="teamProjectSourceEmpReport(sources)">{{sources.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></div>
                                                <td ng-if="sources.is_parent == 0 || sources.employee_id == employee_id">{{sources.name}}</div>
                                                <td>{{sources.Total}}</td>
                                                <td ng-repeat="(key,value) in sources.source">{{value}}</td>
                                            </tr>
                                            <tr>
                                                <td align="center"><b>Total</b></td>
                                                <td>{{SubsourceTotal}}</td>
                                                <td ng-repeat="data in subsourceApp">{{data}}</td>
                                            </tr>
                                            <tr>
                                                <td align="center"><b>Percent</b></td>
                                                <td>{{ ((SubsourceTotal / SubsourceTotal * 100).toFixed(2)) ? 00.00 : ((SubsourceTotal / SubsourceTotal * 100).toFixed(2))}}</td>
                                                <td  ng-repeat="data in subsourceApp"> <span ng-if="data != 0">{{ ((data / SubsourceTotal * 100).toFixed(2))}}</span> <span ng-if="data == 0">00.00</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row"  align="center" >
                                    <div class="col-md-12 col-xs-12"  align="center" >
                                        <div style="margin:0 auto;padding: 40px; width: 30%">
                                            <canvas id="doughnut" class="chart chart-doughnut" chart-data="subteamsourcedata" chart-options="subsourceoptions" chart-labels="subteamSourcelabels" chart-colors="subsourcecolors"></canvas>
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
                                    <span class="widget-caption" style="font-size: 15px;font-weight: 600 !important;">Team Status-Wise Enquiry Report</span>
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
                                            <tr ng-repeat="status in status_wise_report">
                                                <td ng-if="status.is_parent == 1 && status.employee_id != employee_id"><a href="" ng-if="status.is_parent == 1 && status.employee_id != employee_id" ng-click="teamProjectStatusEmpReport(status)">{{status.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></div>
                                                <td ng-if="status.is_parent == 0 || status.employee_id == employee_id">{{status.name}}</div> 
                                                <td><b>{{status.Total}}</b></td>
                                                <td>{{status.new}}</td>
                                                <td>{{status.open}}</td>
                                                <td>{{status.booked}}</td>
                                                <td>{{status.lost}}</td>
                                            </tr>   
                                            <tr>
                                                <td><b>Total</b></td>
                                                <td><b>{{Statustotal}}</b></td>
                                                <td><b>{{totalStatusNew}}</b></td>
                                                <td><b>{{totalOpen}}</b></td>
                                                <td><b>{{totalBooked}}</b></td>
                                                <td><b>{{totalLost}}</b></td>
                                            </tr>  
                                            <tr>
                                                <td><b>Total (%)</b></td>
                                                <td ng-if="Statustotal > '0'"><b>{{((Statustotal / Statustotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="Statustotal == '0'"><b>0.00</b></td>
                                                <td ng-if="totalStatusNew > '0'"><b>{{((totalStatusNew / Statustotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="totalStatusNew == '0'"><b>0.00</b></td>
                                                <td ng-if="totalOpen > '0'"><b>{{((totalOpen / total) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="totalOpen == '0'"><b>0.00</b></td>
                                                <td ng-if="totalBooked > '0'"><b>{{((totalBooked / total) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="totalBooked == '0'"><b>0.00</b></td>
                                                <td ng-if="totalLost > '0'"><b>{{((totalLost / total) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="totalLost == '0'"><b>0.00</b></td>
                                            </tr>  
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row"  align="center" >
                                    <div class="col-md-12 col-xs-12"  align="center" >
                                        <div style="margin:0 auto;padding: 40px; width: 30%">
                                            <canvas id="doughnut" class="chart chart-doughnut" chart-data="statusdata" chart-options="statusoptions" chart-labels="statuslabels" chart-colors="statuscolors"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget" ng-if="sub_status_wise_report.length > '0'">                                
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
                                                <th>Open</th>
                                                <th>Booked</th>
                                                <th>Lost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="subStatus in sub_status_wise_report">
                                                <td ng-if="subStatus.is_parent == 1 && subStatus.employee_id != employee_id"><a href=""  ng-click="teamProjectStatusEmpReport(subStatus)">{{subStatus.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></div>
                                                <td ng-if="subStatus.is_parent == 0 || subStatus.employee_id == employee_id">{{subStatus.name}}</div> 
                                                <td><b>{{subStatus.Total}}</b></td>
                                                <td>{{subStatus.new}}</td>
                                                <td>{{subStatus.open}}</td>
                                                <td>{{subStatus.booked}}</td>
                                                <td>{{subStatus.lost}}</td>
                                            </tr>   
                                            <tr>
                                                <td><b>Total</b></td>
                                                <td><b>{{subStatusTotal}}</b></td>
                                                <td><b>{{subTotalStatusNew}}</b></td>
                                                <td><b>{{subTotalOpen}}</b></td>
                                                <td><b>{{subTotalBooked}}</b></td>
                                                <td><b>{{subTotalLost}}</b></td>
                                            </tr>  
                                            <tr>
                                                <td><b>Percentage (%)</b></td>
                                                <td ng-if="subStatusTotal > '0'"><b>{{((subStatusTotal / subStatusTotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="subTotalStatusNew == '0'"><b>0.00</b></td>
                                                <td ng-if="subTotalStatusNew > '0'"><b>{{((subTotalStatusNew / subStatusTotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="totalStatusNew == '0'"><b>0.00</b></td>
                                                <td ng-if="subTotalOpen > '0'"><b>{{((subTotalOpen / subStatusTotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="subTotalOpen == '0'"><b>0.00</b></td>
                                                <td ng-if="subTotalBooked > '0'"><b>{{((subTotalBooked / subStatusTotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="subTotalBooked == '0'"><b>0.00</b></td>
                                                <td ng-if="subTotalLost > '0'"><b>{{((subTotalLost / subStatusTotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="subTotalLost == '0'"><b>0.00</b></td>
                                            </tr>   
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row"  align="center" >
                                    <div class="col-md-12 col-xs-12"  align="center" >
                                        <div style="margin:0 auto;padding: 40px; width: 30%">
                                            <canvas id="doughnut" class="chart chart-doughnut" chart-data="substatusdata" chart-options="substatusoptions" chart-labels="substatuslabels" chart-colors="substatuscolors"></canvas>
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