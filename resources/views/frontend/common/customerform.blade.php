
<html xmlns="http://www.w3.org/1999/xhtml" ng-app="app" ng-controller="AppCtrl">
    <meta name="csrf-token" content="[[ csrf_token() ]]">
        <base href="/">
            <title>Customer Details</title>
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
                                </style>		
                                </head>
                                <body class="regbg">
                                    <div class="container">
                                        <div class="well col-md-12 col-sm-12 col-xs-12 mar50" align="center">
                                            <?php
                                                    $custId=$clientdata['custId'];                                                   
                                                   
                                            ?>
                                            <div class="col-md-2 col-sm-3 col-xs-12"><img src="<?php echo $clientdata['logo'];?>" class="logo"></div>
                                            <div class="col-md-8 col-sm-6 col-xs-12"><h1 class="form-title">Customer Details </h1></div>
                                            <div class="col-md-2 col-sm-3 col-xs-12"><img src="<?php echo $clientdata['brand_logo']; ?>" class="brand-logo"></div>
                                        </div>	
                                        <div class="col-lg-12 col-xs-12 well">
                                            <div class="">
                                                <div class="w3-container">
                                                    <form name="frmRegistration" novalidate ng-init="getenquirydetails([[ $custId ]])" ng-submit="frmRegistration.$valid && customerDetails(customerData,[[ $custId ]])" >
                                                        <div class="col-sm-12">

                                                            <div class="row">
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Title</label>
                                                                    <select class="form-control" ng-model="customerData.title_id" name="title_id" ng-controller="titleCtrl"  required>
                                                                        <option value="">Select Title</option>
                                                                        <option ng-repeat="t in titles track by $index" value="{{t.id}}"  ng-selected="{{ t.id == customerData.title_id}}">{{t.title}}</option>
                                                                    </select>
                                                                    <div ng-show="sbtBtn && frmRegistration.title_id.$invalid" ng-messages="frmRegistration.title_id.$error" class="help-block">
                                                                        <div ng-message="required" style="color: red !important;">&nbsp;Title is Required</div>
                                                                    </div> 
                                                                </div>
                                                                <div class="col-sm-4 form-group">
                                                                    <label>First Name</label>
                                                                    <input type="text" class="form-control" ng-model="customerData.first_name" name="first_name" maxlength="15" capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')"  maxlength="15" placeholder="Enter First Name" required>
                                                                        <div ng-show="sbtBtn && frmRegistration.first_name.$invalid" ng-messages="frmRegistration.first_name.$error"  class="help-block has-error">
                                                                            <div ng-message="required" style="color: red !important;">This field is required</div>
                                                                            <div ng-message="maxlength" style="color: red !important;">Maximum 15 Character are Allowed</div> 
                                                                        </div>  
                                                                </div>
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Last Name</label>
                                                                    <input type="text" class="form-control" ng-model="customerData.last_name" name="last_name" maxlength="15"  capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')"  placeholder="Enter Last Name" maxlength="15" required>
                                                                        <div ng-show="sbtBtn && frmRegistration.last_name.$invalid" ng-messages="frmRegistration.last_name.$error"  class="help-block has-error">
                                                                            <div ng-message="required" style="color: red !important;">This field is required</div>
                                                                            <div ng-message="maxlength" style="color: red !important;">Maximum 15 Character are Allowed</div> 
                                                                        </div>
                                                                </div>
                                                            </div>	

                                                            <div class="row">
                                                                <div class="col-sm-4 form-group" ng-controller="professionsCtrl">
                                                                    <label>Profession</label>                                                        
                                                                    <select class="form-control" ng-model="customerData.profession_id" name="profession_id" >
                                                                        <option value="">Select Profession</option>
                                                                        <option ng-repeat="pList in professions track by $index" value="{{pList.id}}" ng-selected="{{ pList.id == customerData.profession_id}}">{{pList.profession}}</option>
                                                                    </select>                                              
                                                                </div>
                                                                <div class="col-sm-4 form-group">								
                                                                    <label>Birthdate</label>
                                                                    <input type="text" ng-model="customerData.birth_date" name="birth_date" class="form-control" id="birthdate"> 
                                                                </div>
                                                            </div>


                                                            <div class="row">
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Mobile No.</label>
                                                                    <input type="text" ng-model="customerData.mobile_number" name="mobile_number" placeholder="Mobile Number" class="drive-in form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  ng-pattern="/^[0-9]{10}$/" maxlength="10" disabled>
                                                                        <div ng-show="sbtBtn && frmRegistration.mobile_number.$invalid" ng-messages="frmRegistration.mobile_number.$error" class="help-block">
                                                                            <div ng-message="required" style="color: red !important;">This field is required</div>
                                                                            <div ng-message="pattern" style="color: red !important;">Mobile number should be valid & 10 digits</div>
                                                                        </div>
                                                                </div>	
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Email ID</label>
                                                                    <input type="email" ng-model="customerData.email_id" name="email_id" class="form-control drive-in" ng-pattern="/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/" placeholder="Email ID" required>
                                                                        <div ng-show="sbtBtn && frmRegistration.email_id.$invalid" ng-messages="frmRegistration.email_id.$error" class="help-block">
                                                                            <div ng-message="required" style="color: red !important;">This field is required</div>
                                                                            <div ng-message="pattern" style="color: red !important;">Please enter valid email</div>
                                                                        </div>
                                                                </div>	
                                                            </div>
                                                            
                                                             <div class="row">
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Model</label>
                                                                    <select ng-model="customerData.model_id" ng-controller="vehicleDetailsCtlr" name="model_id" class="form-control drive-sel" required>
                                                                        <option value="">Select Vehicle Model</option>
                                                                        <option ng-repeat="vmodel in modelList" value="{{vmodel.id}}" ng-selected="{{ vmodel.id == customerData.model_id}}">{{vmodel.model_name}}</option>
                                                                    </select>
                                                                    <div ng-show="sbtBtn && frmRegistration.model_id.$invalid" ng-messages="frmRegistration.model_id.$error" class="help-block">
                                                                        <div ng-message="required" style="color: red !important;">This field is required</div>
                                                                    </div>
                                                                </div>	
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Maximum Budget</label>
                                                                    <input type="text" class="form-control" ng-model="customerData.max_budget" name="max_budget"  oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  maxlength="9" placeholder="Enter Maximum Budget" required>
                                                                    <div ng-show="sbtBtn && frmRegistration.max_budget.$invalid" ng-messages="frmRegistration.max_budget.$error"  class="help-block has-error">
                                                                        <div ng-message="required" style="color: red !important;">This field is required</div>
                                                                        <div ng-message="maxlength" style="color: red !important;">Maximum 9 Character are Allowed</div> 
                                                                    </div>  
                                                                </div>	
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Finance required</label>
                                                                    <select class="form-control drive-sel" ng-model="customerData.finance_required" name="finance_required" required>
                                                                            <option value="1">Yes</option>
                                                                            <option value="0">No</option>
                                                                        </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4 form-group">
                                                                    <label>Exchange required</label>
                                                                    <select class="form-control drive-sel" ng-model="customerData.exchange_required" name="exchange_required" required>
                                                                            <option value="1">Yes</option>
                                                                            <option value="0">No</option>
                                                                        </select>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                            
                                                            
                                                            
                                                            
                                                            
                                                            <div class="panel-group" id="accordion">
                                                        <div class="panel panel-default">
                                                          <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                              <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                                <span class="glyphicon glyphicon-plus"></span>
                                                                Address
                                                              </a>
                                                            </h4>
                                                          </div>
                                                          <div id="collapseOne" class="panel-collapse collapse ">
                                                            <div class="panel-body">
                                                                  <div class="row">
                                                                <div class="col-sm-4  form-group">
                                                                    <label>Area Name</label>
                                                                    <input type="text" class="form-control" ng-model="customerData.area_name" name="area_name" maxlength="30" capitalization oninput="if (/[^A-Za-z 0-9.,]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z 0-9.,]/g,'')" placeholder="Enter Area Name">
                                                                </div>
                                                                <div class="col-sm-4  form-group">
                                                                    <label>Landmark</label>
                                                                    <input type="text" class="form-control" ng-model="customerData.landmark" name="landmark" maxlength="30" capitalization oninput="if (/[^A-Za-z 0-9.,]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z 0-9.,]/g,'')"  placeholder="Enter Landmark">
                                                                </div>
                                                                <div class="col-sm-4 form-group">								
                                                                    <label>Pin code</label>
                                                                    <input type="text" ng-model="customerData.pin" name="pin" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  maxlength="6">
                                                                </div>
                                                            </div>
                                                            <div class="row" ng-controller="currentCountryListCtrl">
                                                                <div class="col-sm-4 form-group">
                                                                        <label>Country</label>
                                                                        <select ng-change="onCountryChange()" ng-model="customerData.country_id" name="country_id" id="current_country_id" class="form-control">
                                                                            <option value="">Select Country</option>
                                                                            <option ng-repeat="country in countryList track by $index"  value="{{country.id}}" data-sortname ="{{country.sortname}}" data-phonecode="{{country.phonecode}}" ng-selected="{{ country.id == customerData.country_id}}">{{country.name}}</option>
                                                                        </select>
                                                                </div>
                                                                <div class="col-sm-4 form-group">
                                                                    <label>State</label>                                                                        
                                                                    <select ng-model="customerData.state_id" ng-change="onStateChange()" name="state_id" id="current_state_id" class="form-control">
                                                                        <option value="">Select State</option>
                                                                        <option ng-repeat="state in stateList" value="{{state.id}}" ng-selected="{{ state.id == customerData.state_id}}">{{state.name}}</option>
                                                                    </select>
                                                                </div>	
                                                                <div class="col-sm-4 form-group">
                                                                    <label>City</label>
                                                                    <select ng-model="customerData.city_id" name="city_id" class="form-control">
                                                                        <option value="">Select City</option>
                                                                        <option ng-repeat="city in cityList" value="{{city.id}}" ng-selected="{{ city.id == customerData.city_id}}">{{city.name}}</option>
                                                                    </select>
                                                                </div>
                                                                
                                                            </div>
      </div>
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
                                        <script>
                                                                    $(function() {
                                                                    $("#birthdate").datepicker({ yearRange: '-80:-16', dateFormat: "dd-mm-yy", defaultDate:'-20y', changeMonth: true, changeYear: true});
                                                                    $("#marriagedate").datepicker({
                                                                    yearRange: '1950:2017',
                                                                            changeYear: true,
                                                                            changeMonth: true
                                                                    });
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




