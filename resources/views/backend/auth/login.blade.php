
<!--<link rel="stylesheet" href="/backend/assets/css/login.css">-->

<div class="page-bg">
    <div class="sub-page-bg">
        <div class="row div-wdt div-bg">
            <div class="col-md-9 col-sm-8 col-xs-12" style="padding: 0;">
                <img src="http://cdn.wonderfulengineering.com/wp-content/uploads/2014/01/building-wallpaper-5.jpg" class="img-responsive">
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12"  style="padding: 0;">
                <form name="loginForm" novalidate ng-submit="loginForm.$valid && login(loginData)" ng-controller="adminController">
                <input type="hidden" ng-model="loginData.csrfToken" name="csrftoken" id="csrftoken" ng-init="loginData.csrfToken='<?php echo csrf_token(); ?>'" class="form-control">
                <div class="login-div">
                    <h3>Hi, GUEST</h3>
                    <hr>
                    <div id="login-form" class="w3-animate-right">
                        <div class="group-div">
                            <label>Mobile No.</label>
                            <input type="text" name="mobile" ng-model="loginData.mobile" check-login-credentials minlength="10" maxlength="10" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required ng-model-options="{ allowInvalid: true, debounce: 100 }">
                            <div ng-show="next1" ng-messages="loginForm.mobile.$error" class="help-block next1">
                                <div ng-message="required">Required</div>
                                <div ng-message="minlength">Invalid mobile no.</div>
                                <div ng-message="wrongCredentials">{{errMsg}}</div>
                            </div>                     
                        </div>
                        <br>
                        <hr>
                        <div class="group-div" align="center">
                            <button class="bt-next1" ng-click="next1=true">Next</button>
                        </div>
                    </div>
                    <div id="forgot-form" class="w3-animate-right">
                        <div class="group-div">
                            <label>Password</label>
                            <input type="password" name="password" check-login-credentials minlength="6" maxlength="6" ng-model="loginData.password" required ng-model-options="{ allowInvalid: true, debounce: 100 }"><br>
                            <div ng-show="next2" ng-messages="loginForm.password.$error" class="help-block next2">
                                <div ng-message="required">Required</div>
                                <div ng-message="minlength">Too short (Minimum length is 6 characters)</div>
                                <div ng-message="wrongCredentials">Wrong password!</div>                                
                            </div>
                            <div class="mar10">
                                <a href="javascript:void(0);" ng-model="collapsed" ng-click="collapsed=!collapsed">Forgot Password?</a>
                                <div ng-show="collapsed">
                                    <h5>Are you really forgotten your password ?</h5>                                     
                                    <div>
                                        <button ng-show="collapsed" ng-click="collapsed=!collapsed" class="for-btn">Yes</button>
                                        <button ng-show="collapsed" ng-click="collapsed=!collapsed" class="for-btn">No</button>
                                    </div>   
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="group-div"  align="center">
                            <button class="next2" ng-click="next2=true">Next</button>
                        </div>
                    </div>
                    <div id="otp-form" class="w3-animate-right">
                        <div class="group-div">
                            <label>High Security Password</label>
                            <input type="text" name="securityPassword" check-login-credentials minlength="4" maxlength="4" ng-model="loginData.securityPassword" required ng-model-options="{ allowInvalid: true, debounce: 100 }">
                            <div ng-show="next3" ng-messages="loginForm.securityPassword.$error" class="help-block next3">
                                <div ng-message="required">Required</div>
                                <div ng-message="minlength">Too short (Minimum length is 4 characters)</div>
                                <div ng-message="wrongCredentials">Wrong security password!</div>                                
                            </div>
                        </div>
                        <br>
                        <hr>
                        <div class="group-div" align="center">
                            <button type="submit" ng-click="next3=true" class="sub-btn">Login</button>
                        </div>
                    </div>
                </div>
                </form>
                <!--div class="footer-div">
                        <p>All rights are reserved</p>
                </div-->
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".bt-next1").click(function (e) {
            if($(".next1").hasClass("ng-active")) {
                e.preventDefault();
            }else{
                $("#login-form").hide();
                $("#forgot-form").show();
            }
        });
        $(".next2").click(function (e) {
            if($(".next2").hasClass("ng-active")) {
                e.preventDefault();
            }else{
                $("#forgot-form").hide();
                $("#otp-form").show();
            }
        });
    });
</script>