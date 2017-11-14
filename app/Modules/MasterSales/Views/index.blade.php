<style>
    .btn-round{
        border-radius: 50%;
        height: 40px;
        width: 40px;
        line-height: 28px;
        padding-left: 13px;
        outline: none !important;
    }
    @media (min-width:768px){
        .modal-dialog {
            width: 700px !important;
        }
    }
    .errMsg{
        color:red;
    }    
    .demo-tab .tab-content{
        display: inline-block !important;
        -webkit-box-shadow: none;
        -moz-box-shadow: 1px 0 10px 1px rgba(0, 0, 0, .3);
        box-shadow: none;
        border: 1px solid #e5e5e5;
    }
    .demo-tab .nav-tabs{
        display: inline-flex;
    }
    .custAdress{
        font-size:20px;
    }
    .companyField{
        padding: 0px 0px;
        margin: 0px 0px 5px;
        max-height: 100px;
        overflow-y: scroll;
        position: absolute;
        width: 92%;
        z-index: 999;
        border:1px solid #b1acac;
        border-top: none;
    }
    .companyField li{
        padding: 10px;
        color: #5a5a5a;
        list-style:none;
        background:#f8f8f8; 
        cursor: pointer;
    }
    .companyField :hover{
        background: #ccc;
        color:#fff;
    }
    .toggleClassActive {font-size:40px !important;cursor:pointer;color: #5cb85c !important;vertical-align: middle;margin-left: 15px;}
    .toggleClassInactive {font-size:40px !important;cursor:pointer;color: #d9534f !important;vertical-align: middle;margin-left: 15px;}
</style>
<div class="row"> 
    <div class="widget flat radius-bordered ">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="customerController" ng-init="manageForm([[ !empty($editCustomerId) ?  $editCustomerId : '0' ]],[[ !empty($editEnquiryId) ?  $editEnquiryId : '0' ]],0);manageQuickEnquiry()">
            <!--<h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{pageHeading}}</h5>-->
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">{{pageHeading}}</span>
            </div>
            <div class="widget-body  col-lg-12 col-sm-12 col-xs-12" style="box-shadow:none;">
                <div id="customer-form">                    
                    <input type="hidden" ng-model="customerData.csrfToken" name="csrftoken" id="csrftoken" ng-init="customerData.csrfToken = '[[ csrf_token() ]]'">
                    <input type="hidden" ng-model="searchData.customerId" name="customerId" id="custId" value="{{searchData.customerId}}">
                    <div class="row col-lg-12 col-sm-12 col-xs-12" >
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="form-title">
                                Customer Details  
                            </div>
                            <div class="row">
                                <div class="col-sm-1 col-xs-1">
                                    <div class="form-group" >
                                        <label for="">Country Code</label>
                                        <span class="input-icon icon-right countryClass" >
                                            <input type="text" disabled ng-model="searchData.mobile_calling_code" name="mobile_calling_code"  id="mobile_calling_code" class="form-control">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Mobile Number</label>
                                        <span class="input-icon icon-right">                                    
                                            <input type="text" class="form-control" ng-disabled="disableText" ng-model="searchData.searchWithMobile" get-customer-details-directive minlength="10" maxlength="10" id="searchWithMobile"  ng-pattern="/^[789][0-9]{9,10}$/" name="searchWithMobile" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" ng-model-options="{allowInvalid: true, debounce: 100}" ng-change="checkValue(customerData.searchWithMobile)" value="{{ searchData.searchWithMobile}}">
                                            <i class="glyphicon glyphicon-phone"></i>
                                            <div ng-messages="searchData.searchWithMobile.$error" class="help-block">
                                                <div ng-message="minlength">Invalid mobile no.</div>
                                                <div ng-message="customerInputs">Mobile number does not exist!</div>
                                                <div ng-message="customerPattern">Mobile number wrong!</div>
                                            </div>                                            
                                            <div ng-show="errMobile" class="sp-err">Invalid mobile number!</div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Email ID</label>
                                        <span class="input-icon icon-right">
                                            <input type="email" class="form-control" ng-disabled="disableText || emailField" get-customer-details-directive ng-model="searchData.searchWithEmail" name="searchWithEmail" ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/" ng-model-options="{allowInvalid: true, debounce: 500}" ng-change="checkValue(customerData.searchWithEmail)">
                                            <i class="glyphicon glyphicon-envelope"></i>
                                        </span>
                                    </div>
                                    <input type="hidden" ng-model="customer_id" name="customer_id">
                                </div>                                
                            </div>
                        </div>
                        <br><br>
                    </div>
                    <tabset ng-if="showDivCustomer" class="demo-tab row showDivCustomer">
                        <tab heading="Customer Information" id="custDiv">
                            <div data-ng-include=" '/MasterSales/createCustomer'"></div>
                        </tab>
                        <tab heading="Enquiry Information" active="enquiry_div" id="enquiryDiv" style="display: none;">
                            <div data-ng-include=" '/MasterSales/createEnquiry'"></div>
                        </tab>
                    </tabset>
                </div>                
                <div class="col-lg-12 col-sm-12 col-xs-12 showDiv" ng-if="showDiv && !enquiryList">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="form-title">
                            Previous Open Enquiries
                        </div>
                    </div>
                    <div class="widget-body table-responsive" style="box-shadow:none;">
                        <div class="row" >
                        <div class="col-xs-12 col-md-12">
                            <div class="widget">
                                <div  class="widget-body">
                                    <table class="table table-hover table-striped table-bordered" at-config="config">
                                        <thead class="bord-bot">
                                            <tr>
                                                <th style="width:5%">
                                                    Sr. No.
                                                </th>
                                                <th style="width: 30%">
                                                    Customer 
                                                </th>
                                                <th style="width: 30%">
                                                    Enquiry
                                                </th>
                                                <th style="width: 30%">
                                                    History 
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr role="row" dir-paginate="enquiry in listsIndex.CustomerEnquiryDetails | filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
                                                <td>{{ $index + 1}}</td>
                                                <td> 
                                                    {{ enquiry.customer_fname}} {{ enquiry.customer_lname}}
                                                    <div ng-if="enquiry.mobile_number != ''" ng-init="mobile_number = enquiry.mobile_number.split(',')" class="ng-scope">
                                                        <span ng-repeat="mobile_obj in mobile_number| limitTo:2" class="ng-binding ng-scope">
                                                            <a style="cursor: pointer;" class="Linkhref ng-scope" ng-if="mobile_obj != null" ng-click="cloudCallingLog(1,<?php echo Auth::guard('admin')->user()->id; ?>,{{ enquiry.id}},'{{enquiry.customer_id}}','{{$index}}')">
                                                                <img src="/images/call.png" title="Click on call icon to make a call" class="hi-icon-effect-8 psdn_session" style="height: 17px;width: 17px;">
                                                            </a>
                                                            {{mobile_obj}}
                                                        </span>
                                                    </div>
                                                    <p ng-if="enquiry.email_id != '' && enquiry.email_id !='null' ">{{enquiry.email_id}}</p>
                                                    <hr class="enq-hr-line">
                                                    <div>
                                                        <a target="_blank" href="[[ config('global.backendUrl') ]]#/sales/update/cid/{{ enquiry.customer_id}}" class="ng-binding"><i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;Customer Id ({{ enquiry.customer_id}})</a>
                                                    </div>
                                                    <hr class="enq-hr-line">
                                                    <p>Company :{{enquiry.company_name}}</p>
                                                    <p>Source  : {{enquiry.sales_source_name}}</p>
                                                </td>
                                                <td>
                                                    Status : {{enquiry.sales_status}}
                                                     <hr class="enq-hr-line">
                                                    Category :  {{enquiry.enquiry_category}}
                                                     <hr class="enq-hr-line">
<!--                                                    Project : {{enquiry.project_name}} 
                                                     <hr class="enq-hr-line">-->
                                                    <div>
                                                        <span style="text-align: center;"><a target="_blank" href="[[ config('global.backendUrl') ]]#/sales/update/cid/{{ enquiry.customer_id }}/eid/{{ enquiry.id}}" class="ng-binding"><i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;Enquiry Id ({{ enquiry.id}})</a></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <b> Enquiry Owner  :</b> {{enquiry.owner_fname}} {{enquiry.owner_lname}}
                                                    <hr class="enq-hr-line">
<!--                                                    <b>Test Drive : </b>{{enquiry.testdrive_list}}
                                                    <hr class="enq-hr-line">-->
                                                    <b>Last followup :</b> {{enquiry.last_followup_date}}
                                                    <br/>
                                                    <b>By followup : {{enquiry.owner_fname}} {{enquiry.owner_lname}} : </b>{{enquiry.remarks}} 
                                                    <hr class="enq-hr-line">
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#historyDataModal" ng-click="listRecords({{ enquiry.id}},{{initmoduelswisehisory}},1)">View History</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>                                    
                                </div>
                                <!-- Modal -->
                                <div class="modal fade modal-primary" id="historyDataModal" role="dialog" tabindex='-1' >
                                    <div class="modal-dialog modal-lg" >
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header navbar-inner">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title" align="center">Enquiry History</h4>
                                            </div>
                                            <div class="modal-body"> 
                                                <div>
                            <label>
                                <input type="checkbox" name="chk_enquiry_history_list" ng-click="getModulesWiseHist_list(history_enquiryId, 1, 'listFlag')" checked  id="chk_enquiry_history_list">
                                <span class="text">All</span>
                            </label>
                            &nbsp;&nbsp;
                            <label>
                                <input type="checkbox"  ng-click="getModulesWiseHist_list(history_enquiryId, 0, 'listFlag')" data-id="1" checked class="chk_followup_history_all_list" id="chk_presales_list">
                                <span class="text">Pre Sales</span>
                            </label>
                            &nbsp;&nbsp;
                            <label>
                                <input type="checkbox"  ng-click="getModulesWiseHist_list(history_enquiryId, 0, 'listFlag')" data-id="2" checked  class="chk_followup_history_all_list" id="chk_Customer_Care_list">
                                <span class="text">Customer Care</span>
                            </label>
                            <hr class="enq-hr-line">           
                            1) <span>PS = Pre Sales</span> &nbsp;&nbsp;2) <span>CC = Customer Care</span>            
                            <hr class="enq-hr-line">    
                        </div>

                        <div style="height: auto;max-height: 605px;margin-top: 0px; overflow-x: hidden;overflow-y: scroll;">
                            {{historyList}}
                            <table class="table table-hover table-striped table-bordered" at-config="config" >
                                <thead class="bord-bot">
                                    <tr>
                                        <th class="enq-table-th" style="width:3%">SR</th>
                                        <th class="enq-table-th" style="width: 13%;">
                                            Followup By 
                                        </th>
                                        <th class="enq-table-th" style="width: 13%">
                                            Last  
                                        </th>
                                        <th class="enq-table-th" style="width: 13%">
                                            Next
                                        </th>
                                        <th class="enq-table-th" style="width: 20%">
                                            Status
                                        </th>
                                        <th class="enq-table-th" style="width: 38%">
                                            Remarks
                                        </th>
                                    </tr>
                                </thead>
                                
                            </table>
                        </div>
                                            </div>
                                            
                                            
                                            
                                            
