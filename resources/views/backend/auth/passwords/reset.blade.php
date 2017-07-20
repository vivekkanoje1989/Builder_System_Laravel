<div class="login-container animated fadeInDown">
    <div class="loginbox bg-white">
        <div class="loginbox-title">Reset Password</div>
        <form name="resetForm" novalidate ng-submit="resetForm.$valid && resetPassword(resetData)" ng-controller="adminController">
            <input type="hidden" ng-model="resetData.csrfToken" name="csrftoken" id="csrftoken" ng-init="resetData.csrfToken='<?php echo csrf_token(); ?>'" class="form-control">
            <input type="hidden" name="token" ng-init="resetData.token='[[ $token ]]'" ng-model="resetData.token">
            <div class="loginbox-textbox">
                <input type="email" name="email" class="form-control" placeholder="Email" ng-model="resetData.email" required/>
                <div ng-show="submitted" ng-messages="resetForm.email.$error">
                    <div ng-message="required">Required</div>
                    <div ng-message="email">Invalid email address</div>
                </div>
            </div>
            <div class="loginbox-textbox">
                <input type="password" name="password" class="form-control" placeholder="Password" minlength="6" ng-model="resetData.password" required/>
                <div ng-show="submitted" ng-messages="resetForm.password.$error">
                    <div ng-message="required">Required</div>
                    <div ng-message="minlength">Too short (Minimum length is 6 characters)</div>
                </div>
                <span ng-if="errorMsg"><br>{{ errorMsg }}</span>
            </div>
            <div class="loginbox-textbox">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" 
                       ng-model="resetData.password_confirmation" compare-to="resetData.password" required />
                <div ng-show="submitted" ng-messages="resetForm.password_confirmation.$error">
                    <div ng-message="required">Required</div>
                    <div ng-message="compareTo">Must match the previous entry</div>
                </div>
            </div>
            <div class="loginbox-submit">
                <button type="submit" class="btn btn-primary btn-block" ng-click="submitted=true">Reset Password</button>
            </div>
        </form>
    </div>
    <div class="logobox">
    </div>
</div>