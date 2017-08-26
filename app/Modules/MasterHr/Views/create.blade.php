<style>
    .actions {
        z-index: 0 !important;
    }
    .help-block {
        margin-top: 0px !important; 
        margin-bottom: 0px !important; 
        color: #e46f61;
    }
    textarea {
        resize: none;
    }
</style>
<input type="hidden" ng-model="userForm.csrfToken" name="csrftoken" id="csrftoken" ng-init="userForm.csrfToken = '<?php echo csrf_token(); ?>'"  class="form-control">
<input type="hidden" ng-model="userData.id" name="id" id="empId" ng-init="userForm.id = '[[ $empId ]]'" value="[[ $empId ]]" class="form-control">
<div class="row" >
    <input type="hidden" name="employeeId" id="employeeId"  value="[[$empId]]" >
    <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="hrController" >
        <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>New User</h5>
        <div id="WiredWizard" class="wizard wizard-wired" data-target="#WiredWizardsteps">
            <ul class="steps">
                <li  class="wiredstep1 active"><span class="step">1</span><span class="title">Personal Information</span><span class="chevron"></span></li>
                <li  class="wiredstep2"><span class="step btn-nxt1">2</span><span class="title">Contact Information</span> <span class="chevron"></span></li>
                <li  class="wiredstep3"><span class="step btn-nxt2">3</span><span class="title">Educational & Other Details</span> <span class="chevron"></span></li>
                <li  class="wiredstep4"><span class="step btn-nxt3">4</span><span class="title">Job Offer Details</span> <span class="chevron"></span></li>
                <li  class="wiredstep5"><span class="step btn-nxt4">5</span><span class="title">User status</span> <span class="chevron"></span></li>
            </ul>
        </div>
        <div class="step-content" id="WiredWizardsteps"  >
            <div class="step-pane active" id="wiredstep1" >
                <form name="userForm" novalidate ng-submit="userForm.$valid && createUser(userData, [[ $empId ]])" ng-controller="hrController" ng-init="manageUsers([[ !empty($empId) ?  $empId : '0' ]], 'edit', 1, [[config('global.recordsPerPage')]]);">
                    <input type="hidden" name="employeeId" ng-model="employeeId" value="{{employeeId}}" >
                    <div class="form-title">Personal Information</div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step1 && (!userForm.title_id.$dirty && userForm.title_id.$invalid)}">
                                <label for="">Title <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select ng-model="userData.title_id" ng-controller="titleCtrl" name="title_id" class="form-control" required="required">
                                        <option value="">Select Title</option>
                                        <option ng-repeat="t in titles track by $index" value="{{t.id}}" ng-selected="{{ t.id == userData.title_id}}">{{t.title}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <div ng-show="step1" ng-messages="userForm.title_id.$error" class="help-block step1">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step1 && (!userForm.first_name.$dirty && userForm.first_name.$invalid)}">
                                <label for="">First Name <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="userData.first_name" name="first_name" class="form-control"  capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')"    maxlength="15" required>
                                    <i class="fa fa-user"></i>
                                    <div ng-show="step1" ng-messages="userForm.first_name.$error" class="help-block step1">
                                        <div ng-message="required">This field is required.</div>
                                        <div ng-message="maxlength">Maximum 15 Character are Allowed.</div> 
                                    </div>
                                </span>                                
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Middle Name</label>
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="userData.middle_name" name="middle_name" class="form-control" capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')" maxlength="15">
                                    <i class="fa fa-user"></i>

                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step1 && (!userForm.last_name.$dirty && userForm.last_name.$invalid)}">
                                <label for="">Last Name <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="userData.last_name" name="last_name" class="form-control"  maxlength="15" capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')"  maxlength="15"  required>
                                    <i class="fa fa-user"></i>
                                    <div ng-show="step1" ng-messages="userForm.last_name.$error" class="help-block step1">
                                        <div ng-message="required">This field is required.</div>
                                        <div ng-message="maxlength">Maximum 15 Character are Allowed.</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-sm-3 col-xs-6">
                            <label>Birth Date </label>
                            <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                <p class="input-group">
                                    <input type="text" ng-model="userData.birth_date" name="date_of_birth" id="date_of_birth" max-date="maxDates" class="form-control" datepicker-popup="{{format}}" is-open="opened"  datepicker-options="dateOptions" close-text="Close" readonly />
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" ng-click="open($event,1)"><i class="glyphicon glyphicon-calendar"></i></button>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step1 && (!userForm.gender_id.$dirty && userForm.gender_id.$invalid)}">
                                <label for="">Gender <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select ng-model="userData.gender_id" ng-controller="genderCtrl" name="gender_id" class="form-control" required>
                                        <option value="">Select Gender</option>
                                        <option ng-repeat="genderList in genders track by $index" value="{{genderList.id}}" ng-selected="{{ genderList.id == userData.gender_id}}">{{genderList.gender}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <div ng-show="step1" ng-messages="userForm.gender_id.$error" class="help-block step1">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step1 && (!userForm.physic_status.$dirty && userForm.physic_status.$invalid)}">
                                <label for="">Physic  <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right" required>
                                    <select ng-model="userData.physic_status" name="physic_status" class="form-control"   placeholder="Select Physic"   required>
                                        <option value="">Select Physic Status</option>
                                        <option value="1">Normal</option>
                                        <option value="2">Handicap</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <div ng-show="step1" ng-messages="userForm.physic_status.$error" class="help-block step1">
                                        <div ng-message="required">This field is required.</div>
                                    </div>                                
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6"  ng-if="userData.physic_status == 2">
                            <div class="form-group">
                                <label for="">Physic  Description</label>
                                <span class="input-icon icon-right">
                                    <textarea ng-model="userData.physic_desc" name="physic_desc"  class="form-control" maxlength="50"  ></textarea>
                                </span>
                            </div>
                        </div>                        
                    </div>
                    <div class="row"> 
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step1 && (!userForm.blood_group_id.$dirty && userForm.blood_group_id.$invalid)}">
                                <label for="">Blood Group </label>
                                <span class="input-icon icon-right">
                                    <select ng-model="userData.blood_group_id" ng-controller="bloodGroupCtrl" name="blood_group_id" class="form-control" >
                                        <option value="">Select Blood Group</option>
                                        <option ng-repeat="bloodGroup in bloodGroups track by $index" value="{{bloodGroup.id}}" ng-selected="{{ bloodGroup.id == userData.blood_group_id}}">{{bloodGroup.blood_group}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>

                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step1 && (userForm.marital_status.$invalid)}">
                                <label for="">Marital Status <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select ng-model="userData.marital_status" name="marital_status" id="marital_status" class="form-control" required>
                                        <option value="">Select Marital Status</option>
                                        <option value="1">Single</option>
                                        <option value="2">Married</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <div ng-show="step1" ng-messages="userForm.marital_status.$error" class="help-block step1">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6" ng-if="userData.marital_status == 2">
                            <div class="form-group" ng-class="{ 'has-error' : step1 && (!userForm.marriage_date.$dirty && userForm.marriage_date.$invalid)}">
                                <label>Marriage Date</label>
                                <div ng-controller="DatepickerDemoCtrl">
                                    <p class="input-group">

                                        <input type="text" ng-model="userData.marriage_date" name="marriage_date" class="form-control" datepicker-popup="dd-MM-yyyy" is-open="opened" max-date='dt' datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly />
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>                                                
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="right">
                            <button type="submit" class="btn btn-primary btn-nxt1"  ng-click="step1 = true; getStepDiv(1, [[$empId]])"  >Next</button>
                        </div>
                    </div>
                </form>
            </div>	
            <div class="step-pane" id="wiredstep2" >	
                 <form name="userContactForm" novalidate ng-submit="userContactForm.$valid && contact && createContactForm(userContact, [[$empId]])"   >
                    <div class="form-title">
                        Contact Information
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div class="row">
                                <div class="col-sm-2 col-xs-2">
                                    <div class="form-group" >
                                        <label for="">Calling code</label>
                                        <span class="input-icon icon-right"> 
                                            <input type="text" disabled ng-model="userContact.personal_mobile1_calling_code" style="width:110px; height:34px;" name="personal_mobile1_calling_code"  id="personal_mobile1_calling_code" class="form-control" >
                                           
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (!userContactForm.personal_mobile1.$dirty && userContactForm.personal_mobile1.$invalid)}">
                                        <label for="">Personal Mobile Number<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right1"> 
                                            <input type="text" ng-model="userContact.personal_mobile1" ng-minlength="10" style="margin-left: -24px;" maxlength="10"  oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" name="personal_mobile1" check-unique-mobiles id="personal_mobile1" class="form-control"  ng-model-options="{ allowInvalid: true, debounce: 300 }" ng-change="copyToUsername(userContact.personal_mobile1); validateMobile(userContact.personal_mobile1); uniqueMobile" required>
                                            <i class="fa fa-phone"></i>
                                            <div ng-show="step2 || errPersonalMobile" ng-messages="userContactForm.personal_mobile1.$error" class="help-block step2 {{ applyClassPMobile}}">
                                                <div ng-message="required">This field is required.</div>
                                                <div ng-message="minlength">Personal mobile no. must be 10 digits</div>
                                                <div ng-message="pattern">Mobile number should be 10 digits and pattern should be for ex. +91-9999999999</div>
                                                <div ng-message="uniqueMobile">Number already exists enter different number</div>
                                                <div>{{ errPersonalMobile}}</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-sm-2 col-xs-2">
                                    <div class="form-group">
                                        <label for="">Country code</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" disabled ng-model="userContact.office_mobile_calling_code" style="width:110px; height:34px;"  name="office_mobile_calling_code" id="office_mobile_calling_code" class="form-control" placeholder="+91-">
                                        </span>                               
                                    </div> 
                                </div> 
                                <div class="col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <label for="">Office Mobile Number</label>
                                        <span class="input-icon icon-right1">
                                            <input type="text" ng-model="userContact.office_mobile_no" maxlength="10" style="margin-left: -25px; " ng-minlength="10" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  name="office_mobile_no" id="office_mobile_no" class="form-control"  ng-model-options="{ updateOn: 'blur' }" ng-change="validateOfficeMobileNumber(userContact.office_mobile_no, 'errOfficeNOMobile')">
                                            <i class="fa fa-phone"></i>
                                            <div ng-show="step2 || errOfficeMobile || errOfficeNOMobile" ng-messages="userContactForm.office_mobile_no.$error" class="help-block step2 {{ applyOfficeClassMobile}}">
                                                <div ng-message="minlength">Office Mobile Number must be 10 digits</div>
                                                <div>{{ errOfficeMobile}}</div>
                                                <div>{{ errOfficeNOMobile}}</div>
                                            </div>
                                        </span>                               
                                    </div> 
                                </div> 
                            </div> 
                            <div class="row">                            
                                <div class="col-sm-2 col-xs-2">
                                    <div class="form-group">
                                        <label for="">Country code</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" disabled ng-model="userContact.personal_mobile2_calling_code" style="width:110px; height:34px;" name="personal_mobile2_calling_code" id="personal_mobile2_calling_code" class="form-control" placeholder="+91-" ng-model-options="{ updateOn: 'blur' }" ng-change="validateMobileNumber(userContact.personal_mobile2, 'errFamilyMobile')">
                                        </span>                               
                                    </div> 
                                </div> 
                                <div class="col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <label for="">Family Member Mobile Number</label>
                                        <span class="input-icon icon-right1">
                                            <input type="text" ng-model="userContact.personal_mobile2" maxlength="10" style="margin-left: -24px;" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" name="personal_mobile2" id="personal_mobile2" class="form-control"  ng-model-options="{ updateOn: 'blur' }" ng-change="validateMobileNumber(userContact.personal_mobile2, 'errFamilyMobile')">
                                            <i class="fa fa-phone"></i>
                                            <div ng-show="step2 || errMobile || errFamilyMobile" ng-messages="userContactForm.personal_mobile2.$error" class="help-block step2 {{ applyClassMobile}}">
                                                <div ng-message="minlength">Personal Mobile Number must be 10 digits</div>
                                                <div>{{ errMobile}}</div>
                                                <div>{{ errFamilyMobile}}</div>
                                            </div>
                                        </span>                               
                                    </div> 
                                </div> 
                                <div class="col-sm-2 col-xs-2">
                                    <div class="form-group">
                                         <label for="">Country code</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" disabled ng-model="userContact.personal_landline_calling_code" style="width:110px; height:34px;" name="personal_landline_calling_code" id="personal_landline_calling_code" class="form-control"  ng-model-options="{ updateOn: 'blur' }" ng-change="validateLandlineNumber(userContact.personal_landline_no)">
               
                                        </span>                               
                                    </div> 
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                    <div class="form-group">
                                       <label for="">Landline Number</label>
                                        <span class="input-icon icon-right1">
                                            <input type="text" ng-model="userContact.personal_landline_no" ng-minlength="10" style="margin: 0px 0 0 -25px;" maxlength="10" ng-minlength="10" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" name="personal_landline_no" id="personal_landline_no" class="form-control"  ng-model-options="{ updateOn: 'blur' }" ng-change="validateLandlineNumber(userContact.personal_landline_no)">
                                            <i class="fa fa-phone"></i>
                                            <div ng-show="step2 || errLandline" ng-messages="userContactForm.personal_landline_no.$error" class="help-block step2 {{applyClass}}">
                                                <div ng-message="minlength">Personal Mobile Number must be 10 digits</div>
                                                <div ng-message="minlength">Landline No. must be 10 digits</div>
                                                <div ng-if="errLandline">{{ errLandline}}</div>
                                            </div>
                                        </span>                               
                                    </div> 
                                </div> 
                            </div>
                        </div>                        
                        <div class="col-sm-6 col-xs-12">
                            <div class="row">  
                                <div class="col-sm-6 col-xs-6">
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (!userContactForm.personal_email1.$dirty && userContactForm.personal_email1.$invalid)}">
                                        <label for="">Personal Email <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="email" ng-model="userContact.personal_email1" check-unique-emails name="personal_email1" ng-change="uniqueEmail" class="form-control" ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/" required ng-model-options="{ allowInvalid: true, debounce: 300 }">
                                            <i class="fa fa-envelope"></i>
                                            <!--                                            check-unique-email -->
                                            <div ng-show="step2" ng-messages="userContactForm.personal_email1.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                                <div ng-message="email">Invalid email address.</div>
                                                <div ng-message="pattern">Invalid email address.</div>
                                                <div ng-message="uniqueEmail">Email address exist. Please enter another email address!</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <label for=""> Office Email</label>
                                        <span class="input-icon icon-right">
                                            <input type="email" ng-model="userContact.office_email_id" name="office_email_id" ng-pattern="/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/"  class="form-control">
                                            <i class="fa fa-envelope"></i>
                                            <div ng-show="step2" ng-messages="userContactForm.office_email_id.$error" class="help-block step2">
                                                <div ng-message="email">Invalid email address.</div>
                                                <div ng-message="pattern">Invalid email address.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>    
                            </div> 
                            <div class="row">  
                                <div class="col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <label for=""> Alternate Email</label>
                                        <span class="input-icon icon-right">
                                            <input type="email" ng-model="userContact.personal_email2" ng-pattern="/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/"   name="personal_email2" class="form-control">
                                            <i class="fa fa-envelope"></i>
                                            <div ng-show="step2" ng-messages="userContactForm.personal_email2.$error"  class="help-block step2">
                                                <div ng-message="email">Invalid email address.</div>
                                                <div ng-message="pattern">Invalid email address.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div> 
                            </div> 
                        </div> 

                    </div>    
                    <hr class="wide">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12" ng-controller="currentCountryListCtrl">
                            <div class="form-title">
                                Correspondence Address
                            </div>
                            <div class="row">  
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (!userContactForm.current_address.$dirty && userContactForm.current_address.$invalid)}">
                                        <label for="">Correspondence Address <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <textarea ng-model="userContact.current_address" name="current_address" ng-change="changePermanentAddress()" class="form-control" maxlength="255" required></textarea>
                                            <i class="fa fa-map-marker"></i>
                                            <div ng-show="step2" ng-messages="userContactForm.current_address.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">  
                                <div class="col-sm-6 col-xs-6">
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (!userContactForm.current_country_id.$dirty && userContactForm.current_country_id.$invalid)}">
                                        <label for="">Select Country <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select ng-change="onCountryChange(); changePermanentAddress();" ng-model="userContact.current_country_id" name="current_country_id" id="current_country_id" class="form-control" required>
                                                <option value="">Select Country</option>
                                                <option ng-repeat="country in countryList track by $index" value="{{country.id}}" data-sortname ="{{country.sortname}}" data-phonecode="{{country.phonecode}}" ng-selected="{{ country.id == userContact.current_country_id}}">{{country.name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div ng-show="step2" ng-messages="userContactForm.current_country_id.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (!userContactForm.current_state_id.$dirty && userContactForm.current_state_id.$invalid)}">
                                        <label for="">Select State <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select ng-model="userContact.current_state_id" ng-change="onStateChange(); changePermanentAddress()" name="current_state_id" id="current_state_id" class="form-control" required>
                                                <option value="">Select State</option>
                                                <option ng-repeat="state in stateList" value="{{state.id}}" ng-selected="{{ state.id == userContact.current_state_id}}">{{state.name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div ng-show="step2" ng-messages="userContactForm.current_state_id.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">  
                                <div class="col-sm-6 col-xs-6">
                                    <label for="">Select City <span class="sp-err">*</span></label>											
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (!userContactForm.current_city_id.$dirty && userContactForm.current_city_id.$invalid)}">
                                        <span class="input-icon icon-right">
                                            <select ng-model="userContact.current_city_id" ng-change="changePermanentAddress();" name="current_city_id" class="form-control" required>
                                                <option value="">Select City</option>
                                                <option ng-repeat="city in cityList" value="{{city.id}}" ng-selected="{{ city.id == userContact.current_city_id}}">{{city.name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div ng-show="step2" ng-messages="userContactForm.current_city_id.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>                                
                                <div class="col-sm-6 col-xs-6">
                                    <label for="">Pin code <span class="sp-err">*</span></label>
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (!userContactForm.current_pin.$dirty && userContactForm.current_pin.$invalid)}">
                                        <span class="input-icon icon-right">
                                            <input type="text" name="current_pin" ng-model-options="{ updateOn: 'blur' }" ng-change="changePermanentAddress(); pinCodeValidation(userContact.current_pin, errCurrentPin)" ng-model="userContact.current_pin"  name="current_pin" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="6" required>
                                            <i class="fa fa-map-pin"></i>
                                            <div ng-show="step2 || errPin"  ng-messages="userContactForm.current_pin.$error" class="help-block step2 {{applyClasspin}}">
                                                <div ng-message="required">This field is required.</div>
                                                <div>{{errPin}}</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12" ng-controller="permanentCountryListCtrl">
                            <div class="form-title">

                                Permanent Address  &nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="checkbox" style="display:inline-block;margin: 0;">
                                    <label>
                                        <input type="checkbox" id="copyContent" ng-model="copyContent" ng-change="checkboxSelected(copyContent)">
                                        <span class="text"> Same as correspondence address</span>
                                    </label>
                                </span>	
                            </div>
                            <div class="row">  
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (userContactForm.permenent_address.$invalid)}">
                                        <label for="">Permanent Address <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <textarea ng-model="userContact.permenent_address" name="permenent_address" class="form-control" maxlength="250" required></textarea>
                                            <i class="fa fa-map-marker"></i>                                            
                                            <div ng-show="step2" ng-messages="userContactForm.permenent_address.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">  
                                <div class="col-sm-6 col-xs-6">
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (userContactForm.permenent_country_id.$invalid)}">
                                        <label for="">Select Country <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select ng-change="onPCountryChange()" ng-model="userContact.permenent_country_id" name="permenent_country_id" class="form-control" required>
                                                <option value="">Select Country</option>
                                                <option ng-repeat="country in countryList" value="{{country.id}}" ng-selected="{{ country.id == userContact.permenent_country_id}}">{{country.name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>                                            
                                            <div ng-show="step2" ng-messages="userContactForm.permenent_country_id.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (userContactForm.permenent_state_id.$invalid)}">
                                        <label for="">Select State <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select ng-change="onPStateChange()" ng-model="userContact.permenent_state_id" name="permenent_state_id" id="permenent_state_id" class="form-control" required>
                                                <option value="">Select State</option>
                                                <option ng-repeat="state in stateTwoList track by $index" value="{{state.id}}" ng-selected="{{ state.id == userContact.permenent_state_id}}">{{state.name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div ng-show="step2" ng-messages="userContactForm.permenent_state_id.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">  
                                <div class="col-sm-6 col-xs-6">
                                    <label for="">Select City <span class="sp-err">*</span></label>											
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (userContactForm.permenent_city_id.$invalid)}">
                                        <span class="input-icon icon-right">
                                            <select ng-model="userContact.permenent_city_id" name="permenent_city_id" id="permenent_city_id" class="form-control" required>
                                                <option value="">Select City</option>
                                                <option ng-repeat="city in cityTwoList track by $index" value="{{city.id}}" ng-selected="{{ city.id == userContact.permenent_city_id}}">{{city.name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div ng-show="step2" ng-messages="userContactForm.permenent_city_id.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>  
                                <div class="col-sm-6 col-xs-6">
                                    <label for="">Pin code <span class="sp-err">*</span></label>
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (!userContactForm.permenent_pin.$dirty && userContactForm.permenent_pin.$invalid)}">
                                        <span class="input-icon icon-right">
                                            <input type="text" name="permenent_pin" ng-model-options="{ updateOn: 'blur' }" ng-change="pinPCodeValidation(userContact.permenent_pin, errPermanentPin)" ng-model="userContact.permenent_pin"  name="current_pin" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="6" required>
                                            <i class="fa fa-map-pin"></i>
                                            <div ng-show="step2 || errPPin"  ng-messages="userContactForm.permenent_pin.$error" class="help-block step2 {{applyClassppin}}">
                                                <div ng-message="required">This field is required.</div>
                                                <div>{{errPPin}}</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="right">
                            <button type="button" class="btn btn-primary btn-pre2" ng-click="previous(1, 2)">Prev</button>
                            <button type="submit" class="btn btn-primary btn-nxt2" ng-click="step2 = true;">Next</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="step-pane" id="wiredstep3" >
                <form name="usereducationForm" novalidate ng-submit="usereducationForm.$valid && invalidImage == '' &&  createEducationForm(userEducation, userEducation.employee_photo_file_name, [[ $empId ]]);" enctype="multipart/form-data">
                    <div class="form-title">
                        Educational & Other Details
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step3 && (!usereducationForm.highest_education_id.$dirty && usereducationForm.highest_education_id.$invalid)}">
                                <label for="">Highest Education <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select ng-controller="educationListCtrl" ng-model="userEducation.highest_education_id"  name="highest_education_id" required class="form-control" >
                                        <option value="">Select Education</option>
                                        <option ng-repeat="list in educationList track by $index" value="{{list.id}}" ng-selected="{{ list.id == userData.highest_education_id}}">{{list.education}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <div ng-show="step3" ng-messages="usereducationForm.highest_education_id.$error" class="help-block step3">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for=""> Education Details</label>
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="userEducation.education_details" name="education_details" capitalization    maxlength="50" class="form-control">
                                    <i class="fa fa-university"></i>
                                </span>
                            </div>
                        </div>
                         <div class="col-sm-3 col-xs-6">
                            <label for="">Employee Photo ( W 105 X H 120 )</label>
                            <span class="input-icon icon-right">
                                <input type="file" ngf-select ng-model="userEducation.employee_photo_file_name" value="Select photo" ng-change="checkImageExtension(userEducation.employee_photo_file_name)" name="employee_photo_file_name"   ng-model-options="{ allowInvalid: true, debounce: 300 }"  id="employee_photo_file_name" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" accept="image/x-png,image/gif,image/jpeg,image/bmp" >
                                <div ng-show="step3 || invalidImage" ng-messages="userEducation.employee_photo_file_name.$error" class="help-block step5">
                                    <div ng-if="invalidImage">{{invalidImage}}</div>
                                </div>
                                <img ng-src="{{image_source}}" class="thumb photoPreview"> 
                            </span> 
                            <div class="img-div2" data-title="name" ng-repeat="list in employee_photo_file_name_preview">    
                                <img ng-src="{{list}}" class="thumb photoPreview">
                            </div>
                        </div>

                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for=""></label>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="right">
                            <button type="button" class="btn btn-primary btn-pre3" ng-click="previous(2, 3)">Prev</button>
                            <button type="submit" class="btn btn-primary btn-nxt3"  ng-click="step3 = true;" >Next</button>
                        </div>
                    </div>
                </form> 
            </div>	
            <div class="step-pane" id="wiredstep4" >	
                <form name="userJobForm" novalidate ng-submit="userJobForm.$valid && createJobForm(userJobData, [[ $empId ]])"  ng-init="manageUsers([[ !empty($empId) ?  $empId : '0' ]], 'edit', 1, [[config('global.recordsPerPage')]]); getEmpId([[$empId]]); ">

                    <div class="form-title">
                        Job Offer Details
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group multi-sel-div" ng-class="{ 'has-error' : (step4 && (!userJobForm.department_id.$dirty && userJobForm.department_id.$invalid)) && emptyDepartmentId}" ng-controller="departmentCtrl">
                                <label for="">Select Departments <span class="sp-err">*</span></label>	
                                <ui-select multiple ng-model="userJobData.department_id" name="department_id" theme="select2" ng-disabled="disabled" style="width: 300px;" ng-required="true"  ng-change="checkDepartment()">
                                    <ui-select-match>{{$item.department_name}}</ui-select-match>
                                    <ui-select-choices repeat="list in departments | filter:$select.search">
                                        {{list.department_name}} 
                                    </ui-select-choices>
                                </ui-select>
                                <div ng-show="emptyDepartmentId && userJobData.department_id == ''" class="help-block department step4 {{ applyClassDepartment}}">
                                    This field is required.
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step4 && (!userJobForm.designation_id.$dirty && userJobForm.designation_id.$invalid)}">
                                <label for="">Designation <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select ng-model="userJobData.designation_id" name="designation_id" ng-controller="designationCtrl" class="form-control" required>
                                        <option value="">Please Select Designation</option>
                                        <option ng-repeat="list in designationList track by $index" value="{{list.id}}" ng-selected="{{ userData.designation_id == list.id}}">{{list.designation}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <div ng-show="step4" ng-messages="userJobForm.designation_id.$error" class="help-block step4">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step4 && (!userJobForm.reporting_to_id.$dirty && userJobForm.reporting_to_id.$invalid)}">
                                <label for="">Reporting To<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select ng-model="userJobData.reporting_to_id" name="reporting_to_id" ng-controller="teamLeadCtrl" class="form-control" required>
                                        <option value="">Please Select Reporting To</option>
                                        <option ng-repeat="reporting in teamLeads track by $index" value="{{reporting.id}}" ng-selected="{{ userData.reporting_to_id == reporting.id}}">{{reporting.first_name}} {{ reporting.last_name}} ({{ reporting.designation_name.designation}})</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <div ng-show="step4" ng-messages="userJobForm.reporting_to_id.$error" class="help-block step4">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>	
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step4 && (!userJobForm.joining_date.$dirty && userJobForm.joining_date.$invalid)}">
                                <label>Joining Date<span class="sp-err">*</span></label>
                                <div ng-controller="DatepickerDemoCtrl">
                                    <p class="input-group">
                                        <input type="text" ng-model="userJobData.joining_date" name="joining_date" class="form-control" datepicker-popup="dd-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required/>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                        </span>
                                    </p>
                                    <div ng-show="step4" ng-messages="userJobForm.joining_date.$error" class="help-block step4">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6" ng-if="userId != '1'">
                            <div class="form-group" ng-class="{ 'has-error' : step4 && (!userJobForm.team_lead_id.$dirty && userJobForm.team_lead_id.$invalid)}">
                                <label for="">Team Lead<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select ng-model="userJobData.team_lead_id" name="team_lead_id" ng-controller="teamLeadCtrl" class="form-control" required>
                                        <option value="">Please Select Team Lead</option>
                                        <option ng-repeat="teamLead in teamLeads track by $index" value="{{teamLead.id}}" ng-selected="{{ userData.team_lead_id == teamLead.id}}">{{teamLead.first_name}} {{ teamLead.last_name}} ({{ teamLead.designation_name.designation}})</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <div ng-show="step4" ng-messages="userJobForm.team_lead_id.$error" class="help-block step4">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>                            
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="right">
                            <button type="button" class="btn btn-primary btn-pre4" ng-click="previous(3, 4)">Prev</button>
                            <button type="submit" class="btn btn-primary btn-nxt6" ng-click="step4 = true; emptyDepartmentId = true;">Next</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="step-pane" id="wiredstep5" >
                <form name="userStatusForm" novalidate ng-submit="userStatusForm.$valid && createStatusForm(userStatus, [[ $empId ]])"  >
                    <div class="form-title">                                           
                        User status
                    </div>
                    <div class="row">
                        <div  class="col-sm-3 col-xs-6" ng-if="userId != '0'">

                            <label>Status <span class="sp-err">*</span></label>
                            <div class="control-group">
                                <div class="radio">
                                    <label>
                                        <input name="form-field-radio" type="radio" ng-model="userStatus.employee_status" value="1" class="colored-success">
                                        <span class="text">Active </span>
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input name="form-field-radio" type="radio" ng-model="userStatus.employee_status" value="2" class="colored-danger">
                                        <span class="text">Temporary Suspended </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step5 && (!userStatusForm.high_security_password_type.$dirty && userStatusForm.high_security_password_type.$invalid)}">
                                <label>High security password type <span  class="sp-err">*</span></label>
                                <span class="input-icon icon-right" >
                                    <select ng-model="userStatus.high_security_password_type" name="high_security_password_type" class="form-control" required>
                                        <option value="">Select Password Type</option>
                                        <option value="0">Always OTP</option>
                                        <option value="1">Always Fixed</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <div ng-show="step5" ng-messages="userStatusForm.high_security_password_type.$error" class="help-block step5">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6" ng-if="userStatus.high_security_password_type == 1">
                            <div class="form-group" ng-class="{ 'has-error' : step5 && (!userStatusForm.high_security_password.$dirty && userStatusForm.high_security_password.$invalid)}">
                                <label>High security password <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="password" ng-model="userStatus.high_security_password" name="high_security_password" class="form-control" minlength="4" maxlength="4" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" ng-required='userStatus.high_security_password_type == 1'>
                                    <i class="fa fa-lock"></i>
                                    <div ng-show="step5" ng-messages="userStatusForm.high_security_password.$error" class="help-block step5">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>
                            </div>
                        </div>


                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" >
                                <label>User Name <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="userStatus.username" name="username"  class="form-control" maxlength="10" disabled minlenght="10" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" >
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step5 && (!userStatusForm.employee_id.$dirty && userStatusForm.employee_id.$invalid)}">
                                <label>Employee Id</label>
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="userStatus.employee_id" name="employee_id" id="employee_id" maxlength="4" ng-model-options="{ allowInvalid: true, debounce: 500 }"  ng-change="checkEmployeeId(userStatus.employee_id);"  class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                    <i class="fa fa-user"></i>
                                    <div ng-show="step2 || errEmployeeId" ng-messages="userStatusForm.employee_id.$error" class="help-block step2 {{ applyClassEmployeeId}}">
                                        <div>{{ errEmployeeId}}</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step5 && (!userStatusForm.show_on_homepage.$dirty && userStatusForm.show_on_homepage.$invalid)}">
                                <label>Show on website <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select name="show_on_homepage" id="show_on_homepage" required ng-model="userStatus.show_on_homepage" class="form-control">
                                        <option value="">Select</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <div ng-show="step5" ng-messages="userStatusForm.show_on_homepage.$error" class="help-block step5">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="right">
                            <span class="progress" ng-show="userData.employee_photo_file_name.progress >= 0">
                                <div style="width:{{userData.employee_photo_file_name.progress}}%" ng-bind="userData.employee_photo_file_name.progress + '%'"></div>
                            </span>
                            <span ng-show="userData.employee_photo_file_name.result">Upload Successful</span>
                            <button type="button" class="btn btn-primary btn-pre5" ng-click="previous(4, 5)">Prev</button>
                            <button type="submit" class="btn btn-primary btn-submit-last"  ng-click="step5 = true; employeeSId()" >Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</form>
<script>
    /*  $(document).ready(function(){
     $(".btn-nxt1").mouseup(function(e){
     if ($(".step1").hasClass("ng-active")) {
     e.preventDefault();
     } else{
     $("#wiredstep1").hide();
     $("#wiredstep2").show();
     $(".wiredstep2").addClass("active");
     $(".wiredstep1").removeClass("active");
     $(".wiredstep1").addClass("complete");
     }
     });
     $(".btn-nxt2").click(function(e){
     if ($(".step2").hasClass("ng-active")) {
     e.preventDefault();
     } else{
     $("#wiredstep2").hide();
     $("#wiredstep3").show();
     $(".wiredstep3").addClass("active");
     $(".wiredstep2").removeClass("active");
     $(".wiredstep2").addClass("complete");
     }
     });
     $(".btn-nxt3").click(function(e){
     if ($(".step3").hasClass("ng-active")) {
     e.preventDefault();
     } else{
     $("#wiredstep3").hide();
     $("#wiredstep4").show();
     $(".wiredstep4").addClass("active");
     $(".wiredstep3").removeClass("active");
     $(".wiredstep3").addClass("complete");
     }
     });
     $(".btn-nxt6").click(function(e){
     if ($(".step4").hasClass("ng-active")) {
     e.preventDefault();
     } else{
     $("#wiredstep4").hide();
     $("#wiredstep5").show();
     $(".wiredstep5").addClass("active");
     $(".wiredstep4").removeClass("active");
     $(".wiredstep4").addClass("complete");
     }
     if ($(".select2-input").attr('placeholder') === '' && $(".step4").hasClass("ng-hide")) {
     }
     else{ $(".department").removeClass("ng-hide"); }
     });
     $(".btn-submit-last").click(function(e){
     if ($(".step5").hasClass("ng-active")) {
     e.preventDefault();
     }
     });
     $(".btn-pre2").click(function(){
     $("#wiredstep1").show();
     $("#wiredstep2").hide();
     $(".wiredstep1").addClass("active");
     $(".wiredstep2").removeClass("active");
     $(".wiredstep1").removeClass("complete");
     });
     $(".btn-pre3").click(function(){
     $("#wiredstep2").show();
     $("#wiredstep3").hide();
     $(".wiredstep2").addClass("active");
     $(".wiredstep3").removeClass("active");
     $(".wiredstep2").removeClass("complete");
     });
     $(".btn-pre4").click(function(){
     $("#wiredstep3").show();
     $("#wiredstep4").hide();
     $(".wiredstep3").addClass("active");
     $(".wiredstep4").removeClass("active");
     $(".wiredstep3").removeClass("complete");
     });
     $(".btn-pre5").click(function(){
     $("#wiredstep4").show();
     $("#wiredstep5").hide();
     $(".wiredstep4").addClass("active");
     $(".wiredstep5").removeClass("active");
     $(".wiredstep4").removeClass("complete");
     });
     });
     */
    $("#personal_mobile1_calling_code,#personal_mobile2_calling_code,#personal_landline_calling_code,#office_mobile_calling_code").intlTelInput();</script>