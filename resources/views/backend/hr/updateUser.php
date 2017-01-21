<form name="userForm" ng-controller="userController" novalidate="novalidate">
<input type="hidden" ng-model="userForm.csrfToken" name="csrftoken" id="csrftoken" ng-init="userForm.csrfToken='<?php echo csrf_token(); ?>'" class="form-control">
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{ pageHeading }}</h5>
        <div id="WiredWizard" class="wizard wizard-wired" data-target="#WiredWizardsteps" ui-jq="wizard">
            <ul class="steps">
                <li data-target="#wiredstep1" class="active"><span class="step">1</span><span class="title">Step 1</span><span class="chevron"></span></li>
                <li data-target="#wiredstep2"><span class="step">2</span><span class="title">Step 2</span> <span class="chevron"></span></li>
                <li data-target="#wiredstep3"><span class="step">3</span><span class="title">Step 3</span> <span class="chevron"></span></li>
                <li data-target="#wiredstep4"><span class="step">4</span><span class="title">Step 4</span> <span class="chevron"></span></li>
                <li data-target="#wiredstep5"><span class="step">5</span><span class="title">Step 5</span> <span class="chevron"></span></li>
            </ul>
        </div>
        <div class="step-content" id="WiredWizardsteps">
            <div class="step-pane active" id="wiredstep1">
                <div class="form-title">Personal Information</div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : userForm.title.$invalid && !userForm.title.$pristine }">
                                <label for="">Title <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select ng-controller="titleCtrl" ng-model="userData.title" name="title" class="form-control" required>
                                        <option value="0">Select Title</option>
                                        <option ng-repeat="t in titles track by $index" value="{{t.value}}">{{t.title}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <p ng-show="userForm.title.$invalid && !userForm.title.$pristine" class="help-block">This field is required.</p>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : userForm.first_name.$invalid && !userForm.first_name.$pristine }">
                                <label for="">First Name <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="userData.first_name" name="first_name" class="form-control" required>
                                    <i class="fa fa-user"></i>
                                    <p ng-show="userForm.first_name.$invalid && !userForm.first_name.$pristine" class="help-block">This field is required.</p>
                                </span>                                
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Middle Name</label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : userForm.last_name.$invalid && !userForm.last_name.$pristine }">
                                <label for="">Last Name <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="userData.last_name" name="last_name" class="form-control" required>
                                    <i class="fa fa-user"></i>
                                    <p ng-show="userForm.last_name.$invalid && !userForm.last_name.$pristine" class="help-block">This field is required.</p>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6" ng-class="{ 'has-error' : userForm.date_of_birth.$invalid && !userForm.date_of_birth.$pristine }">
                            <label>Birth Date <span class="sp-err">*</span></label>
                            <div ng-controller="DatepickerDemoCtrl">
                                <p class="input-group">
                                    <input type="text" ng-model="userData.dt" name="date_of_birth" class="form-control" datepicker-popup="{{format}}" is-open="opened" min-date="minDate" max-date=maxDate datepicker-options="dateOptions" ng-required="true" close-text="Close" ng-click="toggleMin()" required/>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                    </span>
                                    <p ng-show="userForm.date_of_birth.$invalid && !userForm.date_of_birth.$pristine" class="help-block">This field is required.</p>
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : userForm.gender.$invalid && !userForm.gender.$pristine }">
                                <label for="">Gender <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select ng-controller="genderCtrl" ng-model="userData.gender" name="gender" class="form-control" required>
                                        <option value="0">Select Gender</option>
                                        <option ng-repeat="gender in genders" value="{{gender.gender_id}}">{{gender.gender_title}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <p ng-show="userForm.gender.$invalid && !userForm.gender.$pristine" class="help-block">This field is required.</p>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Blood Group</label>
                                <span class="input-icon icon-right">
                                    <select ng-controller="bloodGroupCtrl" ng-model="userData.blood_group_id" name="blood_group_id" class="form-control">
                                        <option value="0">Select Blood Group</option>
                                        <option ng-repeat="bloodGroup in bloodGroups track by $index" value="{{bloodGroup.blood_group_id}}">{{bloodGroup.blood_group}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : userForm.marital_status.$invalid && !userForm.marital_status.$pristine }">
                                <label for="">Married Status <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select ng-model="userData.marital_status" name="marital_status" class="form-control" required>
                                        <option value="0">Select Marital Staus</option>
                                        <option value="1">Single</option>
                                        <option value="2">Married</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <p ng-show="userForm.marital_status.$invalid && !userForm.marital_status.$pristine" class="help-block">This field is required.</p>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : userForm.physic_status_id.$invalid && !userForm.physic_status_id.$pristine }">
                                <label for="">Physic <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right" required>
                                    <select ng-model="userData.physic_status_id" name="physic_status_id" class="form-control" placeholder="Select Physic">
                                        <option value="0" selected="selected">Normal</option>
                                        <option value="1">Handicap</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <p ng-show="userForm.physic_status_id.$invalid && !userForm.physic_status_id.$pristine" class="help-block">This field is required.</p>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Physic Description</label>
                                <span class="input-icon icon-right">
                                    <textarea ng-model="userData.physic_desc" name="physic_desc" class="form-control" required></textarea>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="step-pane" id="wiredstep2">
                <div class="form-title">
                    Contact Information
                </div>
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group" ng-class="{ 'has-error' : userForm.office_mobile_no.$invalid && !userForm.office_mobile_no.$pristine }">
                            <label for="">Office Mobile Number <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">                                
                                <input type="text" ng-model="userData.office_mobile_country_id" name="office_mobile_country_id" style="width:20%;">
                                <input type="text" ng-model="userData.office_mobile_no" name="office_mobile_no" class="form-control" required>
                                <i class="fa fa-phone"></i>
                                <div ng-messages="myForm1.office_mobile_no.$error" ng-if='myForm1.office_mobile_no.$dirty'>
                                    <div ng-message="required">This is required.</div>
                                </div>
                                <p ng-show="userForm.office_mobile_no.$invalid && !userForm.office_mobile_no.$pristine" class="help-block">This field is required.</p>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group" ng-class="{ 'has-error' : userForm.personal_mobile_no1.$invalid && !userForm.personal_mobile_no1.$pristine }">
                            <label>Personal Mobile Number</label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="userData.mobile1_country_id" name="mobile1_country_id" style="width:20%;">
                                <input type="text" ng-model="userData.personal_mobile_no1" name="personal_mobile_no1" class="form-control">
                                <i class="fa fa-phone"></i>
                                <p ng-show="userForm.personal_mobile_no1.$invalid && !userForm.personal_mobile_no1.$pristine" class="help-block">This field is required.</p>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group" ng-class="{ 'has-error' : userForm.email.$invalid && !userForm.email.$pristine }">
                            <label for="">Email <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="userData.email" name="email" class="form-control" required>
                                <i class="fa fa-envelope"></i>
                                <p ng-show="userForm.email.$invalid && !userForm.email.$pristine" class="help-block">This field is required.</p>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for=""> Alternate Email</label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="userData.personal_email_id2" name="personal_email_id2" class="form-control">
                                <i class="fa fa-envelope"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for=""> Office Email</label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="userData.office_email_id" name="office_email_id" class="form-control">
                                <i class="fa fa-envelope"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for="">family Member Mobile No.</label>
                            <span class="input-icon icon-right">
                                    <input type="text" ng-model="userData.mobile2_country_id" name="mobile2_country_id" style="width:20%;">
                                <input type="text" ng-model="userData.personal_mobile_no2" name="personal_mobile_no2" class="form-control">
                                <i class="fa fa-phone"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for="">family Member Relation</label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="userData.landline_country_id" name="landline_country_id" style="width:20%;">
                                <input type="text" ng-model="userData.landline_no" name="landline_no" class="form-control">
                                <i class="fa fa-phone"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <hr class="wide">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-title">
                            Correspondence Address
                        </div>
                        <div class="col-sm-12 col-xs-12 pad-left">
                            <div class="form-group" ng-class="{ 'has-error' : userForm.current_address.$invalid && !userForm.current_address.$pristine }">
                                <label for="">Correspondence Address <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <textarea ng-model="userData.current_address" name="current_address" class="form-control" required></textarea>
                                    <i class="fa fa-map-marker"></i>
                                    <p ng-show="userForm.current_address.$invalid && !userForm.current_address.$pristine" class="help-block">This field is required.</p>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6 pad-left">
                            <div class="form-group" ng-class="{ 'has-error' : userForm.current_country_id.$invalid && !userForm.current_country_id.$pristine }">
                                <label for="">Select Country <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select ng-model="userData.current_country_id" name="current_country_id" class="form-control" required>
                                        <option value="0" selected="selected">India</option>
                                        <option value="1">UK</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <p ng-show="userForm.current_country_id.$invalid && !userForm.current_country_id.$pristine" class="help-block">This field is required.</p>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6 pad-right">
                            <div class="form-group" ng-class="{ 'has-error' : userForm.current_state_id.$invalid && !userForm.current_state_id.$pristine }">
                                <label for="">Select State <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select ng-model="userData.current_state_id" name="current_state_id" class="form-control" required>
                                        <option value="0" selected="selected">Maharastra</option>
                                        <option value="1">Goa</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <p ng-show="userForm.current_state_id.$invalid && !userForm.current_state_id.$pristine" class="help-block">This field is required.</p>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6 pad-left" ng-class="{ 'has-error' : userForm.current_pin.$invalid && !userForm.current_pin.$pristine }">
                            <label for="">Pin Code <span class="sp-err">*</span></label>
                            <div class="form-group">
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="userData.current_pin" name="current_pin" class="form-control" required>
                                    <i class="fa fa-map-pin"></i>
                                    <p ng-show="userForm.current_pin.$invalid && !userForm.current_pin.$pristine" class="help-block">This field is required.</p>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6 pad-right" ng-class="{ 'has-error' : userForm.current_city_id.$invalid && !userForm.current_city_id.$pristine }">
                            <label for="">Select City <span class="sp-err">*</span></label>											
                            <div class="form-group">
                                <span class="input-icon icon-right">
                                    <select ng-model="userData.current_city_id" name="current_city_id" class="form-control" required>
                                        <option value="0" selected="selected">Pune</option>
                                        <option value="1">Mumbai</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <p ng-show="userForm.current_city_id.$invalid && !userForm.current_city_id.$pristine" class="help-block">This field is required.</p>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-title">
                            <span class="checkbox" style="display:inline-block;margin: 0;">
                                <label>
                                    <input type="checkbox">
                                    <span class="text"> Same as Left</span>
                                </label>
                            </span>	
                            &nbsp;&nbsp;:&nbsp;Permanent Address

                        </div>
                        <div class="col-sm-12 col-xs-12 pad-left">
                            <div class="form-group">
                                <label for="">Permanent Address</label>
                                <span class="input-icon icon-right">
                                    <textarea ng-model="userData.permenent_pin" name="permenent_pin" class="form-control" required></textarea>
                                    <i class="fa fa-map-marker"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6 pad-left">
                            <div class="form-group">
                                <label for="">Select Country</label>
                                <span class="input-icon icon-right">
                                    <select ng-model="userData.permenent_country_id" name="permenent_country_id" class="form-control">
                                        <option value="0" selected="selected">India</option>
                                        <option value="1">UK</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6 pad-right">
                            <div class="form-group">
                                <label for="">Select State</label>
                                <span class="input-icon icon-right">
                                    <select ng-model="userData.permenent_state_id" name="permenent_state_id" class="form-control">
                                        <option value="0" selected="selected">Maharastra</option>
                                        <option value="1">Goa</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6 pad-left">
                            <label for="">Pin Code</label>
                            <div class="form-group">
                                <span class="input-icon icon-right">
                                    <input ng-model="userData.permenent_pin" name="permenent_pin" type="text" class="form-control">
                                    <i class="fa fa-map-pin"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6 pad-right">
                            <label for="">Select City	</label>											
                            <div class="form-group">
                                <span class="input-icon icon-right">
                                    <select ng-model="userData.permenent_city_id" name="permenent_city_id" class="form-control">
                                        <option value="0" selected="selected">Pune</option>
                                        <option value="1">Handicap</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="step-pane" id="wiredstep3">
                <div class="form-title">
                    Educational & Other Details
                </div>
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for="">Highest Education</label>
                            <span class="input-icon icon-right">
                                <select ng-model="userData.highest_education_id" name="highest_education_id" class="form-control">
                                    <option value="">Please Select</option>
                                    <option value="11">Below SSC</option>
                                    <option value="15">I T I Before S S C</option>
                                    <option value="22">S.S.C.</option>
                                    <option value="25">I T I After S S C / Equivalent</option>
                                    <option value="33">Diploma after S.S.C.</option>
                                    <option value="44">H.S.C.</option>
                                    <option value="55">Diploma after H.S.C.</option>
                                    <option value="57">First Year Bachelor Degree </option>
                                    <option value="59">Second  Year Bachelor Degree </option>
                                    <option value="61">Third Year Bachelor Degree </option>
                                    <option value="66">Bachelor Degree / Equivalent</option>
                                    <option value="77" selected="selected">Masters Degree  /  Equivalent</option>
                                    <option value="101">P.H.D.</option>
                                    <option value="0">MBA In Sales &amp; Marketing</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
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
                        <div class="form-group">
                            <label for="">Employee Photo ( W 105 X H 120 )</label>
                            <span class="input-icon icon-right">
                                <input type="file" ng-model="userData.emp_photo_url" name="emp_photo_url" class="form-control">
                                <i class="fa fa-file-image-o"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for=""></label>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="step-pane" id="wiredstep4">
                <div class="form-title">
                    Job Offer Details
                </div>
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group multi-sel-div" ng-controller="Select2DemoCtrl">
                            <label for="">Select Department</label>	
                            <ui-select multiple ng-model="userData.multipleDemo.colors" theme="select2" ng-disabled="disabled" style="width: 300px;">
                                <ui-select-match placeholder="Select colors...">{{$item}}</ui-select-match>
                                <ui-select-choices repeat="color in availableColors | filter:$select.search">
                                    {{color}}
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group" ng-class="{ 'has-error' : userForm.first_name.$invalid && !userForm.first_name.$pristine }">
                            <label for="">Designation <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" required>
                                <i class="fa fa-handshake-o"></i>
                                <p ng-show="userForm.title.$invalid && !userForm.title.$pristine" class="help-block">This field is required.</p>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group" ng-class="{ 'has-error' : userForm.first_name.$invalid && !userForm.first_name.$pristine }">
                            <label for="">(Monthly Gross) Salary <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" required>
                                <i class="fa fa-money"></i>
                                <p ng-show="userForm.title.$invalid && !userForm.title.$pristine" class="help-block">This field is required.</p>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for="">	Reporting To</label>
                            <span class="input-icon icon-right">
                                <select class="form-control">
                                    <option value="">Please Select</option>
                                    <option value="5">Balaji Chavan (Sales Head)</option>
                                    <option value="3">Dhawal Patel (Sales Head)</option>
                                    <option value="1">Kamalakar Patil (Managing Director)</option>
                                    <option value="6">Mandar H (Sales Head)</option>
                                    <option value="4">Ramdas Raut (Sales Ex)</option>
                                    <option value="14">Rohit Kedar (Php Developer)</option>
                                    <option value="8">Sudhir Wani (Support EX)</option>
                                    <option value="7">Supriya Kolekar (Sales Head)</option>
                                    <option value="15">Swapnil Pol (sales)</option>
                                    <option value="2">Vivek Gundla (Sales Head)</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>	
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>Joining Date</label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="userData.joining_date" name="joining_date" class="form-control">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>Other Allowances</label>
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control">
                                <i class="fa fa-wpexplorer"></i>
                            </span>
                        </div>
                    </div>

                </div>

            </div>
            <div class="step-pane" id="wiredstep5">
                    <div class="form-title">                                           
                        User status
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label>Status <span class="sp-err">*</span></label>
                                <div class="control-group">
                                    <div class="radio">
                                        <label>
                                            <input name="form-field-radio" type="radio" ng-model="userData.employee_status.name"  class="colored-blue">
                                            <span class="text">Active </span>
                                        </label>
                                    </div>

                                    <div class="radio">
                                        <label>
                                            <input name="form-field-radio" type="radio" ng-model="userData.employee_status.name" class="colored-danger">
                                            <span class="text">  Temporary Suspended </span>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input name="form-field-radio" type="radio" ng-model="userData.employee_status.name" class="colored-success">
                                            <span class="text"> Permanently Suspended  </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : userForm.username.$invalid && !userForm.username.$pristine }">
                                <label>User Name <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="userData.username" name="username" class="form-control" required>
                                    <i class="fa fa-user"></i>
                                    <p ng-show="userForm.username.$invalid && !userForm.username.$pristine" class="help-block">This field is required.</p>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : userForm.password.$invalid && !userForm.password.$pristine }">
                                <label>Password <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="password" ng-model="userData.password" name="password" class="form-control" required>
                                    <i class="fa fa-lock"></i>
                                    <p ng-show="userForm.password.$invalid && !userForm.password.$pristine" class="help-block">This field is required.</p>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-class="{ 'has-error' : userForm.confirmPassword.$invalid && !userForm.confirmPassword.$pristine }">
                                <label>Re Enter Password <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="password" ng-model="userData.confirmPassword" name="confirmPassword" class="form-control" required>
                                    <i class="fa fa-lock"></i>
                                    <p ng-show="userForm.confirmPassword.$invalid && !userForm.confirmPassword.$pristine" class="help-block">This field is required.</p>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>							
        </div>
    </div>
