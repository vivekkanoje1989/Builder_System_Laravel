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
        margin: 0 30px;
    }
    
</style>
<div class="row"> 
    <div class="widget flat radius-bordered ">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="customerController" ng-init="manageForm([[ !empty($editCustomerId) ?  $editCustomerId : '0' ]],[[ !empty($editEnquiryId) ?  $editEnquiryId : '0' ]],1); getAllEmployeeData();manageQuickEnquiry()">
            <!--<h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i></h5>-->
             <div class="widget-header bordered-bottom bordered-themeprimary ">
                <span class="widget-caption">Quick Enquiry</span>
             </div>
            <div class="widget-body col-lg-12 col-sm-12 col-xs-12" style="box-shadow:none;">
                <div id="customer-form">                    
                    <input type="hidden" ng-model="customerData.csrfToken" name="csrftoken" id="csrftoken" ng-init="customerData.csrfToken = '[[ csrf_token() ]]'">
                    <input type="hidden" ng-model="searchData.customerId" name="customerId" id="custId" value="{{searchData.customerId}}">
                    <input type="hidden" name="loginid" id="loginid" value="[[ Auth::guard('admin')->user()->id ]]">
                     <div class="row col-lg-12 col-sm-12 col-xs-12">
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
                                            <input type="text" class="form-control" ng-disabled="disableText" ng-model="searchData.searchWithMobile" get-customer-details-directive minlength="10" maxlength="10" id="searchWithMobile"  ng-pattern="/^[789][0-9]{9,10}$/" name="searchWithMobile" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" ng-model-options="{allowInvalid: true, debounce: 100}" ng-change="checkValue(searchData.searchWithMobile)" value="{{ searchData.searchWithMobile}}">
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
                                            <input type="email" class="form-control" ng-disabled="disableText || emailField" get-customer-details-directive maxlength="50" ng-model="searchData.searchWithEmail" name="searchWithEmail" ng-model-options="{allowInvalid: true, debounce: 500}" ng-change="checkEmailValue(searchData.searchWithEmail)"  value="{{ searchData.searchWithEmail}}">
                                            <i class="glyphicon glyphicon-envelope"></i>
                                            <div ng-messages="searchData.searchWithEmail.$error" class="help-block">
                                                <div ng-message="pattern" >Invalid Email Id</div>
                                            </div>                                            
                                            <div ng-show="errEmail" class="sp-err">Invalid email id!</div>
                                        </span>
                                    </div>
                                    <input type="hidden" ng-model="customer_id" name="customer_id">
                                </div>                                
                            </div>
                        </div>
                        <br><br>
                    </div>
                        <br><br>
                    </div>
                    <tabset ng-if="showDivCustomer" class="demo-tab showDivCustomer row">
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
                                                            <a style="cursor: pointer;" class="Linkhref ng-scope" ng-if="mobile_obj != null" ng-click="cloudCallingLog(1,[[Auth::guard('admin')->user()->id]],{{ enquiry.id}},'{{enquiry.customer_id}}','{{$index}}')">
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
<!--                                                    Model : {{enquiry.model_name}} 
                                                     <hr class="enq-hr-line">-->
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
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#historyDataModal" ng-click="initHistoryDataModal({{ enquiry.id}},{{initmoduelswisehisory}},1)">View History</a>
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
                                                        <input type="checkbox" name="chk_enquiry_history_list" ng-click="getModulesWiseHist_list(history_enquiryId, 1, 'listFlag')" checked  class="chk_enquiry_history_list">
                                                        <span class="text">All</span>
                                                    </label>
                                                    &nbsp;&nbsp;
                                                    <label>
                                                        <input type="checkbox"  ng-click="getModulesWiseHist_list(history_enquiryId, 0, 'listFlag')" data-id="1" checked class="chk_followup_history_all_list" class="chk_presales_list">
                                                        <span class="text">Pre Sales</span>
                                                    </label>
                                                    &nbsp;&nbsp;
                                                    <label>
                                                        <input type="checkbox"  ng-click="getModulesWiseHist_list(history_enquiryId, 0, 'listFlag')" data-id="2" checked  class="chk_followup_history_all_list" class="chk_Customer_Care_list">
                                                        <span class="text">Customer Care</span>
                                                    </label>
                                                    <hr class="enq-hr-line">           
                                                    1) <span>PS = Pre Sales</span> &nbsp;&nbsp;2) <span>CC = Customer Care</span>            
                                                    <hr class="enq-hr-line">    
                                                </div>

                                                <div style="height: auto;max-height: 605px;margin-top: 0px; overflow-x: hidden;overflow-y: scroll;">
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
                                                        <tbody ng-repeat="history in historyList track by $index  | orderBy:orderByField:reverseSort">
                                                            <tr role="row" >
                                                                <td style="width:4%" rowspan="2">
                                                                    {{ $index + 1}}
                                                                </td>
                                                                <td style="width: 10%;">
                                                                    <div>
                                                                        {{ history.first_name}}  {{ history.last_name}}    
                                                                        <span>
                                                                            <b>({{history.short_name}})</b>
                                                                        </span>
                                                                    </div>

                                                                </td>
                                                                <td style="width: 10%">
                                                                    {{ history.last_followup_date | split:'@':0}}<br/> @ {{ history.last_followup_date | split:'@':1 }}
                                                                </td>


                                                                <td style="width: 10%">
                                                                    <span ng-if="history.next_followup_date != null && history.next_followup_date != '00-00-0000'">
                                                                        {{ history.next_followup_date}} <br/>@ {{ history.next_followup_time}}
                                                                    </span>
                                                                    <span ng-if="history.next_followup_date == null || history.next_followup_date == '00-00-0000'">
                                                                        <center>  -</center>
                                                                    </span>

                                                                </td>
                                                                <td style="width: 8%">
                                                                    <div ng-show="history.cc_presales_status != null">
                                                                        {{history.cc_presales_status}} <span ng-if="history.cc_presales_substatus != null">/<br/></span>
                                                                        {{history.cc_presales_substatus}}
                                                                    </div>
                                                                    <div ng-show="history.sales_status != null">
                                                                        {{history.sales_status}} <span ng-if="history.enquiry_sales_substatus != null">/<br/></span>
                                                                        {{history.enquiry_sales_substatus}}
                                                                    </div>
                                                                    <div ng-show="history.cc_presales_status == null && history.sales_status == null">
                                                                        N/A
                                                                    </div>

                                                                </td>              
                                                               <td style="width: 16%">
                                                                    <span data-toggle="tooltip" title="{{history.remarks| removeHTMLTags}}">{{history.remarks| removeHTMLTags | limitTo : 150 }} </span>  
                                                                    <span ng-if="history.remarks.length > 150" data-toggle="tooltip" title="{{history.remarks| removeHTMLTags}}">...</span>
                                                                </td>
                                                            </tr>
                                                           <tr ng-if="history.call_recording_url != '' && history.call_recording_url != 'None' && history.call_recording_url != None">
                                                                <td colspan="7">
                                                                    <audio style="width: 600px;" id="recording_{{ history.id}}" controls></audio>
                                                                </td>
                                                            </tr>            
                                                        </tbody>
                                                         <tr ng-if="historyList.length == 0">
                                                            <td colspan="6" class="text-align-center">
                                                                --Record Not Found--
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer" align="center">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>            
            </div>
        </div>
    </div>
</div>
<script>
    $("#mobile_calling_code,#landline_calling_code").intlTelInput();
</script>