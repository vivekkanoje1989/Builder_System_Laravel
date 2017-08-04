
<form name="frmQuickEmp" novalidate ng-submit="frmQuickEmp.$valid && userData.department_id != '' && userData.department_id != undefined && quickEmployee(userData);" ng-controller="hrController" >
    <input type="hidden" ng-model="frmQuikEmployee.csrfToken" name="csrftoken" id="csrftoken" ng-init="frmQuikEmployee.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">

    <div class="row" ng-init=" manageQuickUsers();">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>Quick User</h5>

            <div class="step-content" id="WiredWizardsteps">

                <div class="step-pane active" id="wiredstep2">	
                    <div class="form-title">
                        &nbsp;
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Title <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select ng-model="userData.title_id" ng-controller="titleCtrl" name="title_id" class="form-control" required>
                                                <option value="">Select Title</option>
                                                <option ng-repeat="t in titles track by $index" value="{{t.id}}" >{{t.title}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div ng-show="btnQukEmp" ng-messages="frmQuickEmp.title_id.$error" class="help-block">
                                                <div ng-message="required" class="sp-err">This field is required.</div>
                                            </div>
                                            <div ng-if="title_id" class="sp-err title_id">{{title_id}}</div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label for="">First Name <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="userData.first_name" name="first_name" class="form-control"  capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')"    maxlength="15" required>
                                            <i class="fa fa-user"></i>
                                            <div ng-show="btnQukEmp" ng-messages="frmQuickEmp.first_name.$error" class="help-block">
                                                <div ng-message="required" class="sp-err">This field is required.</div>
                                                <div ng-message="maxlength" class="sp-err">Maximum 15 Character are Allowed.</div> 
                                            </div>
                                             <div ng-if="first_name" class="sp-err first_name">{{first_name}}</div>
                                        </span>                                
                                    </div>  
                                </div> 
                                <div class="col-sm-3 col-xs-12">
                                    <div class="form-group" >
                                        <label for="">Last Name <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="userData.last_name" name="last_name" class="form-control"  maxlength="15" capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')"  maxlength="15"  required>
                                            <i class="fa fa-user"></i>
                                            <div ng-show="btnQukEmp" ng-messages="frmQuickEmp.last_name.$error" class="help-block">
                                                <div ng-message="required" class="sp-err"> This field is required.</div>
                                                <div ng-message="maxlength" class="sp-err">Maximum 15 Character are Allowed.</div>
                                            </div>
                                             <div ng-if="last_name" class="sp-err last_name">{{last_name}}</div>
                                        </span>
                                    </div>
                                </div> 
                                <div class="col-sm-3 col-xs-12">
                                    <div class="form-group" ng-class="{ 'has-error' : step2 && (!frmQuickEmp.personal_mobile1.$dirty && frmQuickEmp.personal_mobile1.$invalid)}">
                                        <label for="">Personal Mobile Number<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right"> 
                                            <input type="text" ng-model="userData.personal_mobile1" ng-minlength="10" maxlength="10"  oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" name="personal_mobile1" check-unique-mobile id="personal_mobile1" class="form-control"  ng-model-options="{ allowInvalid: true, debounce: 300 }"  ng-change="copyToUsername(userData.personal_mobile1); validatePMobile(userData.personal_mobile1, 'errPersonalMobile');"  required>
                                            <i class="fa fa-phone"></i>
                                            <div ng-show="btnQukEmp || errPersonalMobile" ng-messages="frmQuickEmp.personal_mobile1.$error" class="help-block step2 {{ applyClassPMobile}}">
                                                <div ng-message="required" class="sp-err">This field is required.</div>
                                                <div ng-message="minlength" class="sp-err">Personal mobile no. must be 10 digits</div>
                                                <div ng-message="pattern" class="sp-err">Mobile number should be 10 digits and pattern should be for ex. +91-9999999999</div>
                                                <div ng-message="uniqueMobile" class="sp-err">Number already exists enter different number</div>
                                                <div class="sp-err">{{ errPersonalMobile}}</div>
                                            </div>
                                            <div ng-if="personal_mobile1" class="sp-err personal_mobile1">{{personal_mobile1}}</div>
                                        </span>
                                    </div>
                                </div>
                            </div> 
                        </div>                        
                        <div class="col-sm-12 col-xs-12">
                            <div class="row">  
                                <div class="col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label for=""> Personal Email<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="email" maxlength="45" ng-model="userData.personal_email1" check-unique-email name="personal_email1" ng-pattern="/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/" class="form-control" ng-model-options="{ allowInvalid: true, debounce: 300 }" required>
                                            <i class="fa fa-envelope"></i>
                                            <div ng-show="btnQukEmp" ng-messages="frmQuickEmp.personal_email1.$error"  class="help-block" >
                                                <div ng-message="required" class="sp-err">This field is required.</div>
                                                <div ng-message="email" class="sp-err">Invalid email address.</div>
                                                <div ng-message="pattern" class="sp-err">Invalid email address.</div>
                                                <div ng-message="maxlength" class="sp-err">Maximum 45 Character are Allowed.</div>
                                                <div ng-message="uniqueEmail" class="sp-err">Email address exist. Please enter another email address!</div>
                                            </div>
                                             <div ng-if="personal_email1" class="sp-err personal_email1">{{personal_email1}}</div>
                                        </span>
                                    </div>
                                </div>                                
                                <div class="col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Office Mobile Number</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="userContact.office_mobile_no" maxlength="10" ng-minlength="10" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  name="office_mobile_no" id="office_mobile_no" class="form-control"  ng-model-options="{ updateOn: 'blur' }" ng-change="validateOfficeMobileNumber(userContact.office_mobile_no, 'errOfficeNOMobile')">
                                            <i class="fa fa-phone"></i>
                                            <div ng-show="btnQukEmp || errOfficeMobile || errOfficeNOMobile" ng-messages="userContactForm.office_mobile_no.$error" class="help-block step2 {{ applyOfficeClassMobile}}">
                                                <div ng-message="minlength" class="sp-err">Office Mobile Number must be 10 digits</div>
                                                <div class="sp-err">{{ errOfficeMobile}}</div>
                                                <div class="sp-err">{{ errOfficeNOMobile}}</div>
                                            </div>
                                            <div ng-if="office_mobile_no" class="sp-err office_mobile_no">{{office_mobile_no}}</div>
                                        </span>                               
                                    </div> 
                                </div>
                                <div class="col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label for=""> Office Email</label>
                                        <span class="input-icon icon-right">
                                            <input type="email" maxlength="45" ng-model="userData.office_email_id" name="office_email_id" ng-pattern="/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/" class="form-control">
                                            <i class="fa fa-envelope"></i>
                                            <div ng-show="btnQukEmp" ng-messages="frmQuickEmp.office_email_id.$error" class="help-block">
                                                <div ng-message="email" class="sp-err">Invalid email address.</div>
                                                <div ng-message="pattern" class="sp-err">Invalid email address.</div>
                                                <div ng-message="maxlength" class="sp-err">Maximum 45 Character are Allowed.</div>
                                            </div>
                                              <div ng-if="office_email_id" class="sp-err office_email_id">{{office_email_id}}</div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Select Designation <span class="sp-err">*</span></label>	
                                        <ui-select ng-model="userData.designation_id" name="designation_id" required ng-controller="designationCtrl" theme="select2" style='width: 100%;'  >                                        
                                            <ui-select-match placeholder="Select or search a Designation">{{$select.selected.designation}}</ui-select-match>
                                            <ui-select-choices repeat="item in designationList | filter: $select.search">
                                                <div ng-bind-html="item.designation | highlight: $select.search" ></div>
                                            </ui-select-choices>
                                        </ui-select>
                                        <div ng-show="btnQukEmp" ng-messages="frmQuickEmp.designation_id.$error" class="help-block">
                                            <div ng-message="required" class="sp-err">This field is required.</div>
                                        </div>
                                         <div ng-if="designation_id" class="sp-err designation_id">{{designation_id}}</div>
                                    </div>
                                </div>
                            </div> 
                        </div>    

                        <div class="col-sm-12 col-xs-12">
                            <div class="row">  
                                <div class="col-sm-3 col-xs-12">
                                    <div class="form-group"  ng-controller="teamLeadCtrlforQuick">
                                        <label for=""> Report To <span class="sp-err">*</span></label>	
                                        <ui-select ng-model="userData.reporting_to_id" required  name="reporting_to_id" id="reporting_to_id" theme="select2" style='width: 100%;' >                                        
                                            <ui-select-match placeholder="Select or Search  Report To">{{$select.selected.first_name + ' ' + $select.selected.last_name + ' ' + '(' + $select.selected.designation_name.designation + ')'}}</ui-select-match>
                                            <ui-select-choices repeat="reporting in teamLeadsforQuick | filter: $select.search">
                                                <div ng-bind-html="reporting.first_name+' '+ reporting.last_name + '('+ reporting.designation_name.designation+')' | highlight: $select.search" ></div>
                                            </ui-select-choices>
                                        </ui-select>
                                        <div ng-show="btnQukEmp" ng-messages="frmQuickEmp.reporting_to_id.$error" class="help-block">
                                            <div ng-message="required" class="sp-err">This field is required.</div>
                                        </div>
                                         <div ng-if="reporting_to_id" class="sp-err reporting_to_id">{{reporting_to_id}}</div>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-12">
                                    <div class="form-group"  ng-controller="teamLeadCtrlforQuick">
                                        <label for="">Team lead <span class="sp-err">*</span></label>	
                                        <ui-select ng-model="userData.team_to_id" required name="team_to_id" id="team_to_id" theme="select2" style='width: 100%;' >                                        
                                            <ui-select-match placeholder="Select or Search  Team lead">{{$select.selected.first_name + ' ' + $select.selected.last_name + ' ' + '(' + $select.selected.designation_name.designation + ')'}}</ui-select-match>
                                            <ui-select-choices repeat="team in teamLeadsforQuick | filter: $select.search">
                                                <div ng-bind-html="team.first_name+' '+ team.last_name + '('+ team.designation_name.designation+')' | highlight: $select.search" ></div>
                                            </ui-select-choices>
                                        </ui-select>
                                        <div ng-show="btnQukEmp" ng-messages="frmQuickEmp.team_to_id.$error" class="help-block">
                                            <div ng-message="required" class="sp-err">This field is required.</div>
                                        </div>
                                        <div ng-if="team_lead_id" class="sp-err team_lead_id">{{team_lead_id}}</div>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-12">
                                    <div class="form-group">                                         
                                        <label for="">Role</label>
                                        <ui-select ng-model="userData.roleId" name="roleId" id="roleId"  theme="select2" ng-init="manageRoles()" style='width: 100%;'>                                        
                                            <ui-select-match placeholder="Select or Search Role">{{$select.selected.role_name}}</ui-select-match>
                                            <ui-select-choices repeat="role in roleList | filter: $select.search">
                                                <div ng-bind-html="role.role_name | highlight: $select.search" ></div>
                                            </ui-select-choices>
                                        </ui-select>                                                 
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group multi-sel-div" ng-class="{ 'has-error' : (btnQukEmp && (!userData.department_id.$dirty && userData.department_id.$invalid)) && emptyDepartmentId}" ng-controller="departmentCtrl">
                                        <label for="">Select Departments <span class="sp-err">*</span></label>	
                                        <ui-select multiple ng-model="userData.department_id" name="department_id" theme="select2" ng-disabled="disabled" style="width: 300px;"   ng-change="checkDepartment(1)">
                                            <ui-select-match>{{$item.department_name}}</ui-select-match>
                                            <ui-select-choices repeat="list in departments | filter:$select.search">
                                                {{list.department_name}} 
                                            </ui-select-choices>
                                        </ui-select>
                                        <div ng-show="btnQukEmp" class="sp-err" ng-if="userData.department_id.length==0 || userData.department_id.length == null">This field is required.</div>
<!--                                        <div ng-show="btnQukEmp" class="help-block {{ applyClassDepartment}}">
                                            <p class="sp-err">This field is required.</p>
                                        </div>-->
                                         <div ng-if="department_id" class="sp-err department_id">{{department_id}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group" ng-class="{ 'has-error' : step4 && (!userJobForm.joining_date.$dirty && userJobForm.joining_date.$invalid)}">
                                        <label>Joining Date<span class="sp-err">*</span></label>
                                        <div ng-controller="DatepickerDemoCtrl">
                                            <p class="input-group">
                                                <input type="text" ng-model="userData.joining_date" name="joining_date" class="form-control" datepicker-popup="dd-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required/>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                </span>
                                            </p>
                                            <div ng-show="btnQukEmp" ng-messages="frmQuickEmp.joining_date.$error" class="help-block step4">
                                                <div ng-message="required" class="sp-err">This field is required.</div>
                                            </div>
                                            <div ng-if="joining_date" class="sp-err joining_date">{{joining_date}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="center">
                            <button type="submit" ng-disabled="isDisabled" class="btn btn-primary" ng-click="btnQukEmp = true; emptyDepartmentId = true;">Create</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $("#personal_mobile1_calling_code,#office_mobile_calling_code").intlTelInput();</script>    
