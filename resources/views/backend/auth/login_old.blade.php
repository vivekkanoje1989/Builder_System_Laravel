<style>
    .div-forgot{
        display:none;
    }
    .errorBorder{
        outline:none !important;
        border:2px solid #bc2024 !important;
        box-shadow: 0 0 10px #bc2024l !important;
    }
</style>

<div class="login-container animated fadeInDown">
    <div class="loginbox bg-white div-log">
        <div class="loginbox-title">SIGN IN</div>
        <div class="loginbox-or">
            <div class="or-line"></div>
            <div class="or"><i class="fa fa-sort-desc" aria-hidden="true"></i></div>
        </div>
        <form name="loginForm" novalidate ng-submit="loginForm.$valid && login(loginData)" ng-controller="adminController">
            <input type="hidden" ng-model="loginData.csrfToken" name="csrftoken" id="csrftoken" ng-init="loginData.csrfToken='<?php echo csrf_token(); ?>'" class="form-control">
            <div class="loginbox-textbox">
                <input type="text" name="mobile" class="form-control" placeholder="Mobile No." ng-model="loginData.mobile" ng-blur="login(loginData)" required/>
                <div ng-show="submitted" ng-messages="loginForm.mobile.$error">
                    <div ng-message="required">Required</div>
                    <div ng-message="pattern">Invalid mobile no.</div>
                </div>
            </div>
            <div class="loginbox-textbox">
                <input type="password" name="password" class="form-control" placeholder="Password" minlength="6" ng-model="loginData.password" ng-change="resetErrorMsg()" required/>
                <div ng-show="submitted" ng-messages="loginForm.password.$error">
                    <div ng-message="required">Required</div>
                    <div ng-message="minlength">Too short (Minimum length is 6 characters)</div>
                </div>
                <span ng-if="errorMsg"><br>{{ errorMsg }}</span>
            </div>
            <div class="loginbox-forgot">
                <a href="" id="btn1">Forgot Password?</a>
            </div>
            <div class="loginbox-submit">
                <button type="submit" class="btn btn-primary btn-block" ng-click="submitted=true">Login</button>
            </div>
        </form>     
    </div>
    <div class="loginbox bg-white div-forgot">
        <div class="loginbox-title">FILL FORM</div>
        <div class="loginbox-or">
            <div class="or-line"></div>
            <div class="or"><i class="fa fa-sort-desc" aria-hidden="true"></i></div>
        </div>
        <form name="sendEmailForm" novalidate ng-submit="sendEmailForm.$valid && sendResetLink(getData)" ng-controller="adminController">
            <input type="hidden" ng-model="getData.csrfToken" name="csrftoken" id="csrftoken" ng-init="getData.csrfToken='<?php echo csrf_token(); ?>'" class="form-control">
            <div class="loginbox-textbox">
                <input type="text" name="mobile" id="mobno" class="form-control" placeholder="Mobile No." ng-model="getData.mobile" pattern="\d{10}" oninput="if (/[^0-9 ]/g.test(this.value)) this.value = this.value.replace(/[^0-9 ]/g,'')"/>
                <div ng-show="submitted" ng-messages="sendEmailForm.mobile.$error">
                    <div ng-message="required">Required</div>
                    <div ng-message="pattern">Invalid mobile no.</div>
                </div>
            </div>
                <div class="loginbox-or">
                <div class="or-line"></div>
                <div class="or">OR</div>
            </div>
            <div class="loginbox-textbox">
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" ng-model="getData.email" />
                <div ng-show="submitted" ng-messages="sendEmailForm.email.$error">
                    <div ng-message="required">Required</div>
                    <div ng-message="email">Invalid email address</div>
                </div>
                <span ng-if="errorMsg">{{ errorMsg }}</span>
                <span ng-if="successMsg">{{ successMsg }}</span>
            </div>		
            <div class="loginbox-forgot">
                <a href="" id="btn2">Go To Login</a>
            </div>
            <div class="loginbox-submit">
                <button type="submit" id="sbtbtn" class="btn btn-primary btn-block" ng-click="submitted=true">Submit</button>
            </div>
        </form>
    </div>	
    <div class="logobox">        
    </div>
</div>

<script>
 $(document).ready(function(){
    $("#btn1").click(function(){
        $(".div-log").hide();
        $(".div-forgot").show();
    });
    $("#btn2").click(function(){
        $(".div-log").show();
        $(".div-forgot").hide();
    });
    
    $('#sbtbtn').click(function ()
    {
        if($('#mobno').val() === '' && $('#email').val() === '' )
        {
            $("#mobno").addClass("errorBorder");
            $("#email").addClass("errorBorder");
            setTimeout(function () {
                        $("#email").removeClass('errorBorder');
                        $("#mobno").removeClass('errorBorder');
            }, 3000);
        }
         if ($('#mobno').val() !== '')
        {
            return true;
        }
         if ($('#email').val() !== '')
        {
            return true;
        }
        return false;
    });
        
});
</script>
