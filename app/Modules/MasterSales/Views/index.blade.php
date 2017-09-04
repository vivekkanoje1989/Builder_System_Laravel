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
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="customerController" ng-init="manageForm([[ !empty($editCustomerId) ?  $editCustomerId : '0' ]],[[ !empty($editEnquiryId) ?  $editEnquiryId : '0' ]],0)">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{pageHeading}}</h5>
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
                                            <input type="text" class="form-control" ng-disabled="disableText" ng-model="searchData.searchWithMobile" get-customer-details-directive minlength="10" maxlength="10" ng-pattern="/^[789][0-9]{9,10}$/" name="searchWithMobile" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" ng-model-options="{allowInvalid: true, debounce: 100}" ng-change="checkValue(customerData.searchWithMobile)" value="{{ searchData.searchWithMobile}}">
                                            <i class="glyphicon glyphicon-phone"></i>
                                            <div ng-show="sbtBtn" ng-messages="customerData.searchWithMobile.$error" class="help-block">
                                                <div ng-message="minlength">Invalid mobile no.</div>
                                                <div ng-message="customerInputs">Mobile number does not exist!</div>
                                                <div ng-message="customerPattern">Mobile number wrong!</div>
                                            </div> 
                                            
                                            <div ng-show="errMobile">Mobile number wrong!</div>
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
                        <tab heading="Customer Information" id="custDiv">
                            <div data-ng-include=" '/MasterSales/createCustomer'"></div>
                        </tab>
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
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="border: 1px solid #CED3D7;background-color: #EAEAEA;height:15px" align="center">Sr. No.</th>
                                    <th style="border: 1px solid #CED3D7;background-color: #EAEAEA;height:15px" align="center">Customer Details</th>
                                    <th style="border: 1px solid #CED3D7;background-color: #EAEAEA;height:15px" align="center">Enquiry Details</th>
                                    <th style="border: 1px solid #CED3D7;background-color: #EAEAEA;height:15px" align="center">Last Followup</th>
                                    <th style="border: 1px solid #CED3D7;background-color: #EAEAEA;height:15px" align="center">Enquiry Status</th>
                                    <th style="border: 1px solid #CED3D7;background-color: #EAEAEA;height:15px" align="center">Enquiry </th>
                                </tr>
                            </thead>
                            <tbody ng-if="!listsIndex.success">
                                <tr>
                                    <td colspan="6">{{listsIndex.CustomerEnquiryDetails}}</td>
                                </tr>
                            </tbody>
                            <tbody ng-if="listsIndex.success">
                                <tr dir-paginate="list in listsIndex.CustomerEnquiryDetails | filter:search | itemsPerPage:itemsPerPage">  
                                    <td align="center">{{ $index + 1}}</td>
                                    <td align="center">
                                        <div > 
                                            {{list.customer_fname}} {{list.customer_lname}} {{ list.mobile_number}} <br/> {{list.email_id}}</div>
                                        <hr>
                                        <div class="floatLeft"><a href="[[ config('global.backendUrl') ]]#/sales/update/cid/{{ list.customer_id }}">Customer Details</a></div> 
                                        <div class="floatLeft" style="width:30%;max-width: 30%;word-wrap: break-word;"><b>Enquiries : {{ listsIndex.CustomerEnquiryDetails.length }}</b></div>
                                        <div class="floatLeft" style="width:40%;max-width: 30%;word-wrap: break-word;"><b>Booked : 0</b></div>                    
                                        <div  class="floatLeft" style="width:100%;"><hr></div>
                                        <div>
                                        <span style="margin:5px"><strong>Source: </strong>{{ list.sales_source_name}}<br></span>
                                        <span style="margin:5px"><b>Budget</b>: {{list.max_budget}}</span>    
                                        </div>
                                    </td>
                                    <td>
                                        <div>{{list.project_block_name}} - {{list.block_name}} </div>
                                        <hr>
                                        <!--#/sales/updateenquiry/{{ list.id }}   ng-click="getEnquiryDetails({{ list.id }})"-->
                                        <div class="floatLeft"><i class="fa fa-desktop" aria-hidden="true"></i></div>
                                        <div class="floatLeft" style="width:41%"><a href="[[ config('global.backendUrl') ]]#/sales/update/cid/{{ list.customer_id }}/eid/{{ list.id }}">Enquiry Details</a></div>
                                        <div class="floatLeft" style="width:50%">
                                            <span style="margin-left:4px;background-color:RED;float:left;width:12px;height:12px;" ng-if="list.get_enquiry_category_name.enquiry_category != 'New Enquiry'">&nbsp;</span>
                                            <span style="float: left;margin-left: 5px;">{{ list.enquiry_category}}</span>              
                                        </div> 
                                        <div class="floatLeft" style="width:100%;"><hr></div>
                                        <div class="floatLeft">
                                            <span style="float:left;"><b>No.of Followups : {{list.total_followups}}</b></span><br/>
                                            <span style="float:left;"><b>Location</b> : {{ list.location_name }}</span><br/>
                                            <span style="float:left;" ng-show="list.parking_required == 1">Parking Required</span>
                                            <span style="float:left;" ng-show="list.parking_required == 0">No Parking Required</span>
                                        </div>
                                    </td>
                                    <td align="center" width="30%">
                                        <span>{{ list.last_followup_date | date:'dd M, yyyy'}} By {{list.followup_fname}} {{list.followup_lname}}</span><hr>
                                        <span style="width: 100%;word-break: break-all;">{{ list.remarks}}</span>
                                    </td>
                                    <td align="center" style="vertical-align: middle;">{{ list.sales_status }}</td>
                                    <td align="left">
                                        <div>Owner: {{list.owner_fname}} {{list.owner_lname}}</div><hr>
                                        <button type="button" class="btn btn-primary ng-click-active" data-toggle="modal" data-target="#historyDataModal" ng-click="initHistoryDataModal({{ list.id }})">View History</button>                                     
                                    </td>
                                </tr>
                            </tbody> 
                        </table>
                        <div class="DTTTFooter">
                            <div class="col-sm-6">
                                <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{noOfRows}}</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                                    <dir-pagination-controls class="pagination" on-page-change="pageChangeHandler(newPageNumber)" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><br>
                            <div class="form-group" align="center">
                                <button type="submit" class="btn btn-primary" ng-click="createEnquiry()">Insert New Enquiry</button>
                            </div> 
                        </div> 
                    </div>
                </div>            
            </div>
            <!--  Modal   --> 
            <div class="modal fade" id="contactDataModal" role="dialog" tabindex='-1'>
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content" style="width: 115%;">                        
                        <form novalidate name="modalForm" ng-submit="modalForm.$valid && addRow(contactData)">
                            <div class="modal-header">
                                <button type="button" class="close" id="closeModal" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title" align="center">Contact Details</h4>
                            </div>
                            <input type="hidden" ng-model="contactData.index" name="index" value="{{contactData.index}}">
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
                                                <label for="">Country Code</label>
                                                <span class="input-icon icon-right"> 
                                                    <input type="text" disabled ng-model="contactData.mobile_calling_code"  name="mobile_calling_code"  id="mobile_calling_code" class="form-control">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-xs-4">
                                            <div class="form-group">
                                                <label for="">Mobile Number</label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contactData.mobile_number" name="mobile_number" id="mobile_number" class="form-control" maxlength="10" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" check-mobile-exist ng-model-options="{ allowInvalid: true, debounce: 300 }" required>
                                                    <i class="glyphicon glyphicon-phone"></i>
                                                </span>
                                                <div ng-show="modalSbtBtn && modalForm.mobile_number.$invalid" ng-messages="modalForm.mobile_number.$error" class="help-block">
                                                    <div ng-message="required">Mobile number is required</div> 
                                                    <div ng-message="uniqueMobile">Mobile number already exist</div>
                                                </div>
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
                                                <div ng-show="modalSbtBtn && modalForm.email_id.$invalid" ng-messages="modalForm.email_id.$error" class="help-block">
                                                    <div ng-message="pattern">Please enter valid email id</div>
                                                    <div ng-message="uniqueEmail">Email Id already exist</div>
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
                                                    <input type="text" ng-model="contactData.house_number" name="house_number" class="form-control date-picker">
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
                                                    <input type="text" ng-model="contactData.building_house_name" name="building_house_name" class="form-control">
                                                    <i class="fa fa-building-o"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <label for="">Wing Name</label>
                                                    <span class="input-icon icon-right">
                                                        <input type="text" ng-model="contactData.wing_name" name="wing_name" class="form-control">
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
                                                    <input type="text" ng-model="contactData.area_name" name="area_name" class="form-control date-picker">
                                                    <i class="fa fa-building-o"></i>
                                                </span>                                      
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">                                            
                                                <label for="">Lane Name</label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contactData.lane_name" name="lane_name" class="form-control date-picker">
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
                                                    <input type="text" ng-model="contactData.landmark" name="landmark" class="form-control date-picker">
                                                    <i class="fa fa-building-o"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Pin</label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contactData.pin" name="pin" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
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
                                                    <textarea ng-model="contactData.other_remarks" name="other_remarks" class="form-control"></textarea>
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
   $("#mobile_calling_code,#landline_calling_code").intlTelInput();
</script>