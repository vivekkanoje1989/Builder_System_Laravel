<style>
    .actions {
        z-index: 0 !important;
    }
    .help-block {
        margin-top: 0px !important; 
        margin-bottom: 0px !important; 
        color: #e46f61;
    }
</style>
<form name="userForm" novalidate ng-submit="userForm.$valid && createUser(userData,userData.employee_photo_file_name,[[ $empId ]])" ng-controller="hrController" ng-init="manageUsers([[ !empty($empId) ?  $empId : '0' ]],'edit');getStepDiv(1,[[ !empty($empId) ?  $empId : '0' ]]);">
    <input type="hidden" ng-model="userForm.csrfToken" name="csrftoken" id="csrftoken" ng-init="userForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
    <input type="hidden" ng-model="userData.id" name="id" id="empId" ng-init="userForm.id = '[[ $empId ]]'" value="[[ $empId ]]" class="form-control">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{ pageHeading }}</h5>
            <div id="WiredWizard" class="wizard wizard-wired" data-target="#WiredWizardsteps">
                <ul class="steps">
                    <li ng-class="{complete: userId > 0}" ng-click="getStepDiv(1, [[$empId]])" class="user_steps wizardstep1 active"><span class="step">1</span><span class="title">Personal Information</span><span class="chevron"></span></li>
                    <li ng-class="{complete: userId > 0}" ng-click="getStepDiv(2, [[$empId]])" class="user_steps wizardstep2"><span class="step">2</span><span class="title">Contact Information</span><span class="chevron"></span></li>
                    <li ng-class="{complete: userId > 0}" ng-click="getStepDiv(3, [[$empId]])" class="user_steps wizardstep3"><span class="step">3</span><span class="title">Educational & Other Details</span><span class="chevron"></span></li>
                    <li ng-class="{complete: userId > 0}" ng-click="getStepDiv(4, [[$empId]])" class="user_steps wizardstep4"><span class="step">4</span><span class="title">Job Offer Details</span><span class="chevron"></span></li>
                    <li ng-class="{complete: userId > 0}" ng-click="getStepDiv(5, [[$empId]])" class="user_steps wizardstep5"><span class="step">5</span><span class="title">User Status</span><span class="chevron"></span></li>
                </ul>
            </div>
            <div class="step-content" id="WiredWizardsteps">
                <div class="step-pane active" id="wizardstep1">
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
                                    <input type="text" ng-model="userData.first_name" name="first_name" class="form-control" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15" required>
                                    <i class="fa fa-user"></i>
                                    <div ng-show="step1" ng-messages="userForm.first_name.$error" class="help-block step1">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>                                
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Middle Name</label>
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="userData.middle_name" name="middle_name" class="form-control" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step1 && (!userForm.last_name.$dirty  && userForm.last_name.$invalid)}">
                                <label for="">Last Name <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="userData.last_name" name="last_name" class="form-control" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15" required>
                                    <i class="fa fa-user"></i>
                                    <div ng-show="step1" ng-messages="userForm.last_name.$error" class="help-block step1">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <label>Birth Date <span class="sp-err">*</span></label>
                            <div ng-controller="DatepickerDemoCtrl" class="form-group" ng-class="{ 'has-error' : step1 && (!userForm.date_of_birth.$dirty  && userForm.date_of_birth.$invalid)}">
                                <p class="input-group">
                                <input type="text" ng-model="userData.date_of_birth" name="date_of_birth" id="date_of_birth" value="date_of_birth" class="form-control" datepicker-popup="dd-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                                </p>
                                <div ng-show="step1" ng-messages="userForm.date_of_birth.$error" class="help-block step1">
                                    <div ng-message="required">This field is required.</div>
                                </div>
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
                                <label for="">Physical Status <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right" required>
                                    <select ng-model="userData.physic_status" name="physic_status" class="form-control" placeholder="Select Physic" required>
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
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Physical Description</label>
                                <span class="input-icon icon-right">
                                    <textarea ng-model="userData.physic_desc" name="physic_desc" class="form-control" maxlength="50" ng-disabled="(userData.physic_status == '2') ? false : true"></textarea>
                                    <i class="fa fa-align-left"></i>
                                </span>
                            </div>
                        </div>                        
                    </div>
                    <div class="row"> 
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step1 && (!userForm.blood_group_id.$dirty && userForm.blood_group_id.$invalid)}">
                                <label for="">Blood Group <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select ng-model="userData.blood_group_id" ng-controller="bloodGroupCtrl" name="blood_group_id" class="form-control" required>
                                        <option value="">Select Blood Group</option>
                                        <option ng-repeat="bloodGroup in bloodGroups track by $index" value="{{bloodGroup.id}}" ng-selected="{{ bloodGroup.id == userData.blood_group_id}}">{{bloodGroup.blood_group}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <div ng-show="step1" ng-messages="userForm.blood_group_id.$error" class="help-block step1">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step1 && (userForm.marital_status.$invalid)}">
                                <label for="">Married Status <span class="sp-err">*</span></label>
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
                                <label>Marriage Date<span class="sp-err">*</span></label>
                                <div ng-controller="DatepickerDemoCtrl">
                                    <p class="input-group">
                                        <input type="text" ng-model="userData.marriage_date" name="marriage_date" class="form-control" datepicker-popup="dd-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly ng-required='userData.marital_status == 2'/>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                        </span>
                                    </p>
                                    <div ng-show="step1" ng-messages="userForm.marriage_date.$error" class="help-block step1">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </div>
                            </div>
                        </div>                                                
                    </div>
                    <div class="row">
                        <input type="hidden" ng-model="userData.pan_number" name="pan_number">
                        <div class="col-md-12 col-xs-12" align="right">
                            <button type="button" class="btn btn-primary btn-nxt1" ng-click="step1=true">Next</button>
                        </div>
                    </div>
                </div>	
                <div class="step-pane" id="wizardstep2">	
                    <div class="form-title">
                        Contact Information
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div class="row">
                                <div class="col-sm-6 col-xs-6">
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (!userForm.personal_mobile1.$dirty && userForm.personal_mobile1.$invalid)}">
                                        <label for="">Personal Mobile Number <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">   
                                            <input type="text" ng-model="userData.personal_mobile1" name="personal_mobile1" id="personal_mobile1" class="form-control" ng-pattern="/^(\+\d{1,4}-)\d{10}$/" ng-model-options="{ updateOn: 'blur' }" ng-change="copyToUsername(userData.personal_mobile1); validateMobile(userData.personal_mobile1,'errPersonalMobile');" required>
                                            <i class="fa fa-phone"></i>
                                            <div ng-show="step2" ng-messages="userForm.personal_mobile1.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                                <div ng-message="pattern">Mobile number should be 10 digits and pattern should be for ex. +91-9999999999</div>
                                                <div>{{ errPersonalMobile }}</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (!userForm.office_mobile_no.$dirty && userForm.office_mobile_no.$invalid)}">
                                        <label>Office Mobile Number <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">                                            
                                            <input type="text" ng-model="userData.office_mobile_no" name="office_mobile_no" id="office_mobile_no" class="form-control" ng-change="validateMobile(userData.office_mobile_no,'errOfficeMobile');" ng-model-options="{ updateOn: 'blur' }" ng-pattern="/^(\+\d{1,4}-)\d{10}$/" required>
                                            <i class="fa fa-phone"></i>
                                            <div ng-show="step2" ng-messages="userForm.office_mobile_no.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                                <div ng-message="pattern">Mobile number should be 10 digits and pattern should be for ex. +91-9999999999</div>
                                                <div>{{ errOfficeMobile }}</div>
                                            </div>
                                        </span>
                                    </div>   
                                </div> 
                            </div> 
                            <div class="row">                            
                                <div class="col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <label for="">Family Member Mobile No.</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="userData.personal_mobile2" name="personal_mobile2" id="personal_mobile2" class="form-control" placeholder="+91-" ng-change="validateMobileNumber(userData.personal_mobile2);validateMobile(userData.personal_mobile2,'errFamilyMobile');" ng-model-options="{ updateOn: 'blur' }">
                                            <i class="fa fa-phone"></i>
                                            <div ng-show="step2 || errMobile || errFamilyMobile" ng-messages="userForm.personal_mobile2.$error" class="help-block step2 {{ applyClassMobile }}">
                                                <div>{{ errMobile }}</div>
                                                <div>{{ errFamilyMobile }}</div>
                                            </div>
                                        </span>                               
                                    </div> 
                                </div> 
                                <div class="col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <label for="">Landline No.</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="userData.personal_landline_no" name="personal_landline_no" id="personal_landline_no" class="form-control" placeholder="+91-" ng-model-options="{ updateOn: 'blur' }" ng-change="validateLandlineNumber(userData.personal_landline_no)">
                                            <i class="fa fa-phone"></i>
                                            <div ng-show="step2 || errLandline" ng-messages="userForm.personal_landline_no.$error" class="help-block step2 {{applyClass}}">
                                                <div>{{ errLandline }}</div>
                                            </div>
                                        </span>                               
                                    </div> 
                                </div> 
                            </div>
                        </div>                        
                        <div class="col-sm-6 col-xs-12">
                            <div class="row">  
                                <div class="col-sm-6 col-xs-6">
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (!userForm.personal_email1.$dirty && userForm.personal_email1.$invalid)}">
                                        <label for="">Email <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="email" ng-model="userData.personal_email1" name="personal_email1" class="form-control" maxlength="50" check-unique-email ng-pattern="/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/" required ng-model-options="{ allowInvalid: true, debounce: 300 }">
                                            <i class="fa fa-envelope"></i>
                                            <div ng-show="step2" ng-messages="userForm.personal_email1.$error" class="help-block step2">
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
                                            <input type="email" ng-model="userData.office_email_id" name="office_email_id" maxlength="50" ng-pattern="/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/" class="form-control">
                                            <i class="fa fa-envelope"></i>
                                            <div ng-show="step2" ng-messages="userForm.office_email_id.$error" class="help-block step2">
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
                                            <input type="email" ng-model="userData.personal_email2" name="personal_email2" maxlength="50" ng-pattern="/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/" class="form-control">
                                            <i class="fa fa-envelope"></i>
                                            <div ng-show="step2" ng-messages="userForm.personal_email2.$error" class="help-block step2">
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
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (!userForm.current_address.$dirty && userForm.current_address.$invalid)}">
                                        <label for="">Correspondence Address <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <textarea ng-model="userData.current_address" name="current_address" class="form-control" maxlength="255" required></textarea>
                                            <i class="fa fa-map-marker"></i>
                                            <div ng-show="step2" ng-messages="userForm.current_address.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">  
                                <div class="col-sm-6 col-xs-6">
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (!userForm.current_country_id.$dirty && userForm.current_country_id.$invalid)}">
                                        <label for="">Select Country <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select ng-change="onCountryChange()" ng-model="userData.current_country_id" name="current_country_id" id="current_country_id" class="form-control" required>
                                                <option value="">Select Country</option>
                                                <option ng-repeat="country in countryList" value="{{country.id}}" ng-selected="{{ country.id == userData.current_country_id}}">{{country.name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div ng-show="step2" ng-messages="userForm.current_country_id.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (!userForm.current_state_id.$dirty && userForm.current_state_id.$invalid)}">
                                        <label for="">Select State <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select ng-model="userData.current_state_id" ng-change="onStateChange()" name="current_state_id" id="current_state_id" class="form-control" required>
                                                <option value="">Select State</option>
                                                <option ng-repeat="state in stateList" value="{{state.id}}" ng-selected="{{ state.id == userData.current_state_id}}">{{state.name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div ng-show="step2" ng-messages="userForm.current_state_id.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">  
                                <div class="col-sm-6 col-xs-6">
                                    <label for="">Select City <span class="sp-err">*</span></label>											
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (!userForm.current_city_id.$dirty && userForm.current_city_id.$invalid)}">
                                        <span class="input-icon icon-right">
                                            <select ng-model="userData.current_city_id" name="current_city_id" class="form-control" required>
                                                <option value="">Select City</option>
                                                <option ng-repeat="city in cityList" value="{{city.id}}" ng-selected="{{ city.id == userData.current_city_id}}">{{city.name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div ng-show="step2" ng-messages="userForm.current_city_id.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>                                
                                <div class="col-sm-6 col-xs-6">
                                    <label for="">Pin code <span class="sp-err">*</span></label>
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (!userForm.current_pin.$dirty && userForm.current_pin.$invalid)}">
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="userData.current_pin" name="current_pin" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="6" required>
                                            <i class="fa fa-map-pin"></i>
                                            <div ng-show="step2" ng-messages="userForm.current_pin.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12" ng-controller="permanentCountryListCtrl">
                            <div class="form-title">
                                Permanent Address&nbsp;&nbsp;
                                <span class="checkbox" style="display:inline-block;margin: 0;">
                                    <label>
                                        <input type="checkbox" ng-model="copyContent" ng-change="checkboxSelected(copyContent)">
                                        <span class="text"> Same as Correspondence Address</span>
                                    </label>
                                </span>	
                            </div>
                            <div class="row">  
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (userForm.permenent_address.$invalid)}">
                                        <label for="">Permanent Address <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <textarea ng-model="userData.permenent_address" name="permenent_address" maxlength="255" class="form-control" required></textarea>
                                            <i class="fa fa-map-marker"></i>                                            
                                            <div ng-show="step2" ng-messages="userForm.permenent_address.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">  
                                <div class="col-sm-6 col-xs-6">
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (userForm.permenent_country_id.$invalid)}">
                                        <label for="">Select Country <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select ng-change="onPCountryChange()" ng-model="userData.permenent_country_id" name="permenent_country_id" id="permenent_country_id" class="form-control" required>
                                                <option value="">Select Country</option>
                                                <option ng-repeat="country in countryList" value="{{country.id}}" ng-selected="{{ country.id == userData.permenent_country_id}}">{{country.name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>                                            
                                            <div ng-show="step2" ng-messages="userForm.permenent_country_id.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (userForm.permenent_state_id.$invalid)}">
                                        <label for="">Select State <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select ng-change="onPStateChange()" ng-model="userData.permenent_state_id" name="permenent_state_id" id="permenent_state_id" class="form-control" required>
                                                <option value="">Select State</option>
                                                <option ng-repeat="state in stateList track by $index" value="{{state.id}}" ng-selected="{{ state.id == userData.permenent_state_id}}">{{state.name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div ng-show="step2" ng-messages="userForm.permenent_state_id.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">  
                                <div class="col-sm-6 col-xs-6">
                                    <label for="">Select City <span class="sp-err">*</span></label>											
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (userForm.permenent_city_id.$invalid)}">
                                        <span class="input-icon icon-right">
                                            <select ng-model="userData.permenent_city_id" name="permenent_city_id" id="permenent_city_id" class="form-control" required>
                                                <option value="">Select City</option>
                                                <option ng-repeat="city in cityList track by $index" value="{{city.id}}" ng-selected="{{ city.id == userData.permenent_city_id}}">{{city.name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div ng-show="step2" ng-messages="userForm.permenent_city_id.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>                                
                                <div class="col-sm-6 col-xs-6">
                                    <label for="">Pin Code <span class="sp-err">*</span></label>
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (userForm.permenent_pin.$invalid)}">
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="userData.permenent_pin" name="permenent_pin" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="6" required>
                                            <i class="fa fa-map-pin"></i>
                                            <div ng-show="step2" ng-messages="userForm.permenent_pin.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="right">
                            <button type="button" class="btn btn-primary btn-pre2">Prev</button>
                            <button type="button" class="btn btn-primary btn-nxt2" ng-click="step2=true;">Next</button>
                        </div>
                    </div>
                </div>
                <div class="step-pane" id="wizardstep3">	
                    <div class="form-title">
                        Educational & Other Details
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step3 && (!userForm.highest_education_id.$dirty && userForm.highest_education_id.$invalid)}">
                                <label for="">Highest Education <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select ng-controller="educationListCtrl" ng-model="userData.highest_education_id" name="highest_education_id" class="form-control" required>
                                        <option value="">Select Education</option>
                                        <option ng-repeat="list in educationList track by $index" value="{{list.id}}" ng-selected="{{ list.id == userData.highest_education_id}}">{{list.education}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <div ng-show="step3" ng-messages="userForm.highest_education_id.$error" class="help-block step3">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for=""> Education Details</label>
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="userData.education_details" name="education_details" class="form-control">
                                    <i class="fa fa-university"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step3 && (userForm.employee_photo_file_name.$invalid)}">
                                <label for="">Employee Photo ( W 105 X H 120 )</label>
                                <span class="input-icon icon-right">
                                    <input type="file" ngf-select ng-model="userData.employee_photo_file_name" name="employee_photo_file_name" id="employee_photo_file_name" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" ngf-model-invalid="errorFile" ng-change="checkImageExtension(userData.employee_photo_file_name)">
                                    <img ng-if="!employee_photo_file_name_preview" ng-src="[[ Config('global.s3Path') ]]employee-photos/{{imgUrl}}" class="thumb photoPreview">
                                    <div class="img-div2" data-title="name" ng-repeat="list in employee_photo_file_name_preview">    
                                        <img ng-src="{{list}}" class="thumb photoPreview">
                                    </div>
                                    <div ng-show="step3 || employee_photo_file_name_err" ng-messages="userForm.employee_photo_file_name.$error" class="help-block step3">
                                        <span class="help-block" ng-show="employee_photo_file_name_err">{{employee_photo_file_name_err}}</span>
                                        <i ng-show="userForm.employee_photo_file_name.$error.maxSize">File too large {{errorFile.size / 1000000|number:1}}MB: max 2M</i>
                                    </div>
                                </span>                                                   
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
                            <button type="button" class="btn btn-primary btn-pre3">Prev</button>
                            <button type="button" class="btn btn-primary btn-nxt3" ng-click="step3=true">Next</button>
                        </div>
                    </div>
                </div>	
                <div class="step-pane" id="wizardstep4">	
                    <div class="form-title">
                        Job Offer Details
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group multi-sel-div" ng-class="{ 'has-error' : (step4 && (!userForm.department_id.$dirty && userForm.department_id.$invalid)) && emptyDepartmentId}" ng-controller="departmentCtrl">
                                <label for="">Select Departments <span class="sp-err">*</span></label>	
                                <ui-select multiple ng-model="userData.department_id" name="department_id" theme="select2" ng-disabled="disabled" style="width: 300px;" ng-required="true" ng-change="checkDepartment()">
                                    <ui-select-match>{{$item.department_name}}</ui-select-match>
                                    <ui-select-choices repeat="list in departments | filter:$select.search">
                                        {{list.department_name}} 
                                    </ui-select-choices>
                                </ui-select>
                                <div ng-show="emptyDepartmentId" class="help-block department step4 {{ applyClassDepartment }}">
                                    This field is required.
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step4 && (!userForm.designation_id.$dirty && userForm.designation_id.$invalid)}">
                                <label for="">Designation <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select ng-model="userData.designation_id" name="designation_id" ng-controller="designationCtrl" class="form-control" required>
                                        <option value="">Please Select</option>
                                        <option ng-repeat="list in designationList track by $index" value="{{list.id}}" ng-selected="{{ userData.designation_id == list.id }}">{{list.designation}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <div ng-show="step4" ng-messages="userForm.designation_id.$error" class="help-block step4">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step4 && (!userForm.reporting_to_id.$dirty && userForm.reporting_to_id.$invalid)}">
                                <label for="">Reporting To<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select ng-model="userData.reporting_to_id" name="reporting_to_id" ng-controller="teamLeadCtrl" class="form-control" required>
                                        <option value="">Please Select</option>
                                        <option ng-repeat="reporting in teamLeads track by $index" value="{{reporting.id}}" ng-selected="{{ userData.reporting_to_id == reporting.id }}">{{reporting.first_name }} {{ reporting.last_name }} ({{ reporting.designation_name }})</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <div ng-show="step4" ng-messages="userForm.reporting_to_id.$error" class="help-block step4">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>	
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step4 && (!userForm.joining_date.$dirty && userForm.joining_date.$invalid)}">
                                <label>Joining Date<span class="sp-err">*</span></label>
                                <div ng-controller="DatepickerDemoCtrl">
                                    <p class="input-group">
                                        <input type="text" ng-model="userData.joining_date" name="joining_date" class="form-control" datepicker-popup="dd-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required/>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                        </span>
                                    </p>
                                    <div ng-show="step4" ng-messages="userForm.joining_date.$error" class="help-block step4">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step4 && (!userForm.team_lead_id.$dirty && userForm.team_lead_id.$invalid)}">
                                <label for="">Team Lead<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select ng-model="userData.team_lead_id" name="team_lead_id" ng-controller="teamLeadCtrl" class="form-control" required>
                                        <option value="">Please Select</option>
                                        <option ng-repeat="teamLead in teamLeads track by $index" value="{{teamLead.id}}" ng-selected="{{ userData.team_lead_id == teamLead.id }}">{{teamLead.first_name }} {{ teamLead.last_name }} ({{ teamLead.designation_name }})</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <div ng-show="step4" ng-messages="userForm.team_lead_id.$error" class="help-block step4">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>                            
                            </div>
                        </div> 
                        </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="right">
                            <button type="button" class="btn btn-primary btn-pre4">Prev</button>
                            <button type="button" class="btn btn-primary btn-nxt6" ng-click="(step4=true);checkDepartment();">Next</button>
                        </div>
                    </div>
                </div>
                <div class="step-pane" id="wizardstep5">	
                    <div class="form-title">                                           
                        User status
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step5 && (!userForm.employee_status.$dirty && userForm.employee_status.$invalid)}">
                                <label>Status <span class="sp-err">*</span></label>
                                <div class="control-group">
                                    <div class="radio">
                                        <label>
                                            <input name="form-field-radio" type="radio" ng-model="userData.employee_status" value="1" class="colored-success">
                                            <span class="text">Active </span>
                                        </label>
                                    </div>
                                    <div class="radio" ng-if="[[ $empId ]] != 0">
                                        <label>
                                            <input name="form-field-radio" type="radio" ng-model="userData.employee_status" value="2" class="colored-blue">
                                            <span class="text">  Temporary Suspended </span>
                                        </label>
                                    </div>
                                    <div class="radio" ng-if="[[ $empId ]] != 0">
                                        <label>
                                            <input name="form-field-radio" type="radio" ng-model="userData.employee_status" value="3" class="colored-danger">
                                            <span class="text"> Permanently Suspended  </span>
                                        </label>
                                    </div>
                                </div>
                                <div ng-show="step5" ng-messages="userForm.employee_status.$error" class="help-block step5">
                                    <div ng-message="required">This field is required.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step5 && (!userForm.employee_id.$dirty && userForm.employee_id.$invalid)}">
                                <label>Employee Id <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="userData.employee_id" name="employee_id" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" ng-change="checkUniqueEmpId(userData.employee_id,'[[$empId]]');" ng-model-options="{ updateOn: 'blur' }" required>
                                    <i class="fa fa-user"></i>
                                    <div ng-show="step5 || duplicateEmpId" ng-messages="userForm.employee_id.$error" class="help-block step5">
                                        <div ng-message="required">This field is required.</div>
                                        <span>{{duplicateEmpId}}</span>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step5 && (!userForm.high_security_password_type.$dirty && userForm.high_security_password_type.$invalid)}">
                                <label>High security password type <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right" >
                                    <select ng-model="userData.high_security_password_type" name="high_security_password_type" class="form-control">
                                        <option value="">Select Password Type</option>
                                        <option value="0">OTP</option>
                                        <option value="1">Fixed</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <div ng-show="step5" ng-messages="userForm.high_security_password_type.$error" class="help-block step5">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6" ng-if="userData.high_security_password_type == 1">
                            <div class="form-group" ng-class="{ 'has-error' : step5 && (!userForm.high_security_password.$dirty && userForm.high_security_password.$invalid)}">
                                <label>High security password <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="password" ng-model="userData.high_security_password" name="high_security_password" class="form-control" minlength="4" maxlength="4" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" ng-required='userData.high_security_password_type == 2'>
                                    <i class="fa fa-lock"></i>
                                    <div ng-show="step5" ng-messages="userForm.high_security_password.$error" class="help-block step5">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : step5 && (!userForm.username.$dirty && userForm.username.$invalid)}">
                                <label>User Name <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="userData.username" name="username" class="form-control" maxlength="10" minlenght="10" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" readonly required>
                                    <i class="fa fa-user"></i>
                                    <div ng-show="step5" ng-messages="userForm.username.$error" class="help-block step5">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>
                            </div>
                        </div>                        
