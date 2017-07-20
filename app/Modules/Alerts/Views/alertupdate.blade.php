<style>
    .btn-round{
        border-radius: 50%;
        height: 40px;
        width: 40px;
        line-height: 28px;
        padding-left: 13px;
        outline: none !important;
    }
    
    .toggleClassActive {font-size:40px !important;cursor:pointer;color: #5cb85c !important;vertical-align: middle;margin-left: 15px;}
    .toggleClassInactive {font-size:40px !important;cursor:pointer;color: #d9534f !important;vertical-align: middle;margin-left: 15px;}
</style>
<div class="row">
    <div class="widget flat radius-bordered ">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="alertsController">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{pageHeading}}</h5>
            <div class="widget-body bordered-top bordered-sky col-lg-12 col-sm-12 col-xs-12">
                <div id="customer-form">
                    <form novalidate role="form" ng-submit="alertFrom.$valid &&  createAlert(alertData, alertData.image_file,[[ !empty($alertId) ?  $alertId : '0' ]])" name="alertFrom" ng-init="manageAlerts([[ !empty($alertId) ?  $alertId : '0' ]],'edit',[[$customerType]])">
                        <input type="hidden" ng-model="alertData.csrfToken" name="csrftoken" id="csrftoken" ng-init="alertData.csrfToken = '[[ csrf_token() ]]'" class="form-control">
                        <input type="hidden" ng-model="alertData.customer_type" name="customer_type">
                        <div class="row col-lg-12 col-sm-12 col-xs-12">  
                            <hr class="wide" />
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="form-title">
                                    Update Alerts
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Alert For</label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="alertData.templates_event_id" ng-init="getTemplatesEvents()" name="templates_event_id" class="form-control" required disabled>
                                                    <option value="">Select Event</option>
                                                    <option ng-repeat="t in templateEvents track by $index" value="{{t.id}}" ng-selected="{{ t.id == alertData.templates_event_id}}">{{t.event_name}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="sbtBtn && alertFrom.templates_event_id.$invalid " ng-messages="alertFrom.templates_event_id.$error" class="help-block">
                                                    <div ng-message="required" style="color: red !important;">This field is required</div>
                                                </div> 
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Alerts Category</label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="alertData.template_category" name="template_category" class="form-control" required disabled>
                                                    <option ng-if="alertData.template_category===0" value="0" ng-selected="true" >Default</option>
                                                    <option ng-if="alertData.template_category===1" value="1" ng-selected = "true">Default/Custom</option>
                                                </select>
                                                <div ng-show="sbtBtn && alertFrom.template_category.$invalid" ng-messages="alertFrom.template_category.$error"  class="help-block has-error">
                                                    <div ng-message="required" style="color: red !important;">This field is required</div>
                                                </div> 
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group" >
                                            <label for="">Define SMS Cc Numbers (comma separates multiple numbers)</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control" ng-model="alertData.sms_cc_numbers" name="sms_cc_numbers">
                                                <i class="fa fa-user"></i>
                                                <div ng-show="sbtBtn && alertFrom.sms_cc_numbers.$invalid" ng-messages="alertFrom.sms_cc_numbers.$error" class="help-block">
                                                    <div ng-message="required" style="color: red !important;">This field is required</div>
                                                </div> 
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Define SMS Cc Employees</label>
                                             <span class="input-icon icon-right">
                                                <ui-select multiple ng-model="alertData.sms_cc_employees" name="sms_cc_employees" theme="select2" ng-disabled="disabled" style="width: 300px;" ng-required ng-init="getEmployees()">
                                                    <ui-select-match placeholder="Select Email">{{$item.email}}</ui-select-match>
                                                    <ui-select-choices repeat="Employee in Employees | filter:$select.search">
                                                        {{Employee.email}} 
                                                    </ui-select-choices>
                                                </ui-select>
                                                <div ng-show="sbtBtn && alertFrom.sms_cc_employees.$invalid " ng-messages="alertFrom.sms_cc_employees.$error" class="help-block">
                                                    <div ng-message="required" style="color: red !important;">This field is required</div>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Email From</label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="alertData.from_mail_id" name="from_mail_id" class="form-control" ng-init="getEmailConfig()" >
                                                    <option value="">Select Employee</option>
                                                    <option ng-repeat="email in emailConfig track by $index" value="{{email.id}}" ng-selected="{{email.id == alertData.from_mail_id}}">{{email.email}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-if="gender_id" class="errMsg">{{gender_id}}</div>
                                                <div ng-show="sbtBtn && alertFrom.from_mail_id.$invalid "      ng-messages="alertFrom.from_mail_id.$error" class="help-block">
                                                    <div ng-message="required" style="color: red !important;">This field is required</div>
                                                </div> 
                                            </span>
                                        </div>
                                    </div>
                                   
                                </div>
                                <div class="row">
                                    
                                </div>
                            </div>   
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Email Cc ids(comma separates multiple numbers)</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control" ng-model="alertData.email_cc_ids" name="email_cc_ids">
                                                <i class="fa fa-user"></i>
                                                <div ng-show="sbtBtn && alertFrom.email_cc_ids.$invalid" ng-messages="alertFrom.email_cc_ids.$error" class="help-block">
                                                    <div ng-message="required" style="color: red !important;">This field is required</div>
                                                </div> 
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Email Cc Employees : </label>
                                            <span class="input-icon icon-right">
                                                <ui-select multiple ng-model="alertData.email_cc_employees" name="email_cc_employees" theme="select2" ng-disabled="disabled" style="width: 300px;" ng-required ng-change="">
                                                    <ui-select-match placeholder="Select Email">{{$item.email}}</ui-select-match>
                                                    <ui-select-choices repeat="Employee in Employees | filter:$select.search">
                                                        {{Employee.email}} 
                                                    </ui-select-choices>
                                                </ui-select>
                                                <div ng-show="sbtBtn && alertFrom.email_cc_employees.$invalid " ng-messages="alertFrom.email_cc_employees.$error" class="help-block">
                                                    <div ng-message="required" style="color: red !important;">This field is required</div>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Email Bcc ids(comma separates multiple numbers) </label>
                                             <span class="input-icon icon-right">
                                                <input type="text" class="form-control" ng-model="alertData.email_bcc_ids" name="email_bcc_ids">
                                                <i class="fa fa-user"></i>
                                                <div ng-show="sbtBtn && alertFrom.email_bcc_ids.$invalid" ng-messages="alertFrom.email_bcc_ids.$error" class="help-block">
                                                    <div ng-message="required" style="color: red !important;">This field is required</div>
                                                </div> 
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Email Bcc Employees : </label>
                                            <span class="input-icon icon-right">
                                                <ui-select multiple ng-model="alertData.email_bcc_employees" name="sms_cc_employees" theme="select2" ng-disabled="disabled" style="width: 300px;" ng-required>
                                                    <ui-select-match placeholder="Select Email">{{$item.email}}</ui-select-match>
                                                    <ui-select-choices repeat="Employee in Employees | filter:$select.search">
                                                        {{Employee.email}} 
                                                    </ui-select-choices>
                                                </ui-select>
                                                <div ng-show="sbtBtn && alertFrom.email_bcc_employees.$invalid " ng-messages="alertFrom.email_bcc_employees.$error" class="help-block">
                                                    <div ng-message="required" style="color: red !important;">This field is required</div>
                                                </div>
                                            </span>                                           
                                        </div>
                                    </div>
                                </div>                                
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">SMS Status</label>
                                                <span class="fa fa-toggle-on toggleClassActive" ng-if="alertData.sms_status === 1" ng-click="changeSmsPrivacyStatus(0);"></span>
                                                <span class="fa fa-toggle-on fa-rotate-180 toggleClassInactive" ng-if="alertData.sms_status === 0" ng-click="changeSmsPrivacyStatus(1);"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Email Status</label>
                                            <span class="fa fa-toggle-on toggleClassActive" ng-if="alertData.email_status === 1" ng-click="changeEmailPrivacyStatus(0);"></span>
                                            <span class="fa fa-toggle-on fa-rotate-180 toggleClassInactive" ng-if="alertData.email_status === 0" ng-click="changeEmailPrivacyStatus(1);"></span>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <hr class="wide col-md-12" />
                        </div>  
                        <hr class="wide col-lg-12 col-xs-12 col-md-12"/>  
                        <div class="col-lg-12 col-xs-12 col-md-12" align="center">
                            <button type="submit" class="btn btn-primary" ng-click="sbtBtn=true">{{buttonLabel}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
