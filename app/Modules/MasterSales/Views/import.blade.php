<style>
    .errMsg{
        color:red;
    }
</style>
<form name="importForm" novalidate ng-submit="importForm.$valid && ImportEnquiryData(enquiryData.importfile)" ng-controller="enquiryController">
    <input type="hidden" ng-model="enquiryData.csrfToken" name="csrftoken" id="csrftoken" ng-init="importForm.csrfToken = '[[ csrf_token() ]]'" class="form-control">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Import Enquiry</span>
                <div style="margin-right:10px;" >
                    <a href="http://52.66.17.45/guideline.xls">&nbsp;Guideline File</a></div>
            </div>
            <div class="widget-body">
                <div id="importenquiry-form">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12"> 
                            <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!importForm.importfile.$dirty && importForm.importfile.$invalid)}">
                                <label for="">Import File<span class="sp-err">*</span></label>
                                <input type="file" ngf-select ng-model="enquiryData.importfile"  id="importfile" class="form-control" name="importfile" accept=".xls,.xlsx, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                                <span class="input-icon icon-right">
                                    <div ng-show="sbtBtn" ng-messages="importForm.importfile.$error" class="help-block">
                                        <div ng-message="required">Please select file in xls / xlsx format.</div>
                                    </div>
                                    <div ng-show="importfile_err" style="color: red;">{{importfile_err}}</div>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-xs-12" align="left">
                                    <button type="submit" class="btn btn-primary" ng-click="sbtBtn = true" ng-disabled="btnupload">Upload</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12"> 
                            <span><a class="sample-link" href="http://52.66.17.45/import_enquiries.xls"><i class="fa fa-external-link" aria-hidden="true"></i>Download Import Enquiries Sample</a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <span><a href="javascript:void(0)" data-toggle="modal" data-target="#historyDataModal" ng-click="ShowimportHistory()"><i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;Show Import History</a></span>
                            <br><br><br><span><strong> Note :</strong></span><br>
                            <span>1. You can upload enquiries in excel sheet upto 1000 enquiries in one attempt.</span><br>
                            <span>2. Don't change and delete any column name in excel sheet.</span><br>
                            <span>3. Date format must be in "dd-mm-yyyy" format.</span><br>
                            <span>4. In Excel sheet Date format should be in Text format.</span><br>
                            <span>5. Insert existing employee mobile number else enquiry will be insert in login account.</span><br>
                            <span>6. Vehicle Model name & customer source must be same as in LMS Auto.</span><br>
                            <span>7. In Excel sheet Enquiry Date,Title,First name or Last name,Mobile no1 or Email 1,Employee Mobile,Enquiry source column's are Mandatory .</span>
                        </div>
                    </div>
                </div>

                <div class="row" ng-show="showhisrtory">
                    <div class="col-md-6 col-sm-6 col-xs-12"> 
                        <table width="100%" border="0" class="items" cellspacing="5" cellpadding="5">
                            <tr>
                                <td>
                                    <div style="color:green">
                                        <p>Total imported enquiry :{{total}}</p>
                                        <p>successfully:{{inserted}} </p>
                                        Enquiry inserted in below accounts :
                                        <div ng-if="employeeundercount != ''" ng-repeat="belowemployee in employeeundercount">
                                            <br> 
                                            {{belowemployee}}                                        
                                        </div>
                                        <div ng-if="employeeundercount == ''">
                                            NA
                                        </div>
                                    </div>
                                    <div style="color:red">
                                        Invalid:{{invalidfilecount}}
                                    </div><br>
                                    <div>
                                        <span><a href="[[config('global.s3Path')]]/sales/invalidReport/{{invalidfileurl}}">Click here to view invalid records. </a></span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>           
                </div>   
            </div>
        </div>
    </div>

<!-- show history model-->
<div class="modal fade" id="historyDataModal" role="dialog" tabindex='-1'>
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header navbar-inner">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center">Show Import History</h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover scroll table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th class="enq-table-th" style="width:3%">SR</th>
                            <th class="enq-table-th" style="width: 13%;">
                                Employee Name
                            </th>
                            <th class="enq-table-th" style="width: 13%">
                                Import File
                            </th>
                            <th class="enq-table-th" style="width: 38%">
                                Import Status Report
                            </th>
                            <th class="enq-table-th" style="width: 20%">
                                Invalid File
                            </th>
                            <th class="enq-table-th" style="width: 15%">
                                Created 
                            </th>
                        </tr>
                    </thead>
                    <tbody class="items-wrap" ng-repeat="importhistory in showhistoryList" >
                        <tr role="row" >
                            <td style="width:4%">
                                {{ $index + 1}} 
                            </td>
                            <td style="width: 10%;">
                                {{importhistory.get_employee.first_name}} {{importhistory.get_employee.last_name}} 
                            </td>
                            <td style="width: 10%">
                                <a href="[[config('global.s3Path')]]/{{importhistory.import_file}}">Download File</a>  
                            </td>

                            <td style="width: 38%">
                                {{importhistory.report_status|removeHTMLTags }} 
                            </td>
                            <td style="width: 20%">
                                <a href="[[config('global.s3Path')]]/{{importhistory.error_report_file}}" >Download File</a>   
                            </td>
                            <td style="width: 10%">
                                {{importhistory.created_datetime}}  
                            </td>
                        </tr>
                        <tr ng-if="!showhistoryList.length" align="center"><td colspan="6"> Records Not Found</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" align="center"></div>
        </div>
    </div>
</div>
</form>