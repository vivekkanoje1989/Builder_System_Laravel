<html xmlns="http://www.w3.org/1999/xhtml" ng-app="app" ng-controller="AppCtrl">
    <meta name="csrf-token" content="[[ csrf_token() ]]">
        <base href="/">
            <title>Emplyee Registration</title>
            <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                    <script src="/frontend/angular.min.js"></script>
                    <script src="/frontend/angular-route.min.js"></script>
                    <script src="/frontend/angular-animate.min.js"></script>
                    <script src="/backend/app/ng-file-upload.js"></script>
                    <script src="/frontend/route.js"></script> 
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
                                    <div class="container">
                                        <div class="well col-md-12 col-sm-12 col-xs-12 mar50" align="center">
                                            <div class="col-md-2 col-sm-3 col-xs-12"><img src="logo.png" class="logo"></div>
                                            <div class="col-md-8 col-sm-6 col-xs-12"><h1 class="form-title">Employee Registration </h1></div>
                                            <div class="col-md-2 col-sm-3 col-xs-12"><img src="logo.png" class="brand-logo"></div>
                                        </div>	
                                        <div class="col-lg-12 col-xs-12 well">
                                            <div class="">
                                                <div class="w3-container">


                                                    <form name="frmRegistration" novalidate ng-submit="frmRegistration.$valid && createUser(userData[[ $empId ]])" >
                                                        <div class="col-sm-12">



                                                            <div class="row">
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Title <span class="error_msg">*</span> </label>
                                                                    <select class="form-control" ng-model="userData.title_id" name="title_id" ng-controller="titleCtrl"  required>
                                                                        <option value="">Select Title</option>
                                                                        <option ng-repeat="t in titles track by $index" value="{{t.id}}"  ng-selected="{{ t.id == userData.title_id}}">{{t.title}}</option>
                                                                    </select>
                                                                    <div ng-show="sbtBtn && frmRegistration.title_id.$invalid" ng-messages="frmRegistration.title_id.$error" class="help-block">
                                                                        <div ng-message="required" class="error_msg">&nbsp;Title is Required</div>
                                                                    </div> 
                                                                </div>
                                                                <div class="col-sm-4 form-group">
                                                                    <label>First Name <span class="error_msg">*</span></label>
                                                                    <input type="text" class="form-control" ng-model="userData.first_name" name="first_name" maxlength="15" capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')"  maxlength="15" placeholder="Enter First Name" required>
                                                                        <div ng-show="sbtBtn && frmRegistration.first_name.$invalid" ng-messages="frmRegistration.first_name.$error"  class="help-block has-error">
                                                                            <div ng-message="required" class="error_msg">This field is required</div>
                                                                            <div ng-message="maxlength" class="error_msg">Maximum 15 Character are Allowed</div> 
                                                                        </div>  
                                                                </div>
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Last Name <span class="error_msg">*</span></label>
                                                                    <input type="text" class="form-control" ng-model="userData.last_name" name="last_name" maxlength="15"  capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')"  placeholder="Enter Last Name" maxlength="15" required>
                                                                        <div ng-show="sbtBtn && frmRegistration.last_name.$invalid" ng-messages="frmRegistration.last_name.$error"  class="help-block has-error">
                                                                            <div ng-message="required" class="error_msg">This field is required</div>
                                                                            <div ng-message="maxlength" class="error_msg">Maximum 15 Character are Allowed</div> 
                                                                        </div>
                                                                </div>
                                                            </div>	

                                                            <div class="row">
                                                                <div class="col-sm-4 form-group" ng-controller="genderCtrl">
                                                                    <label>Gender  <span class="error_msg">*</span></label>                                                        
                                                                    <select class="form-control" ng-model="userData.gender_id" name="gender_id"   required>
                                                                        <option value="">Select Gender</option>
                                                                        <option ng-repeat="genderList in genders track by $index" value="{{genderList.id}}" ng-selected="{{ genderList.id == userData.gender_id}}">{{genderList.gender}}</option>
                                                                    </select>
                                                                    <div ng-show="sbtBtn && frmRegistration.gender_id.$invalid" ng-messages="frmRegistration.gender_id.$error" class="help-block">
                                                                        <div ng-message="required" class="error_msg">&nbsp;This field is Required</div>
                                                                    </div>                                                         
                                                                </div>
                                                                
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Physical Status</label>	
                                                                    <select ng-model="userData.physic_status" name="physic_status" class="form-control"   placeholder="Select Physical" required>
                                                                        <option value="">Select Physic Status</option>
                                                                        <option value="1">Normal</option>
                                                                        <option value="2">Handicap</option>
                                                                    </select>
                                                                </div>
                                                                
                                                                <div class="col-sm-4 form-group"  ng-if="userData.physic_status==2">
                                                                    <label for="">physic  Description</label>
                                                                    <div class="form-group">
                                                                            <textarea ng-model="userData.physic_desc" name="physic_desc"  class="form-control" maxlength="50" ></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Blood Group</label>
                                                                      <select ng-model="userData.blood_group_id" ng-controller="bloodGroupCtrl" name="blood_group_id" class="form-control" >
                                                                        <option value="">Select Blood Group</option>
                                                                        <option ng-repeat="bloodGroup in bloodGroups track by $index" value="{{bloodGroup.id}}" ng-selected="{{ bloodGroup.id == userData.blood_group_id}}">{{bloodGroup.blood_group}}</option>
                                                                    </select>
                                                                </div>

                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Marriage Status <span class="error_msg">*</span></label>
                                                                    <select ng-model="userData.marital_status" name="marital_status" id="marital_status" class="form-control" required>
                                                                        <option value="">Select Marital Status</option>
                                                                        <option value="1">Single</option>
                                                                        <option value="2">Married</option>
                                                                    </select>
                                                                    <div ng-show="sbtBtn" ng-messages="frmRegistration.marital_status.$error" class="help-block">
                                                                        <div ng-message="required" class="error_msg">This field is required.</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4 form-group" ng-show="userData.marital_status == 2">
                                                                    <label>Marriage Date</label>
                                                                    <input type="text" ng-model="userData.marriage_date" class="form-control" id="marriagedate">	
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12 clol-xs-12">
                                                                    <h3>Contact Information</h3>							
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Personal Mob. No.</label>
                                                                    <input class="form-control"  id="perMob" type="tel">
                                                                </div>	
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Office  Mob. No.</label>
                                                                    <input type="tel" id="officeMob" class="form-control">
                                                                </div>	
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Alternate  Mob. No.</label>
                                                                    <input type="tel" id="altMob" class="form-control">
                                                                </div>		
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Email ID</label>
                                                                    <input type="text" class="form-control">
                                                                </div>	
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Office Email ID</label>
                                                                    <input type="text" class="form-control">
                                                                </div>	
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Alternate Email ID</label>
                                                                    <input type="text" class="form-control">
                                                                </div>		
                                                            </div>


                                                            <div class="row">
                                                                <div class="col-md-12 clol-xs-12">
                                                                    <h3>Correspondance Address </h3>							
                                                                </div>

                                                                <div class="col-md-12 clol-xs-12">
                                                                    <hr>	
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Address <span class="error_msg">*</span></label>
                                                                <textarea rows="3" class="form-control" ng-model="userData.current_address" name="current_address" class="form-control" maxlength="250" oninput="if (/[^A-Za-z 0-9.,]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z 0-9.,]/g,'')" required></textarea>
                                                                <div ng-show="sbtBtn" ng-messages="frmRegistration.current_address.$error" class="help-block">
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
                                                                    <div ng-show="sbtBtn" ng-messages="frmRegistration.current_country_id.$error" class="help-block">
                                                                        <div ng-message="required" class="error_msg">This field is required</div>
                                                                    </div>
                                                                </div>	
                                                                <div class="col-sm-4 form-group">
                                                                    <label>State <span class="error_msg">*</span></label>                                                                        
                                                                    <select ng-model="userData.current_state_id" ng-change="onStateChange()" name="current_state_id" id="current_state_id" class="form-control" required>
                                                                        <option value="">Select State</option>
                                                                        <option ng-repeat="state in stateList" value="{{state.id}}" ng-selected="{{ state.id == userData.current_state_id}}">{{state.name}}</option>
                                                                    </select>
                                                                    <div ng-show="sbtBtn" ng-messages="frmRegistration.current_state_id.$error" class="help-block">
                                                                        <div ng-message="required" class="error_msg">This field is required</div>
                                                                    </div>
                                                                </div>	
                                                                <div class="col-sm-4 form-group">
                                                                    <label>City <span class="error_msg">*</span></label>
                                                                    <select ng-model="userData.current_city_id" name="current_city_id" class="form-control" required>
                                                                        <option value="">Select City</option>
                                                                        <option ng-repeat="city in cityList" value="{{city.id}}" ng-selected="{{ city.id == userData.current_city_id}}">{{city.name}}</option>
                                                                    </select>
                                                                    <div ng-show="sbtBtn" ng-messages="frmRegistration.current_city_id.$error" class="help-block">
                                                                        <div ng-message="required" class="error_msg">This field is required</div>
                                                                    </div>
                                                                </div>		
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4 form-group">								
                                                                    <label>Pin code <span class="error_msg">*</span></label>
                                                                    <input type="text" ng-model="userData.current_pin" name="current_pin" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  ng-minlength="6" ng-maxlength="6" minlength="6"  maxlength="6" required>
                                                                    <div ng-show="sbtBtn" ng-messages="frmRegistration.current_pin.$error" class="help-block">
                                                                        <div ng-message="required" class="error_msg">This field is required</div>
                                                                        <div ng-message="minlength" class="error_msg">Too short (Minimum length is 6 digit)</div>
                                                                        <div ng-message="maxlength" class="error_msg">Too short (Maximum length is 6 digit)</div>
                                                                    </div>
                                                                </div>
                                                            </div>		
                                                            <br>
                                                                <button type="submit" class="btn btn-lg btn-info" ng-disabled="disableCreateButton" ng-click="sbtBtn=true">Submit</button>
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
                                                                        $("#marriagedate").datepicker({yearRange: '-40:-0',dateFormat: "dd-mm-yy", changeMonth: true,changeYear: true,maxDate: 0,});
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