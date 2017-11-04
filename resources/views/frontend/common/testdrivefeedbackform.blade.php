
<html xmlns="http://www.w3.org/1999/xhtml" ng-app="app" ng-controller="AppCtrl">
    <meta name="csrf-token" content="[[ csrf_token() ]]">
        <base href="/">
            <title>Customer Feedback</title>
            <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                    <script src="/frontend/angular.min.js"></script>
                    <script src="/frontend/angular-route.min.js"></script>
                    <script src="/frontend/angular-animate.min.js"></script>
                    <script src="/backend/app/ng-file-upload.js"></script>
                    <script src="/frontend/route.js"></script> 
                    <script src="/backend/app/controllers/datepicker.js"></script> 
                    <script src="/backend/lib/angular/angular-ui-bootstrap/ui-bootstrap.js"></script>
                    <link rel="stylesheet" href="/frontend/common/assets/bootstrap.min.css">
                        <link rel="stylesheet" href="/frontend/common/assets/jquery-ui.css">
                            <link rel="stylesheet" href="/frontend/common/assets/intlTelInput.css">

                                <style>
                                    .regbg{
                                        background-color: #f5f5f5;
                                    }
                                    .well{
                                        background-color: #fff;
                                    }
                                    .brand-logo{
                                        max-height:65px;
                                        width:auto;
                                        max-width:150px;
                                    }
                                    .logo{

                                        max-height:65px;
                                        width:auto;
                                        max-width:150px;
                                    }
                                    .well {
                                        min-height: 20px;
                                        padding: 15px;
                                        margin-bottom: 10px;
                                    }
                                    h1.form-title {
                                        text-transform: uppercase;
                                        font-size: 25px;	

                                    }
                                    .mar50{
                                        margin-top: 50px;
                                    }
                                    
                                    .panel-title{
                                        font-size: 20px;
                                        color: #000;
                                        text-transform: capitalize;
                                        font-weight: 600;

                                    }
                                    
                                   .glyphicon {
                                        font-size: 30px;
                                        font-weight: 600;
                                        float: right;
                                        top: -5px !important;
                                    }
                                    @media screen and (max-width: 768px) {
                                        .iti-mobile .intl-tel-input.iti-container{
                                            left: 4%;
                                            width: 92%;
                                        }
                                    }
                                    .error_msg
                                    {
                                        color:red;
                                    }
                                </style>		
                                </head>
                                <body class="regbg">
                                    <div class="container">
                                        <div class="well col-md-12 col-sm-12 col-xs-12 mar50" align="center">
                                            <?php
                                                    $testdrive_id=$clientdata['testDriveId'];                                                   
                                                   
                                            ?>
                                            <div class="col-md-2 col-sm-3 col-xs-12"><img src="<?php echo $clientdata['logo'];?>" class="logo"></div>
                                            <div class="col-md-8 col-sm-6 col-xs-12"><h1 class="form-title">Customer Feedback</h1></div>
                                            <div class="col-md-2 col-sm-3 col-xs-12"><img src="<?php echo $clientdata['brand_logo']; ?>" class="brand-logo"></div>
                                        </div>	
                                        <div class="col-lg-12 col-xs-12 well">
                                            <div class="">
                                                <div class="w3-container">
                                                    <form name="frmRegistration" novalidate ng-init="getTestderivedetatils([[ $testdrive_id ]])" ng-submit="frmRegistration.$valid && customertestdriveFeedback(customerData,[[ $testdrive_id ]])" >
                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Title</label>
                                                                    <select class="form-control" ng-model="customerData.title_id" name="title_id" ng-controller="titleCtrl"  disabled="" required>
                                                                        <option value="">Select Title</option>
                                                                        <option ng-repeat="t in titles track by $index" value="{{t.id}}"  ng-selected="{{ t.id == customerData.title_id}}">{{t.title}}</option>
                                                                    </select>
                                                                    <input type="hidden" ng-model="customerData.customer_id" name="customer_id">
                                                                </div>
                                                                <div class="col-sm-4 form-group">
                                                                    <label>First Name</label>
                                                                    <input type="text" class="form-control" ng-model="customerData.first_name" name="first_name" maxlength="15" capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')"  maxlength="15" placeholder="Enter First Name"  disabled="" required>
                                                                </div>
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Last Name</label>
                                                                    <input type="text" class="form-control" ng-model="customerData.last_name" name="last_name" maxlength="15"  capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')"  placeholder="Enter Last Name" maxlength="15" disabled=""  required>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Mobile No.</label>
                                                                    <input type="text" ng-model="customerData.mobile_number" name="mobile_number" placeholder="Mobile Number" class="drive-in form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  ng-pattern="/^[0-9]{10}$/" maxlength="10" disabled="" >
                                                                </div>	
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Email ID</label>
                                                                    <input type="email" ng-model="customerData.email_id" name="email_id" class="form-control drive-in" ng-pattern="/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/" placeholder="Email ID" disabled="" >
                                                                        
                                                                </div>	
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Please Enter Your Feedback For Us <span class="error_msg">*</span>  </label><br>
                                                                        <textArea placeholder="please enter your feedback about test drive" cols="40" maxlength="150" rows="5" ng-model="customerData.customer_feedback" name="customer_feedback" oninput="if (/[^A-Za-z 0-9.,]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z 0-9.,]/g,'')" required=""></textArea>
                                                                    <div ng-show="sbtBtn && frmRegistration.customer_feedback.$invalid" ng-messages="frmRegistration.customer_feedback.$error" class="help-block">
                                                                        <div ng-message="required" class="error_msg">&nbsp;Feedback is Required</div>
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                            <br>
                                                                <center>
                                                                    <button type="submit" class="btn btn-lg btn-info" ng-click="sbtBtn = true" ng-disabled="btdisable">Submit</button>	
                                                                </center>
                                                        </div>
                                                    </form> 
                                                </div>

                                            </div>
                                        </div>


                                        <script src="/frontend/common/assets/jquery.min.js"></script>
                                        <script src="/frontend/common/assets/bootstrap.min.js"></script>
                                        <script src="/frontend/common/assets/jquery-ui.js"></script>	
                                        <script src="/frontend/common/assets/intlTelInput.js"></script>
                                            
                                </body>
                                </html>