<!--                                            <div class="modal-body">
                                                <table class="table table-hover table-striped table-bordered" at-config="config">
                                                    <thead class="bord-bot">
                                                        <tr>
                                                            <th style="width:5%">Sr. No.</th>
                                                            <th style="width: 10%">
                                                                <a href="javascript:void(0);" ng-click="orderByField = 'first_name'; reverseSort = !reverseSort">FollowUp By 
                                                                    <span ng-show="orderByField == 'first_name'">
                                                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                                                    </span>
                                                                </a>
                                                            </th>
                                                            <th style="width: 10%">
                                                                <a href="javascript:void(0);" ng-click="orderByField = 'designation'; reverseSort = !reverseSort">Last FollowUp Date & Time 
                                                                    <span ng-show="orderByField == 'designation'">
                                                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                                                    </span>
                                                                </a>
                                                            </th>
                                                            <th style="width: 10%">
                                                                <a href="javascript:void(0);" ng-click="orderByField = 'reporting_to_id'; reverseSort = !reverseSort">Remark
                                                                    <span ng-show="orderByField == 'reporting_to_id'">
                                                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                                                    </span>
                                                                </a>
                                                            </th>
                                                            <th style="width: 10%">
                                                                <a href="javascript:void(0);" ng-click="orderByField = 'team_lead_id'; reverseSort = !reverseSort">Next FollowUp Date & Time
                                                                    <span ng-show="orderByField == 'team_lead_id'">
                                                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                                                    </span>
                                                                </a>
                                                            </th>
                                                            <th style="width: 10%">
                                                                <a href="javascript:void(0);" ng-click="orderByField = 'department_name'; reverseSort = !reverseSort">Enquiry Status
                                                                    <span ng-show="orderByField == 'department_name'">
                                                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                                                    </span>
                                                                </a>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr role="row" dir-paginate="history in historyList | filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
                                                            <td>{{ $index + 1}}</td>
                                                            <td>
                                                                {{ history.first_name}} {{ history.last_name}}
                                                            </td>
                                                            <td>
                                                                {{ history.last_followup_date}}
                                                            </td>
                                                            <td>
                                                                {{history.remarks}}
                                                            </td>
                                                            <td>
                                                                {{ history.next_followup_date}} at {{ history.next_followup_time}}
                                                            </td>
                                                            <td>
                                                                {{history.sales_status}}
                                                            </td>
                                                        </tr>
                                                        <tr ng-if="!historyList.length" align="center"><td colspan="6"> Records Not Found</td>

                                                        </tr>

                                                    </tbody>
                                                </table>                                                
                                            </div>-->
                                            <div class="modal-footer" align="center">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<!--                        <div class="DTTTFooter">
                            <div class="col-sm-6">
                                <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{noOfRows}}</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                                    <dir-pagination-controls class="pagination" on-page-change="pageChangeHandler(newPageNumber)" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                                </div>
                            </div>
                        </div>-->
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" ng-if="enqType == 0"><br>
                            <div class="form-group" align="center">
                                <button type="submit" class="btn btn-primary" ng-click="createEnquiry()">Create New Enquiry</button>
                                <button type="submit" class="btn btn-primary" ng-click="newEnquiryCreate()">Create Customer And New Enquiry</button>
                            </div> 
                        </div> 
                    </div>
                </div>            
            </div>
            <!--  Modal   --> 
            <div class="modal fade modal-primary" id="contactDataModal" role="dialog" tabindex='-1' >
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content" style="width: 115%;">                        
                        <form novalidate name="modalForm" ng-submit="modalForm.$valid && addRow(contactData)">
                            <div class="modal-header">
                                <button type="button" class="close" id="closeModal" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title" align="center">Contact Details</h4>
                            </div>
                            <!--<input type="hidden" ng-model="contactData.index" name="index" value="{{contactData.index}}">-->
                            <div class="modal-body">
                                <div class="col-lg-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Number Type</label>
                                                <span class="input-icon icon-right">
                                                    <select ng-model="contactData.mobile_number_lable" name="mobile_number_lable" class="form-control">
                                                        <option value="1">Personal</option>
                                                        <option value="2">Office</option>
                                                    </select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-xs-2">
                                            <div class="form-group" >
                                                <label for="">Country Code<span class="sp-err">*</span></label>
                                                <span class="input-icon icon-right"> 
                                                    <input type="text" disabled ng-model="contactData.mobile_calling_code"  name="mobile_calling_code"  id="mobile_calling_code1" class="form-control"  required>
                                                </span>
                                                <div ng-show="modalSbtBtn && modalForm.mobile_calling_code.$invalid" ng-messages="modalForm.mobile_calling_code.$error" class="help-block">
                                                    <div ng-message="required">This field is required</div> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-xs-4">
                                            <div class="form-group">
                                                <label for="">Mobile Number<span class="sp-err">*</span></label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contactData.mobile_number" name="mobile_number"  id="mobile_number" class="form-control" maxlength="10" ng-change="checkMobileValue(contactData.mobile_calling_code)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  check-mobile-exist ng-model-options="{ allowInvalid: true, debounce: 300 }" required>
                                                    <i class="glyphicon glyphicon-phone"></i>
                                                </span>
                                                <div ng-show="modalSbtBtn && modalForm.mobile_number.$invalid" ng-messages="modalForm.mobile_number.$error" class="help-block">
                                                    <div ng-message="required">This field is required</div> 
                                                    <div ng-message="uniqueMobile">Mobile number already exist</div>
                                                    <!--<div ng-message="pattern">Invalid mobile number!</div>-->
                                                </div>
                                                <div ng-show="errMobileNo" class="sp-err">Invalid mobile number!</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Landline Type</label>
                                                <span class="input-icon icon-right">
                                                    <select ng-model="contactData.landline_lable" name="landline_lable" class="form-control">
                                                        <option value="1">Personal</option>
                                                        <option value="2">Office</option>
                                                    </select>
                                                    <i class="fa fa-sort-desc"></i>                                                    
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-xs-2">
                                            <div class="form-group" >
                                                <label for="">Country Code</label>
                                                <span class="input-icon icon-right"> 
                                                    <input type="text" disabled ng-model="contactData.landline_calling_code"  name="landline_calling_code"  id="landline_calling_code" class="form-control">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-xs-4">
                                            <div class="form-group">
                                                <label for="">Landline Number</label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contactData.landline_number" name="landline_number" id="landline_number" minlength="6" maxlength="10" class="form-control" ng-model-options="{ updateOn: 'blur' }" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                                    <i class="glyphicon glyphicon-phone"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Email Type</label>
                                                <span class="input-icon icon-right">
                                                    <select ng-model="contactData.email_id_lable" name="email_id_lable" class="form-control">
                                                        <option value="1">Personal</option>
                                                        <option value="2">Office</option>
                                                    </select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Email ID</label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contactData.email_id" name="email_id" class="form-control" maxlength="50" check-email-exist ng-pattern="/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/" ng-model-options="{ allowInvalid: true, debounce: 500 }">
                                                    <i class="glyphicon glyphicon-envelope"></i>
                                                </span>
                                                <div ng-show="modalSbtBtn" ng-messages="modalForm.email_id.$error" class="help-block">
                                                    <div ng-message="pattern">Please enter valid email id</div>
                                                    <div ng-message="uniqueEmail" ng-if="contactData.email_id">Email Id already exist</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div><strong>Customer Address</strong> 
                                    <span class="custAdress" ng-show="showaddress" ng-click="showAddress()"> <i class="fa fa-plus-square fa-2" aria-hidden="true"></i></span>&nbsp;
                                    <span ng-show="hideaddress" ng-click="hideAddress()" class="custAdress"><i class="fa fa-minus-square fa-2" aria-hidden="true"></i></span>
                                    <div class="col-lg-12 col-sm-12 col-xs-12" ng-show="customerAddress" ng-controller="currentCountryListCtrl">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Address</label>		
                                                <span class="input-icon icon-right">
                                                    <select ng-model="contactData.address_type" name="address_type" class="form-control">
                                                        <option value="1">Personal</option>
                                                        <option value="2">Office</option>
                                                    </select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">House Number</label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contactData.house_number" maxlength="10" name="house_number" class="form-control date-picker">
                                                    <i class="fa fa-home"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Building House Name</label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contactData.building_house_name" maxlength="20" name="building_house_name" class="form-control">
                                                    <i class="fa fa-building-o"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <label for="">Wing Name</label>
                                                    <span class="input-icon icon-right">
                                                        <input type="text" ng-model="contactData.wing_name" maxlength="20" name="wing_name" class="form-control">
                                                        <i class="fa fa-building-o"></i>
                                                    </span> 
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Area Name</label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contactData.area_name" maxlength="30" name="area_name" class="form-control date-picker">
                                                    <i class="fa fa-building-o"></i>
                                                </span>                                      
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">                                            
                                                <label for="">Lane Name</label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contactData.lane_name" maxlength="30"  name="lane_name" class="form-control date-picker">
                                                    <i class="fa fa-building-o"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Landmark</label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contactData.landmark" name="landmark" maxlength="30" class="form-control date-picker">
                                                    <i class="fa fa-building-o"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Pin Code</label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contactData.pin" name="pin" maxlength="6" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                                    <i class="fa fa-compass" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Country</label>
                                                <span class="input-icon icon-right">
                                                    <select ng-change="onCountryChange()" ng-model="contactData.country_id" name="country_id" id="current_country_id" class="form-control">
                                                        <option value="">Select Country</option>
                                                        <option ng-repeat="country in countryList" value="{{country.id}}" ng-selected="{{ country.id == contactData.country_id}}">{{country.name}}</option>
                                                    </select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">State</label>                                                
                                                <span class="input-icon icon-right">
                                                    <select ng-model="contactData.state_id" ng-change="onStateChange()" name="state_id" id="current_state_id" class="form-control">
                                                        <option value="">Select State</option>
                                                        <option ng-repeat="state in stateList" value="{{state.id}}" ng-selected="{{ state.id == contactData.state_id}}">{{state.name}}</option>
                                                    </select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">City</label>
                                                <span class="input-icon icon-right">
                                                    <select ng-model="contactData.city_id" name="city_id" class="form-control">
                                                        <option value="">Select City</option>
                                                        <option ng-repeat="city in cityList" value="{{city.id}}" ng-selected="{{ city.id == contactData.city_id}}">{{city.name}}</option>
                                                    </select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Google Map Link</label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contactData.google_map_link" name="google_map_link" class="form-control">
                                                    <i class="fa fa-compass" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="">Remarks</label>
                                                <span class="input-icon icon-right">
                                                    <textarea ng-model="contactData.other_lists" name="other_lists" class="form-control" maxlength="300"></textarea>
                                                    <i class="fa fa-building-o"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                
                                </div>   
                                </div>
                            </div>
                            <div class="modal-footer" align="center">
                                <button type="submit" class="btn btn-primary" id="subbtn" ng-click="modalSbtBtn = true">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Enquiry History Modal -->
            <!--<div data-ng-include=" '/MasterSales/enquiryHistory'"></div>-->
            <!--<div data-ng-include="'/MasterSales/todaysRemark'"></div>-->
        </div>
    </div>
</div>

<script>
   $(document).ready(function(){
       $("#closeModal").click(function(){
           $("#subbtn").trigger("click");
       });
   });
   $("#mobile_calling_code,#landline_calling_code,#mobile_calling_code1").intlTelInput();
</script>