</div>
<div class="actions actions-footer" id="WiredWizard-actions">
    <div class="btn-group">
        <button type="button" class="btn btn-default btn-sm btn-prev"> <i class="fa fa-angle-left"></i>Prev</button>
        <button type="button" class="btn btn-default btn-sm btn-next" id="next" data-last="Finish" ng-click="createUser(userData)">Next<i class="fa fa-angle-right"></i></button>
    </div>
</div>
</form>


<form>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>Update users </h5>
        <div id="WiredWizard" class="wizard wizard-wired" data-target="#WiredWizardsteps" ui-jq="wizard">
            <ul class="steps">
                <li data-target="#wiredstep1" class="active"><span class="step">1</span><span class="title">Step 1</span><span class="chevron"></span></li>
                <li data-target="#wiredstep2"><span class="step">2</span><span class="title">Step 2</span> <span class="chevron"></span></li>
                <li data-target="#wiredstep3"><span class="step">3</span><span class="title">Step 3</span> <span class="chevron"></span></li>
                <li data-target="#wiredstep4"><span class="step">4</span><span class="title">Step 4</span> <span class="chevron"></span></li>
                <li data-target="#wiredstep5"><span class="step">5</span><span class="title">Step 5</span> <span class="chevron"></span></li>
            </ul>
        </div>
        <div class="step-content" id="WiredWizardsteps">
                <div class="step-pane active" id="wiredstep1">
                    <div id="">
                        <div class="form-title">
                            Personal Information
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label for="">Select Title &nbsp;&nbsp;<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select class="form-control" required>
                                            <option>Mr.</option>
                                            <option>Mrs.</option>
                                            <option>Miss</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label for="">First Name &nbsp;&nbsp;<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" required>
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label for="">Middle Name</label>
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label for="">Last Name &nbsp;&nbsp;<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" required>
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-xs-6">
                                <label>Birth Date &nbsp;&nbsp;<span class="sp-err">*</span></label>
                                <div ng-controller="DatepickerDemoCtrl">
                                    <p class="input-group">
                                        <input type="text" class="form-control" datepicker-popup="{{format}}" ng-model="dt" is-open="opened" min-date="minDate" max-date="'2015-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" close-text="Close" />
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label for="">Select gender &nbsp;&nbsp;<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select class="form-control" required>
                                            <option value="1" selected="selected">Male</option>
                                            <option value="2">Female</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label for="">Select Blood Group</label>
                                    <span class="input-icon icon-right">
                                        <select class="form-control">
                                            <option value="1">A+ve</option>
                                            <option value="2">A-ve</option>
                                            <option value="3" selected="selected">B+ve</option>
                                            <option value="4">B-ve</option>
                                            <option value="5">AB+ve</option>
                                            <option value="6">AB-ve</option>
                                            <option value="7">O+ve</option>
                                            <option value="8">O-ve</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label for="">Select Married Status &nbsp;&nbsp;<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select class="form-control" required>
                                            <option value="0">Married</option>
                                            <option value="1" selected="selected">Un Married</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label for="">Select Physic &nbsp;&nbsp;<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right" required>
                                        <select class="form-control">
                                            <option value="0" selected="selected">Normal</option>
                                            <option value="1">Handicap</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="step-pane" id="wiredstep2">
                    <div class="form-title">
                        Contact Information
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Office Mobile Number &nbsp;&nbsp;<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" required>
                                    <i class="fa fa-phone"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label>Personal Mobile Number</label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control">
                                    <i class="fa fa-phone"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Email &nbsp;&nbsp;<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" required>
                                    <i class="fa fa-envelope"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for=""> Alternate Email</label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control">
                                    <i class="fa fa-envelope"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">family Member Mobile No.</label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control">
                                    <i class="fa fa-phone"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">family Member Relation</label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control">
                                    <i class="fa fa-smile-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <hr class="wide">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-title">
                                Correspondence Address
                            </div>
                            <div class="col-sm-12 col-xs-12 pad-left">
                                <div class="form-group">
                                    <label for="">Correspondence Address &nbsp;&nbsp;<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <textarea  class="form-control" required></textarea>
                                        <i class="fa fa-map-marker"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6 pad-left">
                                <div class="form-group">
                                    <label for="">Select Country &nbsp;&nbsp;<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select class="form-control" required>
                                            <option value="0" selected="selected">India</option>
                                            <option value="1">UK</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6 pad-right">
                                <div class="form-group">
                                    <label for="">Select State &nbsp;&nbsp;<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select class="form-control" required>
                                            <option value="0" selected="selected">Maharastra</option>
                                            <option value="1">Goa</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6 pad-left">
                                <label for="">Pin Code &nbsp;&nbsp;<span class="sp-err">*</span></label>
                                <div class="form-group">
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" required>
                                        <i class="fa fa-map-pin"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6 pad-right">
                                <label for="">Select City &nbsp;&nbsp;<span class="sp-err">*</span></label>											
                                <div class="form-group">
                                    <span class="input-icon icon-right">
                                        <select class="form-control" required>
                                            <option value="0" selected="selected">Pune</option>
                                            <option value="1">Handicap</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-title">
                                <span class="checkbox" style="display:inline-block;margin: 0;">
                                    <label>
                                        <input type="checkbox">
                                        <span class="text"> Same as Left</span>
                                    </label>
                                </span>	
                                &nbsp;&nbsp;:&nbsp;Permanent Address

                            </div>
                            <div class="col-sm-12 col-xs-12 pad-left">
                                <div class="form-group">
                                    <label for="">Permanent Address</label>
                                    <span class="input-icon icon-right">
                                        <textarea  class="form-control" required></textarea>
                                        <i class="fa fa-map-marker"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6 pad-left">
                                <div class="form-group">
                                    <label for="">Select Country</label>
                                    <span class="input-icon icon-right">
                                        <select class="form-control">
                                            <option value="0" selected="selected">India</option>
                                            <option value="1">UK</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6 pad-right">
                                <div class="form-group">
                                    <label for="">Select State</label>
                                    <span class="input-icon icon-right">
                                        <select class="form-control">
                                            <option value="0" selected="selected">Maharastra</option>
                                            <option value="1">Goa</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6 pad-left">
                                <label for="">Pin Code</label>
                                <div class="form-group">
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control">
                                        <i class="fa fa-map-pin"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6 pad-right">
                                <label for="">Select City	</label>											
                                <div class="form-group">
                                    <span class="input-icon icon-right">
                                        <select class="form-control">
                                            <option value="0" selected="selected">Pune</option>
                                            <option value="1">Handicap</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="step-pane" id="wiredstep3">
                    <div class="form-title">
                        Educational & Other Details
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Highest Education</label>
                                <span class="input-icon icon-right">
                                    <select class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="11">Below SSC</option>
                                        <option value="15">I T I Before S S C</option>
                                        <option value="22">S.S.C.</option>
                                        <option value="25">I T I After S S C / Equivalent</option>
                                        <option value="33">Diploma after S.S.C.</option>
                                        <option value="44">H.S.C.</option>
                                        <option value="55">Diploma after H.S.C.</option>
                                        <option value="57">First Year Bachelor Degree </option>
                                        <option value="59">Second  Year Bachelor Degree </option>
                                        <option value="61">Third Year Bachelor Degree </option>
                                        <option value="66">Bachelor Degree / Equivalent</option>
                                        <option value="77" selected="selected">Masters Degree  /  Equivalent</option>
                                        <option value="101">P.H.D.</option>
                                        <option value="0">MBA In Sales &amp; Marketing</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">	Education Details</label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control">
                                    <i class="fa fa-university"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Employee Photo ( W 105 X H 120 )</label>
                                <span class="input-icon icon-right">
                                    <input type="file" class="form-control">
                                    <i class="fa fa-file-image-o"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Employee Id Proof ( W 105 X H 120 )</label>
                                <span class="input-icon icon-right">
                                    <input type="file" class="form-control">
                                    <i class="fa fa-file-image-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="step-pane" id="wiredstep4">
                    <div class="form-title">
                        Job Offer Details
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group multi-sel-div">
                                <label for="">Select Department</label>	
                                <ui-select multiple ng-model="multipleDemo.colors" theme="select2" ng-disabled="disabled" style="width: 300px;">
                                    <ui-select-match placeholder="Select colors...">{{$item}}</ui-select-match>
                                    <ui-select-choices repeat="color in availableColors | filter:$select.search">
                                        {{color}}
                                    </ui-select-choices>
                                </ui-select>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Designation &nbsp;&nbsp;<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" required>
                                    <i class="fa fa-handshake-o"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">(Monthly Gross) Salary &nbsp;&nbsp;<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" required>
                                    <i class="fa fa-money"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">	Reporting To</label>
                                <span class="input-icon icon-right">
                                    <select class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="5">Balaji Chavan (Sales Head)</option>
                                        <option value="3">Dhawal Patel (Sales Head)</option>
                                        <option value="1">Kamalakar Patil (Managing Director)</option>
                                        <option value="6">Mandar H (Sales Head)</option>
                                        <option value="4">Ramdas Raut (Sales Ex)</option>
                                        <option value="14">Rohit Kedar (Php Developer)</option>
                                        <option value="8">Sudhir Wani (Support EX)</option>
                                        <option value="7">Supriya Kolekar (Sales Head)</option>
                                        <option value="15">Swapnil Pol (sales)</option>
                                        <option value="2">Vivek Gundla (Sales Head)</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>	
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label>Joining Date</label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label>Other Allowances</label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control">
                                    <i class="fa fa-wpexplorer"></i>
                                </span>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="step-pane" id="wiredstep5">
                    <div class="form-title">                                           
                        User status
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label>Status &nbsp;&nbsp;<span class="sp-err">*</span></label>
                                <div class="control-group">
                                    <div class="radio">
                                        <label>
                                            <input name="form-field-radio" type="radio" class="colored-blue">
                                            <span class="text">Active </span>
                                        </label>
                                    </div>

                                    <div class="radio">
                                        <label>
                                            <input name="form-field-radio" type="radio" class="colored-danger">
                                            <span class="text">  Temporary Suspended </span>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input name="form-field-radio" type="radio" class="colored-success">
                                            <span class="text"> Permanently Suspended  </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label>User Name &nbsp;&nbsp;<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" required>
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label>Password &nbsp;&nbsp;<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" required>
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label>Re Enter Password &nbsp;&nbsp;<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" required>
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>							
        </div>
    </div>
</div>
<div class="actions actions-footer" id="WiredWizard-actions">
    <div class="btn-group">
        <button type="button" class="btn btn-default btn-sm btn-prev"> <i class="fa fa-angle-left"></i>Prev</button>
        <button type="button" class="btn btn-default btn-sm btn-next" data-last="Finish">Next<i class="fa fa-angle-right"></i></button>
    </div>
</div>
</form>