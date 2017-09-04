<br/> {{list.email_id}}<style>
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
        margin: 0 30px;
    }
</style>
<div class="row"> 
    <div class="widget flat radius-bordered ">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="customerController" ng-init="manageForm([[ !empty($editCustomerId) ?  $editCustomerId : '0' ]],[[ !empty($editEnquiryId) ?  $editEnquiryId : '0' ]],1)">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>Quick Enquiry</h5>
            <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12" style="box-shadow:none;">
                <div id="customer-form">                    
                    <input type="hidden" ng-model="customerData.csrfToken" name="csrftoken" id="csrftoken" ng-init="customerData.csrfToken = '[[ csrf_token() ]]'">
                    <input type="hidden" ng-model="searchData.customerId" name="customerId" id="custId" value="{{searchData.customerId}}">
                    <div class="row col-lg-12 col-sm-12 col-xs-12">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="form-title">
                                Customer Details  
                            </div>
                            <div class="row">
                                <div class="col-sm-3 col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Mobile Number</label>
                                        <span class="input-icon icon-right">                                    
                                            <input type="text" class="form-control" ng-disabled="disableText"  ng-pattern="/^[789][0-9]{9,10}$/" ng-model="searchData.searchWithMobile" get-customer-details-directive minlength="10" maxlength="10" name="searchWithMobile" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" ng-model-options="{allowInvalid: true, debounce: 100}" ng-change="checkValue(customerData.searchWithMobile)" value="{{ searchData.searchWithMobile}}">
                                            <i class="glyphicon glyphicon-phone"></i>
                                            <div ng-show="sbtBtn" ng-messages="customerData.searchWithMobile.$error" class="help-block">
                                                <div ng-message="minlength">Invalid mobile no.</div>
                                                <div ng-message="customerInputs">Mobile number does not exist!</div>
                                            </div> 
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Email ID</label>
                                        <span class="input-icon icon-right">
                                            <input type="email" class="form-control" ng-disabled="disableText" get-customer-details-directive ng-model="searchData.searchWithEmail" name="searchWithEmail" ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/" ng-model-options="{allowInvalid: true, debounce: 500}" ng-change="checkValue(customerData.searchWithEmail)">
                                            <i class="glyphicon glyphicon-envelope"></i>
                                        </span>
                                    </div>
                                    <input type="hidden" ng-model="customer_id" name="customer_id">
                                </div>
                                <div class="col-sm-3 col-md-3 col-xs-12" ng-show="resetBtn">
                                    <div class="form-group"><label></label>
                                        <span class="input-icon icon-right">
                                            <button type="button" class="btn btn-primary" ng-click="resetForm()">Reset</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>
                    </div>
                    <tabset ng-if="showDivCustomer" class="demo-tab row">
<!--                        <tab heading="Customer Information" id="custDiv">
                            <div data-ng-include=" '/MasterSales/createCustomer'"></div>
                        </tab>-->
                        <tab heading="Enquiry Information" active="enquiry_div" id="enquiryDiv" style="display: none;">
                            <div data-ng-include=" '/MasterSales/createEnquiry'"></div>
                        </tab>
                    </tabset>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12" ng-if="showDiv && !enquiryList">
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
                                                    <p>{{enquiry.email_id}}</p>
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
                                                    Model : {{enquiry.model_name}} 
                                                     <hr class="enq-hr-line">
                                                    <div>
                                                        <span style="text-align: center;"><a target="_blank" href="[[ config('global.backendUrl') ]]#/sales/update/cid/{{ enquiry.customer_id }}/eid/{{ enquiry.id}}" class="ng-binding"><i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;Enquiry Id ({{ enquiry.id}})</a></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <b> Enquiry Owner  :</b> {{enquiry.owner_fname}} {{enquiry.owner_lname}}
                                                    <hr class="enq-hr-line">
<!--                                                    <b>Test Drive : </b>{{enquiry.testdrive_remark}}
                                                    <hr class="enq-hr-line">-->
                                                    <b>Last followup :</b> {{enquiry.last_followup_date}}
                                                    <br/>
                                                    <b>By followup : {{enquiry.owner_fname}} {{enquiry.owner_lname}} : </b>{{enquiry.remarks}} 
                                                    <hr class="enq-hr-line">
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#historyDataModal" ng-click="initHistoryDataModal({{ enquiry.id}})">View History</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="historyDataModal" role="dialog" tabindex='-1'>
                                    <div class="modal-dialog modal-lg">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header navbar-inner">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title" align="center">Enquiry History</h4>
                                            </div>
                                            <div class="modal-body">
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
                                            </div>
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
<!--                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><br>
                            <div class="form-group" align="center">
                                <button type="submit" class="btn btn-primary" ng-click="createEnquiry()">Insert New Enquiry</button>
                            </div> 
                        </div> -->
                    </div>
                </div>            
            </div>
        </div>
    </div>
</div>
