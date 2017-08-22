<form name="sendEmailForm" novalidate ng-submit="sendEmailForm.$valid && sendResetLink(emailData)" ng-controller="adminController">
    <div class="login-container animated fadeInDown">
        <div class="loginbox bg-white">
            <div class="loginbox-title">Forgot Password</div>
            <input type="hidden" ng-model="emailData.csrfToken" name="csrftoken" id="csrftoken" ng-init="emailData.csrfToken='<?php echo csrf_token(); ?>'" class="form-control">
            <div class="loginbox-textbox">
                <input type="email" name="email" class="form-control" placeholder="Email" ng-model="emailData.email" required/>
                <div ng-show="submitted" ng-messages="sendEmailForm.email.$error">
                    <div ng-message="required">Required</div>
                    <div ng-message="email">Invalid email address</div>
                </div>
            </div>
            <div class="loginbox-submit">
                <button type="submit" class="btn btn-primary btn-block" ng-click="submitted=true">Send Password Reset Link</button>
            </div>
        </div>
        <div class="logobox">
            <span ng-if="successMsg">{{ successMsg }}</span>
        </div>
    </div>
</form>
