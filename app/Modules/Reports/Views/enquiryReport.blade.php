<div class="row">
    <div class="widget flat radius-bordered">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="reportsController" ng-init="myEnquiryReport([[$loggedInUserID]])">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">{{headingName}}</span>                
            </div>
            <div class="widget-body col-lg-12 col-sm-12 col-xs-12">
                <tabset class="col-md-12">
                    <tab heading="Category" ng-click="reportHeading('Enquiry Category Report'); myEnquiryReport([[$loggedInUserID]])">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered" at-config="config">
                                <thead class="bord-bot">
                                    <tr>
                                        <th>Category</th>
                                        <th>No. of Enquiry</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody ng-repeat="category in category_report">
                                    <tr>
                                        <td><b>New</b></td>
                                        <td><div style="width:50px; float:left">{{category.New}}</div><div style="float:left"><a ng-if="category.New > 0" href="" ng-click="subCategoryReport(category, 1, 0,<?php echo Auth::guard('admin')->user()->id; ?>)">Show Sub-category report</a></div></td>
                                        <td><div  ng-if="category.New > 0" >{{((category.New / category.Total) * 100).toFixed(2)}}</div><div ng-if="category.New == 0">0</div></td>
                                    </tr>   
                                    <tr>
                                        <td><b>Hot</b></td>
                                        <td><div style="width:50px; float:left">{{category.Hot}}</div><div style="float:left"><a ng-if="category.Hot > 0" href="" ng-click="subCategoryReport(category, 2, 0,<?php echo Auth::guard('admin')->user()->id; ?>)">Show Sub-category report</a></div></td>                                                
                                        <td><div  ng-if="category.Hot > 0" >{{((category.Hot / category.Total) * 100).toFixed(2)}}</div><div ng-if="category.Hot == 0">0</div></td>
                                    </tr>   
                                    <tr>
                                        <td><b>Warm</b></td>
                                        <td><div style="width:50px; float:left">{{category.Warm}}</div><div style="float:left"><a ng-if="category.Warm > 0" href="" ng-click="subCategoryReport(category, 3, 0,<?php echo Auth::guard('admin')->user()->id; ?>)">Show Sub-category report</a></div></td>                                       
                                        <td><div  ng-if="category.Warm > 0" >{{((category.Warm / category.Total) * 100).toFixed(2)}}</div><div ng-if="category.Warm == 0">0</div></td>
                                    </tr>
                                    <tr>
                                        <td><b>Cold</b></td>
                                        <td><div style="width:50px; float:left">{{category.Cold}}</div><div style="float:left"><a ng-if="category.Cold > 0" href="" ng-click="subCategoryReport(category, 4, 0,<?php echo Auth::guard('admin')->user()->id; ?>)">Show Sub-category report</a></div></td>
                                        <td><div ng-if="category.Cold > 0" >{{((category.Cold / category.Total) * 100).toFixed(2)}}</div><div ng-if="category.Cold == 0">0</div></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><b>Total</b></td>
                                        <td><b>{{category.Total}}</b></td>
                                        <td><b ng-if="category.Total > 0">{{((category.Total / category.Total) * 100).toFixed(2)}}</b><b ng-if="category.Total == 0" >0</b></td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row"  align="center" >
                                <div class="col-md-12 col-xs-12"  align="center" >
                                    <div style="margin:0 auto;padding: 40px; width: 30%">
                                        <canvas id="doughnut" class="chart chart-doughnut" chart-data="categorydata" chart-options="categoryoptions" chart-labels="categorylabels" chart-colors="categorycolors"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" id="catReport" ng-if="catReport">
                            <h4>Sub-category Report </h4>
                            <table class="table table-hover table-striped table-bordered" at-config="config" >
                                <thead class="bord-bot">
                                    <tr>
                                        <th>Sub-category of {{cat}} category</th>
                                        <th>No. of enquiry</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="subCat in sub_category_report" ng-if="sub_category_report.length > 0">
                                        <td>{{subCat.enquiry_sales_subcategory}}</td>
                                        <td>{{subCat.cnt}}</td>
                                        <td><b>{{((subCat.cnt / subCatTotal) * 100).toFixed(2)}}</b></td>
                                    </tr>
                                    <tr ng-if="unKnownCategory >= 1">
                                        <td>Unspecified sub-category</td>
                                        <td>{{unKnownCategory}}</td>
                                        <td><b>{{((unKnownCategory / subCatTotal) * 100).toFixed(2)}}</b></td>
                                    </tr>
                                    <tr ng-if="sub_category_report.length > 0 || unKnownCategory > 1">
                                        <td><b>Total</b></td>
                                        <td><b>{{subCatTotal}}</b></td>
                                        <td><b>{{((subCatTotal / subCatTotal) * 100).toFixed(2)}}</b></td>
                                    </tr>
                                    <tr ng-if="sub_category_report.length == 0 && unKnownCategory < 1">
                                        <td colspan="3" align="center">
                                            <h4>No Record Found</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row"  align="center"  ng-if="sub_category_report.length > 0 || unKnownCategory > 1" >
                                <div class="col-md-12 col-xs-12"  align="center" >
                                    <div class="pie-chart-width" style="margin:0 auto;padding: 40px; width: 30%">
                                        <canvas id="doughnut" class="chart chart-doughnut" chart-data="subcategorydata" chart-options="subcategoryoptions" chart-labels="subcategorylabels" chart-colors="subcategorycolors"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tab>
                    <tab heading="Source" active="source_div" ng-click="reportHeading('Enquiry Source Report'); myEnquiryReport([[$loggedInUserID]])">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered" at-config="config">
                                <thead class="bord-bot">
                                    <tr>
                                        <th>Source</th>
                                        <th>No. of Enquiry</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="sources in source_report">
                                        <td><b>{{sources.sales_source_name}}</b></td>
                                        <td><div style="width:50px; float:left">{{sources.cnt}}</div><div ng-if="sources.substatus == 1" style="float:left"><a href=""   ng-click="subSourceReport(sources,<?php echo Auth::guard('admin')->user()->id; ?>, 0)">Show sub-source report</a></div></td>
                                        <td><div ng-if="sources.cnt > 0">{{((sources.cnt / source_total) * 100).toFixed(2)}}</div><div ng-if="sources.cnt == 0">0</div></td>
                                    </tr> 
                                    <tr>
                                        <td align="center"><b>Total</b></td>
                                        <td><b>{{source_total}}</b></td>
                                        <td><b ng-if="source_total > 0">{{((source_total / source_total) * 100).toFixed(2)}}</b><b ng-if="source_total == 0">0</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row"  align="center" >
                            <div class="col-md-12 col-xs-12"  align="center" >
                                <div style="margin:0 auto;padding: 40px; width: 30%">
                                    <canvas id="doughnut" class="chart chart-doughnut" chart-data="sourcedata" chart-options="sourceoptions" chart-labels="sourcelabels" chart-colors="sourcecolors"></canvas>
                                </div>
                            </div>
                        </div>


                        <div class="table-responsive" ng-if="sub_source.length > 0 || unSpecifiedSource > 0">
                            <table class="table table-hover table-striped table-bordered" at-config="config">
                                <thead class="bord-bot">
                                    <tr>
                                        <th>Sub Source</th>
                                        <th>No. of Enquiry</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="subsources in sub_source">
                                        <td>{{subsources.sub_source}}</td>
                                        <td>{{subsources.cnt}}</td>
                                        <td ng-if="subsources.cnt > 0"><b>{{((subsources.cnt / subSourceTotal) * 100).toFixed(2)}}</b></td>
                                        <td ng-if="subsources.cnt == 0"><b>0.00</b></td>
                                    </tr> 
                                    <tr ng-if="unSpecifiedSource >= 1">
                                        <td>Unspecified sub-source</td>
                                        <td>{{unSpecifiedSource}}</td>
                                        <td><b>{{((unSpecifiedSource / subSourceTotal) * 100).toFixed(2)}}</b></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><b>Total</b></td>
                                        <td><b>{{subSourceTotal}}</b></td>
                                        <td ng-if="subSourceTotal > '0'"><b>{{((subSourceTotal / subSourceTotal) * 100).toFixed(2)}}</b></td>
                                        <td ng-if="subSourceTotal == '0'"><b>0.00</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row"  align="center" ng-if="sub_source.length > 0 || unSpecifiedSource > 0">
                            <div class="col-md-12 col-xs-12"  align="center" >
                                <div class="pie-chart-width" style="margin:0 auto;padding: 40px; width: 30%">
                                    <canvas id="doughnut" class="chart chart-doughnut" chart-data="team_subsourcedata" chart-options="team_subsourceoptions" chart-labels="team_subsourcelabels" chart-colors="team_subsourcecolors"></canvas>
                                </div>
                            </div>
                        </div>
                    </tab>
                    <tab heading="Status" active="status_div" ng-click="reportHeading('Enquiry Status Report'); myEnquiryReport([[$loggedInUserID]]);">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered" at-config="config">
                                <thead class="bord-bot">
                                    <tr>
                                        <th>Status</th>
                                        <th>No. of Enquiry</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody ng-repeat="status in status_report">
                                    <tr>
                                        <td><b>New</b></td>
                                        <td>{{status.new}}</td>
                                        <td><div ng-if="status.new > 0">{{((status.new / status.Total) * 100).toFixed(2)}}</div><div ng-if="status.new == 0">0</div></td>
                                    </tr>   
                                    <tr>
                                        <td><b>Open</b></td>
                                        <td><div style="width:50px; float:left">{{status.open}}</div><div ng-if="status.open > 0" style="float:left"><a href="" ng-click="getSubStatus(status, 2, 0,<?php echo Auth::guard('admin')->user()->id; ?>)">Show Sub-status report</a></div></td>
                                        <td><div ng-if="status.open > 0">{{((status.open / status.Total) * 100).toFixed(2)}}</div><div ng-if="status.open == 0">0</div></td>
                                    </tr>   
                                    <tr>
                                        <td><b>Booked</b></td>
                                        <td>{{status.booked}}</td>
                                        <td><div ng-if="status.booked > 0">{{((status.booked / status.Total) * 100).toFixed(2)}}</div><div ng-if="status.booked == 0">0</div></td>
                                    </tr>
                                    <tr>
                                        <td><b>Lost</b></td>
                                        <td>{{status.lost}}</td>
                                        <td><div ng-if="status.lost > 0">{{((status.lost / status.Total) * 100).toFixed(2)}}</div><div ng-if="status.lost == 0">0</div></td>
                                    </tr>
                                    <tr>
                                        <td><b>Hold</b></td>
                                        <td><div style="width:50px; float:left">{{status.hold}}</div><div ng-if="status.hold > 0" style="float:left"><a href="" ng-click="getSubStatus(status, 5, 0,<?php echo Auth::guard('admin')->user()->id; ?>)">Show Sub-status report</a></div></td>
                                        <td><div ng-if="status.hold > 0">{{((status.hold / status.Total) * 100).toFixed(2)}}</div><div ng-if="status.hold == 0">0</div></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><b>Total</b></td>
                                        <td><b>{{status.Total}}</b></td>
                                        <td><b ng-if="status.Total > 0">{{((status.Total / status.Total) * 100).toFixed(2)}}</b><b ng-if="status.Total == 0">0</b></td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                        <div   class="row"  align="center" >
                            <div class="col-md-12 col-xs-12"  align="center" >
                                <div style="margin:0 auto;padding: 40px; width: 30%">
                                    <canvas id="doughnut" class="chart chart-doughnut" chart-data="statusdata" chart-options="statusoptions" chart-labels="statuslabels" chart-colors="statuscolors"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive"  ng-if="statusReport">
                            <h4>Sub-status report</h4>
                            <table class="table table-hover table-striped table-bordered" at-config="config">
                                <thead class="bord-bot">
                                    <tr>
                                        <th>Sub status of {{subStatus}} status</th>
                                        <th>No. of Enquiry</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="substatus in sub_status" ng-if="sub_status.length > 0">
                                        <td>{{substatus.enquiry_sales_substatus}}</td>
                                        <td>{{substatus.cnt}}</td>
                                        <td>{{((substatus.cnt / subStatusTotal) * 100).toFixed(2)}}</td>
                                    </tr>   
                                    <tr ng-if="unspecifiedStatus >= 1">
                                        <td>Unspecified Status</td>
                                        <td>{{unspecifiedStatus}}</td>
                                        <td>{{((unspecifiedStatus / subStatusTotal) * 100).toFixed(2)}}</td>
                                    </tr>
                                    <tr ng-if="sub_status.length >= 1 || unspecifiedStatus >= 1">
                                        <td><b>Total</b></td>
                                        <td><b>{{subStatusTotal}}</b></td>
                                        <td><b>{{((subStatusTotal / subStatusTotal) * 100).toFixed(2)}}</b></td>
                                    </tr>  
                                    <tr ng-if="sub_status.length == 0 && unspecifiedStatus < 1">
                                        <td colspan="3" align="center">
                                            <h4>No Record Found</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row"  align="center" ng-if="sub_status.length > 0 || unspecifiedStatus >= 1" >
                                <div class="col-md-12 col-xs-12"  align="center" >
                                    <div class="pie-chart-width" style="margin:0 auto;padding: 40px; width: 30%">
                                        <canvas id="doughnut" class="chart chart-doughnut" chart-data="substatusdata" chart-options="substatusoptions" chart-labels="substatuslabels" chart-colors="substatuscolors"></canvas>
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