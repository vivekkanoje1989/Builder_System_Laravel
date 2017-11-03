<html xmlns="http://www.w3.org/1999/xhtml" ng-app="app">
    <meta name="csrf-token" content="[[ csrf_token() ]]">
        <base href="/">
            <title>Re-Schedule Test Drive</title>
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
                                                  $enqId=$clientdata['enqId'];                                                   
                                            
                                            ?>
                                            <div class="col-md-2 col-sm-3 col-xs-12"><img src="<?php echo $clientdata['logo'];?>" class="logo"></div>
                                            <div class="col-md-8 col-sm-6 col-xs-12"><h1 class="form-title">Re-Schedule Test Drive</h1></div>
                                            <div class="col-md-2 col-sm-3 col-xs-12"><img src="<?php echo $clientdata['brand_logo']; ?>" class="brand-logo"></div>
                                        </div>	
                                        <div class="col-lg-12 col-xs-12 well"  ng-controller="AppCtrl">
                                            <div class="">
                                                <div class="w3-container">
                                                    <form name="frmRegistration" novalidate  ng-submit="frmRegistration.$valid && scheduletestdrive(customerData,[[ $enqId ]])" ng-init="getscheduletestdrivedetails([[ $enqId ]])" >
                                                        <div class="col-sm-12">

                                                            <div class="row">
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Title <span class="error_msg">*</span></label>
                                                                    <select class="form-control" ng-model="customerData.title_id" name="title_id" ng-controller="titleCtrl"  disabled="" required>
                                                                        <option value="">Select Title</option>
                                                                        <option ng-repeat="t in titles track by $index" value="{{t.id}}"  ng-selected="{{ t.id == customerData.title_id}}">{{t.title}}</option>
                                                                    </select>
                                                                    <div ng-show="sbtBtn && frmRegistration.title_id.$invalid" ng-messages="frmRegistration.title_id.$error" class="help-block">
                                                                        <div ng-message="required" class="error_msg">&nbsp;Title is Required</div>
                                                                    </div> 
                                                                </div>
                                                                <div class="col-sm-4 form-group">
                                                                    <label>First Name <span class="error_msg">*</span></label>
                                                                    <input type="text" class="form-control" ng-model="customerData.first_name" name="first_name" maxlength="15" capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')"   placeholder="Enter First Name" required>
                                                                        <div ng-show="sbtBtn && frmRegistration.first_name.$invalid" ng-messages="frmRegistration.first_name.$error"  class="help-block has-error">
                                                                            <div ng-message="required" class="error_msg">This field is required</div>
                                                                            <div ng-message="maxlength" class="error_msg">Maximum 15 Character are Allowed</div> 
                                                                        </div>  
                                                                </div>
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Last Name <span class="error_msg">*</span></label>
                                                                    <input type="text" class="form-control" ng-model="customerData.last_name" name="last_name" maxlength="15"  capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')"  placeholder="Enter Last Name"   required>
                                                                        <div ng-show="sbtBtn && frmRegistration.last_name.$invalid" ng-messages="frmRegistration.last_name.$error"  class="help-block has-error">
                                                                            <div ng-message="required"  class="error_msg">This field is required</div>
                                                                            
                                                                        </div>
                                                                </div>
                                                            </div>	

                                                            <div class="row">
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Mobile No. <span class="error_msg">*</span></label>
                                                                    <input type="text" ng-model="customerData.mobile_number" name="mobile_number" placeholder="Mobile Number" class="drive-in form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  ng-pattern="/^[0-9]{10}$/" maxlength="10" disabled="" >
                                                                        <div ng-show="sbtBtn && frmRegistration.mobile_number.$invalid" ng-messages="frmRegistration.mobile_number.$error" class="help-block">
                                                                            <div ng-message="required" class="error_msg">This field is required</div>
                                                                            <div ng-message="pattern"  class="error_msg">Mobile number should be valid & 10 digits</div>
                                                                        </div>
                                                                </div>	
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Email ID <span class="error_msg">*</span></label>
                                                                    <input type="email" ng-model="customerData.email_id" name="email_id" class="form-control drive-in" ng-pattern="/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/" placeholder="Email ID" disabled="" >
                                                                        <div ng-show="sbtBtn && frmRegistration.email_id.$invalid" ng-messages="frmRegistration.email_id.$error" class="help-block">
                                                                            <div ng-message="required" class="error_msg">This field is required</div>
                                                                            <div ng-message="pattern" class="error_msg">Please enter valid email</div>
                                                                        </div>
                                                                </div>
                                                               <div class="col-sm-4 form-group" >
                                                                     <label>Select Vehicle <span class="error_msg">*</span></label>
                                                                     <select  ng-model="customerData.testdrive_vehicle_ids" name="testdrive_vehicle_ids" id="testdrive_vehicle_ids" class="form-control"  required>
                                                                            <option value="">Select Vehicle</option>
                                                                            <option ng-repeat="vehicle in vehicleList" value="{{vehicle.id}}" ng-selected="{{ vehicle.id == enquiryData.testdrive_vehicle_ids}}">{{vehicle.friendly_name}}</option>
                                                                        </select> 
                                                                        <div ng-show="sbtBtn && frmRegistration.testdrive_vehicle_ids.$invalid" ng-messages="frmRegistration.testdrive_vehicle_ids.$error" class="help-block errMsg">
                                                                            <div ng-message="required" class="error_msg">This field is required</div>
                                                                        </div>
                                                                </div>	
                                                            </div>
                                                            
                                                             
                                                                <div class="row">
                                                                     <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                                                          <div class="col-sm-4 form-group">								
                                                                          <label>Test Drive Date <span class="error_msg">*</span></label>
                                                                            <p class="input-group">
                                                                                <!--<input type="hidden" ng-model="enquiryData.enquiry_id">-->
                                                                                <input type="text" ng-model="customerData.testdrive_date" name="testdrive_date" id="testdrive_date" class="form-control" ng-change="timeChange(customerData.testdrive_date)" placeholder="Schedule date" datepicker-popup="dd-MM-yyyy" is-open="opened" min-date="dt" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly="" required/>
                                                                                <span class="input-group-btn">
                                                                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i style="height: 20px;" class="glyphicon glyphicon-calendar"></i></button>
                                                                                </span>
                                                                            <div ng-show="sbtBtn && frmRegistration.testdrive_date.$invalid" ng-messages="frmRegistration.testdrive_date.$error" class="help-block errMsg">
                                                                                <div ng-message="required" class="error_msg">This field is required</div>
                                                                            </div>
                                                                            </p>
                                                                        </div>  

                                                                       <div class="col-md-4 form-group" >
                                                                           <label>Test Drive Time <span class="error_msg">*</span></label>
                                                                           <select ng-model="customerData.testdrive_time" name="testdrive_time" class="form-control drive-sel" required>
                                                                               <option value="">--  Time  --</option>
                                                                               <option ng-repeat="time in timeList" value="{{time.value}}" ng-selected="{{time.value == customerData.testdrive_time}}">{{time.label}}</option>
                                                                           </select>
                                                                           <div ng-show="sbtBtn && frmRegistration.testdrive_time.$invalid" ng-messages="frmRegistration.testdrive_time.$error" class="help-block errMsg">
                                                                               <div ng-message="required" class="error_msg">This field is required</div>
                                                                           </div>
                                                                       </div>
                                                                </div>
                                                                </div>
                                                             <div class="row">
                                                                    <div class="col-sm-4 form-group">   
                                                                            <label>Test Drive Types</label>
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input name="testdrive_type" ng-model="customerData.testdrive_type"  type="radio" value="1" >
                                                                                <span class="text">Showroom </span>
                                                                            </label>  &nbsp;&nbsp;&nbsp;&nbsp;                                      

                                                                           <label>
                                                                                <input name="testdrive_type" ng-model="customerData.testdrive_type" type="radio" value="2">
                                                                                <span class="text">Home / Office</span>
                                                                            </label>
                                                                        </div>
                                                                    </div>  
                                                            <div ng-if='customerData.testdrive_type == 2' class="col-sm-4" style="margin-top: 9px;">
                                                                <label>Test Drive Location <span class="error_msg">*</span> </label>
                                                                <textarea type="text" class="form-control" ng-model="customerData.area" name="area" placeholder="area" oninput="if (/[^A-Za-z 0-9.,]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z 0-9.,]/g,'')" required>
                                                                </textarea>
                                                                <div  ng-show="sbtBtn && frmRegistration.area.$invalid" ng-messages="frmRegistration.area.$error" class="help-block">
                                                                    <div ng-message="required" class="error_msg">This field is required</div>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                      
                                                      

                                                            <br>
                                                                <center>
                                                                    <button type="submit" class="btn btn-lg btn-info" ng-click="sbtBtn = true " ng-disabled="btdisable">Submit</button>	
                                                                </center>
                                                        </div>
                                                         <input type="hidden" ng-model="customerData.test_date"  id="dateTestDrive" >
                                                    </form> 
                                                </div>

                                            </div>
                                        </div>
                                       

                                        <script src="/frontend/common/assets/jquery.min.js"></script>
                                        <script src="/frontend/common/assets/bootstrap.min.js"></script>
                                        <script src="/frontend/common/assets/jquery-ui.js"></script>	
                                        <script src="/frontend/common/assets/intlTelInput.js"></script>
                                        <script>
                                                                    $(function() {
                                                                        
                                                                      
                                                                    $("#perMob").intlTelInput({
                                                                    utilsScript: "/frontend/common/assets/utils.js"
                                                                    });
                                                                    $("#officeMob").intlTelInput({
                                                                    utilsScript: "/frontend/common/assets/utils.js"
                                                                    });
                                                                    $("#altMob").intlTelInput({
                                                                    utilsScript: "/frontend/common/assets/utils.js"
                                                                    });
                                                                    });
                                        
                                         
                                            $('.collapse').on('shown.bs.collapse', function(){
                                        $(this).parent().find(".glyphicon-plus").removeClass("glyphicon-plus").addClass("glyphicon-minus");
                                        }).on('hidden.bs.collapse', function(){
                                        $(this).parent().find(".glyphicon-minus").removeClass("glyphicon-minus").addClass("glyphicon-plus");
                                        });
                                        </script>
                                            
                                </body>
                                </html>




