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
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="customerController">
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
                                            <input type="text" class="form-control" ng-model="searchData.searchWithMobile" get-customer-details-directive ng-disabled="disableText" minlength="10" maxlength="10" name="searchWithMobile" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" ng-model-options="{allowInvalid: true, debounce: 100}" ng-change="checkValue(customerData.searchWithMobile)">
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
                                            <input type="email" class="form-control" get-customer-details-directive ng-model="searchData.searchWithEmail" ng-disabled="disableText" name="searchWithEmail" ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/" ng-model-options="{allowInvalid: true, debounce: 500}" ng-change="checkValue(customerData.searchWithEmail)">
                                            <i class="glyphicon glyphicon-envelope"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>     

                        <br><br>
                    </div>
                    <tabset ng-if="showDivCustomer" class="demo-tab row">
                        <tab heading="Customer Information"  id="custDiv">
                            <div data-ng-include=" '[[ config('global.getUrl') ]]/MasterSales/createGetCustomer'"></div>
                        </tab>
                        <tab heading="Enquiry Information" active="enquiry_div" id="enquiryDiv" style="display: none;">
                            <div data-ng-include=" '[[ config('global.getUrl') ]]/MasterSales/createEnquiry'" ></div>
                        </tab>
                    </tabset>
                </div>


                <div class="row col-lg-12 col-sm-12 col-xs-12" ng-if="showDiv">
                    <hr class="wide" />
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="form-title">
                            Previous Open Enquiries
                        </div>
                    </div>
                    <div class="widget-body table-responsive" style="box-shadow:none;">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                            <th>Sr.No.</th>
                            <th>Customer Details</th>
                            <th>Enquiry Date</th>
                            <th>Last Followup Date & Time</th>
                            <th>Next FollowUp Date & Time </th>
                            <th>Enquiry History </th>
                            </thead>                                 
                            <tbody>
                                <tr ng-repeat="list in listsIndex.CustomerEnquiryDetails">
                                    <td>{{ $index + 1}}</td>
                                    <td>
                                        <div ng-repeat="cust in listsIndex.customerPersonalDetails">
                                            {{ cust.first_name}} {{ cust.last_name}} <br>
                                        </div>                                           
                                    </td>
                                    <td>
                                        {{ list.sales_enquiry_date | date:'dd M, yyyy'}} <br>
                                    </td>
                                    <td>
                                        {{ list.get_followup_details.actual_followup_date_time | date:'dd M, yyyy'}}                                        
                                    </td>                                    
                                    <td>
                                        {{ list.get_followup_details.next_followup_date | date:'dd M, yyyy'}}
                                        {{ list.get_followup_details.next_followup_time | date:'dd M, yyyy'}}
                                    </td>
                                    <!--Owner: [[ Auth::guard('admin')->user()->first_name ]] [[ Auth::guard('admin')->user()->last_name ]]-->                                    
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#historyDataModal" ng-click="initHistoryDataModal({{ list.id}})">View History</button>
                                    </td>
                                </tr>                                       
                            </tbody>
                        </table>
                        <div class="DTTTFooter" align="center">
                            <div class="col-sm-4 col-xs-12">
                                <a class="btn btn-primary" ng-click="createNewEnquiry()" style="margin-top:20px;float: right;">Create New Enquiry</a>
                            </div>
                            <div class="col-sm-4 col-xs-12">
                                <a ng-click="createEnquiry()" class="btn btn-primary" style="margin-top:20px;float: left;">Create Customer And New Enquiry</a>
                            </div>
                        </div>
                    </div>
                </div>                
                <!--  Modal   --> 
                <div class="modal fade" id="contactDataModal" role="dialog" tabindex='-1'>
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title" align="center">Contact Details</h4>
                            </div>
                            <form novalidate name="modalForm" ng-submit="modalForm.$valid && addRow(contactData)">
                                <input type="hidden" ng-model="contactData.index" name="index" value="{{contactData.index}}">
                                <div class="modal-body">
                                    <div class="col-lg-6 col-sm-6 col-xs-12">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Number Type</label>
                                                    <span class="input-icon icon-right">
                                                        <select ng-model="contactData.mobile_number_lable" name="mobile_number_lable" class="form-control">
                                                            <option value="">Select Type</option>
                                                            <option value="1">Personal</option>
                                                            <option value="2">Office</option>
                                                        </select>
                                                        <i class="fa fa-sort-desc"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Mobile Number</label>
                                                    <span class="input-icon icon-right">
                                                        <input type="text" ng-model="contactData.mobile_number" name="mobile_number" id="mobile_number" class="form-control" intl-Tel ng-pattern="/^(\+\d{1,4}-)\d{10}$/" check-mobile-exist required>
                                                        <i class="glyphicon glyphicon-phone"></i>
                                                    </span>
                                                    <div ng-show="modalSbtBtn" ng-messages="modalForm.mobile_number.$error" class="help-block">
                                                        <div ng-message="required">This field is required.</div>
                                                        <div ng-message="pattern">Mobile number should be 10 digits and pattern should be for ex. +91-9999999999</div>
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
                                                            <option value="">Select Type</option>
                                                            <option value="1">Personal</option>
                                                            <option value="2">Office</option>
                                                        </select>
                                                        <i class="fa fa-sort-desc"></i>                                                    
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Landline Number</label>
                                                    <span class="input-icon icon-right">
                                                        <input type="text" ng-model="contactData.landline_number" name="landline_number" id="landline_number" class="form-control" intl-Tel ng-model-options="{ updateOn: 'blur' }" ng-change="validateLandlineNumber(contactData.landline_number)">
                                                        <i class="glyphicon glyphicon-phone"></i>
                                                    </span>
                                                    <div ng-show="modalSbtBtn || errLandline" ng-messages="modalForm.landline_number.$error" class="help-block {{applyClass}}">
                                                        <div>{{ errLandline}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Email Type</label>
                                                    <span class="input-icon icon-right">
                                                        <select ng-model="contactData.email_id_lable" name="email_id_lable" class="form-control">
                                                            <option value="">Select Type</option>
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
                                                        <input type="text" ng-model="contactData.email_id" name="email_id" class="form-control" check-email-exist ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/" ng-model-options="{ allowInvalid: true, debounce: 500 }">
                                                        <i class="glyphicon glyphicon-envelope"></i>
                                                    </span>
                                                    <div ng-show="modalSbtBtn" ng-messages="modalForm.email_id.$error" class="help-block">
                                                        <div ng-message="pattern">Please enter valid email id</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Address</label>		
                                                    <span class="input-icon icon-right">
                                                        <select ng-model="contactData.address_type" name="address_type" class="form-control">
                                                            <option value="">Select Type</option>
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
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-xs-12" ng-controller="currentCountryListCtrl">
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
                                <div class="modal-footer" align="center">
                                    <button type="submit" class="btn btn-primary" ng-click="modalSbtBtn = true">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            <div data-ng-include=" '[[ config('global.getUrl') ]]/MasterSales/enquiryHistory'"></div>
            <div class="modal-footer" align="center">
            </div>
        </div>
    </div>
</div>