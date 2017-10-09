<style>
    .imagediv {
        position: relative;
        width: 25%;
    }

    .image {
        opacity: 1;
        display: block;
        width: 100%;
        height: auto;
        transition: .5s ease;
        backface-visibility: hidden;
    }

    .middle {
        transition: .5s ease;
        opacity: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%)
    }
    .below{
        transition: .5s ease;
        opacity: 0;
        position: absolute;
        top: 70%;
        left: 70%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%)
    }

    .imagediv:hover .image {
        opacity: 0.3;
    }

    .imagediv:hover .middle {
        opacity: 1;
    }

    .text {
        background-color: #4CAF50;
        color: white;
        font-size: 16px;
        padding: 16px 32px;
    }
    .ovr-btn {
        position: relative;
        top: -75px;
        right: 20px;
        float: right;
        color: #fff;
        font-size: 25px;
        text-transform: uppercase;
        background: rgba(0, 0, 0, 0.44);
        padding: 15px;
    }
</style> 
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="websiteChangeController">
        <div class="tabbable" ng-init="manageThemes()">
            <tabset>
                <tab heading="BMS Themes" id="BMSThemeTab" style="width:50%; text-align: center">
                    <div class="row">
                        <div class="col-md-3 imagediv" ng-repeat="list in themesRow">
                            <a href="/office.php/theme/preview/id/1" ng-if="list.status == '0'"  target="_blank" title="Preview [ {{list.theme_name}}]">
                                <img src="[[ Config('global.s3Path') ]]/Themes/{{list.image_url}}" alt="Avatar" class="image" style=" height:200px;">
                                <i  ng-if="list.status == '0'" class="fa fa-eye ovr-btn"></i>
                                <div class="middle">
                                    <div class="text">{{list.theme_name}}</div>
                                </div>
                                <div class="below">
                                    <i class="glyphicon glyphicon-eye-open"></i>
                                </div>
                            </a>
                            <a href="/office.php/theme/preview/id/1" ng-if="list.status == '1'" title="Active [ {{list.theme_name}}]">
                                <img src="[[ Config('global.s3Path') ]]/Themes/{{list.image_url}}" alt="Avatar" class="image" style=" height:200px;">
                                <i ng-if="list.status == '1'" class="fa fa-check ovr-btn" style="background: #ad4747;"></i>
                                <div class="middle">
                                    <div class="text">{{list.theme_name}}</div>
                                </div>
                                <div class="below">
                                    <i class="glyphicon glyphicon-eye-open"></i>
                                </div>
                            </a>
                        </div>
                        <!--                        <div class="col-md-3 imagediv">
                                                    <img src="../images/img2.png" alt="Avatar" class="image" style=" height:200px;">
                                                    <i class="fa fa-eye ovr-btn"></i>
                                                    <div class="middle">
                                                        <div class="text">THEME 2</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 imagediv">
                                                    <img src="../images/img3.png" alt="Avatar" class="image" style=" height:200px;">
                                                    <i class="fa fa-eye ovr-btn"></i>
                                                    <div class="middle">
                                                        <div class="text">THEME 3</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 imagediv">
                                                    <img src="../images/img4.png" alt="Avatar" class="image" style=" height:200px;">
                                                    <i class="fa fa-eye ovr-btn"></i>
                                                    <div class="middle">
                                                        <div class="text">THEME 4</div>
                                                    </div>
                                                </div>-->
                    </div>
                </tab>
                <tab heading="Special Themes" id="specialThemeTab" style="width:50%;  text-align: center">
                    <div class="row">
                        <div class="col-md-3 imagediv">
                            <!--<img src="[[ Config('global.s3Path') ]]/Company/firmlogo/company_firm_1048.jpg" alt="Avatar" class="image" style=" height:200px;">-->
                            <img src="../images/img1.png" alt="Avatar" class="image" style=" height:200px;">
                            <i class="fa fa-check ovr-btn" style="background: #ad4747;"></i>
                            <div class="middle">
                                <div class="text">THEME 1</div>
                            </div>
                            <div class="below">
                                <i class="glyphicon glyphicon-eye-open"></i>
                            </div>
                        </div>
                        <div class="col-md-3 imagediv">
                            <img src="../images/img2.png" alt="Avatar" class="image" style=" height:200px;">
                            <i class="fa fa-eye ovr-btn"></i>
                            <div class="middle">
                                <div class="text">THEME 2</div>
                            </div>
                        </div>
                        <div class="col-md-3 imagediv">
                            <img src="../images/img3.png" alt="Avatar" class="image" style=" height:200px;">
                            <i class="fa fa-eye ovr-btn"></i>
                            <div class="middle">
                                <div class="text">THEME 3</div>
                            </div>
                        </div>
                        <div class="col-md-3 imagediv">
                            <img src="../images/img4.png" alt="Avatar" class="image" style=" height:200px;">
                            <i class="fa fa-eye ovr-btn"></i>
                            <div class="middle">
                                <div class="text">THEME 4</div>
                            </div>
                        </div>
                    </div>
                </tab>
            </tabset>
        </div>
    </div>
</div>
