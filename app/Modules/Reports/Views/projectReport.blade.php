<div class="row">
    <div class="widget flat radius-bordered">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="reportsController" >
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>Project Report</h5>
            <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12">
                <div class="col-sm-3 col-xs-12" ng-controller="projectCtrl">
                    <label for="search">Select Project:</label>
                    <span class="input-icon icon-right">
                        <select id="project" name="project" class="form-control" ng-model="project"  ng-change="projectWiseReport(project, '[[$loggedInUserID]]')" >
                            <option value="">Select Projects</option>
                            <option ng-repeat="item in projectList" value="{{item.id}}">{{item.project_name}}</option>
                        </select>
                        <i class="fa fa-sort-desc"></i>
                    </span><br/><br/>
                </div>
                <tabset class="col-md-12" ng-if="projectShow">
                    <tab heading="Category">
                        <div id="category-report">
                            <div class="widget">                                
                                <div class="widget-header">
                                    <span class="widget-caption" style="font-size: 15px;font-weight: 600 !important;">Enquiry Category-Wise Report</span>
                                </div>
                                <div class="widget-body table-responsive">

                                    <table class="table table-hover table-striped table-bordered" at-config="config">
                                        <thead class="bord-bot">
                                            <tr>
                                                <th>Category</th>
                                                <th>No. of Enquiry</th>
                                                <th>Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr  ng-repeat="(key,value) in category_report['0']">
                                                <td><b>{{ key.split("_").join(" ")}}</b></td>
                                                <td>{{value}}</td>
                                                <td>{{((value / Total) * 100).toFixed(2) == 'NaN' ? '0':((value / Total) * 100).toFixed(2)}}</td>
                                            </tr> 
                                            <tr>
                                                <td align="center"><b>Total</b></td>
                                                <td><b>{{Total}}</b></td>
                                                <td><b>{{((Total / Total) * 100).toFixed(2) == 'NaN' ? '0':((Total / Total) * 100).toFixed(2)}}</b></td>
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
                            </div>
                        </div>
                    </tab>
                    <tab heading="Source" active="source_div">
                        <div id="source-report">
                            <div class="widget">                                
                                <div class="widget-header">
                                    <span class="widget-caption" style="font-size: 15px;font-weight: 600 !important;">Enquiry Source-Wise Report</span>
                                </div>
                                <div class="widget-body table-responsive">
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
                            </div>
                        </div>
                    </tab>
                    <tab heading="Status" active="status_div">
                        <div id="status-report">
                            <div class="widget">                                
                                <div class="widget-header">
                                    <span class="widget-caption" style="font-size: 15px;font-weight: 600 !important;">Enquiry Status-Wise Report</span>
                                </div>
                                <div class="widget-body table-responsive">
                                    <table class="table table-hover table-striped table-bordered" at-config="config">
                                        <thead class="bord-bot">
                                            <tr>
                                                <th>Status</th>
                                                <th>No. of Enquiry</th>
                                                <th>Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            <tr  ng-repeat="(key,value) in status_report['0']">
                                                <td><b>{{ key.split("_").join(" ")}}</b></td>
                                                <td>{{value}}</td>
                                                <td>{{((value / Total) * 100).toFixed(2) == 'NaN' ? '0':((value / Total) * 100).toFixed(2)}}</td>
<!--                                               <td>{{((value / Total) * 100).toFixed(2)}}</td>-->
                                            </tr> 
                                            <tr>
                                                <td align="center"><b>Total</b></td>
                                                <td><b>{{Total}}</b></td>
                                                <td><b>{{((Total / Total) * 100).toFixed(2) == 'NaN' ? '0':((Total / Total) * 100).toFixed(2)}}</b></td>
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
                            </div>
                        </div>
                    </tab>
                </tabset>
            </div>
        </div>
    </div>
</div>