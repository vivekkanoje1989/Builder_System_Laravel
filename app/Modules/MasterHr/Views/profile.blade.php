<style>
    .img-cstdiv{
        position: fixed;
    }

</style>
<div ng-controller="hrController" ng-init="getProfile()">
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <form ng-submit="frmProfile.$valid && updateProfile(profileData)"  name="frmProfile"  novalidate enctype="multipart/form-data"  >
                <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                <div class="widget flat radius-bordered">
                    <div class="widget-header bordered-bottom bordered-themeprimary">
                        <span class="widget-caption">Profile</span>
                    </div>
                    <div class="widget-body">
                        <div id="pricing-form">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group" >
                                        <label id="lbltitle" for="">Title</label>
                                        <span class="input-icon icon-right">
                                            <select ng-model="profileData.title_id" ng-controller="titleCtrl" id="title_id" name="title_id" class="form-control" ng-disabled="true">
                                                <option value="">Select Title</option>
                                                <option ng-repeat="t in titles track by $index" value="{{t.id}}" ng-selected="{{ t.id == profileData.title_id}}">{{t.title}}</option>
                                            </select>                                            
                                        </span>        
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label id="lblfn" for="">First Name</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="profileData.first_name" name="first_name" id="first_name" class="form-control" ng-disabled="true">
                                        </span>                                
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group" >
                                        <label id="lblln" for="">Last Name</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="profileData.last_name"  ng-disabled="true" id="last_name" name="last_name" class="form-control" >
                                        </span>                                
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label id="lblpp" for="">Profile picture<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="file" ngf-select name="employee_photo_file_name" id="employee_photo_file_name"   ng-model="profileData.employee_photo_file_name" id="employee_photo_file_name" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile"> 
                                            <div ng-show="btnProfile"   ng-messages="frmProfile.employee_photo_file_name.$error" class="help-block">
                                                <div id="err_pp" ng-message="required" class="sp-err">Profile picture cannot be blank.</div>
                                            </div>
                                        </span>  
                                    </div>
                                </div>
                            </div> 

                            <div class="row">
                                <div class="col-lg-3 cl-xs-3">
                                    <div ng-repeat="list in employee_photo_file_name_preview">    
                                        <img ng-src="{{list}}" class="thumb" style="width: 60%;"/>
                                    </div>
                                    <div ng-show="(!employee_photo_file_name_preview) && (flag_profile_photo == 1)">
                                        <img ng-src="{{old_profile_photo}}" class="thumb" style="width: 60%;"/>
                                    </div>
                                </div>
                                <div class="col-lg-9 cl-xs-9" align="center">
                                    <button type="submit" class="btn btn-primary" id="btn_update_profile" ng-click="btnProfile = true" style="margin-top: 7%;">Update Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <form ng-submit="frmPassword.$valid && updatePassword(profileData)" id="frmPassword"  name="frmPassword"  novalidate  >
                <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                <div class="widget flat radius-bordered">
                    <div class="widget-header bordered-bottom bordered-themeprimary">
                        <span class="widget-caption">Change Password</span>
                    </div>
                    <div class="widget-body">
                        <div id="pricing-form">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label id="lbluname" for="">User Name</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="profileData.username" ng-disabled="true"  name="username" class="form-control" >
                                        </span>                                
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label id="lbloldpassword" for="">Old Password <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="password" check-old-password ng-model="profileData.oldPassword" id="oldPassword"  name="oldPassword" maxlength="15" class="form-control" required ng-model-options="{ allowInvalid: true, debounce: 300 }">
                                            <div ng-show="btnfrmPassword"   ng-messages="frmPassword.oldPassword.$error" class="help-block">
                                                <div id="err_old_required" ng-message="required" class="sp-err">Old password cannot be blank.</div>
                                                <div id="err_old_pass_match" ng-message="compareOldPassword" class="sp-err">Password could not be matched</div>
                                            </div>
                                            <div ng-if="oldPassword" class="sp-err oldPassword">{{oldPassword}}</div>
                                        </span>                                
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <div class="col-sm-6" >
                                    <div class="form-group">
                                        <label id="lblnewpassword" for="">New Password<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="password" ng-model="profileData.password"  ng-pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/" name="password" class="form-control" required>
                                            <div ng-show="btnfrmPassword" ng-messages="frmPassword.password.$error" class="help-block">
                                                <div id="err_new_pass_blank" ng-message="required" class="sp-err" >New Password cannot be blank.</div>
                                                <div id="err_new_pass_pattern" ng-message="pattern" class="sp-err" >Password must contain at least one uppercase letter, one lowercase letter, one number and one special character</div>

                                            </div>
                                            <div ng-if="password" class="sp-err password">{{password}}</div>
                                        </span>                                
                                    </div>
                                </div>

                                <div class="col-sm-6" >
                                    <div class="form-group" >
                                        <label id="lblconfirmpassowrd" for="">Confirm Password<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="password" ng-model="password_confirmation" name="password_confirmation" maxlength="15"  minlength="8" class="form-control" compare-to="profileData.password" required>
                                            <div ng-show="btnfrmPassword"  ng-messages="frmPassword.password_confirmation.$error" class="help-block">
                                                <div id="err_cof_pass" ng-message="required" class="sp-err">Confirm Password cannot be blank.</div>
                                                <div id="err_cof_pass_compareto" ng-message="compareTo" class="sp-err">Must match new password and confirm password.</div>
                                                <div id="err_cof_pass_minlength" ng-message="minlength" class="sp-err">Minimum 8 Characters Allowed.</div>
                                            </div>

                                        </span>                                
                                    </div>
                                </div>                                
                            </div>    

                            <div class="row">
                                <div class="col-lg-12 cl-xs-12" align="center">
                                    <br><br> <br>
                                    <button type="submit" class="btn btn-primary" id="btn_chang_password" ng-click="btnfrmPassword = true">Change Password</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>    
