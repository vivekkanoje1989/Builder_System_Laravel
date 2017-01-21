<style>
    .actions {
        z-index: 0 !important;
    }
</style>
<form name="userForm" novalidate ng-submit="userForm.$valid && createUser(userData)" ng-controller="userController">
    <input type="hidden" ng-model="userForm.csrfToken" name="csrftoken" id="csrftoken" ng-init="userForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{ pageHeading}}</h5>

            <div class="step-content" id="WiredWizardsteps">
                <div class="form-title">Personal Information</div>
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for="">Title <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select ng-controller="titleCtrl" ng-model="userData.title" name="title" class="form-control" required>
                                    <option value="0">Select Title</option>
                                    <option ng-repeat="t in titles track by $index" value="{{t.value}}">{{t.title}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for="">First Name <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="userData.first_name" name="first_name" class="form-control" oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" required>
                                <i class="fa fa-user"></i>
                            </span>                                
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for="">Middle Name</label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="userData.middle_name" name="middle_name" class="form-control" oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')">
                                <i class="fa fa-user"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group" >
                            <label for="">Last Name <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="userData.last_name" name="last_name" class="form-control" oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" required>
                                <i class="fa fa-user"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <label>Birth Date <span class="sp-err">*</span></label>
                        <div ng-controller="DatepickerDemoCtrl">
                            <p class="input-group">
                                <input type="text" ng-model="userData.dt" name="date_of_birth" class="form-control" datepicker-popup="{{format}}" is-open="opened" min-date="minDate" max-date=maxDate datepicker-options="dateOptions" ng-required="true" close-text="Close" ng-click="toggleMin()" readonly required/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for="">Gender <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select ng-controller="genderCtrl" ng-model="userData.gender" name="gender" class="form-control" required>
                                    <option value="0">Select Gender</option>
                                    <option ng-repeat="gender in genders" value="{{gender.gender_id}}">{{gender.gender_title}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
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
                        <div class="form-group">
                            <label for="">Married Status <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select ng-model="userData.marital_status" name="marital_status" class="form-control" required>
                                    <option value="0">Select Marital Staus</option>
                                    <option value="1">Single</option>
                                    <option value="2">Married</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for="">Physic <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right" required>
                                <select ng-model="userData.physic_status_id" name="physic_status_id" class="form-control" placeholder="Select Physic">
                                    <option value="0">Normal</option>
                                    <option value="1">Handicap</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
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
                <div class="form-title">
                    Contact Information
                </div>
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for="">Office Mobile Number <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">                                
                                <input type="text" ng-model="userData.office_mobile_country_id" name="office_mobile_country_id" style="width:20%;" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                <input type="text" ng-model="userData.office_mobile_no" name="office_mobile_no" class="form-control" required oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                <i class="fa fa-phone"></i>
                                <div ng-messages="myForm1.office_mobile_no.$error" ng-if='myForm1.office_mobile_no.$dirty'>
                                    <div ng-message="required">This is required.</div>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>Personal Mobile Number <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="userData.mobile1_country_id" name="mobile1_country_id" style="width:20%;" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                <input type="text" ng-model="userData.personal_mobile_no1" name="personal_mobile_no1" class="form-control" >
                                <i class="fa fa-phone"></i>
                                <p ng-show="userForm.personal_mobile_no1.$invalid && !userForm.personal_mobile_no1.$pristine" class="help-block">This field is required.</p>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for="">Email <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="userData.email" name="email" class="form-control" required>
                                <i class="fa fa-envelope"></i>
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
                                <input type="text" ng-model="userData.mobile2_country_id" name="mobile2_country_id" style="width:20%;" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                <input type="text" ng-model="userData.personal_mobile_no2" name="personal_mobile_no2" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
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
                            <div class="form-group">
                                <label for="">Correspondence Address <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <textarea ng-model="userData.current_address" name="current_address" class="form-control" required></textarea>
                                    <i class="fa fa-map-marker"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6 pad-left">
                            <div class="form-group">
                                <label for="">Select Country <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select ng-controller="countryListCtrl" ng-model="userData.current_country_id" name="current_country_id" class="form-control" required>
                                        <option value="0">Select Country</option>
                                        <option ng-repeat="country in countryList" value="{{country.countrycode}}">{{country.countryname}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6 pad-right">
                            <div class="form-group">
                                <label for="">Select State <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select ng-controller="stateListCtrl" ng-model="userData.current_state_id" name="current_state_id" class="form-control" required>
                                        <option value="0">Select State</option>
                                        <option ng-repeat="state in stateList" value="{{state.state_id}}">{{state.state_name}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6 pad-left">
                            <label for="">Pin Code <span class="sp-err">*</span></label>
                            <div class="form-group">
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="userData.current_pin" name="current_pin" class="form-control" required>
                                    <i class="fa fa-map-pin"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6 pad-right">
                            <label for="">Select City <span class="sp-err">*</span></label>											
                            <div class="form-group">
                                <span class="input-icon icon-right">
                                    <select ng-controller="cityListCtrl" ng-model="userData.current_city_id" name="current_city_id" class="form-control" required>
                                        <option value="0">Select City</option>
                                        <option ng-repeat="city in cityList" value="{{city.city_id}}">{{city.city_name}}</option>
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
                                    <textarea ng-model="userData.permenent_address" name="permenent_pin" class="form-control" required></textarea>
                                    <i class="fa fa-map-marker"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6 pad-left">
                            <div class="form-group">
                                <label for="">Select Country</label>
                                <span class="input-icon icon-right">
                                    <select ng-controller="countryListCtrl" ng-model="userData.permenent_country_id" name="permenent_country_id" class="form-control">
                                        <option value="0">Select Country</option>
                                        <option ng-repeat="country in countryList" value="{{country.countrycode}}">{{country.countryname}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6 pad-right">
                            <div class="form-group">
                                <label for="">Select State</label>
                                <span class="input-icon icon-right">
                                    <select ng-controller="stateListCtrl" ng-model="userData.permenent_state_id" name="permenent_state_id" class="form-control">
                                        <option value="0">Select State</option>
                                        <option ng-repeat="state in stateList" value="{{state.state_id}}">{{state.state_name}}</option>
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
                                    <select ng-controller="cityListCtrl" ng-model="userData.permenent_city_id" name="permenent_city_id" class="form-control">
                                        <option value="0">Select City</option>
                                        <option ng-repeat="city in cityList" value="{{city.city_id}}">{{city.city_name}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-title">
                    Educational & Other Details
                </div>
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for="">Highest Education</label>
                            <span class="input-icon icon-right">
                                <select ng-controller="educationListCtrl" ng-model="userData.highest_education_id" name="highest_education_id" class="form-control">
                                    <option value="0">Select Education</option>
                                    <option ng-repeat="list in educationList track by $index" value="{{list.education_id}}">{{list.education_title}}</option>
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
                            <label for="">Employee Photo ( W 105 X H 120 )<span class="sp-err">*</span></label>
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
                <div class="form-title">
                    Job Offer Details
                </div>
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group multi-sel-div" ng-controller="departmentCtrl">
                            <label for="">Select Department <span class="sp-err">*</span></label>	
                            <ui-select multiple ng-model="userData.department_id" theme="select2" ng-disabled="disabled" style="width: 300px;">
                                <ui-select-match placeholder="Select Departments">{{$item.department_name}}</ui-select-match>
                                <ui-select-choices repeat="list in departments | filter:$select.search">
                                {{list.department_name}} 
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for="">Designation <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="userData.designation" name="designation" class="form-control" oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" required>
                                <i class="fa fa-handshake-o"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for="">Reporting To<span class="sp-err">*</span></label>
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
                            <label>Joining Date<span class="sp-err">*</span></label>
                            <div ng-controller="DatepickerDemoCtrl">
                                <p class="input-group">
                                    <input type="text" ng-model="userData.joining_date" name="joining_date" class="form-control" datepicker-popup="{{format}}" is-open="opened" datepicker-options="dateOptions" ng-required="true" close-text="Close" ng-click="toggleMin()" readonly required/>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <input name="form-field-radio" type="radio" ng-model="userData.employee_status" value="1" class="colored-blue">
                                        <span class="text">Active </span>
                                    </label>
                                </div>

                                <div class="radio">
                                    <label>
                                        <input name="form-field-radio" type="radio" ng-model="userData.employee_status" value="2" class="colored-danger">
                                        <span class="text">  Temporary Suspended </span>
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input name="form-field-radio" type="radio" ng-model="userData.employee_status" value="3" class="colored-success">
                                        <span class="text"> Permanently Suspended  </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>User Name <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="userData.username" name="username" class="form-control" required>
                                <i class="fa fa-user"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>Password <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="password" ng-model="userData.password" name="password" class="form-control" required>
                                <i class="fa fa-lock"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group" ng-class="{ 'has-error' : userForm.password_confirmation.$error}">
                            <label>Re Enter Password <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="password" ng-model="userData.password_confirmation" name="password_confirmation" class="form-control" compare-to="userData.password" required>
                                <i class="fa fa-lock"></i>
                                <div ng-show="submitted" ng-messages="userForm.password_confirmation.$error" class="help-block">
                                    <div ng-message="required">This field is required.</div>
                                    <div ng-message="compareTo">Must match password and confirm password</div>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>						
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary" ng-click="submitted=true">Create</button>
</form>
<script>
$(document).ready(function(){
    $("#next").click(function() {
    var btnValue = $("#next").text();
    if (btnValue === 'Finish')
    {
        $("form").submit();
    }
});
//        $(".step-pane").attr("ng-form",""); 
//        var attrName = $(".step-pane.active").attr("id");alert(attrName);
//        $(".step-pane.active").attr("ng-form",'myForm');  
//        $( "#next" ).click(function() {
//            $(".step-pane").removeAttr("ng-form"); 
//            var removeLastChar = attrName.slice(0, -1);
//            var actualParam = removeLastChar + (parseInt(attrName.substr(attrName.length -1)) + 1);
//            $("#"+actualParam).attr("ng-form",'myForm');  
//            alert(actualParam);
//        });

    });
</script>