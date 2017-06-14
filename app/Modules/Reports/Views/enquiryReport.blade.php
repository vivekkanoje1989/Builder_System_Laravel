
<div class="row">
    <div class="widget flat radius-bordered">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="reportsController" ng-init="myEnquiryReport([[$loggedInUserID]])">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{headingName}}</h5>
            <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12">
                <tabset class="col-md-12">
                    <tab heading="Category" ng-click="reportHeading('Enquiry Category Report')">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered" at-config="config">
                                <thead class="bord-bot">
                                    <tr>
                                        <th>Category</th>
                                        <th>No. of Enquiry</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody ng-repeat="category in category_report track by $index">
                                    <tr>
                                        <td><b>New</b></td>
                                        <td>{{category.New}}</td>
                                        <td>{{((category.New / category.Total) * 100).toFixed(2)}}</td>
                                    </tr>   
                                    <tr>
                                        <td><b>Hot</b></td>
                                        <td>{{category.Hot}}</td>
                                        <td>{{((category.Hot / category.Total) * 100).toFixed(2)}}</td>
                                    </tr>   
                                    <tr>
                                        <td><b>Warm</b></td>
                                        <td>{{category.Warm}}</td>
                                        <td>{{((category.Warm / category.Total) * 100).toFixed(2)}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Cold</b></td>
                                        <td>{{category.Cold}}</td>
                                        <td>{{((category.Cold / category.Total) * 100).toFixed(2)}}</td>
                                    </tr>
                                    <tr>
                                        <td align="center"><b>Total</b></td>
                                        <td><b>{{category.Total}}</b></td>
                                        <td><b>{{((category.Total / category.Total) * 100).toFixed(2)}}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row"  align="center" >
                            <div class="col-md-12 col-xs-12"  align="center" >
                                <div style="margin:0 auto;padding: 40px; width: 30%">
                                    <canvas id="doughnut" class="chart chart-doughnut" chart-data="categorydata" chart-options="categoryoptions" chart-labels="categorylabels" chart-colors="categorycolors"></canvas>
                                </div>
                            </div>
                        </div>
                    </tab>
                    <tab heading="Source" active="source_div" ng-click="reportHeading('Enquiry Source Report')">
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
                                    <tr  ng-repeat="(key,value) in source_report['0']">
                                        <td><b>{{ key.split("_").join(" ")}}</b></td>
                                        <td>{{value}}</td>
                                        <td>{{((value / Total) * 100).toFixed(2)}}</td>
                                    </tr>
                                    <tr>
                                        <td align="center"><b>Total</b></td>
                                        <td><b>{{Total}}</b></td>
                                        <td><b>{{((Total / Total) * 100).toFixed(2)}}</b></td>
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
                    </tab>
                    <tab heading="Status" active="status_div" ng-click="reportHeading('Enquiry Status Report')">
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
                                        <td>{{status.New}}</td>
                                        <td>{{((status.New / status.Total) * 100).toFixed(2)}}</td>
                                    </tr>   
                                    <tr>
                                        <td><b>Open</b></td>
                                        <td>{{status.Open}}</td>
                                        <td>{{((status.Open / status.Total) * 100).toFixed(2)}}</td>
                                    </tr>   
                                    <tr>
                                        <td><b>Booked</b></td>
                                        <td>{{status.Booked}}</td>
                                        <td>{{((status.Booked / status.Total) * 100).toFixed(2)}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Lost</b></td>
                                        <td>{{status.Lost}}</td>
                                        <td>{{((status.Lost / status.Total) * 100).toFixed(2)}}</td>
                                    </tr>
                                    <tr>
                                        <td align="center"><b>Total</b></td>
                                        <td><b>{{status.Total}}</b></td>
                                        <td><b>{{((status.Total / status.Total) * 100).toFixed(2)}}</b></td>
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
                    </tab>
                </tabset>
            </div>
        </div>
    </div>
</div>