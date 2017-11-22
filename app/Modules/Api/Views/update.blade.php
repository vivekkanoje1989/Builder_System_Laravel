<style>
    .error-msg{
        color:red;    
    }
</style>
<div class="row" >
    <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="apiController" ng-init="getapiData('[[$apiId]]')">
        <div class="widget-header  bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Edit Push API</span>
            </div>
        <div class="step-content" id="WiredWizardsteps"  >
            <div class="step-pane active" id="wiredstep1" >
                <form name="pushApiForm" novalidate ng-submit="pushApiForm.$valid && pushApiData.employee_id.length != 0 && pushApiData.employee_id.length != null && updateApi(pushApiData)"  ng-init="updateApis([[ !empty($apiId) ?  $apiId : '0' ]]);">
                    <input type="hidden" name="employeeId" ng-model="employeeId" value="{{employeeId}}" >
                    <input type="hidden" name="pdf_name" ng-model="pushApiData.pdf_name"  >
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" >
                                <label for="">Api name <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" placeholder="Enter api name" ng-model="pushApiData.api_name" name="api_name" class="form-control"  capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,' ')"    maxlength="15" required>
                                    <div ng-show="btn" ng-messages="pushApiForm.api_name.$error" class="help-block step1 error-msg">
                                        <div ng-message="required" >This field is required</div>
                                        <div ng-message="maxlength">Maximum 15 Character are Allowed</div> 
                                    </div>
                                </span>                                
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6" ng-controller="employeesCtrl">
                            <div class="form-group" >
                                <label for="">Select employees for assigning new enquiries <span class="sp-err">*</span></label>	
                                <ui-select multiple ng-model="pushApiData.employee_id" name="employees1"  theme="select2" ui-select-required style="width: 260px;" >
                                    <ui-select-match placeholder="Select Employees">{{$item.first_name}} {{$item.last_name}}</ui-select-match>
                                    <ui-select-choices repeat="list in employeesDatas | filter:$select.search">
                                        {{list.first_name}}  {{list.last_name}}&nbsp;
                                    </ui-select-choices>
                                </ui-select>
                                <br/>
                                <span ng-if="btn" class="error-msg"  ng-show="pushApiData.employee_id.length == 0 || pushApiData.employee_id.length == null">This field is required</span>
                            </div>
                        </div> 
                        <div class="col-sm-3 col-xs-6" ng-controller="employeesCtrl">
                            <div class="form-group" >
                                <label for="">Provide email ids to send api related error notification emails<span class="sp-err">*</span></label>	
                                <span class="input-icon icon-right">
                                    <select ng-model="pushApiData.error_notification_email" class="form-control" required  name="error_notification_email">
                                        <option value="">Select email id</option>
                                        <option ng-repeat="list in employeeList" ng-selected="pushApiData.error_notification_email == list.id" value="{{list.id}}">{{list.personal_email1}}</option>
                                    </select>
                                    <div ng-show="btn" ng-messages="pushApiForm.error_notification_email.$error" class="help-block step1 error-msg">
                                        <div ng-message="required">This field is required</div>
                                    </div>
                                </span>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" >
                                <label for="">Enquiry Status<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select class="form-control" ng-controller="salesStatusCtrl" ng-model="pushApiData.set_enquiry_status" name="set_enquiry_status" required>
                                        <option value="">Select Status</option>
                                        <option ng-repeat="list in salesstatus"  value="{{list.id}}" ng-selected="{{ list.id == pushApiData.set_enquiry_status}}">{{list.sales_status}}</option>          
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <div ng-show="btn" ng-messages="pushApiForm.enquiry_status.$error" class="help-block error-msg">
                                        <div ng-message="required">Please Select Status</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" >
                                <label for=""> Api Status</label>
                                <span class="input-icon icon-right">
                                    <select ng-model="pushApiData.status"  name="status" class="form-control" required>
                                        <option value="">Select Api Status</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <div ng-show="step1" ng-messages="pushApiForm.status.$error" class="help-block step1 error-msg">
                                        <div ng-message="required">This field is required</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div>
                                <b>Select the fields which should be mandatory</b>
                            </div>
                            <div class="checkbox" >
                                <label>
                                    <input type="checkbox" ng-model="pushApiData.first_name_mandatory" name="first_name_mandatory" class="form-control" value="{{ pushApiData.first_name_mandatory}}" >
                                    <span class="text">First name is mandatory</span>
                                </label>
                            </div>
                            <div class="checkbox" >
                                <label>
                                    <input type="checkbox" ng-model="pushApiData.last_name_mandatory" name="last_name_mandatory" class="form-control" value="{{ pushApiData.last_name_mandatory}}" >
                                    <span class="text">Last name is mandatory</span>
                                </label>
                            </div>
                            <div class="checkbox" >
                                <label>
                                    <input type="checkbox" ng-model="pushApiData.mobile_number_mandatory" name="mobile_number_mandatory" class="form-control" value="{{ pushApiData.mobile_number_mandatory}}" >
                                    <span class="text">Mobile No is mandatory   </span>
                                </label>
                            </div>
                            <div class="checkbox" >
                                <label>
                                    <input type="checkbox" ng-model="pushApiData.email_id_mandatory" name="email_id_mandatory" class="form-control" value="{{ pushApiData.email_id_mandatory}}" >
                                    <span class="text">Email id is mandatory</span>
                                </label>
                            </div>
                            <div class="checkbox" >
                                <label>
                                    <input type="checkbox" ng-model="pushApiData.country_code_mandatory" name="country_code_mandatory" class="form-control"  >
                                    <span class="text">Country code is mandatory</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div>
                                <b>Existing customers preferences</b>
                            </div>
                            <div>
                                <u>*For existing customer with open enquiry*</u>
                            </div>
                            <div class="checkbox" >
                                <label>
                                    <input type="radio" ng-model="pushApiData.existing_open_customer_action" name="existing_open_customer_action" class="form-control"  value="1"  >
                                    <span class="text">For existing customer update followup of the enquity which is in open status.</span>
                                </label>
                                <label>
                                    <input type="radio" ng-model="pushApiData.existing_open_customer_action" name="existing_open_customer_action" class="form-control" value="0" >
                                    <span class="text">For existing customer open new enquiry.</span>
                                </label>
                            </div>
                            <div>
                                <u>*For existing customer with lost enquiry*</u>
                            </div>
                            <div class="checkbox" >
                                <label>
                                    <input type="radio" ng-model="pushApiData.existing_lost_customer_action" name="existing_lost_customer_action" class="form-control" value="1" >
                                    <span class="text"> For existing customer with lost enquiry, open new enquiry.</span>
                                </label>
                                <label>
                                    <input type="radio" ng-model="pushApiData.existing_lost_customer_action" name="existing_lost_customer_action" class="form-control"  value="0" >
                                    <span class="text">For existing customer with lost enquiry set the last enquiry to open again and update followup</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div>
                                <b>Notification settings</b>
                            </div>
                            <div class="checkbox" >
                                <label>
                                    <input type="checkbox" ng-model="pushApiData.send_sms_customer" name="send_sms_customer" class="form-control" value="{{ pushApiData.send_sms_customer}}" >
                                    <span class="text">Send thanking SMS to customer</span>
                                </label>
                            </div>
                            <div class="checkbox" >
                                <label>
                                    <input type="checkbox" ng-model="pushApiData.send_email_customer" name="send_email_customer" class="form-control" value="{{ pushApiData.send_email_customer}}" >
                                    <span class="text">Send thanking email to customer</span>
                                </label>
                            </div>
                            <div class="checkbox" >
                                <label>
                                    <input type="checkbox" ng-model="pushApiData.send_sms_employee" name="send_sms_employee" class="form-control" value="{{ pushApiData.send_sms_employee}}" >
                                    <span class="text">Send SMS notification to employee</span>
                                </label>
                            </div>
                            <div class="checkbox" >
                                <label>
                                    <input type="checkbox" ng-model="pushApiData.send_email_employee" name="send_email_employee" class="form-control" value="{{ pushApiData.send_email_employee}}" >
                                    <span class="text">Send email notification to employee</span>
                                </label>
                            </div>
                            <div class="checkbox" >
                                <label>
                                    <input type="checkbox" ng-model="pushApiData.dial_outbound_call" name="dial_outbound_call" class="form-control" value="{{ pushApiData.dial_outbound_call}}" >
                                    <span class="text">Initiate outbound call on receiving enquiry</span>
                                </label>
                            </div>
                            <div class="checkbox" >
                                <label>
                                    <input type="checkbox" ng-model="pushApiData.mobile_verification" name="mobile_verification" class="form-control" value="{{ pushApiData.mobile_verification}}" >
                                    <span class="text"> Send verification link to customers mobile number to get the mobile number verified</span>
                                </label>
                            </div>
                            <div class="checkbox" >
                                <label>
                                    <input type="checkbox" ng-model="pushApiData.email_verification" name="email_verification" class="form-control" value="{{ pushApiData.email_verification}}" >
                                    <span class="text">Send verification link to customers email id to get the email id verified</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div  class="row">
                        <div class="col-sm-3 col-xs-6">
                            <b>Customer SMS</b>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            &nbsp;&nbsp;
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <b>Employee SMS</b>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            &nbsp;&nbsp;
                        </div>
                    </div>
                    <hr class="enq-hr-line">
                    <br>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" >
                                <label for="">Customer SMS CC </label>
                                <span class="input-icon icon-right">
                                    <input type="text" placeholder="Enter customer mobile number" ng-model="pushApiData.customer_sms_cc_numbers" name="customer_sms_cc_numbers" class="form-control" >

                                    <div style="color: red">Enter multiple mobile numbers comma separated</div>
                                </span>                                
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" >
                                <label for="">Customer SMS Template</label>&nbsp;&nbsp;<input type="button" name="defaultcustsms" id="defaultcustsms" ng-model="defaultcustsms" ng-click="defaultcustsmstemplate()" value="Default Template">
                                <span class="input-icon icon-right">
                                    <textarea type="text"  rows="8" cols="15" ng-model="pushApiData.customer_sms_template" id="customer_sms_template" name="customer_sms_template" class="form-control" >
                                    </textarea>
                                </span>                                
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">

                            <div class="form-group" >
                                <label for="">Employee SMS CC </label>
                                <span class="input-icon icon-right">
                                    <input type="text" placeholder="Enter employee mobile number" ng-model="pushApiData.employee_sms_cc_numbers" name="employee_sms_cc_numbers" class="form-control" >
                                    <div style="color: red">Enter multiple mobile numbers comma separated</div>
                                </span>                                
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">

                            <div class="form-group" >
                                <label for="">Employee Sms Template</label>&nbsp;&nbsp;<input type="button" name="defaultempsms" id="defaultempsms" ng-model="defaultempsms" ng-click="defaultempsmstemplate()" value="Default Template">
                                <span class="input-icon icon-right">
                                    <textarea type="text"  rows="8" cols="15" ng-model="pushApiData.employee_sms_template" id="employee_sms_template" name="employee_sms_template" class="form-control" >
                                    </textarea> 
                                </span>                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <b style="margin-left: 15px;">Customer Email</b>
                    </div >    
                    <hr class="enq-hr-line">
                    <br>
                    <div class="row" ng-init="getEmailConfiguration()">
                        <div class="col-sm-3 col-xs-6">

                            <div class="form-group" >
                                <label for="">Select from email id : </label>
                                <span class="input-icon icon-right">
                                    <select class="form-control" ng-model="pushApiData.from_email_id" name="from_email_id" >
                                        <option value="">Select Email</option>
                                        <option ng-repeat="list in salesstatus"  ng-selected="{{list.id == pushApiData.from_email_id}}" value="{{list.id}}" >{{list.email}}</option>          
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>                              
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" >
                                <label for="">Mark CC of this email to :</label>
                                <span class="input-icon icon-right">
                                    <input type="text" placeholder="" ng-model="pushApiData.customer_email_cc" name="customer_email_cc" class="form-control">

                                    <div style="color:red">Enter multiple email id's comma separated</div>
                                </span>                            
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" >
                                <label for="">Mark BCC of this email to :</label>
                                <span class="input-icon icon-right">
                                    <input type="text" placeholder="" ng-model="pushApiData.customer_email_bcc" name="customer_email_bcc" class="form-control" >
                                    <div style="color:red">Enter multiple email id's comma separated</div>
                                </span>                           
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" >
                                <label for="">Email subject line :</label>
                                <span class="input-icon icon-right">
                                    <input type="text" placeholder="" ng-model="pushApiData.customer_email_subject_line" name="customer_email_subject_line" class="form-control" >
                                    <div ng-show="btn"  ng-messages="pushApiForm.customer_email_subject_line.$error" class="help-block">
                                        <div ng-message="required">This field is required</div>
                                    </div>
                                </span>                           
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label for="">Email body : <span class="sp-err">*</span></label>&nbsp;&nbsp;<input type="button" name="defaultcustemail" id="defaultcustemail" ng-model="defaultcustemail" ng-click="customer_email_template()" value="Default Template">
                            <span class="input-icon icon-right">
                                <div class="widget flat radius-bordered" style="margin: 0 0 -15px 0 !important;">
                                    <div class="widget-body no-padding">   
                                        <div class="form-group">
                                            <textarea  name="customer_email_template"  ng-model="pushApiData.customer_email_template" id="customer_email_temp" data-ck-editor  required  style="position: relative;"></textarea>
                                        </div>                                                                        
                                    </div>
                                    <div ng-show="sbtBtn2" ng-messages="remarkForm.customer_email_template.$error" class="help-block">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </div>
                            </span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div><b style="margin-left: 15px;">Employee Email</b>
                        </div>
                        <hr>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" >
                                <label for="">Mark CC of this email to :</label>
                                <span class="input-icon icon-right">
                                    <input type="text" placeholder="" ng-model="pushApiData.employee_email_cc" name="employee_email_cc" class="form-control">
                                    <div ng-show="btn"  ng-messages="pushApiForm.employee_email_cc.$error" class="help-block">
                                        <div ng-message="required">This field is required</div>
                                    </div>
                                    <div style="color:red">Enter multiple email id's comma separated</div>
                                </span>                            
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" >
                                <label for="">Mark BCC of this email to :</label>
                                <span class="input-icon icon-right">
                                    <input type="text" placeholder="" ng-model="pushApiData.employee_email_bcc" name="employee_email_bcc" class="form-control">
                                   
                                    <div style="color:red">Enter multiple email id's comma separated</div>
                                </span>                           
                            </div>
                        </div>

                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" >
                                <label for="">Email subject line :  <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" placeholder="" ng-model="pushApiData.employee_email_subject_line" name="employee_email_subject_line" class="form-control" >
                                    <div ng-show="btn"  ng-messages="pushApiForm.employee_email_subject_line.$error" class="help-block">
                                        <div ng-message="required">This field is required</div>
                                    </div>
                                </span>                           
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label for="">Email body : <span class="sp-err">*</span></label>&nbsp;&nbsp;<input type="button" name="defaultemailemail" id="defaultemailemail" ng-model="defaultemailemail" ng-click="employee_email_template()" value="Default Template">
                            <span class="input-icon icon-right">
                                <div class="widget flat radius-bordered" style="margin: 0 0 -15px 0 !important;">
                                    <div class="widget-body no-padding">   
                                        <div class="widget-body no-padding">    
                                            <textarea  name="employee_email_template"  ng-model="pushApiData.employee_email_template" id="employee_email_template" data-ck-editor  required  style="position: relative;"></textarea>
                                        </div>                                                                      
                                    </div>
                                    <div ng-show="sbtBtn2" ng-messages="remarkForm.employee_email_template.$error" class="help-block">
                                        <div ng-message="required">This field is required</div>
                                    </div>
                                </div>
                            </span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div><b style="margin-left: 15px;">Guidelines for SMS / Email :</b></div>
                        <hr>
                        <div class="col-sm-3 col-xs-6">
                            <b> Customer related tags:</b><br>
                            <label for="">1) Customer Full Name : [#customerName#] </label>
                            <label for="">2) Customer Mobile : [#customerMob1#] </label>
                            <label for="">3) Customer Email ID : [#customerEmail1#] </label>
                            <label for="">4) Customer Message : [#customerMsg#] </label>
                            <label for="">5) Customer Enquiry Source : [#enquirySource#] </label>
                            <label for=""> 6) Customer Enquiry Description : [#enquiryDescription#] </label>
                            <label for="">7) Customer Greeting : [#greeting#] </label>
                            <br>
                            <b>Campaigning related tags:</b><br>
                            <label for="">1) Campaigning name: [#apiName#] </label><br>
                            <label for="">2) website : [#website#] </label>

                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <b>Employee related tags:</b><br>
                            <label for="">1) Employee Full Name : [#employeeName#]</label>
                            <label for="">2) Employee Mobile : [#employeeMobile#]</label>
                            <label for="">3) Employee Email ID : [#employeeEmail#] </label>
                            <label for="">4) Employee Designation: [#employeeDesignation#]</label>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <b> Company related tags:</b><br>
                            <label for="">1) Company Logo : [#companyLogo#]</label>
                            <label for="">2) Company Name : [#companyMarketingName#]</label>
                            <label for="">3) Company Address : [#companyAddress#]</label>
                            <!--<label for="">4) Company Contact Number : [#companyNumber#]</label>
                                <label for="">5) Company Email ID : [#companyEmail#]</label>-->
                        </div>
                         <div class="col-sm-3 col-xs-6">
                            <b> Project related tags:</b><br>
                            <label for="">1) Project Name : [#projectName#]</label> 
                            <label for=""> 2) Project logo : [#projectLogo#]</label>
                            <label for="">3) Project Contact Number : [#projectContactNo#]</label>
                            <label for="">4) Project Email ID : [#projectContactEmail#]</label>
                            <label for="">5) Project Address  : [#projectAddress#]</label>
                            <label for=""> 6) Project Brochure  : [#projectBroucher#]</label>
                            <label for="">7) Project Banner Image  : [#projectBannerImage#]</label>
<!--                            <label for="">8) Customer Information Form Link: [#customerFormLink#] </label>
                            Example: <xmp><a href="[#custFormLink#]">Click Here</a></xmp>-->
                            <label for="">8) Google Map Link (ifram): [#projectGoogleMap#]</label>
                            <label for="">9) Block type : [#projectBlockType#]</label>
                        </div>
                    </div>
                    <div class="row">
                        <center><button type="submit" class="btn btn-primary" ng-click="btn = true">Update</button></center>
                    </div>
                </form>
            </div>
            <div id="employee_default_sms_template" style="display:none"> 
                <h3>Dear  [#employeeName#] ,</h3><br/> 
                <p>you have just received enquiry from [#customerName#]  having mobile number [#customerMob1#].</p><br/> 
                <p> this enquiry was received through [#enquirySource#].</p><br/> 
                <p>please do the needful.</p><br/> 
                <p>LMSAuto</p><br/> 
                <p>[#greeting#]</p>
            </div>
            <div id="customer_default_sms_template" style="display:none">
                <h3>Dear [#customerName#],</h3><br/> 
                <p>We thank you for your Interest in buying vehicle. </p><br/> 
                <p> kindly click on the link [#website#] to let us know in detail about your requirement. </p><br/> 
                <p> for any further queries [#employeeName#] [#employeeMobile#] will be in touch with you.</p><br/> 
                <p> LMSAuto</p><br/> 
                <p> [#greeting#]</p><br/> 
            </div>  
        </div>
    </div>
</div>
<style>
    hr {
        margin-top: 2px;
        margin-bottom: 2px;
        border: 0;
        border-top: 1px solid #eee;
    }
    .ta-editor.form-control.myform1-height, .ta-scroll-window.form-control.myform1-height  {
        min-height: 100px;
        height: auto;
        overflow: auto;
        font-family: inherit;
        font-size: 100%;
    }
    p {
        line-height: 100px;
    }
</style>

