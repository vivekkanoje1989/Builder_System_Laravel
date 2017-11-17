
<html xmlns="http://www.w3.org/1999/xhtml" ng-app="app" ng-controller="AppCtrl">
    <meta name="csrf-token" content="[[ csrf_token() ]]">
        <base href="/">
            <title>Employee Registration </title>
            <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                    <script src="/frontend/angular.min.js"></script>
                    <script src="/frontend/angular-route.min.js"></script>
                    <script src="/frontend/angular-animate.min.js"></script>
                    <script src="/backend/app/ng-file-upload.js"></script>
                    <script src="/frontend/route.js"></script> 
                    <script src="/backend/app/directives.js"></script> 
                    <script src="/backend/app/controllers/datepicker.js"></script> 
                    <script src="/backend/lib/angular/angular-ui-bootstrap/ui-bootstrap.js"></script>
                    <link rel="stylesheet" href="/frontend/common/assets/bootstrap.min.css">
                        <link rel="stylesheet" href="/frontend/common/assets/jquery-ui.css">
                            <link rel="stylesheet" href="/frontend/common/assets/intlTelInput.css">

                                <style>
                                    .regbg{
                                        background-color: #f5f5f5;
                                    }
                                    .well{
                                        background-color: #fff;
                                    }
                                    .brand-logo{
                                        max-height:65px;
                                        width:auto;
                                        max-width:150px;
                                    }
                                    .logo{

                                        max-height:65px;
                                        width:auto;
                                        max-width:150px;
                                    }
                                    .well {
                                        min-height: 20px;
                                        padding: 15px;
                                        margin-bottom: 10px;
                                    }
                                    h1.form-title {
                                        text-transform: uppercase;
                                        font-size: 25px;	

                                    }
                                    .mar50{
                                        margin-top: 50px;
                                    }

                                    @media screen and (max-width: 768px) {
                                        .iti-mobile .intl-tel-input.iti-container{
                                            left: 4%;
                                            width: 92%;
                                        }
                                    }
                                    .error_msg
                                    {
                                        color:red;
                                    }
                                </style>		
                                </head>
                                <body class="regbg">
                                    <?php
                                    $empId = $clientdata['empId']
                                    ?>
                                    <div class="container">
                                        <div class="well col-md-12 col-sm-12 col-xs-12 mar50" align="center">
                                            <div class="col-md-2 col-sm-3 col-xs-12"> 
                                                <div class="col-md-2 col-sm-3 col-xs-12"><img src="<?php echo $clientdata['logo']; ?>" class="logo"></div></div>
                                            <div class="col-md-8 col-sm-6 col-xs-12"><h1 class="form-title">Employee Registration </h1></div>
                                            <div class="col-md-2 col-sm-3 col-xs-12"></div>
                                        </div>	
                                        <div class="col-lg-12 col-xs-12 well">
                                            <div class="">
                                                <div class="w3-container">
                                                    <form name="frmRegistration" novalidate ng-submit="frmRegistration.$valid && invalidImage == '' && updateemployee(userData, [[ $empId ]])" ng-init="getemployee([[ $empId]])" >
                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <div class="col-md-12 clol-xs-12">
                                                                    <h3>{{regerror}}</h3>							
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12 clol-xs-12">
                                                                    <h3>Personal Information</h3>				
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Title <span class="error_msg">*</span></label>
                                                                    <select class="form-control" ng-model="userData.title_id" ng-disabled="true" name="title_id" ng-controller="titleCtrl"  required>
                                                                        <option value="">Select Title</option>
                                                                        <option ng-repeat="t in titles track by $index" value="{{t.id}}"  ng-selected="{{ t.id == userData.title_id}}">{{t.title}}</option>
                                                                    </select>
                                                                    <div ng-show="sbtBtn && frmRegistration.title_id.$invalid" ng-messages="frmRegistration.title_id.$error" class="help-block">
                                                                        <div ng-message="required" class="error_msg">&nbsp;Title is Required</div>
                                                                    </div> 
                                                                </div>
                                                                <div class="col-sm-4 form-group">
                                                                    <label>First Name <span class="error_msg">*</span></label>
                                                                    <input type="text" class="form-control" ng-model="userData.first_name" ng-disabled="true"  name="first_name" maxlength="15" capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')"  maxlength="15" placeholder="Enter First Name" required>
                                                                        <div ng-show="sbtBtn && frmRegistration.first_name.$invalid" ng-messages="frmRegistration.first_name.$error"  class="help-block has-error">
                                                                            <div ng-message="required" class="error_msg">This field is required</div>
                                                                            <div ng-message="maxlength" class="error_msg">Maximum 15 Character are Allowed</div> 
                                                                        </div>  
                                                                </div>
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Last Name <span class="error_msg">*</span></label>
                                                                    <input type="text" class="form-control" ng-model="userData.last_name" ng-disabled="true" name="last_name" maxlength="15"  capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')"  placeholder="Enter Last Name" maxlength="15" required>
                                                                        <div ng-show="sbtBtn && frmRegistration.last_name.$invalid" ng-messages="frmRegistration.last_name.$error"  class="help-block has-error">
                                                                            <div ng-message="required" class="error_msg">This field is required</div>
                                                                            <div ng-message="maxlength" class="error_msg">Maximum 15 Character are Allowed</div> 
                                                                        </div>
                                                                </div>
                                                            </div>	
                                                            <div class="row">
                                                                <div class="col-sm-4 form-group" ng-controller="genderCtrl">
                                                                    <label>Gender <span class="error_msg">*</span></label>                                                        
                                                                    <select class="form-control" ng-model="userData.gender_id" name="gender_id"   required>
                                                                        <option value="">Select Gender</option>
                                                                        <option ng-repeat="genderList in genders track by $index" value="{{genderList.id}}" >{{genderList.gender}}</option>
                                                                    </select>
                                                                    <div ng-show="sbtBtn && frmRegistration.gender_id.$invalid" ng-messages="frmRegistration.gender_id.$error" class="help-block">
                                                                        <div ng-message="required" class="error_msg">&nbsp;This field is Required</div>
                                                                    </div>                                                         
                                                                </div>
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Physic Status <span class="error_msg">*</span></label>	
                                                                    <select ng-model="userData.physic_status" name="physic_status" class="form-control"   placeholder="Select Physic" required>
                                                                        <option value="">Select Physical Status</option>
                                                                        <option value="1">Normal</option>
                                                                        <option value="2">Handicap</option>
                                                                    </select>
                                                                    <div ng-show="sbtBtn && frmRegistration.physic_status.$invalid" ng-messages="frmRegistration.physic_status.$error" class="help-block">
                                                                        <div ng-message="required" class="error_msg">&nbsp;This field is Required</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4 form-group"  ng-if="userData.physic_status == 2">
                                                                    <label for="">Physic  Description</label>
                                                                    <div class="form-group">
                                                                        <textarea ng-model="userData.physic_desc" name="physic_desc" placeholder="Physic Description    "  class="form-control" maxlength="50" ></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Blood Group <span class="error_msg">*</span></label>
                                                                    <select ng-model="userData.blood_group_id" ng-controller="bloodGroupCtrl" name="blood_group_id" class="form-control" required>
                                                                        <option value="">Select Blood Group</option>
                                                                        <option ng-repeat="bloodGroup in bloodGroups track by $index" value="{{bloodGroup.id}}">{{bloodGroup.blood_group}}</option>
                                                                    </select>
                                                                    <div ng-show="sbtBtn && frmRegistration.blood_group_id.$invalid" ng-messages="frmRegistration.blood_group_id.$error" class="help-block">
                                                                        <div ng-message="required" class="error_msg">&nbsp;This field is Required</div>
                                                                    </div>   
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Birth Date</label>
                                                                    <input type="date" ng-model="userData.date_of_birth" name="date_of_birth" id="date_of_birth" class="form-control">	
                                                                </div>
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Marriage Status <span class="error_msg">*</span></label>
                                                                    <select ng-model="userData.marital_status" name="marital_status" id="marital_status" class="form-control" required>
                                                                        <option value="">Select Marital Status</option>
                                                                        <option value="1">Single</option>
                                                                        <option value="2">Married</option>
                                                                    </select>
                                                                    <div ng-show="sbtBtn && frmRegistration.marital_status.$invalid" ng-messages="frmRegistration.marital_status.$error" class="help-block">
                                                                        <div ng-message="required" class="error_msg">This field is required</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4 form-group" ng-show="userData.marital_status == 2">
                                                                    <label>Marriage Date</label>
                                                                    <input type="text" ng-model="userData.marriage_date" name="marriage_date" class="form-control" id="marriagedate">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12 clol-xs-12">
                                                                    <h3>Educational Information</h3>							
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4 form-group">
                                                                    <label for="">Highest Education <span class="error_msg">*</span></label>
                                                                    <select ng-controller="educationListCtrl" ng-model="userData.highest_education_id" name="highest_education_id" class="form-control" required>
                                                                        <option value="">Select Education</option>
                                                                        <option ng-repeat="list in educationList track by $index" value="{{list.id}}" ng-selected="{{ list.id == userData.highest_education_id}}">{{list.education}}</option>
                                                                    </select>
                                                                    <div ng-show="sbtBtn && frmRegistration.highest_education_id.$invalid" ng-messages="frmRegistration.highest_education_id.$error" class="help-block">
                                                                        <div ng-message="required" class="error_msg">This field is required</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Education Details</label>
                                                                    <input type="text" ng-model="userData.education_details" name="education_details" capitalization placeholder="Education Details"  oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')"  maxlength="50" class="form-control">
                                                                </div>	
                                                                <div class="col-sm-4 col-xs-6">
                                                                    <label for="">Employee Photo ( W 105 X H 120 )</label>
                                                                    <span class="input-icon icon-right">
                                                                        <input type="file" ngf-select ng-model="userData.employee_photo_file_name" id="employee_photo_file_name" value="Select photo" ng-change="checkImageExtension(userData.employee_photo_file_name)" accept="image/*" ngf-max-size="2MB" name="employee_photo_file_name"  ngf-model-invalid="errorFile" accept="image/x-png,image/gif,image/jpeg"  ng-model-options="{ allowInvalid: true, debounce: 300 }"  id="employee_photo_file_name" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"   accept="image/x-png,image/gif,image/jpeg,image/bmp" >
                                                                            <div ng-show="step3 || invalidImage" ng-messages="frmRegistration.employee_photo_file_name.$error" class="help-block step5">
                                                                                <div ng-if="invalidImage">{{invalidImage}}</div>
                                                                            </div>
                                                                            <img ng-src="{{image_source}}" class="thumb photoPreview"> 
                                                                                <div ng-if="imgUrl" > <img ng-if="employee_photo_file_name_preview.length != 1"  height="80px" width="80px" ng-src="[[ Config('global.s3Path') ]]/employee-photos/{{ imgUrl}}"  alt="{{ altName}}"  class="thumb photoPreview"/></div>
                                                                                </span> 
                                                                                <div class="img-div2" data-title="name" ng-repeat="list in employee_photo_file_name_preview">    
                                                                                    <img ng-src="{{list}}"  height="80px" width="80px"  class="thumb photoPreview">
                                                                                </div>
                                                                                </div>	
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-12 clol-xs-12">
                                                                                        <h3>Contact Information</h3>							
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-sm-4 form-group">
                                                                                        <label>Personal Mobile No. <span class="error_msg">*</span></label>
                                                                                        <input type="text"  ng-model="userData.personal_mobile1" name="personal_mobile1" ng-disabled="true" placeholder="Mobile Number" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  ng-pattern="/^[0-9]{10}$/" maxlength="10" required>
                                                                                            <div ng-show="sbtBtn && frmRegistration.personal_mobile1.$invalid" ng-messages="frmRegistration.personal_mobile1.$error" class="help-block">
                                                                                                <div ng-message="required" class="error_msg">This field is required</div>
                                                                                                <div ng-message="pattern" class="error_msg">Mobile number should be valid & 10 digits</div>
                                                                                                <div ng-message="maxlength" class="error_msg">Maximum 10 digit are Allowed</div> 
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class="col-sm-4 form-group">
                                                                                        <label>Office Mobile No. </label>
                                                                                        <input type="text"  ng-model="userData.office_mobile_no" name="office_mobile_no" placeholder="Mobile Number" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  ng-pattern="/^[7-9][0-9]{9}$/" maxlength="10">
                                                                                            <div ng-show="sbtBtn && frmRegistration.office_mobile_no.$invalid" ng-messages="frmRegistration.office_mobile_no.$error" class="help-block">
                                                                                                <div ng-message="pattern" class="error_msg">Mobile number should be valid & 10 digits</div>
                                                                                            </div>
                                                                                    </div>	
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-sm-4 form-group">
                                                                                        <label>Personal Email  <span class="error_msg">*</span></label>
                                                                                        <input type="text" ng-model="userData.personal_email1" ng-disabled="true" name="personal_email1"  ng-change="checkForSameEmails" ng-disabled="true" class="form-control" ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/"  ng-disabled="true" maxlength="45" required >
                                                                                            <i class="fa fa-envelope"></i>
                                                                                            <div ng-show="sbtBtn && frmRegistration.personal_email1.$invalid" ng-messages="userForm.personal_email1.$error" class="help-block">
                                                                                                <div ng-message="required" class="error_msg">This field is required</div>
                                                                                                <div ng-message="pattern" class="error_msg">Invalid email address</div>                                                                               
                                                                                                <div ng-message="maxlength" class="error_msg">Maximum 45 Character are Allowed</div> 
                                                                                                <div ng-message="checkForSameEmails">Email address must not be same.</div>
                                                                                            </div>
                                                                                    </div>	
                                                                                    <div class="col-sm-4 form-group">
                                                                                        <label>Office Email</label>
                                                                                        <!--check-for-same-emails="userData.personal_email1"-->
                                                                                        <input type="text" ng-model="userData.office_email_id"     ng-model-options="{ allowInvalid: true, debounce: 300 }"  placeholder="Office Email" name="office_email_id" class="form-control" ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/" maxlength="45" >
                                                                                            <i class="fa fa-envelope"></i>
                                                                                            <div ng-show="sbtBtn && frmRegistration.office_email_id.$invalid" ng-messages="userForm.office_email_id.$error" class="help-block">
                                                                                                <div ng-message="pattern" class="error_msg">Invalid email address</div>                                                                               
                                                                                                <div ng-message="maxlength" class="error_msg">Maximum 45 Character are Allowed</div> 
