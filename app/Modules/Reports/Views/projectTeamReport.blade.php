<div class="row">
    <div class="widget flat radius-bordered">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="reportsController">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>Team's Project Report</h5>
            <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12">
                <div class="col-sm-3 col-xs-12" ng-controller="projectCtrl">
                    <label for="search">Select Project:</label>
                    <span class="input-icon icon-right">
                        <select id="project" name="project" class="form-control" ng-model="project"  ng-change="projectWiseTeamReports(project, '[[$loggedInUserID]]')" >
                            <option value="">Select Projects</option>
                            <option ng-repeat="item in projectList" value="{{item.id}}">{{item.project_name}}</option>
                        </select>
                        <i class="fa fa-sort-desc"></i>
                    </span><br/><br/>
                </div>
                <tabset class="col-md-12" ng-if="project_id > 0">
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
                                                <td ng-if="category.is_parent == 1"><a href=""  ng-click="teamProjectCategoryReport(category); teamEmployees(category);">{{category.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></div>
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
                                    <div class="row"  align="center" >
                                        <div class="col-md-12 col-xs-12"  align="center" >
                                            <div style="margin:0 auto;padding: 40px; width: 30%">
                                                <canvas id="doughnut" class="chart chart-doughnut" chart-data="teamcategorydata" chart-options="categoryoptions" chart-labels="categorylabels" chart-colors="categorycolors"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                                <div class="widget animated-item"  ng-if="subteam_category_report.length > 0 || subteam_category_report.length > 0">
                                    <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12" style="margin-left:-1%; width: 102%;">
                                        <tabset class="col-md-12">
                                            <tab ng-repeat="emp in empListTab" ng-click="teamcategoryEnquiryReport(emp);"  id="{{'tab' + emp.employee_id}}" heading="{{emp.name}}">
                                                <div id="category-report">
                                                    <div class="widget" ng-if="subteam_category_report.length > 0">  
                                                        <p style="margin-left: 90%;" ng-if="empId != '1'" ng-click="closeProjectsTab(empId)">
                                                            <button type="button" class="btn btn-default btn-sm">
                                                                <span class="glyphicon glyphicon-remove"></span> Close 
                                                            </button>
                                                        </p>
                                                        <div class="table-responsive">
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
                                                                        <td ng-if="subcategory.is_parent == 1 && subcategory.employee_id != employee_id"><a href="" ng-click="teamProjectCategoryReport(subcategory); teamEmployees(subcategory);">{{subcategory.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></div>
                                                                        <td ng-if="subcategory.is_parent == 0 || subcategory.employee_id == employee_id">{{subcategory.name}}</div>
                                                                        <td><b>{{subcategory.Total}}</b></td>
                                                                        <td ng-if="subcategory.employee_id == employee_id"><span  ng-if="subcategory.New > 0">{{subcategory.New}} <a href="" style="padding-left:30px;" ng-click="subProjectCategoryReport(subcategory, 1, 0)">Show sub-category wise report</a></span><span ng-if="subcategory.New == 0">{{subcategory.New}}</span></td>
                                                                        <td ng-if="subcategory.employee_id != employee_id"><span  ng-if="subcategory.New > 0">{{subcategory.New}} <a style="padding-left:30px;" href=""  ng-click="subProjectCategoryReport(subcategory, 1, 1)">Show sub-category wise report</a></span><span ng-if="subcategory.New == 0">{{subcategory.New}}</span></td>
                                                                        <td ng-if="subcategory.employee_id == employee_id"><span  ng-if="subcategory.Hot > 0">{{subcategory.Hot}} <a style="padding-left:30px;" href=""  ng-click="subProjectCategoryReport(subcategory, 2, 0)">Show sub-category wise report</a></span><span ng-if="subcategory.Hot == 0">{{subcategory.Hot}}</span></td>
                                                                        <td ng-if="subcategory.employee_id != employee_id"><span  ng-if="subcategory.Hot > 0">{{subcategory.Hot}} <a href=""  style="padding-left:30px;" ng-click="subProjectCategoryReport(subcategory, 2, 1)">Show sub-category wise report</a></span><span ng-if="subcategory.Hot == 0">{{subcategory.Hot}}</span></td>
                                                                        <td ng-if="subcategory.employee_id == employee_id"><span  ng-if="subcategory.Warm > 0">{{subcategory.Warm}} <a href="" style="padding-left:30px;" ng-click="subProjectCategoryReport(subcategory, 3, 0)">Show sub-category wise report</a></span><span ng-if="subcategory.Warm == 0">{{subcategory.Warm}}</span></td>
                                                                        <td ng-if="subcategory.employee_id != employee_id"><span  ng-if="subcategory.Warm > 0">{{subcategory.Warm}} <a href="" style="padding-left:30px;" ng-click="subProjectCategoryReport(subcategory, 3, 1)">Show sub-category wise report</a></span><span ng-if="subcategory.Warm == 0">{{subcategory.Warm}}</span></td>
                                                                        <td ng-if="subcategory.employee_id == employee_id"><span  ng-if="subcategory.Cold > 0">{{subcategory.Cold}} <a href="" style="padding-left:30px;" ng-click="subProjectCategoryReport(subcategory, 4, 0)">Show sub-category wise report</a></span><span ng-if="subcategory.Cold == 0">{{subcategory.Cold}}</span></td>
                                                                        <td ng-if="subcategory.employee_id != employee_id"><span  ng-if="subcategory.Cold > 0">{{subcategory.Cold}} <a href="" style="padding-left:30px;" ng-click="subProjectCategoryReport(subcategory, 4, 1)">Show sub-category wise report</a></span><span ng-if="subcategory.Cold == 0">{{subcategory.Cold}}</span></td>

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
                            <!--                            <div class="widget" ng-if="subteam_category_report.length > '0'">                                
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
                                                        </div>-->
                        </div>
                    </tab>
                    <tab heading="Source" active="source_div" ng-click="reportHeading('Team-wise Project Source Report')">
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
                                                <th>Total</th>
                                                <th>Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="sources in source_wise_report track by $index">
                                                <td ng-if="sources.is_parent == 1"><a href=""  ng-click="teamProjectSourceEmpReport(sources); teamsourceEmployees(sources)">{{sources.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></td>
                                                <td ng-if="sources.is_parent == 0">{{sources.name}}</td>
                                                <td>{{sources.count}}</td>
                                                <td>{{((sources.count / SourceTotal * 100).toFixed(2))}}</td>
                                            </tr>
                                            <tr>
                                                <td align="center"><b>Total</b></td>
                                                <td>{{SourceTotal}}</td>
                                                <td>{{((SourceTotal / SourceTotal * 100).toFixed(2))}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12" ng-if="empListTab1.length > 0" style="margin-left:-1%; width: 102%;">
                                    <tabset class="col-md-12">
                                        <tab ng-repeat="emp in empListTab1"  id="{{'tab1' + emp.employee_id}}" ng-click="teamProjectSourceEmpReport(emp);" heading="{{emp.name}}"  >
                                            <div id="category-report">
                                                <div class="widget">    
                                                    <div class="widget" >  

                                                        <p style="margin-left: 90%;" ng-if="empId1 != '1'"  ng-click="closeProjectSourceTab(empId1)">
                                                            <button type="button" class="btn btn-default btn-sm">
                                                                <span class="glyphicon glyphicon-remove"></span> Close 
                                                            </button>
                                                        </p>
                                                        <table class="table table-hover table-striped table-bordered" at-config="config">
                                                            <thead class="bord-bot">
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <th>Total</th>
                                                                    <th>Percent</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr ng-repeat="mysources in subsource_wise_report" ng-if="subsource_wise_report.length > 0">
                                                                    <td ng-if="mysources.is_parent == 1 && mysources.employee_id != employee_id"><a href="" ng-if="mysources.is_parent == 1 && mysources.employee_id != employee_id" ng-click="teamProjectSourceEmpReport(mysources); teamsourceEmployees(mysources);">{{mysources.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></td>
                                                                    <td ng-if="mysources.is_parent == 0 || mysources.employee_id == employee_id">{{mysources.name}}</td>
                                                                    <td ng-if="mysources.count > 0">{{mysources.count}} <a href="" style="padding-left:30px;"  ng-click="projectSourceReport(mysources)">Show source report</a></td>
                                                                    <td ng-if="mysources.count == 0">{{mysources.count}}</td>
                                                                    <td ng-if="mysources.count > 0"><b>{{((mysources.count / SubsourceTotal) * 100).toFixed(2)}}</b></td>
                                                                    <td ng-if="mysources.count == 0"><b>0.00</b></td>
                                                                </tr> 
                                                                <tr ng-if="source_wise_report.length > 0">
                                                                    <td align="center"><b>Total</b></td>
                                                                    <td><b>{{SubsourceTotal}}</b></td>
                                                                    <td ng-if="SubsourceTotal > '0'"><b>{{((SubsourceTotal / SubsourceTotal) * 100).toFixed(2)}}</b></td>
                                                                    <td ng-if="SubsourceTotal == '0'"><b>0.00</b></td>
                                                                </tr>
                                                                <tr ng-if="source_wise_report.length == 0">
                                                                    <td colspan="3" align="center">
                                                                        <h4>No Record Found</h4>
                                                                    </td>
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
                                                                    <td>{{mysources.sales_source_name}}</td>
                                                                    <td ng-if="mysources.cnt > 0">{{mysources.cnt}}<a href="" style="padding-left:30px;" ng-if="mysources.substatus == 1" ng-click="projectSubSourceReport(mysources)">Show sub-source report</a></td>
                                                                    <td ng-if="mysources.cnt == 0">{{mysources.cnt}}</td>
                                                                    <td ng-if="mysources.cnt > 0"><b>{{((mysources.cnt / sourceTotal) * 100).toFixed(2)}}</b></td>
                                                                    <td ng-if="mysources.cnt == 0"><b>0.00</b></td>
                                                                </tr> 
                                                                <tr ng-if="subteam_source_report.length > 0">
                                                                    <td align="center"><b>Total</b></td>
                                                                    <td><b>{{sourceTotal}}</b></td>
                                                                    <td ng-if="sourceTotal > '0'"><b>{{((sourceTotal / sourceTotal) * 100).toFixed(2)}}</b></td>
                                                                    <td ng-if="sourceTotal == '0'"><b>0.00</b></td>
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
                                                                <canvas id="doughnut" class="chart chart-doughnut" chart-data="subsourcedata" chart-options="team_sourceoptions" chart-labels="sourcelabels" chart-colors="subsourcecolors"></canvas>
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
                                                                    <td ng-if="subsources.cnt > 0"><b>{{((subsources.cnt / subsourceTotal) * 100).toFixed(2)}}</b></td>
                                                                    <td ng-if="subsources.cnt == 0"><b>0.00</b></td>
                                                                </tr> 
                                                                <tr>
                                                                    <td align="center"><b>Total</b></td>
                                                                    <td><b>{{subsourceTotal}}</b></td>
                                                                    <td ng-if="subsourceTotal > '0'"><b>{{((subsourceTotal / subsourceTotal) * 100).toFixed(2)}}</b></td>
                                                                    <td ng-if="subsourceTotal == '0'"><b>0.00</b></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="row"  align="center" ng-if="sub_source.length > 0">
                                                        <div class="col-md-12 col-xs-12"  align="center" >
                                                            <div style="margin:0 auto;padding: 40px; width: 30%">
                                                                <canvas id="doughnut" class="chart chart-doughnut" chart-data="sub_sourcedata" chart-options="sub_sourceoptions" chart-labels="sub_sourcelabels" chart-colors="sub_sourcecolors"></canvas>
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
                    </tab>
                    <tab heading="Status" active="status_div" ng-click="reportHeading('Team-wise Project Status Report')">
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
                                                <th>Preserved</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="status in status_wise_report">
                                                <td ng-if="status.is_parent == 1"><a href=""  ng-click="teamProjectStatusEmpReport(status); teamStatusEmployees(status);">{{status.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></div>
                                                <td ng-if="status.is_parent == 0">{{status.name}}</div> 
                                                <td><b>{{status.total}}</b></td>
                                                <td>{{status.new}}</td>
                                                <td>{{status.open}}</td>
                                                <td>{{status.booked}}</td>
                                                <td>{{status.lost}}</td>
                                                <td>{{status.preserved}}</td>
                                            </tr>   
                                            <tr>
                                                <td><b>Total</b></td>
                                                <td><b>{{Statustotal}}</b></td>
                                                <td><b>{{totalStatusNew}}</b></td>
                                                <td><b>{{totalOpen}}</b></td>
                                                <td><b>{{totalBooked}}</b></td>
                                                <td><b>{{totalLost}}</b></td>
                                                <td><b>{{totalPreserved}}</b></td>
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
                                                <td ng-if="totalPreserved > '0'"><b>{{((totalPreserved / total) * 100).toFixed(2)}}</b></td>
                                                <td ng-if="totalPreserved == '0'"><b>0.00</b></td>
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
                            <div class="widget"  ng-if="sub_status_wise_report.length > 0">
                                <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12" style="margin-left:-1%; width: 102%;">
                                    <tabset class="col-md-12">
                                        <tab ng-repeat="emp in empListTab2"  id="{{'tab2' + emp.employee_id}}" ng-click="teamProjectStatusEmpReport(emp);"   id="{{emp.employee_id}}" heading="{{emp.name}}"  >
                                            <div id="category-report">
                                                <div class="widget" ng-if="sub_status_wise_report.length > 0">
                                                    <div class="widget-body table-responsive">
                                                        <p style="margin-left: 90%;" ng-if="empId != '1'"  ng-click="closeProjectStatusTab(empId)">
                                                            <button type="button" class="btn btn-default btn-sm">
                                                                <span class="glyphicon glyphicon-remove"></span> Close 
                                                            </button>
                                                        </p>
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
                                                                <tr ng-repeat="subStatus in sub_status_wise_report">
                                                                    <td ng-if="subStatus.is_parent == 1 && subStatus.employee_id != employee_id"><a href=""  ng-click="teamProjectStatusEmpReport(subStatus); teamStatusEmployees(subStatus);">{{subStatus.name}}<i class="icon" style="float: right" ng-class="isSubEmployeeShown ? 'ion-chevron-up' : 'ion-chevron-down'"></i></a></div>
                                                                    <td ng-if="subStatus.is_parent == 0 || subStatus.employee_id == employee_id">{{subStatus.name}}</div> 
                                                                    <td><b>{{subStatus.Total}}</b></td>
                                                                    <td ng-if="subStatus.employee_id == employee_id"><span  ng-if="subStatus.new > 0">{{subStatus.new}} <a href="" style="padding-left:30px;" ng-click="subProjectStatusReport(subStatus, 1, 0)">Show sub-status wise report</a></span><span ng-if="subStatus.new == 0">{{subStatus.new}}</span></td>
                                                                    <td ng-if="subStatus.employee_id != employee_id"><span  ng-if="subStatus.new > 0">{{subStatus.new}} <a style="padding-left:30px;" href=""  ng-click="subProjectStatusReport(subStatus, 1, 1)">Show sub-status wise report</a></span><span ng-if="subStatus.new == 0">{{subStatus.new}}</span></td>
                                                                    <td ng-if="subStatus.employee_id == employee_id"><span  ng-if="subStatus.open > 0">{{subStatus.open}} <a href="" style="padding-left:30px;" ng-click="subProjectStatusReport(subStatus, 2, 0)">Show sub-status wise report</a></span><span ng-if="subStatus.open == 0">{{subStatus.open}}</span></td>
                                                                    <td ng-if="subStatus.employee_id != employee_id"><span  ng-if="subStatus.open > 0">{{subStatus.open}} <a style="padding-left:30px;" href=""  ng-click="subProjectStatusReport(subStatus, 2, 1)">Show sub-status wise report</a></span><span ng-if="subStatus.open == 0">{{subStatus.open}}</span></td>
                                                                    <td ng-if="subStatus.employee_id == employee_id"><span  ng-if="subStatus.booked > 0">{{subStatus.booked}} <a href="" style="padding-left:30px;" ng-click="subProjectStatusReport(subStatus, 3, 0)">Show sub-status wise report</a></span><span ng-if="subStatus.booked == 0">{{subStatus.booked}}</span></td>
                                                                    <td ng-if="subStatus.employee_id != employee_id"><span  ng-if="subStatus.booked > 0">{{subStatus.booked}} <a style="padding-left:30px;" href=""  ng-click="subProjectStatusReport(subStatus, 3, 1)">Show sub-status wise report</a></span><span ng-if="subStatus.booked == 0">{{subStatus.booked}}</span></td>
                                                                    <td ng-if="subStatus.employee_id == employee_id"><span  ng-if="subStatus.lost > 0">{{subStatus.lost}} <a href="" style="padding-left:30px;" ng-click="subProjectStatusReport(subStatus, 4, 0)">Show sub-status wise report</a></span><span ng-if="subStatus.lost == 0">{{subStatus.lost}}</span></td>
                                                                    <td ng-if="subStatus.employee_id != employee_id"><span  ng-if="subStatus.lost > 0">{{subStatus.lost}} <a style="padding-left:30px;" href=""  ng-click="subProjectStatusReport(subStatus, 4, 1)">Show sub-status wise report</a></span><span ng-if="subStatus.lost == 0">{{subStatus.lost}}</span></td>
                                                                    <td ng-if="subStatus.employee_id == employee_id"><span  ng-if="subStatus.preserved > 0">{{subStatus.preserved}} <a href="" style="padding-left:30px;" ng-click="subProjectStatusReport(subStatus, 5, 0)">Show sub-status wise report</a></span><span ng-if="subStatus.preserved == 0">{{subStatus.preserved}}</span></td>
                                                                    <td ng-if="subStatus.employee_id != employee_id"><span  ng-if="subStatus.preserved > 0">{{subStatus.preserved}} <a style="padding-left:30px;" href=""  ng-click="subProjectStatusReport(subStatus, 5, 1)">Show sub-status wise report</a></span><span ng-if="subStatus.preserved == 0">{{subStatus.preserved}}</span></td>
                                                                </tr>   
                                                                <tr>
                                                                    <td><b>Total</b></td>
                                                                    <td><b>{{subStatusTotal}}</b></td>
                                                                    <td><b>{{subTotalStatusNew}}</b></td>
                                                                    <td><b>{{subTotalOpen}}</b></td>
                                                                    <td><b>{{subTotalBooked}}</b></td>
                                                                    <td><b>{{subTotalLost}}</b></td>
                                                                    <td><b>{{ subTotalPreserved}}</b></td>
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
                                                                    <td ng-if="subTotalPreserved > '0'"><b>{{((subTotalPreserved / subStatusTotal) * 100).toFixed(2)}}</b></td>
                                                                    <td ng-if="subTotalPreserved == '0'"><b>0.00</b></td>
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
                                                                <tr ng-repeat="substatus in sub_status_report" ng-if="sub_status_report.length > 0">
                                                                    <td>{{substatus.enquiry_sales_substatus}}</td>
                                                                    <td>{{substatus.cnt}}</td>
                                                                    <td>{{((substatus.cnt / subStatus_Total) * 100).toFixed(2)}}</td>
                                                                </tr>   
                                                                <tr ng-if="sub_status_report.length > 0">
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
                                                    </div>
                                                    <div class="row"  align="center" ng-if="sub_status_report.length > 0" >
                                                        <div class="col-md-12 col-xs-12"  align="center" >
                                                            <div style="margin:0 auto;padding: 40px; width: 30%">
                                                                <canvas id="doughnut" class="chart chart-doughnut" chart-data="substatus_data" chart-options="substatus_options" chart-labels="substatus_labels" chart-colors="substatus_colors"></canvas>
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
                            <!--                            <div class="widget" ng-if="sub_status_wise_report.length > '0'">                                
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
                                                                            <td><b>{{subStatus.total}}</b></td>
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
                                                        </div>-->
                        </div>
                    </tab>
                </tabset>
            </div>
        </div>
    </div>
</div>