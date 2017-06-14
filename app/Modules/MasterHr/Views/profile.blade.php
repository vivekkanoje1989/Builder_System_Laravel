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
                                <div class="col-sm-2">
                                    <div class="form-group" >
                                        <label for="">Title</label>
                                        <span class="input-icon icon-right">
                                            <select ng-model="profileData.title_id" ng-controller="titleCtrl" name="title_id" class="form-control" ng-disabled="true">
                                                <option value="">Select Title</option>
                                                <option ng-repeat="t in titles track by $index" value="{{t.id}}" ng-selected="{{ t.id == profileData.title_id}}">{{t.title}}</option>
                                            </select>                                            
                                        </span>        
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="">First Name</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="profileData.first_name" name="first_name" class="form-control" ng-disabled="true">
                                        </span>                                
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group" >
                                        <label for="">Last Name<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="profileData.last_name"  ng-disabled="true" name="last_name" class="form-control" >
                                        </span>                                
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Profile</label>
                                        <span class="input-icon icon-right">
                                            <input type="file" ngf-select name="employee_photo_file_name" ng-model="profileData.employee_photo_file_name" id="employee_photo_file_name" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" ngf-model-invalid="errorFile" required>
                                            <div class="help-block" ng-show="btnProfile" ng-messages="frmProfile.employee_photo_file_name.$error">
                                                <div ng-message="required" class="sp-err" >Please select photo</div>
                                            </div>
                                            <div class="img-div2" data-title="name" ng-repeat="list in employee_photo_file_name_preview">    
                                                <img ng-src="{{list}}" class="thumb photoPreview">
                                            </div>
                                            <div ng-show="(!employee_photo_file_name_preview) && (flagProfilePhoto == 1)">
                                                <img ng-src="{{profilePhoto}}" class="thumb photoPreview"/>
                                            </div>
                                        </span>  
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group" >
                                        <label for="">Change Password</label>
                                        <span class="input-icon icon-right">
                                            <label>
                                                <input type="checkbox" ng-model="profileData.changePasswordflag" ng-change="changePasswordFlagFun(profileData.changePasswordflag)" class="form-control" value="false">
                                                <span class="text">Click Here</span>
                                            </label>
                                        </span>  
                                    </div>
                                </div>
                            </div>

                            <div class="row" ng-if='passwordValidation'>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">User Name</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="profileData.username" ng-disabled="true"  name="username" class="form-control" >
                                        </span>                                
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Old Password <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="password" check-old-password ng-model="profileData.oldPassword"  name="oldPassword" class="form-control" ng-required="passwordValidation==true" ng-model-options="{ allowInvalid: true, debounce: 300 }">
                                            <div ng-show="btnProfile"   ng-messages="frmProfile.oldPassword.$error" class="help-block">
                                                <div ng-message="required" class="sp-err">Old password cannot be blank.</div>
                                                <div ng-message="compareOldPassword" class="sp-err">Password could not be matched</div>
                                            </div>
                                        </span>                                
                                    </div>
                                </div>
                            </div>
                            <div class="row" ng-if='passwordValidation'>
                                <div class="col-sm-6" >
                                    <div class="form-group">
                                        <label for="">New Password<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="password" ng-model="profileData.password" ng-maxlength="6"  ng-minlength="6" name="password" class="form-control" ng-required="passwordValidation==true">
                                            <div ng-show="btnProfile" ng-messages="frmProfile.password.$error" class="help-block">
                                                <div ng-message="required" class="sp-err" >Password cannot be blank.</div>
                                                <div ng-message="maxlength"  class="sp-err" >Maximum 6 Characters Allowed.</div>
                                                <div ng-message="minlength"  class="sp-err" >Minimum 6 Characters Allowed.</div>
                                            </div>
                                        </span>                                
                                    </div>
                                </div>

                                <div class="col-sm-6" >
                                    <div class="form-group" >
                                        <label for="">Confirm Password<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="password" ng-model="password_confirmation" name="password_confirmation" class="form-control" compare-to="profileData.password" ng-required="passwordValidation==true">
                                            <div ng-show="btnProfile"  ng-messages="frmProfile.password_confirmation.$error" class="help-block">
                                                <div ng-message="required" class="sp-err">Re Enter Password cannot be blank.</div>
                                                <div ng-message="compareTo" class="sp-err">Must match password and confirm password.</div>
                                                <div ng-message="minlength" class="sp-err">Minimum 6 Characters Allowed.</div>
                                            </div>
                                        </span>                                
                                    </div>
                                </div>                                
                            </div>    
                            <div class="row">
                                <div class="col-lg-12 cl-xs-12" align="center">
                                    <button type="submit" class="btn btn-primary" ng-click="btnProfile = true">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>    
