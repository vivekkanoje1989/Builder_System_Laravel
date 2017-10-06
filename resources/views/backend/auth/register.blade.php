<div class="register-container animated fadeInDown">
    <div class="registerbox bg-white">
        <form name="registrationForm" novalidate ng-submit="registrationForm.$valid && signUp(registration)" ng-controller="adminController">
            <div class="registerbox-title">Register</div>
            <input type="hidden" ng-model="registration.csrfToken" name="csrftoken" id="csrftoken" ng-init="registration.csrfToken='<?php echo csrf_token(); ?>'" class="form-control">
            <div class="registerbox-caption ">Please fill your information</div>
            <div class="registerbox-textbox">
                <input type="text" name="username" class="form-control" placeholder="Username" ng-model="registration.username" required/>
                <span class="help-inline" ng-show="submitted && registrationForm.username.$error.required">Required</span>
            </div>
            <div class="registerbox-textbox">
                <input type="password" name="password" class="form-control" placeholder="Enter Password" ng-model="registration.password" minlength="6" required/>
                <div ng-show="submitted" ng-messages="registrationForm.password.$error">
                    <div ng-message="required">Required</div>
                    <div ng-message="minlength">Too short</div>
                </div>
            </div>
            <div class="registerbox-textbox">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" 
                       ng-model="registration.password_confirmation" compare-to="registration.password" required />
                <div ng-show="submitted" ng-messages="registrationForm.password_confirmation.$error">
                    <div ng-message="required">Required</div>
                    <div ng-message="compareTo">Must match the previous entry</div>
                </div>
            </div>
            <hr class="wide" />
            <div class="registerbox-textbox">
                <input type="text" name="name" class="form-control" placeholder="Name" ng-model="registration.name" required/>
                <span class="help-inline" ng-show="submitted && registrationForm.name.$error.required">Required</span>
            </div>
            <div class="registerbox-textbox">
                <input type="email" name="email" class="form-control" placeholder="Email" ng-model="registration.email" required/>
                <div ng-show="submitted" ng-messages="registrationForm.email.$error">
                    <div ng-message="required">Required</div>
                    <div ng-message="email">Invalid email address</div>
                </div>
            </div>
            <div class="registerbox-textbox no-padding-bottom">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="checkTerms" class="colored-primary" checked="checked" ng-model="registration.checkTerms" required>
                        <span class="text darkgray">I agree to the Company <a class="themeprimary">Terms of Service</a> and Privacy Policy</span>
                    </label>
                    <span class="help-inline" ng-show="submitted && registrationForm.checkTerms.$error.required">Please select checkbox</span>                    
                </div>
            </div>
            <div class="registerbox-submit">
                <button type="submit" class="btn btn-primary pull-right" ng-click="submitted=true">Register!</button>
            </div>
        </form>
    </div>
    <div class="logobox">
    </div>
</div>