<div ng-show="authenticated == false" style="background:url(/backend/login/img/bg.jpg);background-repeat: no-repeat;background-size: cover;min-height: 100%;    position: absolute;    width: 100%;" class="ng-scope">
    <div class="col-md-7 col-lg-8 col-xs-12 half-2" align="center"> 
        <div class="">
            <div class="row img-div">
                <h1 class="v2">
                    Getting ready to glide on</h1>
                <img src="backend/login/img/loading.gif" class="loding-img">
            </div>
        </div>
    </div>
    <div class="col-md-5 col-lg-4 col-xs-12 half-1 mob-bg" align="center">
        <div class="">
            <div class="left-div">
                <div>
                    <div class="col-md-12 col-xs-12 bg1">
                        <form name="loginForm" novalidate="" ng-submit="loginForm.$valid & amp; & amp; login(loginData)" ng-controller="adminController" class="ng-pristine ng-scope ng-invalid ng-invalid-required ng-valid-minlength ng-valid-maxlength">
                            <input type="hidden" ng-model="loginData.csrfToken" name="csrftoken" id="csrftoken" ng-init="loginData.csrfToken = 'SxGLGdxVKA31hVvoJfOA35MbWFYnooB50G9nKTsI'" class="form-control ng-pristine ng-untouched ng-valid">
                            <div class="col-xs-12 col-md-12">
                                <!-- ngIf: !user_profile --><img ng-if="!user_profile" src="/backend/login/img/user-1.png" class="log-usr ng-scope"><!-- end ngIf: !user_profile -->
                                <!-- ngIf: user_profile -->
                                <!-- ngIf: !fullName --><p class="usr-name ng-scope" ng-if="!fullName">Hello, GUEST</p><!-- end ngIf: !fullName -->
                                <!-- ngIf: fullName -->
                                <!-- ngIf: showmsg -->
                            </div>
                            <div class="col-xs-12 col-md-12" id="login-form">

                                <div class="input-group">

                                    <input type="text" name="mobile" class="form-control in-tag ng-pristine ng-untouched ng-invalid ng-invalid-required ng-valid-minlength ng-valid-maxlength" placeholder="Mobile" ng-model="loginData.mobile" check-login-credentials="" minlength="10" maxlength="10" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required="" ng-model-options="{allowInvalid: true, debounce: 100}">
                                </div>
                                <div ng-show="next1" ng-messages="loginForm.mobile.$error" class="help-block next1 ng-active ng-hide" id="mobText">
                                    <!-- ngMessage: required --><div ng-message="required" class="sp-err ng-scope">Username is required.</div>
                                    <!-- ngMessage: minlength -->
                                    <!-- ngMessage: wrongCredentials -->
                                </div>
                                <br>
                                <hr>
                                <div class="group-div" align="center">
                                    <button class=" w3-btn w3-hover-white bt-next1" ng-click="next1 = true">Next</button>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12" id="forgot-form">
                                <div class="input-group">

                                    <input class="form-control in-tag ng-pristine ng-untouched ng-invalid ng-invalid-required ng-valid-minlength ng-valid-maxlength" placeholder="Password" type="password" name="password" minlength="6" maxlength="15" ng-model="loginData.password" required="" ng-model-options="{ allowInvalid: true, debounce: 100 }">
                                </div>
                                <div ng-show="next2" ng-messages="loginForm.password.$error" class="help-block next2 ng-active ng-hide" id="passwordText">
                                    <!-- ngMessage: required --><div ng-message="required" class="sp-err ng-scope">Password id required</div>
                                    <!-- ngMessage: minlength -->
                                    <!-- ngMessage: wrongCredentials -->
                                    <!-- ngIf: errlMsg -->
                                </div>
                                <div class="for-div">
                                    <a href="javascript:void(0);" ng-model="collapsed" ng-click="collapsed = !collapsed" class="ng-pristine ng-untouched ng-valid">Forgot Password?</a>
                                    <div ng-show="collapsed" class="ng-hide">
                                        <h5>You really forgot your password ?</h5>
                                        <div>
                                            <button ng-show="collapsed" ng-click="getpassword(loginData.mobile)" class="for-btn ng-hide">Yes</button>
                                            <button ng-show="collapsed" ng-click="collapsed = !collapsed" class="for-btn ng-hide">No</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="group-div" align="center">
                                    <button type="submit" ng-click="next2 = true" class="sub-btn w3-btn">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="cls"></div>
                </div>
                <div class="foot-div2 col-md-12 col-xs-12"></div>
            </div>
        </div>
        <div class="left-logo-div">
            <span style="margin: 0px;color: #fff;"> | <a href="#"><img src="backend/login/img/lMS-auto.png" class="foot-img"></a> <span class="ver-info">1.0</span></span>
            <p style=" margin-top: 25px;"><a href="http://businessapps.co.in/" target="_blank" class="foot-a">
                    All Rights Reserved © 2017 Business Apps </a></p>
            <img src="/backend/login/img/google.png" class="google-logo">     
            <img src="/backend/login/img/businessapp.png" class="google-logo">        
        </div>
    </div>
</div>
<script class="ng-scope">
    $(document).ready(function () {
    $(".bt-next1").click(function (e) {
    if ($("#mobText").hasClass("ng-active")) {
    e.preventDefault();
    } else {
    $("#login-form").hide();
    $("#forgot-form").show();
    }
    });
    $(".next2").click(function (e) {
    if ($("#passwordText").hasClass("ng-active")) {
    e.preventDefault();
    } else {
    $("#forgot-form").hide();
    $("#otp-form").show();
    }
    });
    });
</script>