<!--                        <div class="col-sm-3 col-xs-6" ng-if="[[ $empId ]] == 0">
                            <div class="form-group" ng-class="{ 'has-error' : step5 && (!userForm.password.$dirty && userForm.password.$invalid)}">
                                <label>Password <span ng-show="[[ $empId ]] == 0" class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="password" ng-model="userData.password" name="password" class="form-control" minlength="6" maxlength="6" ng-required = "[[ $empId ]] == 0">
                                    <input type="hidden" ng-model="userData.passwordOld" name="passwordOld" class="form-control" ng-if = "[[ $empId ]] != 0">
                                    <i class="fa fa-lock"></i>
                                    <div ng-show="step5" ng-messages="userForm.password.$error" class="help-block step5">
                                        <div ng-message="required">This field is required.</div>
                                        <div ng-message="minlength">Password length should be minimum 6 characters.</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6" ng-if="[[ $empId ]] == 0">
                            <div class="form-group" ng-class="{ 'has-error' : step5 && (!userForm.password_confirmation.$dirty && userForm.password_confirmation.$invalid)}">
                                <label>Re Enter Password <span ng-show="[[ $empId ]] == 0" class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="password" ng-model="userData.password_confirmation" name="password_confirmation" minlength="6" maxlength="6" class="form-control" compare-to="userData.password" required> 
                                    <i class="fa fa-lock"></i>
                                    <div ng-show="step5" ng-messages="userForm.password_confirmation.$error" class="help-block step5">
                                        <div ng-message="required">This field is required.</div>
                                        <div ng-message="compareTo">Must match password and confirm password</div>
                                        <div ng-message="minlength">Password length should be minimum 6 characters.</div>
                                    </div>
                                </span>
                            </div>
                        </div>-->
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="right">
                            <span class="progress" ng-show="userData.employee_photo_file_name.progress >= 0">
                                <div style="width:{{userData.employee_photo_file_name.progress}}%" ng-bind="userData.employee_photo_file_name.progress + '%'"></div>
                            </span>
                            <button type="button" class="btn btn-primary btn-pre5">Prev</button>
                            <button type="submit" class="btn btn-primary btn-submit-last" ng-disabled="disableCreateButton" ng-click="step5=true">{{buttonLabel}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function(){
        $(".btn-nxt1").mouseup(function(e){
            if($(".step1").hasClass("ng-active")) {
                e.preventDefault();
            }else{
                $("#wizardstep1").hide();
                $("#wizardstep2").show();
                $(".wizardstep2").addClass("active");
                $(".wizardstep2").removeClass("complete");
                $(".wizardstep1").removeClass("active");
                $(".wizardstep1").addClass("complete");
            }
        });
        $(".btn-nxt2").click(function(e){
            if($(".step2").hasClass("ng-active")) {
                e.preventDefault();
            }else{
                $("#wizardstep2").hide();
                $("#wizardstep3").show();
                $(".wizardstep3").addClass("active");
                $(".wizardstep3").removeClass("complete");
                $(".wizardstep2").removeClass("active");
                $(".wizardstep2").addClass("complete");
            }
        });
        $(".btn-nxt3").click(function(e){
            if($(".step3").hasClass("ng-active")) {
                e.preventDefault();
            }else{
                $("#wizardstep3").hide();
                $("#wizardstep4").show();
                $(".wizardstep4").addClass("active");
                $(".wizardstep4").removeClass("complete");
                $(".wizardstep3").removeClass("active");
                $(".wizardstep3").addClass("complete");
            }
        });
        $(".btn-nxt6").click(function(e){
            if($(".step4").hasClass("ng-active")) {
                e.preventDefault();
            }else{
                $("#wizardstep4").hide();
                $("#wizardstep5").show();
                $(".wizardstep5").addClass("active");
                $(".wizardstep5").removeClass("complete");
                $(".wizardstep4").removeClass("active");
                $(".wizardstep4").addClass("complete");
            }
            if( $(".select2-input").attr('placeholder') === '' && $(".step4").hasClass("ng-hide")) {
            }
            else{ $(".department").removeClass("ng-hide");}
        });
        $(".btn-submit-last").click(function(e){
            if($(".step5").hasClass("ng-active")) {
                e.preventDefault();
            }
        });
        
        $(".btn-pre2").click(function(){
            $("#wizardstep1").show();
            $("#wizardstep2").hide();
            $(".wizardstep1").addClass("active");
            $(".wizardstep2").addClass("complete");
            $(".wizardstep2").removeClass("active");
            $(".wizardstep1").removeClass("complete");
        });
        $(".btn-pre3").click(function(){
            $("#wizardstep2").show();
            $("#wizardstep3").hide();
            $(".wizardstep2").addClass("active");
            $(".wizardstep3").addClass("complete");
            $(".wizardstep3").removeClass("active");
            $(".wizardstep2").removeClass("complete");
        });
        $(".btn-pre4").click(function(){
            $("#wizardstep3").show();
            $("#wizardstep4").hide();
            $(".wizardstep3").addClass("active");
            $(".wizardstep4").addClass("complete");
            $(".wizardstep4").removeClass("active");
            $(".wizardstep3").removeClass("complete");
        });
        $(".btn-pre5").click(function(){
            $("#wizardstep4").show();
            $("#wizardstep5").hide();
            $(".wizardstep4").addClass("active");
            $(".wizardstep5").addClass("complete");
            $(".wizardstep5").removeClass("active");
            $(".wizardstep4").removeClass("complete");
        });
    });
    $("#personal_mobile1,#personal_mobile2,#office_mobile_no,#personal_landline_no").intlTelInput();

</script>