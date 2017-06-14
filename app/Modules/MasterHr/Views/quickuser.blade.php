<form name="frmQuickEmp" novalidate ng-submit="frmQuickEmp.$valid && quickEmployee(userData)" ng-controller="hrController" >
    <input type="hidden" ng-model="frmQuikEmployee.csrfToken" name="csrftoken" id="csrftoken" ng-init="frmQuikEmployee.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
    <input type="hidden" ng-model="userData.id" name="id" ng-init="userForm.id = '0'" value="0" class="form-control">
    <input type="hidden" id="empId" value="[[ $empId ]]" class="form-control">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>Quick User</h5>
            <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12" style="box-shadow:none;">
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
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">First Name <span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <input type="text" ng-model="userData.first_name" name="first_name" class="form-control" capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')" maxlength="15" required>
                                        <i class="fa fa-user"></i>
                                        <div ng-show="btnQukEmp" ng-messages="frmQuickEmp.first_name.$error" class="help-block">
                                            <div ng-message="required" class="sp-err">This field is required.</div>
                                            <div ng-message="maxlength" class="sp-err">Maximum 15 Character are Allowed.</div> 
                                        </div>
                                    </span>                                
                                </div>  
                            </div> 
                            <div class="col-sm-3 col-xs-12">
                                <div class="form-group" >
                                    <label for="">Last Name <span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <input type="text" ng-model="userData.last_name" name="last_name" class="form-control" maxlength="15" capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')" maxlength="15" required>
                                        <i class="fa fa-user"></i>
                                        <div ng-show="btnQukEmp" ng-messages="frmQuickEmp.last_name.$error" class="help-block">
                                            <div ng-message="required" class="sp-err"> This field is required.</div>
                                            <div ng-message="maxlength" class="sp-err">Maximum 15 Character are Allowed.</div>
                                        </div>
                                    </span>
                                </div>
                            </div> 
                            <div class="col-sm-3 col-xs-12">
                                <div class="form-group" >
                                    <label for="">Personal Mobile Number <span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">   
                                        <input type="text" ng-model="userData.personal_mobile1" maxlength="20" name="personal_mobile1" id="personal_mobile1" check-unique-mobile class="form-control" ng-pattern="/^(\+\d{1,4}-)\d{10}$/" ng-model-options="{ allowInvalid: true, debounce: 300 }" ng-change="copyToUsername(userData.personal_mobile1); validateMobile(userData.personal_mobile1, 'errPersonalMobile');" required>
                                        <i class="fa fa-phone"></i>
                                        <div ng-show="btnQukEmp" ng-messages="frmQuickEmp.personal_mobile1.$error" class="help-block {{ applyClassPMobile}}">
                                            <div ng-message="required" class="sp-err">This field is required.</div>
                                            <div ng-message="pattern" class="sp-err">Mobile number should be 10 digits and pattern should be for ex. +91-9999999999</div>
                                            <div ng-message="uniqueMobile" class="sp-err">Mobile number already exists.</div>
                                            <div class="sp-err">{{ errPersonalMobile}}</div>
                                        </div>
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
                                        <input type="email" maxlength="15" ng-model="userData.personal_email1" name="personal_email1" id="personal_email1" check-unique-email ng-pattern="/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/" class="form-control" required ng-model-options="{ allowInvalid: true, debounce: 300 }">
                                        <i class="fa fa-envelope"></i>
                                        <div ng-show="btnQukEmp" ng-messages="frmQuickEmp.personal_email1.$error"  class="help-block" >
                                            <div ng-message="required" class="sp-err">This field is required.</div>
                                            <div ng-message="email" class="sp-err">Invalid email address.</div>
                                            <div ng-message="pattern" class="sp-err">Invalid email address.</div>
                                            <div ng-message="maxlength" class="sp-err">Maximum 20 Character are Allowed.</div>
                                            <div ng-message="uniqueEmail">Email address exist. Please enter another email address!</div>
                                        </div>
                                    </span>
                                </div>
                            </div> 
                            <div class="col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label>Office Mobile Number </label>
                                    <span class="input-icon icon-right">                                            
                                        <input type="text" ng-model="userData.office_mobile_no" maxlength="20" name="office_mobile_no" id="office_mobile_no" class="form-control" ng-model-options="{ updateOn: 'blur' }"  >
                                        <i class="fa fa-phone"></i>
                                    </span>
                                </div>   
                            </div>
                            <div class="col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label for=""> Office Email</label>
                                    <span class="input-icon icon-right">
                                        <input type="email" maxlength="20" ng-model="userData.office_email_id" name="office_email_id" ng-pattern="/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/" class="form-control">
                                        <i class="fa fa-envelope"></i>
                                        <div ng-show="btnQukEmp" ng-messages="frmQuickEmp.office_email_id.$error" class="help-block">
                                            <div ng-message="email" class="sp-err">Invalid email address.</div>
                                            <div ng-message="pattern" class="sp-err">Invalid email address.</div>
                                            <div ng-message="maxlength" class="sp-err">Maximum 20 Character are Allowed.</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-12">
                                <div class="form-group" >
                                    <label for="">Designation <span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select ng-model="userData.designation_id" name="designation_id" ng-controller="designationCtrl" class="form-control" required>
                                            <option value="">Please Select Designation</option>
                                            <option ng-repeat="list in designationList track by $index" value="{{list.id}}">{{list.designation}}</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                        <div ng-show="btnQukEmp" ng-messages="frmQuickEmp.designation_id.$error" class="help-block">
                                            <div ng-message="required" class="sp-err">This field is required.</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div> 
                    </div>    
                </div>    
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <div class="row">  
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Reporting To<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select ng-model="userData.reporting_to_id" name="reporting_to_id" ng-controller="teamLeadCtrl" class="form-control" required>
                                            <option value="">Please Select Reporting To</option>
                                            <option ng-repeat="reporting in teamLeads track by $index" value="{{reporting.id}}">{{reporting.first_name}} {{ reporting.last_name}} ({{ reporting.designation_name}})</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                        <div ng-show="btnQukEmp" ng-messages="frmQuickEmp.reporting_to_id.$error" class="help-block">
                                            <div ng-message="required" class="sp-err">This field is required.</div>
                                        </div>
                                    </span>	
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Team Lead<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select ng-model="userData.team_lead_id" name="team_lead_id" ng-controller="teamLeadCtrl" class="form-control" required>
                                            <option value="">Please Select Team Lead</option>
                                            <option ng-repeat="teamLead in teamLeads track by $index" value="{{teamLead.id}}">{{teamLead.first_name}} {{ teamLead.last_name}} ({{ teamLead.designation_name}})</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                        <div ng-show="btnQukEmp" ng-messages="frmQuickEmp.team_lead_id.$error" class="help-block">
                                            <div ng-message="required" class="sp-err">This field is required.</div>
                                        </div>
                                    </span>                            
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="row">  
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">    
                                    <label for="">Role<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select class="form-control" ng-model="userData.roleId" name="roleId" ng-init="manageRoles()" required>
                                            <option value="">Select Role</option>                
                                            <option ng-repeat="list in roleList track by $index" value="{{list.id}}">{{list.role_name}}</option>  
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                        <div ng-show="btnQukEmp" ng-messages="frmQuickEmp.roleId.$error" class="help-block">
                                            <div ng-message="required" class="sp-err">This field is required.</div>
                                        </div>
                                    </span>                            
                                </div>
                            </div>
                        </div>
                    </div>                        
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12" align="left">
                        <button type="submit" class="btn btn-primary" ng-click="btnQukEmp = true;">Create</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $("#personal_mobile1,#personal_mobile2,#office_mobile_no,#personal_landline_no").intlTelInput();
</script>    
