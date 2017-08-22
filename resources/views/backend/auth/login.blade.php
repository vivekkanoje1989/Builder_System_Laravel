
<link rel="stylesheet" href="/backend/assets/css/w3.css">
<div class="page-bg" ng-controller="adminController" style="background:url(/backend/images/bg.jpg);background-repeat: no-repeat;background-size: cover;min-height: 100%;    position: absolute;    width: 100%;">
    <div class="sub-page-bg">
        <div class="col-md-7 col-lg-8 col-xs-12 half-2" align="center"> 
            <div class="">
                <div class="row img-div">
                    <h1 class="v2">
                        Getting ready to glide on</h1>
                    <img src="backend/images/loading.gif" class="loding-img">
                </div>
            </div>
        </div>
        <div class="col-md-5 col-lg-4 col-xs-12 half-1 mob-bg" align="center">
            <div class="left-div">
                <div class="col-md-12 col-xs-12 bg1">
                    <form name="loginForm" novalidate ng-submit="loginForm.$valid && login(loginData)">
                        <input type="hidden" ng-model="loginData.csrfToken" name="csrftoken" id="csrftoken" ng-init="loginData.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">

                        <div class="col-xs-12 col-md-12">
                            <img ng-if="!user_profile" src="/backend/images/user-1.png" class="log-usr ng-scope">
                            <img ng-if="user_profile" ng-src="[[ Config('global.s3Path') ]]/employee-photos/{{user_profile}}" class="log-usr ng-scope">

                            <p class="usr-name ng-scope" ng-if="!fullName">Hello, GUEST</p>
                            <p class="usr-name ng-scope" ng-if="fullName">Hello, {{fullName}}</p>

                        </div>
                        <div id="login-form" class="w3-animate-right col-xs-12 col-md-12" >
                            <div class="input-group">
                                <input type="text" name="mobile" class="form-control in-tag ng-pristine ng-untouched ng-invalid ng-invalid-required ng-valid-minlength ng-valid-maxlength" placeholder="Mobile" ng-model="loginData.mobile" check-login-credentials="" minlength="10" maxlength="10" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required="" ng-model-options="{allowInvalid: true, debounce: 100}">
                                <div ng-show="next1" ng-messages="loginForm.mobile.$error" class="help-block next1">
                                    <div ng-message="required" class="sp-err">Username is required</div>
                                    <div ng-message="minlength"  class="sp-err">Invalid mobile no.</div>
                                    <div ng-message="wrongCredentials"  class="sp-err">{{errMsg}}</div>
                                </div>                     
                            </div>
                            <br>
                            <br>
                            <div class="group-div" align="center">
                                <button class=" w3-btn w3-hover-white bt-next1" ng-click="next1 = true">Next</button>
                            </div>
                        </div>
                        <div id="forgot-form" class="w3-animate-right col-xs-12 col-md-12">
                            <div class="input-group">
                                <input class="form-control in-tag ng-pristine ng-untouched ng-invalid ng-invalid-required ng-valid-minlength ng-valid-maxlength" placeholder="Password" type="password" name="password" minlength="6" maxlength="15" ng-model="loginData.password" required="" ng-model-options="{allowInvalid: true, debounce: 100}">
                            </div>
                            <div ng-show="next2" ng-messages="loginForm.password.$error" class="help-block next2">
                                <div ng-message="required"  class="sp-err">Required</div>
                                <div ng-message="minlength"  class="sp-err">Too short (Minimum length is 6 characters)</div>
                                <div ng-message="maxlength"  class="sp-err">Too long (Maximum length is 15 characters)</div>
                                <div ng-message="wrongCredentials" class="sp-err">Wrong password!</div>                                
                            </div>
                            <div class="mar10">
                                <a href="javascript:void(0);" ng-model="collapsed" ng-click="collapsed = !collapsed">Forgot Password?</a>
                                <div ng-show="collapsed">
                                    <h5>You really forgot your password ?</h5>                                     
                                    <div>
                                        <button ng-show="collapsed" ng-click="collapsed = !collapsed" class="for-btn">Yes</button>
                                        <button ng-show="collapsed" ng-click="collapsed = !collapsed" class="for-btn">No</button>
                                    </div>   
                                </div>
                            </div>
                            <br>
                            <div class="group-div"  align="center">
                                <button type="submit" ng-click="next2 = true" class="sub-btn w3-btn">Login</button>
                            </div>
                        </div>
                        <!--                    <div id="otp-form" class="w3-animate-right">
                                                <div class="group-div">
                                                    <label>High Security Password</label>
                                                    <input type="text" name="securityPassword" check-login-credentials minlength="4" maxlength="4" ng-model="loginData.securityPassword" required ng-model-options="{allowInvalid: true, debounce: 100}">
                                                    <div ng-show="next3" ng-messages="loginForm.securityPassword.$error" class="help-block next3">
                                                        <div ng-message="required">Required</div>
                                                        <div ng-message="minlength">Too short (Minimum length is 4 characters)</div>
                                                        <div ng-message="wrongCredentials">Wrong security password!</div>                                
                                                    </div>
                                                </div><br><hr>
                                                <div class="group-div" align="center">
                                                    <button type="submit" ng-click="next3 = true" class="sub-btn">Login</button>
                                                </div>
                                            </div>-->

                    </form>
                </div>
                <div class="foot-div2 col-md-12 col-xs-12"></div>
            </div>
            <!--            <div class="foot-p2" align="center">
                            <div class="bord2">  
                                <img src="http://bmsbuilder.in/themes/backend/bms.1.9.14/bms.png" class="bms-logo">
                                <span class="pos2">1.0</span>
                            </div>  
                            <img src="http://bmsbuilderdev.in/common/images/edynamicslogo.jpg" class="foot-logo2">
            <p> All Rights Reserved © 2017 <a href="http://edynamics.co.in/" target="_blank"> edynamics Business Services LLP </a></p>
                        </div> -->
            <div class="left-logo-div">
                <p style=" margin-top: 25px;"><a href="http://edynamics.co.in/" target="_blank" class="footer-a">
                        All Rights Reserved © 2017 edynamics Business Services LLP </a></p>
                <img src="http://bmsbuilder.in/themes/backend/bms.1.9.14/bms.png" class="bms-logo">     
                <img src="http://bmsbuilderdev.in/common/images/edynamicslogo.jpg" class="bms-logo">        
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".bt-next1").click(function (e) {
            if ($(".next1").hasClass("ng-active")) {
                e.preventDefault();
            } else {
                $("#login-form").hide();
                $("#forgot-form").show();
            }
        });
        $(".next2").click(function (e) {
            if ($(".next2").hasClass("ng-active")) {
                e.preventDefault();
            } else {
                $("#forgot-form").hide();
                $("#otp-form").show();
            }
        });
    });
</script>