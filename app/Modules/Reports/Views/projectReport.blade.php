<div class="row">
    <div class="widget flat radius-bordered">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="reportsController" >
            <!--<h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>Project Report</h5>-->
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Project Report</span>                
            </div>
            <div class="widget-body  col-lg-12 col-sm-12 col-xs-12">
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
                                            <tr  ng-repeat="category in category_report">
                                                <td>{{category.category}}</td>
                                                <td><div style="width:60px; float:left;"  ng-if="category.count > 0">{{category.count}}</div><div style="float:left;" ng-if="category.count > 0"> <a href="" style="padding-left:30px;" ng-click="teamcategoryEnquiryReport(category); teamEmployees(category); subProjectCategoryReport(category, category.id, 1)">Show sub-category wise report</a></div><span ng-if="category.count == 0">0</span></td>
                                                <td>{{((category.count / TotalCnt) * 100).toFixed(2) == 'NaN' ? '0':((category.count / TotalCnt) * 100).toFixed(2)}}</td>
                                            </tr> 
                                            <tr>
                                                <td align="center"><b>Total</b></td>
                                                <td><b>{{TotalCnt}}</b></td>
                                                <td><b>{{((TotalCnt / TotalCnt) * 100).toFixed(2) == 'NaN' ? '0':((TotalCnt / TotalCnt) * 100).toFixed(2)}}</b></td>
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
                        <div class=" table-responsive" ng-if="catReport">
                            <h4>Sub-category Report</h4>
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
                                    <tr ng-if="sub_category_report.length > 0 || unKnownCategory >= 1">
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
                            <div class="row"  align="center"  ng-if="sub_category_report.length > 0 || unKnownCategory >= 1" >
                                <div class="col-md-12 col-xs-12"  align="center" >
                                    <div style="margin:0 auto;padding: 40px; width: 30%">
                                        <canvas id="doughnut" class="chart chart-doughnut" chart-data="subcategorydata" chart-options="subcategoryoptions" chart-labels="subcategorylabels" chart-colors="subcategorycolors"></canvas>
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
                                            <tr  ng-repeat="sources in source_report">
                                                <td><b>{{ sources.sales_source_name.split("_").join(" ")}}</b></td>
                                                <td><div style="width:60px; float:left;"  ng-if="sources.cnt > 0">{{sources.cnt}}</div><div ng-if="sources.cnt > 0" style="float:left"><a href="" style="padding-left:30px;"  ng-click="projectSubSourceReport(sources); ">Show source report</a></div><span ng-if="sources.count == 0">0</span></td>
                                                <td>{{((sources.cnt / Total) * 100).toFixed(2)}}</td>
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
                        <div class="table-responsive" ng-if="subSourceCheck">
                            <table class="table table-hover table-striped table-bordered" at-config="config" ng-if="sub_source.length > 0 || unSpecifiedSource >= 1">
                                <thead class="bord-bot">
                                    <tr>
                                        <th>Sub Source Name</th>
                                        <th>No. of Enquiry</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="subsources in sub_source">
                                        <td>{{subsources.sub_source}}</td>
                                        <td>{{subsources.cnt}}</td>
                                        <td ng-if="subsources.cnt > 0"><b>{{((subsources.cnt / subsourceTotal) * 100).toFixed(2)}}</b></td>
                                        <td ng-if="subsources.cnt == 0"><b>0.00</b></td>
                                    </tr> 
                                    <tr ng-if="unSpecifiedSource >= 1">
                                        <td>Unspecified sub-source</td>
                                        <td>{{unSpecifiedSource}}</td>
                                        <td><b>{{((unSpecifiedSource / subsourceTotal) * 100).toFixed(2)}}</b></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><b>Total</b></td>
                                        <td><b>{{subsourceTotal}}</b></td>
                                        <td ng-if="subsourceTotal > '0'"><b>{{((subsourceTotal / subsourceTotal) * 100).toFixed(2)}}</b></td>
                                        <td ng-if="subsourceTotal == '0'"><b>0.00</b></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row"  align="center" ng-if="sub_source.length > 0 || unSpecifiedSource >= 1">
                                <div class="col-md-12 col-xs-12"  align="center" >
                                    <div style="margin:0 auto;padding: 40px; width: 30%">
                                        <canvas id="doughnut" class="chart chart-doughnut" chart-data="sub_sourcedata" chart-options="sub_sourceoptions" chart-labels="sub_sourcelabels" chart-colors="sub_sourcecolors"></canvas>
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
                                            <tr  ng-repeat="status in status_report">
                                                <td><b>{{ status.sales_status.split("_").join(" ")}}</b></td>
                                                <td><div style="width:60px; float:left;"  ng-if="status.cnt > 0">{{status.cnt}}</div><a  href="" ng-click="subProjectStatusReport(status, 2, 0)">Show Sub-Status wise report</a></td>
                                                <td>{{((status.cnt / statusTotal) * 100).toFixed(2) == 'NaN' ? '0':((status.cnt / statusTotal) * 100).toFixed(2)}}</td>
<!--                                               <td>{{((value / Total) * 100).toFixed(2)}}</td>-->
                                            </tr> 
                                            <tr>
                                                <td align="center"><b>Total</b></td>
                                                <td><b>{{statusTotal}}</b></td>
                                                <td><b>{{((statusTotal / statusTotal) * 100).toFixed(2) == 'NaN' ? '0':((statusTotal / statusTotal) * 100).toFixed(2)}}</b></td>
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
                        <div class=" table-responsive" ng-if="statusReport">
                            <h4>Sub-status Report of {{statusEmployee}}</h4>
                            <table class="table table-hover table-striped table-bordered" at-config="config">
                                <thead class="bord-bot">
                                    <tr>
                                        <th>Sub status of {{subStatus}} status</th>
                                        <th>No. of Enquiry</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="substatus in sub_status_report" ng-if="sub_status_report.length > 0">
                                        <td>{{substatus.enquiry_sales_substatus}}</td>
                                        <td>{{substatus.cnt}}</td>
                                        <td>{{((substatus.cnt / subStatus_Total) * 100).toFixed(2)}}</td>
                                    </tr>   
                                    <tr ng-if="unspecifiedStatus >= 1">
                                        <td>Unspecified Status</td>
                                        <td>{{unspecifiedStatus}}</td>
                                        <td>{{((unspecifiedStatus / subStatus_Total) * 100).toFixed(2)}}</td>
                                    </tr>
                                    <tr ng-if="sub_status_report.length > 0 || unspecifiedStatus >= 1">
                                        <td><b>Total</b></td>
                                        <td><b>{{subStatus_Total}}</b></td>
                                        <td><b>{{((subStatus_Total / subStatus_Total) * 100).toFixed(2)}}</b></td>
                                    </tr>  
                                    <tr ng-if="sub_status_report.length == 0">
                                        <td colspan="3" align="center">
                                            <h4>No Record Found</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--ng-if="sub_status_report.length > 0 || unspecifiedStatus >= 1"-->
                            <div class="row"  align="center" >
                                <div class="col-md-12 col-xs-12"  align="center" >
                                    <div style="margin:0 auto;padding: 40px; width: 30%">
                                        <canvas id="doughnut" class="chart chart-doughnut" chart-data="substatus_data" chart-options="substatus_options" chart-labels="substatus_labels" chart-colors="substatus_colors"></canvas>
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