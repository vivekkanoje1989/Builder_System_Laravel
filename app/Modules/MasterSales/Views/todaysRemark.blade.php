<style>
    .imgcls{
        width:40px;
        border-radius: 50%;
        -webkit-filter: drop-shadow(0 0 3px #00415d);
        filter: drop-shadow(0 0 0 2px #00415d);
    }
    .ta-editor.form-control.myform1-height, .ta-scroll-window.form-control.myform1-height  {
        min-height: 85px;
        height: auto;
        overflow: auto;
        font-family: inherit;
        font-size: 100%;
    }

    .form-control.myform1-height > .ta-bind {
        height: auto;
        min-height: 85px;
        padding: 6px 12px;
    }
    .editor-text p {
        height: 60px !important;
    }
    .timeline-unit:before, .timeline-unit:after {
        top: 0;
        border: solid transparent;
        border-width: 1.35em;
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
    }

    .timeline-unit:after {
        content: " ";
        left: 100%;
        border-left-color: #77b3d4; /*blue*/
    }

    .timeline-unit {
        margin-right: 25px;
        position: relative;
        display: inline-block;
        background: #77b3d4;/*grey*/
        padding: 1em;
        line-height: 0.65em;
        color: #000;
        -webkit-filter: drop-shadow(0 0 2px black);
        filter: drop-shadow(0 0 0 2px black);
    }

    .custom-btn{
        float: right;
        margin:5px;
    }

    #divMyTags div.existingTag
    {
        position: relative;
        color: #000; /*EEE*/
        font-size: 15px;
        display: inline-block;
        border: 3px solid;
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        margin: 5px;
        width:100%;
    }

    #divMyTags div.existingTag p {
        color: black;
    }

    .csspadding{
        padding: 15px 15px 0px 15px;
    }
    .help-block{
        color: red;
    }

    .call-img{
        height:17px;width:17px;
        position: absolute;
    }

    .call-img:hover{
        height:22px;width:22px;
    }

    /*******************Company START**********************/
    .companyField{
        padding: 0px 0px;
        margin: 0px 0px 5px;
        max-height: 100px;
        overflow-y: scroll;
        position: absolute;
        /*width: 93%;*/
        width: 89%;
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

    /*******************Company END**********************/

    .main-container1 {
        position: relative;
        overflow: hidden;
    }
    .main-container1 > .content1 {
        width: 100%;
        position: absolute;
        height: 320px;
        bottom: -265px;
        left: 0;
        right: 0;
        z-index: 101;
        padding: 10px 20px;
        background-color: #efefef;
        transition: all ease 1s;
    }
    .main-container1 > .content2 {
        width: 100%;
        position: absolute;
        height: 480px;
        bottom: -423px;
        left: 0;
        right: 0;
        z-index: 101;
        padding: 10px 20px;
        background-color: #efefef;
        transition: all ease 1s;
    }
    .main-container1 > .content1:hover {
        bottom: 0px;
        transition: all ease 1s;
    }

    .toggleClassActive {font-size:40px !important;cursor:pointer;color: #5cb85c !important;vertical-align: middle;}
    .toggleClassInactive {font-size:40px !important;cursor:pointer;color: #d9534f !important;vertical-align: middle;}

    .followupdate + ul.dropdown-menu{
        top: -254px !important;
    }
    
    .pleaseWait{
        display:none;
    }
    .sending{
        margin-top: 17%;
        position: absolute;
        margin-left: 34%;
    }
    #followup_by_employee_id{
        margin-top: -235px;
    }
</style>

<div class="modal-body"> 
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <tabset>
                <tab heading="Today Remarks" id="remarkTab">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">                            
                            <form name="remarkForm" novalidate ng-submit="remarkForm.$valid && insertTodayRemark(remarkData, sharedemployee)" class="main-container1">
                                <input type="hidden" ng-model="remarkData.enquiryId" name="enquiryId" id="enquiryId" value="{{remarkData.enquiryId}}">
                                <input type="hidden" ng-model="remarkData.customerId" name="customerId" id="custId" value="{{remarkData.customerId}}">
                                <input type="hidden" ng-model="remarkData.bookingId" name="bookingId" id="bookingId">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <span ng-show="custInfo"><b style="font-size: 17px;">{{remarkData.title}} {{remarkData.customer_fname}} {{remarkData.customer_lname}}</b></span>  	
                                        <div class="row" ng-show="editableCustInfo">
                                            <div class="col-sm-4">
                                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!remarkForm.title_id.$dirty && remarkForm.title_id.$invalid)}">
                                                    <span class="input-icon icon-right">
                                                        <select ng-model="remarkData.title_id" ng-controller="titleCtrl" name="title_id" class="form-control" ng-required="editableCustInfo">
                                                            <option value="">Select Title</option>
                                                            <option ng-repeat="t in titles track by $index" value="{{t.id}}" ng-selected="{{ t.id == remarkData.title_id}}">{{t.title}}</option>
                                                        </select>
                                                        <i class="fa fa-sort-desc"></i>
                                                        <div ng-show="sbtBtn" ng-messages="remarkForm.title_id.$error" class="help-block">
                                                            <div ng-message="required">This field is required</div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!remarkForm.customer_fname.$dirty && remarkForm.customer_fname.$invalid)}">
                                                    <span class="input-icon icon-right">
                                                        <input type="text" placeholder="First Name" ng-model="remarkData.customer_fname" name="customer_fname" capitalization class="form-control" ng-required="editableCustInfo">
                                                        <i class="fa fa-user"></i>
                                                        <div ng-show="sbtBtn" ng-messages="remarkForm.first_name.$error" class="help-block">
                                                            <div ng-message="required">This field is required</div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!remarkForm.customer_lname.$dirty && remarkForm.customer_lname.$invalid)}">
                                                    <span class="input-icon icon-right">
                                                        <input type="text" placeholder="Last Name" ng-model="remarkData.customer_lname" name="customer_lname" capitalization class="form-control" ng-required="editableCustInfo">
                                                        <i class="fa fa-user"></i>
                                                        <div ng-show="sbtBtn" ng-messages="remarkForm.last_name.$error" class="help-block">
                                                            <div ng-message="required">This field is required</div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div>
                                                    <span ng-if="displayMobile != '1'" ng-repeat="(key, value) in mobileList track by $index" style="float: left;">
                                                        <a ng-show="displayCallBtn == '1'"> <img src="/images/call.png" title="Click on call icon to make a call" class="hi-icon-effect-8 psdn_session call-img"></a>
                                                        <span class="text" style="margin-left: 23px;" ng-click="key!=0 && manageMobText(key, value)">{{value}}</span>
                                                        <span ng-if="key<mobileList.length-1">&nbsp; | &nbsp;</span>
                                                    </span> 
                                                </div>

                                                <div class="col-sm-12">
                                                    <span ng-if="displayMobile == '1' && mobileList" ng-repeat="(key, value) in mobileList track by $index" style="float: left;margin: 7px 20px 0px 0px;">    
                                                        <img ng-if="displayCallBtn == '1'" src="/images/call.png" title="Click on call icon to make a call" class="hi-icon-effect-8 psdn_session call-img">
                                                        <span class="text" style="margin-left: 23px;" ng-click="manageMobText(key, value)">+91-xxxxxx{{  value.substring(value.length - 4, value.length)}}</span>
                                                        <span ng-if="key<mobileList.length - 1">&nbsp; | &nbsp;</span>
                                                    </span>
                                                    @if (strpos(Auth::guard('admin')->user()->employee_submenus,'"040501"'))
                                                    <div class="col-sm-12" style="margin-left: -13px;" ng-if="mobileList.length < 4 && displayMobile != '1'"><a href ng-click="manageMobText('', '')">Add Mobile Number</a></div>
                                                    <span class="input-icon icon-right" ng-if="addMob && displayMobile != '1'">
                                                        <span class="input-icon icon-right">
                                                            <input type="text" ng-model="remarkData.mobile_number" placeholder="Enter Mobile Number" maxlength="10" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="mobile_number" name="mobile_number" class="form-control" ng-model-options="{ allowInvalid: true, debounce: 500 }"
                                                                   ng-blur="addInfo(remarkData.customerId, remarkData.mobile_calling_code1, remarkData.mobile_number, 'mobile_number')">
                                                            <i class="fa fa-times" aria-hidden="true" id="iconformob" style="cursor: pointer;" ng-click="closeMobText()"></i>
                                                            <div ng-show="mobErr" style="color: red;">Mobile number already exist</div>
                                                        </span>
                                                        <div ng-show="remarkData.mobile_number.length > 0" ng-messages="remarkForm.mobile_number.$error" class="help-block {{ applyClassPMobile}}">
                                                            <div ng-message="minlength" style="color: red !important;">Length of mobile number minimum 10 digit required</div>
                                                            <div ng-message="pattern" style="color: red !important;">Mobile number should be 10 digits and pattern should be for ex. +91-9999999999</div>
                                                        </div>
                                                    </span>
                                                    @endif
                                                    <input type="hidden" ng-mode="prevMob" name="prevMob" id="prevMob"><br>
                                                </div>

                                                <div class="col-sm-12">
                                                    <span ng-if="emailList.length > 0" ng-repeat="(key, value) in emailList track by $index" style="float: left;  margin: 7px 20px 5px 0px;">    
                                                        <i class="fa fa-envelope" aria-hidden="true" ng-if="value != 'null'"></i>
                                                        <span class="text" ng-click="key!=0 && manageEmailText(key, value)" ng-if="value != 'null' && displayEmail != '1'">{{value}}</span>
                                                        <span class="text" ng-click="key!=0 && manageEmailText(key, value)" ng-if="value != 'null' && displayEmail == '1'">{{ value | emailHider }}</span>
                                                    </span>
                                                    @if (strpos(Auth::guard('admin')->user()->employee_submenus,'"040501"'))
                                                    <div class="col-sm-12" style="margin-left: -13px;" ng-if="emailList.length < 4 && displayEmail != '1'">
                                                        <a href ng-click="manageEmailText('', '');">Add Email Id</a>
                                                    </div>
                                                    <span class="input-icon icon-right" ng-if="addEmail && displayEmail != '1'">
                                                        <input type="email" ng-model="remarkData.email_id" name="email_id" placeholder="Enter Email Address" 
                                                               class="form-control" maxlength="40" ng-pattern="/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/" 
                                                               ng-model-options="{ allowInvalid: true, debounce: 850 }"
                                                               ng-blur="addInfo(remarkData.customerId, '', remarkData.email_id, 'email_id')">
                                                        <i class="fa fa-times" aria-hidden="true" id="iconformob" style="cursor: pointer;" ng-click="closeEmailText()"></i>
                                                        <div ng-if="emailErr" style="color: red;">Email id already exist</div>
                                                        <div ng-messages="remarkForm.email_id.$error" class="help-block">
                                                            <div ng-message="pattern" >Invalid Email Id</div>
                                                        </div> 
                                                    </span>
                                                    @endif
                                                    <input type="hidden" ng-mode="prevEmail" name="prevEmail" id="prevEmail">
                                                    <input type="hidden" ng-mode="pkid" name="pkid" id="pkid">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <span class="checkbox" style="margin: 0;">
                                                    <label>
                                                        <input type="checkbox" id="corporateCust" ng-model="remarkData.corporateCust" name="corporateCust" ng-change="isChecked(remarkData.corporateCust)">
                                                        <span class="text"> Corporate Customer</span>
                                                    </label>
                                                </span>	
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="form-group" ng-if="companyInput" ng-class="{ 'has-error' : (sbtBtn) && (!remarkForm.company_name.$dirty && remarkForm.company_name.$invalid)}">
                                                    <input type="text" class="form-control" placeholder="Company name" ng-model="remarkData.company_name" name="company_name" ng-keyup="getCompanyList(remarkData.company_name)" capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')" required>
                                                    <ul class="companyField" ng-if="company_list.length > 0 && showComapnyList" >
                                                        <li ng-repeat="company in company_list| filter : remarkData.company_name" ng-click="setCompany(company)"><span>{{company.company_name}}</span></li>
                                                    </ul> 
                                                    <div ng-show="sbtBtn" ng-messages="remarkForm.company_name.$error" class="help-block">
                                                        <div ng-message="required">This field is required</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if (strpos(Auth::guard('admin')->user()->employee_submenus,'"040501"'))
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <strong ng-if="customer_address">Address:</strong> <span>{{customer_address}}</span><br>
                                                <!--<strong ng-if="customer_area_name">Area:</strong> <span> {{customer_area_name}}</span>-->
                                                <a href ng-if="!customer_address" ng-click="gotoCustomerTab()">Add Address</a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <strong>Source: </strong><span ng-bind-html="sourceDetails"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6"></div>                            
                                </div>
                                <br/>
                                <div class="row" ng-controller="salesEnqStatusCtrl">
                                    <div class="col-sm-6">
                                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!remarkForm.sales_status_id.$dirty && remarkForm.sales_status_id.$invalid)}">
                                            <label for="">Enquiry Status<span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select class="form-control" ng-model="remarkData.sales_status_id" name="sales_status_id" id="sales_status_id" ng-change="getSubStatus(remarkData.sales_status_id)" ng-click="hideIcon(remarkData.sales_status_id)" required ng-disabled="!booked">
                                                    <option value="">Select Status</option>
                                                    <option ng-repeat="list in salesEnqStatusList" ng-if="remarkSt == '' && (list.id != 1)" value="{{list.id}}" ng-selected="{{ list.id == remarkData.sales_status_id}}">{{list.sales_status}}</option>
                                                    <option ng-repeat="list in salesEnqStatusList" ng-if="remarkSt == 'lost' && ((list.id == 2) || (list.id == 4))" value="{{list.id}}" ng-selected="{{ list.id == remarkData.sales_status_id}}">{{list.sales_status}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="sbtBtn" ng-messages="remarkForm.sales_status_id.$error" class="help-block errMsg">
                                                    <div ng-message="required">This field is required</div>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6" ng-if="remarkData.sales_status_id == 4">
                                        <div class="form-group">
                                            <label for="">Lost Followup Date & Time</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control" disabled name="followup_date_time" value="{{remarkData.followup_date_time}}"/>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6" ng-if="remarkData.sales_status_id != 4 && remarkData.sales_status_id != 3">
                                        <div class="form-group" ng-class="{ 'has-error' : (sbtBtn && salesEnqSubStatusList.length != 0) && (!remarkForm.sales_substatus_id.$dirty && remarkForm.sales_substatus_id.$invalid)}">
                                            <label for="">Enquiry Sub Status<span class="sp-err" ng-if="salesEnqSubStatusList.length != 0">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select class="form-control" ng-model="remarkData.sales_substatus_id" name="sales_substatus_id" id="sales_substatus_id" ng-required="salesEnqSubStatusList.length != 0">
                                                    <option value="">Select Sub Status</option>
                                                    <option ng-repeat="list in salesEnqSubStatusList" value="{{list.id}}" ng-selected="{{ list.id == remarkData.sales_substatus_id}}">({{list.listing_position}}) {{list.enquiry_sales_substatus}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="sbtBtn" ng-messages="remarkForm.sales_substatus_id.$error" class="help-block errMsg" ng-if="salesEnqSubStatusList.length != 0">
                                                    <div ng-message="required">This field is required</div>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6" ng-if="remarkData.sales_status_id == 3">
                                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!remarkForm.booking_date.$dirty && remarkForm.booking_date.$invalid)}">
                                            <label>Booking Date<span class="sp-err">*</span></label>                                    
                                            <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                                <p class="input-group">
                                                    <input type="text" ng-model="remarkData.booking_date" name="booking_date" class="form-control" datepicker-popup="dd-MM-yyyy" is-open="opened" min-date="minDate" datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required  ng-disabled="!booked"/>
                                                    <span class="input-group-btn" >
                                                        <button type="button" class="btn btn-default" ng-click="!disableDataOnEnqUpdate && open($event)" ng-disabled="!booked"><i class="glyphicon glyphicon-calendar"></i></button>
                                                    </span>
                                                <div ng-show="sbtBtn" ng-messages="remarkForm.booking_date.$error" class="help-block enqFormBtn">
                                                    <div ng-message="required">This field is required</div>
                                                </div>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" ng-controller="salesLostReasonCtrl" ng-if="remarkData.sales_status_id == 4">
                                    <div class="col-sm-6">
                                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!remarkForm.sales_lost_reason_id.$dirty && remarkForm.sales_lost_reason_id.$invalid)}">
                                            <label for="">Lost Reason<span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select class="form-control" ng-model="remarkData.sales_lost_reason_id" name="sales_lost_reason_id" id="sales_lost_reason_id" ng-required="remarkData.sales_status_id == 4" ng-change="getlostsubreason(remarkData.sales_lost_reason_id)">
                                                    <option value="">Select Lost Reason</option>
                                                    <option ng-repeat="list in saleslostreasons" ng-selected="{{ list.id == remarkData.sales_lost_reason_id}}" value="{{list.id}}">({{list.id}}) {{list.reason}}</option>          
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                            <div ng-show="sbtBtn" ng-messages="remarkForm.sales_lost_reason_id.$error" class="help-block enqFormBtn">
                                                <div ng-message="required">This field is required</div>
                                            </div>
                                        </div>                    
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group" ng-class="{ 'has-error' : (sbtBtn && salessublostreasons.length > 0) && (!remarkForm.sales_lost_sub_reason_id.$dirty && remarkForm.sales_sublost_reason_id.$invalid)}">
                                            <label for="">Lost Sub Reason<span class="sp-err" ng-if="salessublostreasons.length > 0">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select class="form-control" ng-model="remarkData.sales_lost_sub_reason_id" name="sales_lost_sub_reason_id" ng-required="remarkData.sales_status_id == 4 && salessublostreasons.length > 0">
                                                    <option value="">Select Lost Sub Reason</option>
                                                    <option ng-repeat="list in salessublostreasons" ng-selected="{{ list.id == remarkData.sales_lost_sub_reason_id}}" value="{{list.id}}">({{list.listing_position}}) {{list.sub_reason}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                            <div ng-show="sbtBtn" ng-messages="remarkForm.sales_lost_sub_reason_id.$error" class="help-block enqFormBtn">
                                                <div ng-message="required">This field is required</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" ng-controller="salesEnqCategoryCtrl" ng-if="remarkData.sales_status_id != 3 && remarkData.sales_status_id != 4">
                                    <div class="col-sm-6">
                                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!remarkForm.sales_category_id.$dirty && remarkForm.sales_category_id.$invalid)}">
                                            <label for="">Enquiry Category<span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select class="form-control" ng-model="remarkData.sales_category_id" name="sales_category_id" id="sales_category_id" ng-change="getSubCategory(remarkData.sales_category_id)" required>
                                                    <option value="">Select Category</option>
                                                    <option ng-repeat="list in salesEnqCategoryList" ng-if="list.id != 1" value="{{list.id}}" ng-selected="{{ list.id == remarkData.sales_category_id}}">{{list.enquiry_category}}</option>          
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="sbtBtn" ng-messages="remarkForm.sales_category_id.$error" class="help-block errMsg">
                                                    <div ng-message="required">This field is required</div>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group" ng-class="{ 'has-error' : (sbtBtn && salesEnqSubCategoryList.length != 0) && (!remarkForm.sales_subcategory_id.$dirty && remarkForm.sales_subcategory_id.$invalid)}">
                                            <label for="">Enquiry Sub Category<span class="sp-err" ng-if="salesEnqSubCategoryList.length != 0">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select class="form-control" ng-model="remarkData.sales_subcategory_id" name="sales_subcategory_id" id="sales_subcategory_id" ng-required="salesEnqSubCategoryList.length > 0">
                                                    <option value="">Select Sub Category</option>
                                                    <option ng-repeat="list in salesEnqSubCategoryList" value="{{list.id}}" ng-selected="{{ list.id == remarkData.sales_subcategory_id}}">({{list.listing_position}}) {{list.enquiry_sales_subcategory}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="sbtBtn" ng-messages="remarkForm.sales_subcategory_id.$error" class="help-block errMsg">
                                                    <div ng-message="required">This field is required</div>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6" ng-if="remarkData.sales_status_id != 3 && remarkData.sales_status_id != 4">
                                        <div class="form-group">
                                            <label for="">Next Followup Date & Time<span class="sp-err">*</span></label>                                               
                                            <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                                <p class="input-group">
                                                    <input type="text" ng-model="remarkData.next_followup_date" name="next_followup_date" class="form-control followupdate" datepicker-popup="dd-MM-yyyy" is-open="opened" min-date="minDate" datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" ng-change="todayremarkTimeChange(remarkData.next_followup_date)" readonly required/>
                                                    <span class="input-group-btn" >
                                                        <button type="button" class="btn btn-default" ng-click="!disableDataOnEnqUpdate && open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                    </span>
                                                </p>
                                                <div ng-show="sbtBtn" ng-messages="remarkForm.next_followup_date.$error" class="help-block enqFormBtn">
                                                    <div ng-message="required">This field is required</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-6" >  
                                        <div class="form-group" ng-if="remarkData.sales_status_id != 3 && remarkData.sales_status_id != 4">
                                            <label for="">Time<span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="remarkData.next_followup_time" name="next_followup_time" id="next_followup_time" class="form-control" required>
                                                    <option value=""> Select Time </option>
                                                    <option ng-repeat="time in timeList" value="{{time.value}}" ng-selected="{{time.value == remarkData.next_followup_time}}">{{time.label}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>                                                
                                            </span>
                                            <div ng-show="sbtBtn" ng-messages="remarkForm.next_followup_time.$error" class="help-block">
                                                <div ng-message="required" >This field is required</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" >
                                    <div class="col-sm-6 col-xs-12" ng-if="remarkData.sales_status_id != 4">
                                        <div class="form-group">
                                            <label ng-if="remarkData.sales_status_id != 3">Reassign to</label>
                                            <label ng-if="remarkData.sales_status_id == 3">Reassign this booking to</label>
                                            <ui-select ng-controller="employeesCtrl" ng-model="remarkData.followup_by_employee_id" name="followup_by_employee_id" theme="bootstrap">
                                                <ui-select-match placeholder="Select Employee">{{remarkData.followup_by_employee_id.first_name}}</ui-select-match>
                                                <ui-select-choices repeat="item in employeeList | filter: $select.search" id="followup_by_employee_id">
                                                    <div ng-bind-html="item.first_name | highlight: $select.search"></div>
                                                </ui-select-choices>
                                            </ui-select>
                                        </div>
                                    </div>                          
                                </div>

                                <tabset justified="true" ng-if="remarkData.sales_status_id == 3">
                                    <tab heading="Booking Details" id="bookingTab" ng-controller="projectBlocksCtrl">
                                        <div class="row"  >
                                            <div class="col-sm-6">
                                                <div class="form-group" ng-class="{ 'has-error' : (bookBtn && modelList.length != 0) && (!remarkForm.project_id.$dirty && remarkForm.project_id.$invalid)}">
                                                    <label for="">Project<span class="sp-err">*</span></label>
                                                    <span class="input-icon icon-right">
                                                        <select ng-controller="projectCtrl" ng-model="remarkData.project_id" name="project_id"  id ="project_id" class="form-control" ng-change="getWings(remarkData.project_id); getBlocks(remarkData.project_id);" required>
                                                            <option value="">Select Project</option>
                                                            <option ng-repeat="plist in projectList" value="{{plist.id}}_{{plist.project_name}}">{{plist.project_name}}</option>
                                                        </select>
                                                        <i class="fa fa-sort-desc"></i>                                                        
                                                    </span>
                                                    <div ng-show="bookBtn" ng-messages="remarkForm.project_id.$error" class="help-block">
                                                        <div ng-message="required">This field is required</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group" ng-class="{ 'has-error' : (bookBtn && wingList.length != 0) && (!remarkForm.wing_id.$dirty && remarkForm.wing_id.$invalid)}">
                                                    <label for="">Wing<span class="sp-err" ng-if="wingList.length > 0">*</span></label>
                                                    <span class="input-icon icon-right">
                                                        <select ng-model="remarkData.wing_id" id="wing_id" name="wing_id" class="form-control" ng-required="wingList.length > 0">
                                                            <option value="">Select Wing</option>
                                                            <option ng-repeat="wlist in wingList" value="{{wlist.id}}" ng-selected="{{ wlist.id == remarkData.wing_id}}">{{wlist.wing_name}}</option>
                                                        </select>
                                                        <i class="fa fa-sort-desc"></i>
                                                        <div ng-show="bookBtn" ng-messages="remarkForm.wing_id.$error" class="help-block">
                                                            <div ng-message="required">This field is required</div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group" ng-class="{ 'has-error' : (bookBtn && blockList.length != 0) && (!remarkForm.block_id.$dirty && remarkForm.block_id.$invalid)}">
                                                    <label for="">Block Type<span class="sp-err" ng-if="blockList.length > 0">*</span></label>
                                                    <span class="input-icon icon-right">
                                                        <select ng-model="remarkData.block_id" id="block_id" name="block_id" class="form-control" ng-required="blockList.length > 0" ng-change="getSubBlocks(remarkData.project_id, remarkData.block_id)">
                                                            <option value="">Select Block</option>
                                                            <option ng-repeat="list in blockList" value="{{list.id}}" ng-selected="{{ list.id == remarkData.block_id}}">{{list.block_name}}</option>
                                                        </select>
                                                        <i class="fa fa-sort-desc"></i>
                                                        <div ng-show="bookBtn" ng-messages="remarkForm.block_id.$error" class="help-block">
                                                            <div ng-message="required">This field is required</div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group" ng-class="{ 'has-error' : (bookBtn && subBlockList.length != 0) && (!remarkForm.sub_block_id.$dirty && remarkForm.sub_block_id.$invalid)}">
                                                    <label for="">Block Sub Type<span class="sp-err" ng-if="subBlockList.length > 0">*</span></label>
                                                    <span class="input-icon icon-right">
                                                        <select ng-model="remarkData.sub_block_id" id="sub_block_id" name="sub_block_id" class="form-control" ng-required="subBlockList.length > 0">
                                                            <option value="">Select Sub Block</option>
                                                            <option ng-repeat="list1 in subBlockList" value="{{list1.id}}" ng-selected="{{ list1.id == remarkData.sub_block_id}}">{{list1.block_sub_type}}</option>
                                                        </select>
                                                        <i class="fa fa-sort-desc"></i>
                                                        <div ng-show="bookBtn" ng-messages="remarkForm.sub_block_id.$error" class="help-block">
                                                            <div ng-message="required">This field is required</div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>  
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div id="divMyTags"><br>
                                                    <label>Booking Remarks<span class="sp-err" >*</span></label>
                                                    <div class="existingTag bordered-themeprimary">
                                                        <div class="col-sm-12 csspadding">
                                                            <div class="form-group">
                                                                <span class="input-icon icon-right">
                                                                    <textarea class="form-control" rows="5" cols="50" ng-model="remarkData.textRemark" name="textRemark" ng-required="divText" capitalization></textarea>
                                                                </span>
                                                                <div ng-show="bookBtn" ng-messages="remarkForm.textRemark.$error" class="help-block">
                                                                    <div ng-message="required">This field is required</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <span class="input-icon icon-right">
                                                    <button type="submit" class="btn btn-primary custom-btn" ng-click="[bookBtn = true, sbtBtn = true]; companyValidate();" ng-disabled="disableRemarkSbt">Submit</button>
                                                </span>
                                            </div>
                                        </div> 
                                    </tab>
<!--                                    <tab heading="Collection Details" ng-click="checkAmount(collectionData.total_recievable_amount1)" disabled="!collectedTab" id="collectedTab">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group" ng-class="{ 'has-error' : collectionBtn && (!remarkForm.total_recievable_amount1.$dirty && remarkForm.total_recievable_amount1.$invalid)}">
                                                    <label for="">Total Receivable Amount (Please enter total on road amount)<span class="sp-err">*</span></label>
                                                    <span class="input-icon icon-right">                                        
                                                        <input type="text" ng-model="collectionData.total_recievable_amount1" name="total_recievable_amount1" class="form-control" ng-pattern="/^[1-9]\d*$/" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="8" ng-required="!booked">
                                                        <i class="fa fa-money" aria-hidden="true"></i>
                                                        <div ng-show="collectionBtn" ng-messages="remarkForm.total_recievable_amount1.$error" class="help-block">
                                                            <div ng-message="required">Please Enter Amount</div>
                                                            <div ng-message="pattern">Please Enter Valid Amount</div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-3" ng-controller="collectionStagesCtrl">
                                            <div class="col-sm-3" >
                                                <div class="form-group" ng-class="{ 'has-error' : (collectionBtn && !funcalled) && (!remarkForm.collection_stage_id1.$dirty || remarkForm.collection_stage_id1.$invalid)}">
                                                    <label for="">Collection Stage<span class="sp-err">*</span></label>
                                                    <span class="input-icon icon-right">
                                                        <select ng-model="collectionData.collection_stage_id1" id="collection_stage_id1" name="collection_stage_id1" class="form-control" ng-required="!booked">
                                                            <option value="">Select</option>
                                                            <option ng-repeat="list in collectionStagesList" value="{{list.id}}_{{list.stages}}" ng-selected="{{ list.id == remarkData.collection_stage_id1}}">{{list.stages}}</option>
                                                        </select>
                                                        <i class="fa fa-sort-desc"></i>
                                                        <div ng-show="collectionBtn && !funcalled" ng-messages="remarkForm.collection_stage_id1.$error" class="help-block">
                                                            <div ng-message="required">Please Select Collection Stage</div>
                                                        </div>
                                                        <div ng-show="existStage" style="color: red;">{{existStage}}</div>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group" ng-class="{ 'has-error' : (collectionBtn && !funcalled) && (!remarkForm.collection_date1.$dirty || remarkForm.collection_date1.$invalid)}">
                                                    <label for="">Payment Date<span class="sp-err">*</span></label>
                                                    <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                                        <p class="input-group">
                                                            <input type="text" ng-model="collectionData.collection_date1" name="collection_date1" class="form-control" datepicker-popup="dd-MM-yyyy" is-open="opened" datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly ng-required="!booked"/>
                                                            <span class="input-group-btn">
                                                                <button type="button" class="btn btn-default" ng-click="!disableDataOnEnqUpdate && openMaxDate($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                            </span>
                                                        <div ng-show="collectionBtn && !funcalled" ng-messages="remarkForm.collection_date1.$error" class="help-block enqFormBtn">
                                                            <div ng-message="required">Please select date</div>
                                                        </div>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>                                
                                            <div class="col-sm-3">
                                                <div class="form-group" ng-class="{ 'has-error' : (collectionBtn && !funcalled) && (!remarkForm.collection_amount.$dirty || remarkForm.collection_amount.$invalid)}">
                                                    <label for="">Payment Amount<span class="sp-err">*</span></label>
                                                    <span class="input-icon icon-right">                                        
                                                        <input type="text" ng-model="collectionData.collection_amount" name="collection_amount" class="form-control" ng-pattern="/^[1-9]\d*$/" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="7" ng-required="!booked">
                                                        <i class="fa fa-inr" aria-hidden="true"></i>
                                                        <div ng-show="collectionBtn && !funcalled" ng-messages="remarkForm.collection_amount.$error" class="help-block">
                                                            <div ng-message="required">Please Enter Amount</div>
                                                            <div ng-message="pattern">Please Enter Valid Amount</div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for=""></label>
                                                    <a href class="btn btn-labeled btn-primary btn-sm" ng-click="collectionBtn = true; addCollectionRow(collectionData);" style="margin-top: 25px;">
                                                        <i class="btn-sm fa fa-plus"></i>{{collectionBtnLbl}}
                                                    </a>
                                                </div>
                                            </div>                            
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                                <span style="color: red;" ng-if="amountExcess">{{amountExcess}}</span><br>
                                                <table class="table table-hover table-striped table-bordered collectiontbl" at-config="config">
                                                    <thead class="bord-bot">
                                                        <tr>
                                                            <th style="width:5%;text-align: center;">Sr. No.</th>
                                                            <th style="width:5%;text-align: center;">Collection Stage</th>
                                                            <th style="width:5%;text-align: center;">Payment Date</th>
                                                            <th style="width:5%;text-align: center;">Payment Amount</th>                        
                                                            <th style="width:5%;text-align: center;">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr role="row" ng-repeat="rec in crecords track by $index">
                                                            <td style="text-align: center;">{{ $index + 1}}</td>
                                                            <td style="text-align: center;">{{ rec.collection_stage_id1 | split:'_':1 }}</td>
                                                            <td style="text-align: center;">{{ rec.collection_date1 | date:"dd-MM-yyyy"}}</td>
                                                            <td style="text-align: center;">{{ rec.collection_amount}}</td>
                                                            <td class="fa-div">
                                                                <div class="fa-hover" tooltip-html-unsafe="Edit Collection"><a href><i class="fa fa-pencil editMode{{$index + 1}}" ng-click="editIndex(collectionData.total_recievable_amount1, rec)"></i></a> &nbsp;&nbsp;</div>
                                                                <div class="fa-hover" tooltip-html-unsafe="Delete Collection" style="display: block;" ng-click="deleteIndex(collectionData.total_recievable_amount1, rec)"><a href><i class="fa fa-trash-o"></i></a> &nbsp;&nbsp;</div>
                                                            </td>
                                                        </tr>
                                                        <tr ng-if="crecords.length > 0">
                                                            <td colspan="2"></td>
                                                            <td style="text-align: center;">Total</td>
                                                            <td style="text-align: center;">{{amountTotal}}</td>
                                                            <td colspan="2"></td>
                                                        </tr>
                                                        <tr ng-if="crecords.length == 0"><td colspan="5" align="center">No records found</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <span class="input-icon icon-right">
                                                    <button type="button" class="btn btn-primary custom-btn" ng-click="insertCollection(remarkData);" ng-disabled="disSubmitBtn">Submit</button>
                                                </span>
                                            </div>
                                        </div> 
                                    </tab>
                                    <tab heading="Receipts" ng-click="initRecieptTab()" disabled="!receiptTab" id="receiptTab">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group" ng-class="{ 'has-error' : receiptBtn && (!remarkForm.received_amount.$dirty && remarkForm.received_amount.$invalid)}">
                                                    <label for="">Collected Amount<span class="sp-err">*</span></label><span style="color:red;" ng-if="rexcessAmount"> {{rexcessAmount}}</span>
                                                    <span style="float: right;">Total on road amount: {{totalOnRoadAmount}}</span>
                                                    <span class="input-icon icon-right">                                        
                                                        <input type="text" ng-model="receiptData.received_amount" name="received_amount" class="form-control" ng-pattern="/^[1-9]\d*$/" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="7" ng-required="!collected" ng-change="checkPayableAmount(receiptData.received_amount)" ng-model-options="{ allowInvalid: true, debounce: 600 }">
                                                        <i class="fa fa-money" aria-hidden="true"></i>
                                                        <div ng-show="receiptBtn && !rfuncalled" ng-messages="remarkForm.received_amount.$error" class="help-block">
                                                            <div ng-message="required">Please Enter Amount</div>
                                                            <div ng-message="pattern">Please Enter Valid Amount</div>
                                                        </div>
                                                        <div class="col-sm-12" ng-if="receiptData.collection_stage_id_receipt">
                                                            <span style="float: left;font-weight: bold;">Total amount: {{totalAmount}}</span>
                                                            <span style="text-align: center;font-weight: bold;color:red;margin-left: 25%;">Pending amount: {{pendingAmount}}</span>
                                                            <span style="float: right;font-weight: bold;">Balance amount: {{balanceAmount}}</span>                                                                            
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group" ng-class="{ 'has-error' : receiptBtn && (!remarkForm.collection_stage_id_receipt.$dirty && remarkForm.collection_stage_id_receipt.$invalid)}">
                                                    <label for="">Collection Stage<span class="sp-err">*</span></label>
                                                    <span class="input-icon icon-right">
                                                        <select ng-model="receiptData.collection_stage_id_receipt" id="collection_stage_id_receipt" name="collection_stage_id_receipt" class="form-control" ng-click="getCollectionStageReceipt(receiptData.collection_stage_id_receipt.split('_')[0])" ng-required="!collected" ng-disabled="disReceiptField || disReceiptField1">
                                                            <option value="">Select</option>
                                                            <option ng-repeat="list in recieptStagesList" value="{{list.id}}_{{list.stages}}" ng-selected="{{ list.id == remarkData.collection_stage_id_receipt}}">{{list.stages}}</option>
                                                        </select>
                                                        <i class="fa fa-sort-desc"></i>                                                        
                                                    </span>
                                                    <div ng-show="receiptBtn && !rfuncalled" ng-messages="remarkForm.collection_stage_id_receipt.$error" class="help-block">
                                                        <div ng-message="required">Please Select Collection Stage</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group" ng-class="{ 'has-error' : receiptBtn && (!remarkForm.payment_date.$dirty && remarkForm.payment_date.$invalid)}">
                                                    <label for="">Payment Date<span class="sp-err">*</span></label>
                                                    <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                                        <p class="input-group">
                                                            <input type="text" ng-model="receiptData.payment_date" name="payment_date" class="form-control" datepicker-popup="dd-MM-yyyy" is-open="opened" datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly ng-required="!collected"/>
                                                            <span class="input-group-btn">
                                                                <button type="button" class="btn btn-default" ng-click="!disableDataOnEnqUpdate && openMaxDate($event)" ng-disabled="disReceiptField"><i class="glyphicon glyphicon-calendar"></i></button>
                                                            </span>
                                                        <div ng-show="receiptBtn && !rfuncalled" ng-messages="remarkForm.payment_date.$error" class="help-block">
                                                            <div ng-message="required">Please select date</div>
                                                        </div>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3" ng-controller="paymentModeCtrl">
                                                <div class="form-group" ng-class="{ 'has-error' : (receiptBtn && !rfuncalled && receiptData.payment_mode_id1 == '0') && (!remarkForm.payment_mode_id1.$dirty && remarkForm.payment_mode_id1.$invalid)}">
                                                    <label for="">Payment Mode<span class="sp-err">*</span></label>
                                                    <span class="input-icon icon-right">
                                                        <select ng-model="receiptData.payment_mode_id1" id="payment_mode_id1" name="payment_mode_id1" class="form-control" ng-required="!collected" ng-disabled="disReceiptField">
                                                            <option value="0">Select</option>
                                                            <option ng-repeat="list in paymentModeList" value="{{list.id}}_{{list.payment_mode}}" ng-selected="{{ list.id == receiptData.payment_mode_id1}}">{{list.payment_mode}}</option>
                                                        </select>
                                                        <i class="fa fa-sort-desc"></i>
                                                        <div ng-show="receiptBtn && !rfuncalled && receiptData.payment_mode_id1 == '0'" ng-messages="remarkForm.payment_mode_id1.$error" class="help-block">
                                                            <div>Please Select Payment Status</div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3" ng-show="receiptData.payment_mode_id1.split('_')[0] != '1' && receiptData.payment_mode_id1 != '0'">
                                                <div class="form-group" ng-class="{ 'has-error' : (receiptBtn && !rfuncalled) && (!remarkForm.pdc_date.$dirty && remarkForm.pdc_date.$invalid)}">
                                                    <label for="">Cheque / DD Date<span class="sp-err">*</span></label>
                                                    <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                                        <p class="input-group">
                                                            <input type="text" ng-model="receiptData.pdc_date" name="pdc_date" class="form-control" datepicker-popup="dd-MM-yyyy" is-open="opened" datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly ng-required="receiptData.payment_mode_id1 != '1' && !collected"/>
                                                            <span class="input-group-btn">
                                                                <button type="button" class="btn btn-default" ng-click="!disableDataOnEnqUpdate && open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                            </span>
                                                        <div ng-show="receiptBtn && !rfuncalled" ng-messages="remarkForm.pdc_date.$error" class="help-block">
                                                            <div ng-message="required">Please select date</div>
                                                        </div>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3" ng-show="receiptData.payment_mode_id1.split('_')[0] != '1' && receiptData.payment_mode_id1 != '0'">
                                                <div class="form-group" ng-class="{ 'has-error' : receiptBtn && (!remarkForm.transaction_number.$dirty && remarkForm.transaction_number.$invalid)}">
                                                    <label for="">UTR / REF / Cheque / DD Number</label>
                                                    <span class="input-icon icon-right">                                        
                                                        <input type="text" ng-model="receiptData.transaction_number" name="transaction_number" class="form-control">
                                                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                            </div>           
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Receipt Remarks</label>
                                                    <span class="input-icon icon-right">
                                                        <textarea class="form-control" rows="2" cols="30" ng-model="receiptData.receiptRemarks" name="receiptRemarks" maxlength="300" capitalization></textarea>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for=""></label>
                                                    <a href class="btn btn-labeled btn-primary btn-sm" ng-click="receiptBtn = true; addReceiptRow(receiptData);" style="margin-top: 25px;">
                                                        <i class="btn-sm fa fa-plus"></i>{{receiptBtnLbl}}
                                                    </a>
                                                </div>
                                            </div>                            
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                                <table class="table table-hover table-striped table-bordered collectiontbl table-responsive" at-config="config">
                                                    <thead class="bord-bot">
                                                        <tr>
                                                            <th style="width:2%;text-align: center;">SR</th>
                                                            <th style="width:20%;text-align: center;">Collection Stage</th>
                                                            <th style="width:15%;text-align: center;">Payment Date</th>
                                                            <th style="width:10%;text-align: center;">Amount</th>                        
                                                            <th style="width:15%;text-align: center;">Payment Mode</th>  
                                                            <th style="width:20%;text-align: center;">Transaction Status</th>  
                                                            <th style="width:10%;text-align: center;">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr role="row" ng-repeat="rec in receiptRecords track by $index">
                                                            <td style="text-align: center;">{{ $index + 1}}</td>
                                                            <td style="text-align: center;">{{ rec.collection_stage_id_receipt | split:'_':1}}</td>
                                                            <td style="text-align: center;">{{ rec.payment_date | date:"dd-MM-yyyy"}}</td>
                                                            <td style="text-align: center;">{{ rec.received_amount}}</td>
                                                            <td style="text-align: center;">{{ rec.payment_mode_id1 | split:'_':1 }}</td>
                                                            <td style="text-align: center;">{{ rec.transaction_status_id | split:'_':1 }}</td>
                                                            <td class="fa-div">
                                                                <div class="fa-hover" tooltip-html-unsafe="Edit Receipt" ng-hide="rec.id && (rec.transaction_status_id == '3_Credited' || rec.transaction_status_id == '4_Rejected')">
                                                                    <a href><i class="fa fa-pencil" ng-click="editReceiptIndex(rec)"></i></a> &nbsp;&nbsp;</div>
                                                                <div class="fa-hover" tooltip-html-unsafe="Delete Receipt" style="display: block;" ng-click="deleteReceiptIndex(rec)" ng-hide="rec.id && (rec.transaction_status_id == '3_Credited' || rec.transaction_status_id == '4_Rejected')">
                                                                    <a href><i class="fa fa-trash-o"></i></a> &nbsp;&nbsp;</div>
                                                            </td>
                                                        </tr>
                                                        <tr ng-if="receiptRecords.length > 0">
                                                            <td colspan="2"></td>
                                                            <td style="text-align: center;">Total</td>
                                                            <td style="text-align: center;">{{receiptAmountTotal}}</td>
                                                            <td colspan="3"></td>
                                                        </tr>
                                                        <tr ng-if="receiptRecords.length == 0"><td colspan="7" align="center">No records found</td></tr>
                                                    </tbody>
                                                </table>                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <span class="input-icon icon-right">
                                                    <button type="button" class="btn btn-primary custom-btn" ng-click="insertReciept(receiptData)" ng-disabled="receiptSbtBtn">Submit</button>
                                                </span>
                                            </div>
                                        </div> 
                                    </tab>-->
                                </tabset>

                                <div ng-if="remarkData.sales_status_id != 3"><br><br><br></div>
                                <div class="content1" id="footerContent" ng-show="remarkData.sales_status_id != 3">
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-12">
                                            <div class="row" ng-if="remarkData.sales_status_id != 3 && remarkData.sales_status_id != 4">
                                                <div class="col-sm-12 col-lg-12">
                                                    <div class="timeline-unit"> Remark through </div>
                                                    <a href ng-click="text()" class="atext"><img src="/images/text_blue.png" tooltip-placement="bottom" tooltip="Enter Remark" class="imgcls"/></a><span class="checkLost" ng-show="mobileList.length > 0 || mobileIcon">&nbsp; OR &nbsp;</span>
                                                    <a href ng-click="sms()" class="checkLost asms" ng-show="mobileList.length > 0 || mobileIcon"><img src="/images/sms_blue.png" tooltip-placement="bottom" tooltip="Send SMS" class="imgcls"/></a><span ng-show="emailList.length > 0 || emailIcon" class="checkLost">&nbsp; OR &nbsp;</span>
                                                    <a href ng-click="email()" class="checkLost aemail" ng-show="emailList.length > 0"><img src="/images/mail_blue.png" tooltip-placement="bottom" tooltip="Send Email" class="imgcls"/></a>
                                                </div>
                                            </div>
                                            <div class="row" class="overlay">
                                                <div class="col-sm-12 col-lg-12">
                                                    <div class="row mod-sh-div" ng-show="divText">
                                                        <div class="col-sm-12">
                                                            <div id="divMyTags"><br>
                                                                <label for="" ng-if="remarkData.sales_status_id != 4">Today's Remarks<span class="sp-err" >*</span></label>
                                                                <label for="" ng-if="remarkData.sales_status_id == 4">Lost Remarks<span class="sp-err" >*</span></label>
                                                                <div class="existingTag bordered-themeprimary">
                                                                    <div class="col-sm-12 csspadding">
                                                                        <div class="form-group">
                                                                            <span class="input-icon icon-right">
                                                                                <textarea class="form-control" rows="5" cols="50" ng-model="remarkData.textRemark" name="textRemark" ng-required="divText" capitalization></textarea>
                                                                            </span>
                                                                            <div ng-show="sbtBtn" ng-messages="remarkForm.textRemark.$error" class="help-block">
                                                                                <div ng-message="required">This field is required</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">   
                                                            @if (strpos(Auth::guard('admin')->user()->employee_submenus,'"040501"'))
                                                            <div class="col-sm-6">
                                                                <div class="form-group" style="float: left;margin-right: 30px;">
                                                                    <label for="">SMS Privacy Status</label>    
                                                                    <span class="fa fa-toggle-on toggleClassActive" ng-if="remarkData.sms_privacy_status === 1" ng-click="changeSmsPrivacyStatus(0);"></span>
                                                                    <span class="fa fa-toggle-on toggleClassActive fa-rotate-180 toggleClassInactive" ng-if="remarkData.sms_privacy_status === 0" ng-click="changeSmsPrivacyStatus(1);"></span>
                                                                </div>
                                                                <div class="form-group" style="float: left;">
                                                                    <label for="">Email Privacy Status</label>
                                                                    <span class="fa fa-toggle-on toggleClassActive" ng-show="remarkData.email_privacy_status === 1" ng-click="changeEmailPrivacyStatus(0);"></span>
                                                                    <span class="fa fa-toggle-on toggleClassActive fa-rotate-180 toggleClassInactive" ng-show="remarkData.email_privacy_status === 0" ng-click="changeEmailPrivacyStatus(1);"></span>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            <div class="col-sm-6">
                                                                <button type="submit" class="btn btn-primary custom-btn" ng-click="sbtBtn = true" ng-disabled="disableRemarkSbt">Submit</button>
                                                            </div> 
                                                        </div>
                                                    </div>

                                                    <div class="row mod-sh-div" ng-show="divSms">
                                                        <div class="col-sm-12">
                                                            <div id="divMyTags"><br>
                                                                <label for="">Send / Schedule SMS</label>
                                                                <div class="existingTag bordered-themeprimary" style="padding: 10px 0px 0px 0px;">   
                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label for="">Select mobile number <span class="sp-err">*</span></label>
                                                                            <div class="control-group" ng-style="{'overflow-y': mobileList.length > 2 ? 'scroll' : 'none'}" style="height: 75px;"> 
                                                                                <div class="checkbox" ng-repeat="mlist in mobileList track by $index">
                                                                                    <label>
                                                                                        <input type="checkbox" ng-model="mobile_number" name="mobile_number" ng-change="checkedMobileNo(mlist, $index)" value="{{mlist}}" id="mob_{{$index}}" class="clsMobile" ng-required="mobile_number.length == 0 && divSms">
                                                                                        <span class="text" ng-if="displayMobile == '1'">xxxxxx{{ mlist.substring(mlist.length - 4, mlist.length)}}</span>
                                                                                        <span class="text" ng-if="displayMobile != '1'">{{ mlist}}</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div><br/><br/>
                                                                        <div ng-show="sbtBtn1" ng-messages="remarkForm.mobile_number.$error" class="help-block">
                                                                            <div ng-message="required">This field is required</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-group">
                                                                            <label for="">Remark <span class="sp-err">*</span></label>
                                                                            <span class="input-icon icon-right">
                                                                                <textarea class="form-control" rows="4" ng-model="remarkData.msgRemark" name="msgRemark" ng-required="divSms" capitalization></textarea>
                                                                            </span>
                                                                            <div ng-show="sbtBtn1" ng-messages="remarkForm.msgRemark.$error" class="help-block">
                                                                                <div ng-message="required">This field is required</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12"> 
                                                            @if (strpos(Auth::guard('admin')->user()->employee_submenus,'"040501"'))
                                                            <div class="col-sm-6">
                                                                <div class="form-group" style="float: left;margin-right: 30px;">
                                                                    <label for="">SMS Privacy Status</label>
                                                                    <span class="fa fa-toggle-on toggleClassActive" ng-if="remarkData.sms_privacy_status === 1" ng-click="changeSmsPrivacyStatus(0);"></span>
                                                                    <span class="fa fa-toggle-on toggleClassActive fa-rotate-180 toggleClassInactive" ng-if="remarkData.sms_privacy_status === 0" ng-click="changeSmsPrivacyStatus(1);"></span>
                                                                </div>
                                                                <div class="form-group" style="float: left;">
                                                                    <label for="">Email Privacy Status</label>
                                                                    <span class="fa fa-toggle-on toggleClassActive" ng-if="remarkData.email_privacy_status === 1" ng-click="changeEmailPrivacyStatus(0);"></span>
                                                                    <span class="fa fa-toggle-on toggleClassActive fa-rotate-180 toggleClassInactive" ng-if="remarkData.email_privacy_status === 0" ng-click="changeEmailPrivacyStatus(1);"></span>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            <div class="col-sm-6">
                                                                <button type="submit" class="btn btn-primary custom-btn" ng-click="[sbtBtn1 = true, sbtBtn = true]" ng-disabled="disableRemarkSbt">Schedule For Later</button>
                                                                <button type="submit" class="btn btn-primary custom-btn" ng-click="[sbtBtn1 = true, sbtBtn = true]" ng-disabled="disableRemarkSbt">Send Now</button>
                                                            </div> 
                                                        </div> 

                                                    </div>

                                                    <div class="row mod-sh-div" ng-show="divEmail">
                                                        <div class="col-sm-12 csspadding">
                                                            <div id="divMyTags">
                                                                <label for="">Send / Schedule Email</label>
                                                                <div class="existingTag bordered-themeprimary csspadding">
                                                                    <div class="row">                                                    
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label>Select email id<span class="sp-err">*</span></label>
                                                                                <div class="control-group" ng-style="{'overflow-y': emailList.length > 2 ? 'scroll' : 'none'}" style="height: 65px;">
                                                                                    <div class="checkbox" ng-repeat="elist in emailList track by $index">
                                                                                        <label ng-if="elist != 'null' && elist != ''">
                                                                                            <input type="checkbox" ng-model="email_id" name="email_id" ng-change="checkedEmailId(elist, $index)" value="{{elist}}" id="email_{{$index}}" class="clsEmail" ng-required="email_id_arr.length == 0 && divEmail">
                                                                                            <span class="text" ng-if="displayEmail != '1'">{{elist}}</span>
                                                                                            <span class="text" ng-if="displayEmail == '1'">{{elist | emailHider}}</span>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div ng-show="sbtBtn2" ng-messages="remarkForm.email_id.$error" class="help-block">
                                                                                <div ng-message="required">This field is required</div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label for="">Subject<span class="sp-err">*</span></label>
                                                                                <span class="input-icon icon-right">
                                                                                    <input type="text" ng-model="remarkData.subject" name="subject" class="form-control" ng-required="divEmail">
                                                                                </span>
                                                                                <div ng-show="sbtBtn2" ng-messages="remarkForm.subject.$error" class="help-block">
                                                                                    <div ng-message="required">This field is required</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">                                                    
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group">
                                                                                <label for="">Mail Content<span class="sp-err">*</span></label>
                                                                                <span class="input-icon icon-right">
                                                                                    <div class="widget flat radius-bordered" style="margin: 0 0 -15px 0 !important;">
                                                                                        <div class="widget-body no-padding">   
                                                                                            <div class="form-group">
                                                                                                <div text-angular name="email_content" ng-model="remarkData.email_content" ta-text-editor-class="editor-text form-control myform1-height" ta-html-editor-class="editor-text form-control myform1-height" ng-required="divEmail" style="height: 130px;"></div>
                                                                                            </div>                                                                        
                                                                                        </div>
                                                                                    </div>
                                                                                </span>
                                                                                <div ng-show="sbtBtn2" ng-messages="remarkForm.email_content.$error" class="help-block">
                                                                                    <div ng-message="required">This field is required</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12"> 
                                                            @if (strpos(Auth::guard('admin')->user()->employee_submenus,'"040501"'))
                                                            <div class="col-sm-6">
                                                                <div class="form-group" style="float: left;margin-right: 30px;">
                                                                    <label for="">SMS Privacy Status</label>
                                                                    <span class="fa fa-toggle-on toggleClassActive" ng-if="remarkData.sms_privacy_status === 1" ng-click="changeSmsPrivacyStatus(0);"></span>
                                                                    <span class="fa fa-toggle-on toggleClassActive fa-rotate-180 toggleClassInactive" ng-if="remarkData.sms_privacy_status === 0" ng-click="changeSmsPrivacyStatus(1);"></span>
                                                                </div>
                                                                <div class="form-group" style="float: left;">
                                                                    <label for="">Email Privacy Status</label>
                                                                    <span class="fa fa-toggle-on toggleClassActive" ng-if="remarkData.email_privacy_status === 1" ng-click="changeEmailPrivacyStatus(0);"></span>
                                                                    <span class="fa fa-toggle-on toggleClassActive fa-rotate-180 toggleClassInactive" ng-if="remarkData.email_privacy_status === 0" ng-click="changeEmailPrivacyStatus(1);"></span>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            <div class="col-sm-6">
                                                                <button type="submit" class="btn btn-primary custom-btn" ng-disabled="disableRemarkSbt">Schedule For Later</button>
                                                                <button type="submit" class="btn btn-primary custom-btn" ng-click="[sbtBtn2 = true, sbtBtn = true]" ng-disabled="disableRemarkSbt">Send Now</button>
                                                            </div> 
                                                        </div> 
                                                    </div>   
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </form>                           
                        </div>
                    </div>
                </tab>
                @if (strpos(Auth::guard('admin')->user()->employee_submenus,'"040501"'))
                <tab heading="Customer Details" ng-click="getTodayRemarkCustomerModal(remarkData.customerId)" id="customerTab">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="form-title">
                            Personal Details
                        </div>
                    </div>
                    <form novalidate role="form" ng-submit="customerForm.$valid && updateTodayRemarkCustomerModal(customerData, customerContacts, remarkData.customerId, '')" name="customerForm">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group" ng-class="{ 'has-error' : csbtBtn && (!customerForm.title_id.$dirty && customerForm.title_id.$invalid)}">
                                    <label for="">Title <span class="sp-err">*</span> </label>
                                    <span class="input-icon icon-right">
                                        <select ng-model="customerData.title_id" ng-controller="titleCtrl" name="title_id" class="form-control" required>
                                            <option value="">Select</option>
                                            <option ng-repeat="t in titles track by $index" value="{{t.id}}" ng-selected="{{ t.id == customerData.title_id}}">{{t.title}}</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                        <div ng-show="csbtBtn" ng-messages="customerForm.title_id.$error">
                                            <div ng-message="required" style="color: red !important;">This field is required</div>
                                        </div> 
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group" ng-class="{ 'has-error' : csbtBtn && (!customerForm.first_name.$dirty && customerForm.first_name.$invalid)}">
                                    <label for="">First Name<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="customerData.first_name" name="first_name" capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')" maxlength="15" required>
                                        <i class="fa fa-user"></i>
                                        <div ng-show="csbtBtn" ng-messages="customerForm.first_name.$error" class="help-block">
                                            <div ng-message="required" style="color: red !important;">This field is required</div>
                                        </div> 
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Middle Name </label>
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="customerData.middle_name" name="middle_name" capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')" maxlength="15">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group" ng-class="{ 'has-error' : csbtBtn && (!customerForm.last_name.$dirty && customerForm.last_name.$invalid)}">
                                    <label for="">Last Name<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="customerData.last_name" name="last_name" capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')" maxlength="15" required>
                                        <i class="fa fa-user"></i>
                                        <div ng-show="csbtBtn" ng-messages="customerForm.last_name.$error" class="help-block">
                                            <div ng-message="required" style="color: red !important;">This field is required</div>
                                        </div> 
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group" ng-class="{ 'has-error' : csbtBtn && (!customerForm.gender_id.$dirty && customerForm.gender_id.$invalid)}">
                                    <label for="">Gender <span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select ng-model="customerData.gender_id" name="gender_id" ng-controller="genderCtrl" class="form-control" required>
                                            <option value="">Select</option>
                                                <option ng-repeat="genderList in genders" value="{{genderList.id}}" ng-selected="{{ genderList.id == customerData.gender_id}}">{{genderList.gender}}</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                        <div ng-if="gender_id" class="errMsg">{{gender_id}}</div>
                                        <div ng-show="csbtBtn" ng-messages="customerForm.gender_id.$error" class="help-block">
                                            <div ng-message="required" style="color: red !important;">This field is required</div>
                                        </div> 
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Birth Date</label>
                                    <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                        <p class="input-group">
                                            <input type="text" ng-model="customerData.birth_date" name="birth_date" id="birth_date" class="form-control" datepicker-popup="dd-MM-yyyy" is-open="opened" max-date="maxDate" datepicker-options="dateOptions" close-text="Close" readonly/>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" ng-click="open($event, 3)"><i class="glyphicon glyphicon-calendar"></i></button>
                                            </span>
                                        </p>
                                    </div>     
                                </div>
                            </div>                        
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Marriage Date</label>
                                    <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                        <p class="input-group">
                                            <input type="text" ng-model="customerData.marriage_date" name="marriage_date" id="marriage_date" class="form-control" datepicker-popup="dd-MM-yyyy" max-date="dt" is-open="opened" datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly />
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" ng-click="open($event, 3)"><i class="glyphicon glyphicon-calendar"></i></button>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Profession</label>
                                    <span class="input-icon icon-right">
                                        <select class="form-control" ng-model="customerData.profession_id" name="profession_id" ng-controller="professionCtrl">
                                            <option value="">Select Profession</option>
                                            <option ng-repeat="t in professions track by $index" value="{{t.id}}" ng-selected="{{ t.id == customerData.profession_id}}">{{t.profession}}</option>
                                        </select>                
                                        <i class="fa fa-sort-desc"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">PAN Number</label>
                                    <span class="input-icon icon-right">
                                        <input type="text" ng-model="customerData.pan_number" name="pan_number" class="form-control" maxlength="10" ng-pattern="/^[A-Za-z]{5}\d{4}[A-Za-z]{1}$/">
                                    </span>
                                    <span ng-show="customerForm.pan_number.$error.pattern" style="color: red !important;">Invalid pan number</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Aadhar Number</label>
                                    <span class="input-icon icon-right">
                                        <input type="text" ng-model="customerData.aadhar_number" name="aadhar_number" class="form-control" maxlength="12" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div ng-controller="currentCountryListCtrl">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="">Address of</label>       
                                        <span class="input-icon icon-right">
                                            <select ng-model="customerContacts.address_type" name="address_type" class="form-control">
                                                <option value="">Select Type</option>
                                                <option value="1">Personal</option>
                                                <option value="2">Office</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">House / Flat Number</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="customerContacts.house_number" name="house_number"  maxlength="4"  oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" class="form-control date-picker">
                                            <i class="fa fa-home"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">House / Building Name</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="customerContacts.building_house_name" name="building_house_name" maxlength="25" capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')"  class="form-control">
                                            <i class="fa fa-building-o"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <span class="input-icon icon-right">
                                            <label for="">Colony / Wing Name</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="customerContacts.wing_name" name="wing_name" maxlength="25" capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')" class="form-control">
                                                <i class="fa fa-building-o"></i>
                                            </span> 
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">Area Name</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="customerContacts.area_name" name="area_name" maxlength="25" capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')" class="form-control">
                                            <i class="fa fa-building-o"></i>
                                        </span>                                      
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">                                            
                                        <label for="">Lane Name</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="customerContacts.lane_name" name="lane_name" maxlength="15" class="form-control date-picker">
                                            <i class="fa fa-building-o"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">Landmark</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="customerContacts.landmark" name="landmark" maxlength="25" capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')" class="form-control">
                                            <i class="fa fa-building-o"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">Pin</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="customerContacts.pin" name="pin" maxlength="6" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                            <i class="fa fa-compass" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">Country</label>
                                        <span class="input-icon icon-right">
                                            <select ng-change="onCountryChange()" ng-model="customerContacts.country_id" name="country_id" id="current_country_id" class="form-control">
                                                <option value="">Select Country</option>
                                                <option ng-repeat="country in countryList" value="{{country.id}}" ng-selected="{{ country.id == contactData.country_id}}">{{country.name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">State</label>                                                
                                        <span class="input-icon icon-right">
                                            <select ng-model="customerContacts.state_id" ng-change="onStateChange()" name="state_id" id="current_state_id" class="form-control">
                                                <option value="">Select State</option>
                                                <option ng-repeat="state in stateList" value="{{state.id}}" ng-selected="{{ state.id == contactData.state_id}}">{{state.name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">City</label>
                                        <span class="input-icon icon-right">
                                            <select ng-model="customerContacts.city_id" name="city_id" id="current_city_id" class="form-control">
                                                <option value="">Select City</option>
                                                <option ng-repeat="city in cityList" value="{{city.id}}" ng-selected="{{ city.id == contactData.city_id}}">{{city.name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for=""></label>
                                        <span class="input-icon icon-right">
                                            <button type="submit" class="btn btn-primary custom-btn" ng-click="csbtBtn = true;">Update</button>
                                        </span>
                                    </div>
                                </div>
                            </div>                        
                        </div>  
                    </form>
                </tab>
                @endif
                <tab heading="Enquiry History" ng-click="initHistoryDataModal(remarkData.enquiryId,{{initmoduelswisehisory}}, 1)" id="historyTab">
                    <div class="modal-body"> 
                        <div>
                            <label>
                                <input type="checkbox" name="chk_enquiry_history_remark" ng-click="getModulesWiseHist_remark(history_enquiryId, 1, 'todayremarkFlag')" checked  id="chk_enquiry_history_remark">
                                <span class="text">All</span>
                            </label>
                            &nbsp;&nbsp;
                            <label>
                                <input type="checkbox"  ng-click="getModulesWiseHist_remark(history_enquiryId, 0, 'todayremarkFlag')" data-id="1" checked class="chk_followup_history_all_remark" id="chk_presales_remark">
                                <span class="text">Pre Sales</span>
                            </label>
                            &nbsp;&nbsp;
                            <label>
                                <input type="checkbox"  ng-click="getModulesWiseHist_remark(history_enquiryId, 0, 'todayremarkFlag')" data-id="2" checked  class="chk_followup_history_all_remark" id="chk_Customer_Care_remark">
                                <span class="text">Customer Care</span>
                            </label>
                            <hr class="enq-hr-line">           
                            1) <span>PS = Pre Sales</span> &nbsp;&nbsp;2) <span>CC = Customer Care</span>            
                            <hr class="enq-hr-line">    
                        </div>

                        <div style="height: auto;max-height: 605px;margin-top: 0px;    overflow-x: hidden;overflow-y: scroll;">
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
                                <tbody ng-repeat="history in historyList track by $index | filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
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
                    <style>
                        .errMsg{
                            color:red;
                        }
                    </style>

                </tab>
            </tabset>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
    $("a#gotoCustomerTab").on("click", function () {
    $("li#remarkTab").removeClass('active');
    $("li#customerTab").addClass('active');
    $("li#customerTab a").trigger('click');
    });
    $(".modal-footer").hide();
    });</script>