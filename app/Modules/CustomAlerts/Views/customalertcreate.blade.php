<style>
    .bordered-bot {
        border-color: #2dc3e8 !important;
    }
</style>

<div class="row">
    <div class="widget flat radius-bordered ">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="customalertsController">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{pageHeading}}</h5>
            <div class="widget-body bordered-top bordered-sky col-lg-12 col-sm-12 col-xs-12">
                <div id="customer-form">
                    <form novalidate role="form" ng-submit="customAlertForm.$valid && createAlert(customAlertData, [[ !empty($alertId) ?  $alertId : '0' ]])" name="customAlertForm" ng-init="manageAlerts([[ !empty($alertId) ?  $alertId : '0' ]], 'edit')">
                        <input type="hidden" ng-model="customAlertData.csrfToken" name="csrftoken" id="csrftoken" ng-init="customAlertData.csrfToken = '[[ csrf_token() ]]'" class="form-control">
                        <input type="hidden" ng-model="customAlertData.client_id" name="client_id">
                        <div class="row col-lg-12 col-sm-12 col-xs-12">  
                            <hr class="wide" />                            
                            <div class="col-lg-12 col-sm-6 col-xs-12">
                                <div class="well with-header  with-footer col-md-12 col-xs-12 mar-bot30">
                                    
                                    <div class="buttons-preview">
                                        
                                            <div class="col-md-12 col-xs-12">
                                                <div class="form-group col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 nopadleft">
                                                        <label for="definpu">Friendly Name :</label>
                                                    </div>
                                                    <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12 nopadright">
                                                        <div class="form-group field-alertscustommodel-event_id required">
                                                            <span class="input-icon icon-right">
                                                                <input type="text" id="friendly_name" ng-model="customAlertData.friendly_name" name="friendly_name" class="form-control"  ng-maxlength="50"  maxlength="50" required>
                                                                <div ng-show="sbtBtn && customAlertForm.friendly_name.$invalid" ng-messages="customAlertForm.friendly_name.$error" class="help-block">
                                                                    <div ng-message="required" style="color: red !important;">This field is required</div>
                                                                    <div ng-message="maxlength" class="sp-err">Too short (Maximum length is 50 character)</div>
                                                                </div> 
                                                            </span>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="col-md-12 col-xs-12">
                                            <div class="form-group col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 nopadleft">
                                                    <label for="definpu">SMS Body :</label>
                                                </div>
                                                <div class="col-lg-6 col-md-10 col-sm-10 col-xs-12 nopadright">
                                                    <div class="form-group field-alertscustommodel-sms_body required">
                                                        <span class="input-icon icon-right">
                                                            <textarea id="sms_body1" ng-model="customAlertData.sms_body" style="height: 125px;" name="sms_body" class="form-control ng-pristine ng-valid ng-valid-required ng-touched"  ng-maxlength="250"  maxlength="250" required=""></textarea>
                                                            
                                                            <div ng-show="sbtBtn && customAlertForm.sms_body.$invalid" ng-messages="customAlertForm.sms_body.$error" class="help-block ng-hide ng-inactive">
                                                                <div ng-message="required" style="color: red !important;">This field is required</div>
                                                                <div ng-message="maxlength" class="sp-err">Too short (Maximum length is 250 character)</div>
                                                            </div>
                                                        </span>
                                                    </div>                                
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-xs-12">
                                            <div class="form-group col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 nopadleft">
                                                    <label for="definpu">Email Subject :</label>
                                                </div>
                                                <div class="col-lg-6 col-md-10 col-sm-10 col-xs-12 nopadright">
                                                    <div class="form-group field-alertscustommodel-email_subject required">
                                                        <span class="input-icon icon-right">
                                                            <input type="text" id="email_subject1" ng-model="customAlertData.email_subject" name="email_subject" class="form-control ng-pristine ng-valid ng-valid-required ng-touched" ng-maxlength="100"  maxlength="100"  required>
                                                            
                                                            <div ng-show="sbtBtn && customAlertForm.email_subject.$invalid" ng-messages="customAlertForm.email_subject.$error" class="help-block ng-hide ng-inactive">
                                                                <div ng-message="required" style="color: red !important;">This field is required</div>
                                                                <div ng-message="maxlength" class="sp-err">Too short (Maximum length is 100 character)</div>
                                                            </div>
                                                        </span>
                                                    </div>                                
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-xs-12">
                                            <div class="form-group col-lg-14 col-md-12 col-sm-12 col-xs-12">
                                                <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12 nopadleft">
                                                    <label for="definpu">Email Body :</label>
                                                </div>
                                                <div class="col-lg-12 col-md-10 col-sm-10 col-xs-12 nopadright">
                                                    <div class="form-group field-alertscustommodel-email_body required">
                                                        <span class="input-icon icon-right">
                                                            <textarea ck-editor id="email_body" ng-model="customAlertData.email_body" name="email_body" class="form-control ng-pristine ng-valid ng-valid-required ng-touched" required=""></textarea>
                                                            <i class="fa fa fa-align-left"></i>
                                                            <div ng-show="sbtBtn && customAlertForm.email_body.$invalid" ng-messages="customAlertForm.email_body.$error" class="help-block ng-hide ng-inactive">
                                                                <div ng-message="required" style="color: red !important;">This field is required</div>
                                                            </div>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12">
                                            <div class="row">
                                                <center>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary" ng-disabled="isDisabled" ng-click="sbtBtn = true">{{buttonLabel}}</button>
                                                    </div>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-6 col-xs-12">
                                <div class="well with-header  with-footer col-md-12 col-xs-12 mar-bot30">
                                    <div class="header bordered-bot"> 
                                        <center> 
                                            <b>
                                                Custom Templates Replaceable tags to be used in SMS / email template
                                            </b> 
                                        </center>
                                    </div>
                                    <div class="buttons-preview">
                                        <div class="col-md-12 col-xs-12">
                                            <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                                <label for="definpu"><b>Customer related tags :</b></label>
                                                <p> 1) Greeting : [#greeting#]</p>
                                                <p> 2) Customer Full Name : [#customerName#]</p>
                                                <p> 3) Customer Mobile : [#customerMobile#]</p>
                                                <p> 4) Customer Email ID : [#customerEmail#]</p>
                                                <!--p> 4) Title : [#title#]</p-->
                                               
                                            </div>
                                            <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                                <label for="definpu"><b>Employee related tags :</b></label>
                                                <p> 1) Employee Full Name : [#employeeName#]</p>
                                                <p> 2) Employee Mobile : [#employeeMobile#]</p>
                                                <p> 3) Employee Email ID : [#employeeEmail#]</p>
                                                <p> 4) Employee Designation: [#employeeDesignation#]</p>
                                            </div>
                                            <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                                <label for="definpu"><b>Company related tags :</b></label>
                                                <p> 1) Company Name : [#companyMarketingName#]</p>
                                                <p> 2) Company Address : [#companyAddress#]</p>
                                                <p> 3) Company Logo : [#companyLogo#]</p>
                                                <p>        <b>  Example:</b>
                                                        <xmp><img src="[#companyLogo#]"></xmp>
                                                </p>
                                                
                                            </div>
                                            <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                                <label for="definpu"><b>Vehicle related tags :</b></label>
                                                <p>  1) Vehicle Brand : [#brandName#]</p>
                                                <p>  2) Vehicle Model : [#modelName#]</p>
                                                <p>  3) Appointment Date : [#appointmentDate#]</p>
                                                <p>  4) Appointment Time : [#appointmentTime#]</p>
                                                <p>  5) Google Map Link (ifram): [#companyGoogleMap#] </p>
                                                <p>  6) Customer Information Form Link: [#custFormLink#] </p>
                                                <p><b>  Example:</b></p>
                                                <xmp><a href="[#custFormLink#]">Click Here</a></xmp>
                                                
                                            </div>
                                        </div>

                                        <hr style="margin-bottom: 20px" class="col-md-12 col-xs-12">
                                        <div class="col-md-12 col-xs-12">
                                            <h4 class="col-lg-12 col-xs-12">Example : </h4>

                                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label for=""><b>Raw Message :</b></label>
                                                <p>
                                                    Dear <b>[#customerName#]</b>,<br>
                                                    Thank you for enquiring with us Our team member<b> [#employeeName#]</b> will get back to you soon.<br>
                                                    regards,<br>
                                                    <b>[#companyMarketingName#]</b>
                                                </p>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label for=""><b>Your SMS / email look like below :</b></label>
                                                <p>
                                                    Dear <b>Mandar Hendre</b>,<br>
                                                    Thank you for enquiring with us Our team member <b>Rohit Kedar</b> will get back to you soon.<br>
                                                    regards,<br>
                                                    <b>LMS Auto</b>
                                                </p>
                                            </div>
                                        </div>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