<!--                                                                                                <div ng-message="checkForSameEmails">Email address must not be same.</div>-->
                                                                                            </div>
                                                                                    </div>			
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-12 clol-xs-12">
                                                                                        <h3>Correspondence Address </h3>
                                                                                    </div>

                                                                                    <div class="col-md-12 clol-xs-12">
                                                                                        <hr>	
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Address <span class="error_msg">*</span></label>
                                                                                    <textarea rows="3" class="form-control" ng-model="userData.current_address" name="current_address" class="form-control" maxlength="250" oninput="if (/[^A-Za-z 0-9.,]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z 0-9.,]/g,'')" required></textarea>
                                                                                    <div ng-show="sbtBtn && frmRegistration.current_address.$invalid" ng-messages="frmRegistration.current_address.$error" class="help-block">
                                                                                        <div ng-message="required" class="error_msg">This field is required</div>
                                                                                        <div ng-message="maxlength" class="error_msg">Maximum 250 Character are Allowed</div> 
                                                                                    </div>
                                                                                </div>	
                                                                                <div class="row" ng-controller="currentCountryListCtrl">
                                                                                    <div class="col-sm-4 form-group">
                                                                                        <label>Country <span class="error_msg">*</span></label>

                                                                                        <select ng-change="onCountryChange()" ng-model="userData.current_country_id" name="current_country_id" id="current_country_id" class="form-control" required>
                                                                                            <option value="">Select Country</option>
                                                                                            <option ng-repeat="country in countryList track by $index" value="{{country.id}}" data-sortname ="{{country.sortname}}" data-phonecode="{{country.phonecode}}" ng-selected="{{ country.id == userData.current_country_id}}">{{country.name}}</option>
                                                                                        </select>
                                                                                        <div ng-show="sbtBtn && frmRegistration.current_country_id.$invalid" ng-messages="frmRegistration.current_country_id.$error" class="help-block">
                                                                                            <div ng-message="required" class="error_msg">This field is required</div>
                                                                                        </div>
                                                                                    </div>	
                                                                                    <div class="col-sm-4 form-group">
                                                                                        <label>State <span class="error_msg">*</span></label>                                                                        
                                                                                        <select ng-model="userData.current_state_id" ng-change="onStateChange()" name="current_state_id" id="current_state_id" class="form-control" required>
                                                                                            <option value="">Select State</option>
                                                                                            <option ng-repeat="state in stateList" value="{{state.id}}" ng-selected="{{ state.id == userData.current_state_id}}">{{state.name}}</option>
                                                                                        </select>
                                                                                        <div ng-show="sbtBtn && frmRegistration.current_state_id.$invalid" ng-messages="frmRegistration.current_state_id.$error" class="help-block">
                                                                                            <div ng-message="required" class="error_msg">This field is required</div>
                                                                                        </div>
                                                                                    </div>	
                                                                                    <div class="col-sm-4 form-group">
                                                                                        <label>City <span class="error_msg">*</span></label>
                                                                                        <select ng-model="userData.current_city_id" name="current_city_id" class="form-control" required>
                                                                                            <option value="">Select City</option>
                                                                                            <option ng-repeat="city in cityList" value="{{city.id}}" ng-selected="{{ city.id == userData.current_city_id}}">{{city.name}}</option>
                                                                                        </select>
                                                                                        <div ng-show="sbtBtn && frmRegistration.current_city_id.$invalid" ng-messages="frmRegistration.current_city_id.$error" class="help-block">
                                                                                            <div ng-message="required" class="error_msg">This field is required</div>
                                                                                        </div>
                                                                                    </div>		
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-sm-4 form-group">								
                                                                                        <label>Pin code <span class="error_msg">*</span></label>
                                                                                        <input type="text" ng-model="userData.current_pin" name="current_pin" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  minlength="6"  maxlength="6" required>
                                                                                            <div ng-show="sbtBtn && frmRegistration.current_pin.$invalid" ng-messages="frmRegistration.current_pin.$error" class="help-block">
                                                                                                <div ng-message="required" class="error_msg">This field is required</div>
                                                                                                <div ng-message="minlength" class="error_msg">Too short (Minimum length is 6 digit)</div>
                                                                                                <div ng-message="maxlength" class="error_msg">Too short (Maximum length is 6 digit)</div>
                                                                                            </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-12 clol-xs-12">
                                                                                        <h3>Permanent Address</h3>	
                                                                                    </div>
                                                                                    <div class="col-md-12 clol-xs-12">
                                                                                        <hr>	
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Address <span class="error_msg">*</span></label>
                                                                                    <textarea rows="3" class="form-control" ng-model="userData.permenent_address" name="permenent_address" class="form-control" maxlength="250" oninput="if (/[^A-Za-z 0-9.,]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z 0-9.,]/g,'')" required></textarea>
                                                                                    <div ng-show="sbtBtn && frmRegistration.permenent_address.$invalid" ng-messages="frmRegistration.permenent_address.$error" class="help-block">
                                                                                        <div ng-message="required" class="error_msg">This field is required.</div>
                                                                                        <div ng-message="maxlength" class="error_msg">Maximum 250 Character are Allowed.</div> 
                                                                                    </div>
                                                                                </div>	
                                                                                <div class="row" ng-controller="permanentCountryListCtrl">
                                                                                    <div class="col-sm-4 form-group">
                                                                                        <label>Country <span class="error_msg">*</span></label>

                                                                                        <select ng-change="onPCountryChange()" ng-model="userData.permenent_country_id" name="permenent_country_id" id="permenent_country_id" class="form-control" required>
                                                                                            <option value="">Select Country</option>
                                                                                            <option ng-repeat="country in countryList track by $index" value="{{country.id}}" data-sortname ="{{country.sortname}}" data-phonecode="{{country.phonecode}}" ng-selected="{{ country.id == userData.permenent_country_id}}">{{country.name}}</option>
                                                                                        </select>
                                                                                        <div ng-show="sbtBtn && frmRegistration.permenent_country_id.$invalid" ng-messages="frmRegistration.permenent_country_id.$error" class="help-block">
                                                                                            <div ng-message="required" class="error_msg">This field is required</div>
                                                                                        </div>
                                                                                    </div>	
                                                                                    <div class="col-sm-4 form-group">
                                                                                        <label>State <span class="error_msg">*</span></label>                                                                        
                                                                                        <select ng-model="userData.permenent_state_id" ng-change="onPStateChange()" name="permenent_state_id" id="permenent_state_id" class="form-control" required>
                                                                                            <option value="">Select State</option>
                                                                                            <option ng-repeat="state in stateList" value="{{state.id}}" ng-selected="{{ state.id == userData.permenent_state_id}}">{{state.name}}</option>
                                                                                        </select>
                                                                                        <div ng-show="sbtBtn && frmRegistration.permenent_state_id.$invalid" ng-messages="frmRegistration.permenent_state_id.$error" class="help-block">
                                                                                            <div ng-message="required" class="error_msg">This field is required</div>
                                                                                        </div>
                                                                                    </div>	
                                                                                    <div class="col-sm-4 form-group">
                                                                                        <label>City <span class="error_msg">*</span></label>
                                                                                        <select ng-model="userData.permenent_city_id" name="permenent_city_id" class="form-control" required>
                                                                                            <option value="">Select City</option>
                                                                                            <option ng-repeat="city in cityList" value="{{city.id}}" ng-selected="{{ city.id == userData.permenent_city_id}}">{{city.name}}</option>
                                                                                        </select>
                                                                                        <div ng-show="sbtBtn && frmRegistration.permenent_city_id.$invalid" ng-messages="frmRegistration.permenent_city_id.$error" class="help-block">
                                                                                            <div ng-message="required" class="error_msg">This field is required</div>
                                                                                        </div>
                                                                                    </div>		
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-sm-4 form-group">								
                                                                                        <label>Pin code <span class="error_msg">*</span></label>
                                                                                        <input type="text" ng-model="userData.permenent_pin" name="permenent_pin" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  minlength="6"  maxlength="6" required>
                                                                                            <div ng-show="sbtBtn && frmRegistration.permenent_pin.$invalid" ng-messages="frmRegistration.permenent_pin.$error" class="help-block">
                                                                                                <div ng-message="required" class="error_msg">This field is required</div>
                                                                                                <div ng-message="minlength" class="error_msg">Too short (Minimum length is 6 digit)</div>
                                                                                                <div ng-message="maxlength" class="error_msg">Too short (Maximum length is 6 digit)</div>
                                                                                            </div>
                                                                                    </div>
                                                                                </div>		
                                                                                <br>
                                                                                    <p ng-show="pls_wait" style="color:green">Please wait...</p>
                                                                                    <button type="submit" ng-disabled="isDisabled" class="btn btn-lg btn-info" ng-click="sbtBtn = true">Submit</button>
                                                                                    </div>
                                                                                    </form> 
                                                                                    </div>

                                                                                    </div>
                                                                                    </div>
                                                                                    <script src="/frontend/common/assets/jquery.min.js"></script>
                                                                                    <script src="/frontend/common/assets/bootstrap.min.js"></script>
                                                                                    <script src="/frontend/common/assets/jquery-ui.js"></script>	
                                                                                    <script src="/frontend/common/assets/intlTelInput.js"></script>
                                                                                    <script>
                                                                                        $(function() {
                                                                                        $("#birthdate").datepicker({
                                                                                        yearRange: '1950:2017',
                                                                                                changeYear: true,
                                                                                                changeMonth: true
                                                                                        });
                                                                                        //                                                                        $("#marriagedate").datepicker({
                                                                                        //                                                                        yearRange: '1950:2017',
                                                                                        //                                                                                changeYear: true,
                                                                                        //                                                                                changeMonth: true
                                                                                        //                                                                        });
                                                                                        $("#date_of_birth").datepicker({ yearRange: '-80:-16', dateFormat: "dd-mm-yy", defaultDate:'-16y', changeMonth: true, changeYear: true});
                                                                                        $("#marriagedate").datepicker({yearRange: '-40:-0', dateFormat: "dd-mm-yy", changeMonth: true, changeYear: true, maxDate: 0, });
                                                                                        $("#perMob").intlTelInput({
                                                                                        utilsScript: "build/js/utils.js"
                                                                                        });
                                                                                        $("#officeMob").intlTelInput({
                                                                                        utilsScript: "build/js/utils.js"
                                                                                        });
                                                                                        $("#altMob").intlTelInput({
                                                                                        utilsScript: "build/js/utils.js"
                                                                                        });
                                                                                        });
                                                                                    </script>
                                                                                    </body>
                                                                                    </html>




