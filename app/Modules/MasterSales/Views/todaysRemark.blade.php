<style>
    .toggleClassActive{
        font-size: 40px !important;
        cursor: pointer;
        color: #5cb85c !important;
        vertical-align: middle;
        margin-left: 5px;
    }
    .imgcls{
        width:40px;
        border-radius: 50%;
        -webkit-filter: drop-shadow(0 0 3px #00415d);
        filter: drop-shadow(0 0 0 2px #00415d);
    }
    .ta-editor.form-control.myform1-height, .ta-scroll-window.form-control.myform1-height  {
        min-height: 100px;
        height: auto;
        overflow: auto;
        font-family: inherit;
        font-size: 100%;
    }

    .form-control.myform1-height > .ta-bind {
        height: auto;
        min-height: 100px;
        padding: 6px 12px;
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
        height: 338px;
        bottom: -280px;
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
        height: 487px;
        bottom: -420px;
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
</style>

<div class="modal-body">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <tabset>
                <tab heading="Today Remarks" id="remarkTab">
                    
                </tab>
                <tab heading="Customer Details" ng-click="getTodayRemarkCustomerModal(remarkData.customerId)" id="customerTab">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="form-title">
                            Personal Details
                        </div>
                    </div>
                    <form novalidate role="form" ng-submit="customerForm.$valid && updateTodayRemarkCustomerModal(customerData, customerContacts, remarkData.customerId)" name="customerForm">
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
                                <div class="form-group" ng-class="{ 'has-error' : csbtBtn && (!customerForm.birth_date.$dirty && customerForm.birth_date.$invalid)}">
                                    <label for="">Birth Date<span class="sp-err">*</span></label>
                                    <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                        <p class="input-group">
                                            <input type="text" ng-model="customerData.birth_date" name="birth_date" id="birth_date" class="form-control" datepicker-popup="{{format}}" is-open="opened" max-date="maxDates" datepicker-options="dateOptions" close-text="Close" readonly/>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" ng-click="open($event,3)"><i class="glyphicon glyphicon-calendar"></i></button>
                                            </span>
                                        </p>
                                    </div>             
                                    <div ng-show="csbtBtn" ng-messages="customerForm.birth_date.$error" class="help-block">
                                        <div ng-message="required" style="color: red !important;">This field is required</div>
                                    </div> 
                                </div>
                            </div>                        
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Marriage Date</label>
                                    <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                        <p class="input-group">
                                            <input type="text" ng-model="customerData.marriage_date" name="marriage_date" id="marriage_date" class="form-control" datepicker-popup="{{format}}" is-open="opened" max-date="maxDates" datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly />
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" ng-click="open($event,3)"><i class="glyphicon glyphicon-calendar"></i></button>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group" ng-class="{ 'has-error' : csbtBtn && (!customerForm.profession_id.$dirty && customerForm.profession_id.$invalid)}">
                                    <label for="">Profession<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select class="form-control" ng-model="customerData.profession_id" name="profession_id" ng-controller="professionCtrl" required>
                                            <option value="">Select Profession</option>
                                            <option ng-repeat="t in professions track by $index" value="{{t.id}}" ng-selected="{{ t.id == customerData.profession_id}}">{{t.profession}}</option>
                                        </select>                
                                        <i class="fa fa-sort-desc"></i>
                                        <div ng-show="csbtBtn" ng-messages="customerForm.profession_id.$error" class="help-block">
                                            <div ng-message="required" style="color: red !important;">This field is required</div>
                                        </div> 
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">PAN Number</label>
                                    <span class="input-icon icon-right">
                                        <input type="text" ng-model="customerData.pan_number" name="pan_number" maxlength="10" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Aadhar Number</label>
                                    <span class="input-icon icon-right">
                                        <input type="text" ng-model="customerData.aadhar_number" name="aadhar_number" maxlength="12" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
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
                                                <option value="1">Home</option>
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
                                            <input type="text" ng-model="customerContacts.area_name" name="area_name" maxlength="25" capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')" class="form-control date-picker">
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
                                            <input type="text" ng-model="customerContacts.landmark" name="landmark" maxlength="25" capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')" class="form-control date-picker">
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
                                            <button type="submit" class="btn btn-primary custom-btn" ng-click="csbtBtn = true">Update</button>
                                        </span>
                                    </div>
                                </div>
                            </div>                        
                        </div>  
                    </form>
                </tab>
                <tab heading="Enquiry History" ng-click="initHistoryDataModal(remarkData.enquiryId)" id="historyTab">
                    <div data-ng-include=" '/MasterSales/enquiryHistory'"></div>
                </tab>
            </tabset>
        </div>
    </div>
</div>