<div class="row">
    <div class="widget flat radius-bordered">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="reportsController" ng-init="teamEnquiryReport([[$loggedInUserID]])">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>Team Enquiry Report</h5>
            <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12">
                <tabset class="col-md-12">
                    <tab heading="Category" ng-click="teamEnquiryReport(<?php echo Auth::guard('admin')->user()->id; ?>)">
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
                                                <td ng-if="category.is_parent == 1"><a href=""  ng-click="teamcategoryEnquiryReport(category); teamEmployees(category);">{{category.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></td>
                                                <td ng-if="category.is_parent == 0">{{category.name}}</td>
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
                                <div class="widget animated-item"  ng-if="subteam_category_report.length > 0 || sub_category_report.length > 0">
                                    <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12" style="margin-left:-1%; width: 102%;">
                                        <tabset class="col-md-12">
                                            <tab ng-repeat="emp in empListTab" ng-click="teamcategoryEnquiryReport(emp);"  id="{{'tab' + emp.employee_id}}" heading="{{emp.name}}">
                                                <div id="category-report">
                                                    <div class="widget" ng-if="subteam_category_report.length > 0">  
                                                        <p style="margin-left: 90%;" ng-if="empId != '1'" ng-click="closeTab(empId)">
                                                            <button type="button" class="btn btn-default btn-sm">
                                                                <span class="glyphicon glyphicon-remove"></span> Close 
                                                            </button>
                                                        </p>
                                                        <div class=" table-responsive" >
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
                                                                        <td ng-if="subcategory.is_parent == 1"><a href="" ng-if="subcategory.employee_id != employee_id" ng-click="teamcategoryEnquiryReport(subcategory); teamEmployees(subcategory);">{{subcategory.name}}</a><span ng-if="subcategory.employee_id == employee_id" >{{subcategory.name}}</span></div>
                                                                        <td ng-if="subcategory.is_parent == 0">{{subcategory.name}}</div>
                                                                        <td><b>{{subcategory.Total}}</b></td>
                                                                        <td ng-if="subcategory.employee_id == employee_id"><span  ng-if="subcategory.New > 0">{{subcategory.New}} <a href="" style="padding-left:30px;" ng-click="subCategoryReport(subcategory, 1, 0)">Show sub-category wise report</a></span><span ng-if="subcategory.New == 0">{{subcategory.New}}</span></td>
                                                                        <td ng-if="subcategory.employee_id != employee_id"><span  ng-if="subcategory.New > 0">{{subcategory.New}} <a style="padding-left:30px;" href=""  ng-click="subCategoryReport(subcategory, 1, 1)">Show sub-category wise report</a></span><span ng-if="subcategory.New == 0">{{subcategory.New}}</span></td>
                                                                        <td ng-if="subcategory.employee_id == employee_id"><span  ng-if="subcategory.Hot > 0">{{subcategory.Hot}} <a style="padding-left:30px;" href=""  ng-click="subCategoryReport(subcategory, 2, 0)">Show sub-category wise report</a></span><span ng-if="subcategory.Hot == 0">{{subcategory.Hot}}</span></td>
                                                                        <td ng-if="subcategory.employee_id != employee_id"><span  ng-if="subcategory.Hot > 0">{{subcategory.Hot}} <a href=""  style="padding-left:30px;" ng-click="subCategoryReport(subcategory, 2, 1)">Show sub-category wise report</a></span><span ng-if="subcategory.Hot == 0">{{subcategory.Hot}}</span></td>
                                                                        <td ng-if="subcategory.employee_id == employee_id"><span  ng-if="subcategory.Warm > 0">{{subcategory.Warm}} <a href="" style="padding-left:30px;" ng-click="subCategoryReport(subcategory, 3, 0)">Show sub-category wise report</a></span><span ng-if="subcategory.Warm == 0">{{subcategory.Warm}}</span></td>
                                                                        <td ng-if="subcategory.employee_id != employee_id"><span  ng-if="subcategory.Warm > 0">{{subcategory.Warm}} <a href="" style="padding-left:30px;" ng-click="subCategoryReport(subcategory, 3, 1)">Show sub-category wise report</a></span><span ng-if="subcategory.Warm == 0">{{subcategory.Warm}}</span></td>
                                                                        <td ng-if="subcategory.employee_id == employee_id"><span  ng-if="subcategory.Cold > 0">{{subcategory.Cold}} <a href="" style="padding-left:30px;" ng-click="subCategoryReport(subcategory, 4, 0)">Show sub-category wise report</a></span><span ng-if="subcategory.Cold == 0">{{subcategory.Cold}}</span></td>
                                                                        <td ng-if="subcategory.employee_id != employee_id"><span  ng-if="subcategory.Cold > 0">{{subcategory.Cold}} <a href="" style="padding-left:30px;" ng-click="subCategoryReport(subcategory, 4, 1)">Show sub-category wise report</a></span><span ng-if="subcategory.Cold == 0">{{subcategory.Cold}}</span></td>
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
                                                        <div class="row"  align="center">
                                                            <div class="col-md-12 col-xs-12"  align="center" >
                                                                <div style="margin:0 auto;padding: 40px; width: 30%">
                                                                    <canvas id="doughnut" class="chart chart-doughnut" chart-data="subteamcategorydata" chart-options="subteamcategoryoptions" chart-labels="subteamcategorylabels" chart-colors="subteamcategorycolors"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class=" table-responsive" id="catReport" style="display:none">
                                                        <h4>Category Report of {{catEmployee}}</h4>
                                                        <table class="table table-hover table-striped table-bordered" at-config="config" >
                                                            <thead class="bord-bot">
                                                                <tr>
                                                                    <th>Sub Category</th>
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
                                                                <tr ng-if="sub_category_report.length > 0">
                                                                    <td><b>Total</b></td>
                                                                    <td><b>{{subCatTotal}}</b></td>
                                                                    <td><b>{{((subCatTotal / subCatTotal) * 100).toFixed(2)}}</b></td>
                                                                </tr>
                                                                <tr ng-if="sub_category_report.length == 0">
                                                                    <td colspan="3" align="center">
                                                                        <h4>No Record Found</h4>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class="row"  align="center"  ng-if="sub_category_report.length > 0" >
                                                            <div class="col-md-12 col-xs-12"  align="center" >
                                                                <div style="margin:0 auto;padding: 40px; width: 30%">
                                                                    <canvas id="doughnut" class="chart chart-doughnut" chart-data="subcategorydata" chart-options="subcategoryoptions" chart-labels="subcategorylabels" chart-colors="subcategorycolors"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="widget-body table-responsive" ng-if="enquiries.length > 0">
                                                        <table class="table table-hover table-striped table-bordered" at-config="config">
                                                            <thead class="bord-bot">
                                                                <tr>
                                                                    <th>Sr No.</th>
                                                                    <th>Enquiry Date</th>
                                                                    <th>Customer</th>
                                                                    <th>Mobile No.</th>
                                                                    <th>Email</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr ng-repeat="enquiry in enquiries">
                                                                    <td>{{$index + 1}}</td>
                                                                    <td>{{enquiry.sales_enquiry_date}}</td>
                                                                    <td>{{enquiry.first_name + ' ' + enquiry.last_name}}</td>
                                                                    <td>{{enquiry.mobile_number}}</td>
                                                                    <td>{{enquiry.email_id == 'null' ? " " : enquiry.email_id }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </tab>
                                        </tabset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tab>
                    <tab heading="Source" active="source_div"  ng-click="teamEnquiryReport(<?php echo Auth::guard('admin')->user()->id; ?>)">
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
                                                <th>No. of Enquiry</th>
                                                <th>Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="sources in team_source_report">
                                                <td><a href="" ng-click="getsourceReport(sources); teamsourceEmployees(sources);">{{sources.name}}</a></div>
                                                <td>{{sources.total}}</td>
                                                <td ng-if="sources.total > 0"><b>{{ ((sources.total / team_source_total) * 100).toFixed(2)}}</b></td>
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
                        </div> 
                        <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12" ng-if="empListTab1.length > 0" style="margin-left:-1%; width: 102%;">
                            <tabset class="col-md-12">
                                <tab ng-repeat="emp in empListTab1"  id="{{'tab1' + emp.employee_id}}" ng-click="getsourceReport(emp);" heading="{{emp.name}}"  >
                                    <div id="category-report">
                                        <div class="widget">    
                                            <div class="widget" ng-if="teamEmp_source_report.length > '0'">  

                                                <p style="margin-left: 90%;" ng-if="empId1 != '1'"  ng-click="closeSourceTab(empId1)">
                                                    <button type="button" class="btn btn-default btn-sm">
                                                        <span class="glyphicon glyphicon-remove"></span> Close 
                                                    </button>
                                                </p>
                                                <table class="table table-hover table-striped table-bordered" at-config="config">
                                                    <thead class="bord-bot">
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>No. of Enquiry</th>
                                                            <th>Percentage</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="sub_sources in teamEmp_source_report">
                                                            <td ng-if="sub_sources.is_parent == '1'"><a href="" ng-if="employee_id != sub_sources.employee_id" ng-click="getsourceReport(sub_sources); teamsourceEmployees(sub_sources);">{{sub_sources.name}}</a><span ng-if="employee_id == sub_sources.employee_id">{{sub_sources.name}}</span></td>
                                                            <td ng-if="sub_sources.is_parent == '0'">{{sub_sources.name}}</td>
                                                            <td ng-if="sub_sources.is_parent == '1' && sub_sources.total > '0'"><span ng-if="employee_id == sub_sources.employee_id">{{sub_sources.total}}    &nbsp;&nbsp;&nbsp;&nbsp;<a href=""  ng-click="getSubSourceReport(sub_sources)">Show source wise report</a></span><span ng-if="employee_id != sub_sources.employee_id">{{sub_sources.total}} &nbsp;&nbsp;&nbsp;&nbsp;  <a href="" ng-click="getSubSourceGroupReport(sub_sources)">Show source wise report</a></span></td>
                                                            <td ng-if="sub_sources.is_parent == '1' && sub_sources.total == '0'">{{sub_sources.total}}</td>
                                                            <td ng-if="sub_sources.is_parent == '0'"><span  ng-if="sub_sources.total != '0'">{{sub_sources.total}}<a style="padding-left:30px;" href=""   ng-click="getSubSourceReport(sub_sources)">Show source wise report</a></span><span  ng-if="sub_sources.total == '0'">{{sub_sources.total}}</span></td>
                                                            <td ng-if="sub_sources.total > 0"><b>{{ ((sub_sources.total / subEmpSourceTotal) * 100).toFixed(2)}}</b></td>
                                                            <td ng-if="sub_sources.total == 0"><b>0.00</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center"><b>Total</b></td>
                                                            <td><b>{{subEmpSourceTotal}}</b></td>
                                                            <td ng-if="subEmpSourceTotal > '0'"><b>{{((subEmpSourceTotal / subEmpSourceTotal) * 100).toFixed(2)}}</b></td>
                                                            <td ng-if="subEmpSourceTotal == '0'"><b>0.00</b></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="table-responsive" id="sourceEmp" >
                                                <h4>Source report of {{sourceEmployee}}</h4>
                                                <table class="table table-hover table-striped table-bordered" at-config="config">
                                                    <thead class="bord-bot">
                                                        <tr>
                                                            <th>Source Name</th>
                                                            <th>No. of Enquiry</th>
                                                            <th>Percentage</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="mysources in subteam_source_report" ng-if="subteam_source_report.length > 0">
                                                            <td >{{mysources.sales_source_name}}</td>
                                                            <td ng-if="mysources.cnt > 0">{{mysources.cnt}}<a href="" style="padding-left:30px;" ng-if="mysources.substatus == 1" ng-click="subSourceReport(mysources)">Show sub-source report</a></td>
                                                            <td ng-if="mysources.cnt == 0">{{mysources.cnt}}</td>
                                                            <td ng-if="mysources.cnt > 0"><b>{{((mysources.cnt / team_sub_source_total) * 100).toFixed(2)}}</b></td>
                                                            <td ng-if="mysources.cnt == 0"><b>0.00</b></td>
                                                        </tr> 
                                                        <tr ng-if="subteam_source_report.length > 0">
                                                            <td align="center"><b>Total</b></td>
                                                            <td><b>{{team_sub_source_total}}</b></td>
                                                            <td ng-if="team_sub_source_total > '0'"><b>{{((team_sub_source_total / team_sub_source_total) * 100).toFixed(2)}}</b></td>
                                                            <td ng-if="team_sub_source_total == '0'"><b>0.00</b></td>
                                                        </tr>
                                                        <tr ng-if="subteam_source_report.length == 0">
                                                            <td colspan="3" align="center">
                                                                <h4>No Record Found</h4>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row"  align="center" ng-if="subteam_source_report.length > 0">
                                                <div class="col-md-12 col-xs-12"  align="center" >
                                                    <div style="margin:0 auto;padding: 40px; width: 30%">
                                                        <canvas id="doughnut" class="chart chart-doughnut" chart-data="team_sourcedata" chart-options="team_sourceoptions" chart-labels="team_sourcelabels" chart-colors="team_sourcecolors"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive" ng-if="sub_source.length > 0">

                                                <table class="table table-hover table-striped table-bordered" at-config="config">
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
                                                            <td ng-if="subsources.cnt > 0"><b>{{((subsources.cnt / subSourceTotal) * 100).toFixed(2)}}</b></td>
                                                            <td ng-if="subsources.cnt == 0"><b>0.00</b></td>
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
                                            <div class="row"  align="center" ng-if="sub_source.length > 0">
                                                <div class="col-md-12 col-xs-12"  align="center" >
                                                    <div style="margin:0 auto;padding: 40px; width: 30%">
                                                        <canvas id="doughnut" class="chart chart-doughnut" chart-data="team_subsourcedata" chart-options="team_subsourceoptions" chart-labels="team_subsourcelabels" chart-colors="team_subsourcecolors"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-body table-responsive" ng-if="enquiries.length > 0">
                                                <table class="table table-hover table-striped table-bordered" at-config="config">
                                                    <thead class="bord-bot">
                                                        <tr>
                                                            <th>Sr No.</th>
                                                            <th>Enquiry Date</th>
                                                            <th>Customer</th>
                                                            <th>Mobile No.</th>
                                                            <th>Email</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="enquiry in enquiries">
                                                            <td>{{$index + 1}}</td>
                                                            <td>{{enquiry.sales_enquiry_date}}</td>
                                                            <td>{{enquiry.first_name + ' ' + enquiry.last_name}}</td>
                                                            <td>{{enquiry.mobile_number}}</td>
                                                            <td>{{enquiry.email_id == 'null' ? " " :enquiry.email_id }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </tab>
                            </tabset>
                        </div>   
                    </tab>
                    <tab heading="Status" ng-click="teamEnquiryReport(<?php echo Auth::guard('admin')->user()->id; ?>)">
                        <div id="category-report">
                            <div class="widget">                                
                                <div class="widget-header">
                                    <span class="widget-caption" style="font-size: 15px;font-weight: 600 !important;">Team's Status-Wise Enquiry Report</span>
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
                                                <th>Preserved</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="status in team_status_report">
                                                <td ng-if="status.is_parent == 1"><a href="" ng-if="status.is_parent == 1" ng-click="teamstatusReport(status); teamStatusEmployees(status);">{{status.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></td>
                                                <td ng-if="status.is_parent == 0">{{status.name}}</td>
                                                <td><b>{{status.total}}</b></td>
                                                <td>{{status.new}}</td>
                                                <td>{{status.open}}</td>
                                                <td>{{status.booked}}</td>
                                                <td>{{status.lost}}</td>
                                                <td>{{status.preserved}}</td>
                                            </tr>   
                                            <tr>
                                                <td><b>Total</b></td>
                                                <td><b>{{stotal}}</b></td>
                                                <td><b>{{stotalNew}}</b></td>
                                                <td><b>{{stotalOpen}}</b></td>
                                                <td><b>{{stotalBooked}}</b></td>
                                                <td><b>{{stotalLost}}</b></td>
                                                <td><b>{{stotalPreserved}}</b></td>
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
                                                <td ng-if="stotalPreserved > '0'"><b>{{((stotalPreserved / stotal) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="stotalPreserved == '0'"><b>0.00</b></td>
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
                                <div class="widget"  ng-if="sub_team_status_report.length > 0 || sub_status.length > 0">
                                    <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12" style="margin-left:-1%; width: 102%;">
                                        <tabset class="col-md-12">
                                            <tab ng-repeat="emp in empListTab2"  id="{{'tab2' + emp.employee_id}}" ng-click="teamstatusReport(emp);"   id="{{emp.employee_id}}" heading="{{emp.name}}"  >
                                                <div id="category-report">
                                                    <div class="widget" ng-if="sub_team_status_report.length > 0">
                                                        <div class="widget-body table-responsive">
                                                            <p style="margin-left: 90%;" ng-if="empId2 != '1'"  ng-click="closeStatusTab(empId2)">
                                                                <button type="button" class="btn btn-default btn-sm">
                                                                    <span class="glyphicon glyphicon-remove"></span> Close 
                                                                </button>
                                                            </p>
                                                            <table  class="table table-hover table-striped table-bordered" at-config="config">
                                                                <thead class="bord-bot">
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Total</th>
                                                                        <th>New</th>
                                                                        <th>Open</th>
                                                                        <th>Booked</th>
                                                                        <th>Lost</th>
                                                                        <th>Preserved</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr ng-repeat="status in sub_team_status_report">
                                                                        <td ng-if="status.is_parent == 1"><a href="" ng-if="status.employee_id != employee_id"  ng-click="teamstatusReport(status); teamStatusEmployees(status);">{{status.name}}</a><span ng-if="status.employee_id == employee_id">{{status.name}}</span></td>
                                                                        <td ng-if="status.is_parent == 0">{{status.name}}</div>
                                                                        <td><b>{{status.total}}</b></td>
                                                                        <td ng-if="status.employee_id == employee_id"><span ng-if="status.new > 0">{{status.new}}  <a style="padding-left:30px;" href=""   ng-click="getSubStatus(status, 1, 0)">Show Sub-status wise report</a></span><span ng-if="status.new == 0">{{status.new}}</span></td>
                                                                        <td ng-if="status.employee_id != employee_id"><span ng-if="status.new > 0">{{status.new}}  <a style="padding-left:30px;" href=""   ng-click="getSubStatus(status, 1, 1)">Show Sub-status wise report</a></span><span ng-if="status.new == 0">{{status.new}}</span></td>
                                                                        <td ng-if="status.employee_id == employee_id"><span ng-if="status.open > 0">{{status.open}} <a style="padding-left:30px;" href="" ng-click="getSubStatus(status, 2, 0)">Show Sub-status wise report</a></span><span ng-if="status.open == 0">{{status.open}}</span></td>
                                                                        <td ng-if="status.employee_id != employee_id"><span ng-if="status.open > 0">{{status.open}} <a style="padding-left:30px;" href="" ng-click="getSubStatus(status, 2, 1)">Show Sub-status wise report</a></span><span ng-if="status.open == 0">{{status.open}}</span></td>
                                                                        <td ng-if="status.employee_id == employee_id"><span ng-if="status.booked > 0">{{status.booked}} <a style="padding-left:30px;" href=""  ng-click="getSubStatus(status, 3, 0)">Show Sub-status wise report</a></span><span ng-if="status.booked == 0">{{status.booked}}</span></td>
                                                                        <td ng-if="status.employee_id != employee_id"><span ng-if="status.booked > 0">{{status.booked}} <a style="padding-left:30px;" href=""  ng-click="getSubStatus(status, 3, 1)">Show Sub-status wise report</a></span><span ng-if="status.booked == 0">{{status.booked}}</span></td>
                                                                        <td ng-if="status.employee_id == employee_id"><span ng-if="status.lost > 0">{{status.lost}} <a style="padding-left:30px;" href=""  ng-click="getSubStatus(status, 4, 0)">Show Sub-status wise report</a></span><span ng-if="status.lost == 0">{{status.lost}}</span></td>
                                                                        <td ng-if="status.employee_id != employee_id"><span ng-if="status.lost > 0">{{status.lost}}<a style="padding-left:30px;" href=""  ng-click="getSubStatus(status, 4, 1)">Show Sub-status wise report</a></span><span ng-if="status.lost == 0">{{status.lost}}</span></td>
                                                                        <td ng-if="status.employee_id == employee_id"><span ng-if="status.preserved > 0">{{status.preserved}}<a style="padding-left:30px;" href="" ng-click="getSubStatus(status, 5, 0)">Show Sub-status wise report</a></span><span ng-if="status.preserved == 0">{{status.preserved}}</span></td>
                                                                        <td ng-if="status.employee_id != employee_id"><span ng-if="status.preserved > 0">{{status.preserved}}<a style="padding-left:30px;" href="" ng-click="getSubStatus(status, 5, 1)">Show Sub-status wise report</a></span><span ng-if="status.preserved == 0">{{status.preserved}}</span></td> 
                                                                    </tr>   
                                                                    <tr>
                                                                        <td><b>Total</b></td>
                                                                        <td><b>{{stotal}}</b></td>
                                                                        <td><b>{{stotalNew}}</b></td>
                                                                        <td><b>{{stotalOpen}}</b></td>
                                                                        <td><b>{{stotalBooked}}</b></td>
                                                                        <td><b>{{stotalLost}}</b></td>
                                                                        <td><b>{{stotalPreserved}}</b></td>
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
                                                                        <td ng-if="stotalPreserved > '0'"><b>{{((stotalPreserved / stotal) * 100).toFixed(2)}}</b></td>
                                                                        <td ng-if="stotalPreserved == '0'"><b>0.00</b></td>
                                                                    </tr>  
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="row"  align="center"  ng-if="sub_team_status_report.length > 0">
                                                            <div class="col-md-12 col-xs-12"  align="center" >
                                                                <div style="margin:0 auto;padding: 40px; width: 30%">
                                                                    <canvas id="doughnut" class="chart chart-doughnut" chart-data="steamstatusdata" chart-options="steamstatusoptions" chart-labels="steamstatuslabels" chart-colors="steamstatuscolors"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class=" table-responsive" id="statusReport" style="display:none">
                                                            <h4>Status report of {{statusEmployee}}</h4>
                                                            <table class="table table-hover table-striped table-bordered" at-config="config">
                                                                <thead class="bord-bot">
                                                                    <tr>
                                                                        <th>Sub Status</th>
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
                                                                    <tr ng-if="sub_status.length > 0">
                                                                        <td><b>Total</b></td>
                                                                        <td><b>{{subStatusTotal}}</b></td>
                                                                        <td><b>{{((subStatusTotal / subStatusTotal) * 100).toFixed(2)}}</b></td>
                                                                    </tr>  
                                                                    <tr ng-if="sub_status.length == 0">
                                                                        <td colspan="3" align="center">
                                                                            <h4>No Record Found</h4>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="row"  align="center" ng-if="sub_status.length > 0" >
                                                            <div class="col-md-12 col-xs-12"  align="center" >
                                                                <div style="margin:0 auto;padding: 40px; width: 30%">
                                                                    <canvas id="doughnut" class="chart chart-doughnut" chart-data="substatusdata" chart-options="substatusoptions" chart-labels="substatuslabels" chart-colors="substatuscolors"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="widget-body table-responsive" ng-if="enquiries.length > 0">
                                                            <table class="table table-hover table-striped table-bordered" at-config="config">
                                                                <thead class="bord-bot">
                                                                    <tr>
                                                                        <th>Sr No.</th>
                                                                        <th>Enquiry Date</th>
                                                                        <th>Customer</th>
                                                                        <th>Mobile No.</th>
                                                                        <th>Email</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr ng-repeat="enquiry in enquiries">
                                                                        <td>{{$index + 1}}</td>
                                                                        <td>{{enquiry.sales_enquiry_date}}</td>
                                                                        <td>{{enquiry.first_name + ' ' + enquiry.last_name}}</td>
                                                                        <td>{{enquiry.mobile_number}}</td>
                                                                        <td>{{enquiry.email_id == 'null' ? " " :enquiry.email_id }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </tab>
                                        </tabset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tab>
            </div>
        </div>
    </div>
</div>