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
                            
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Template For</label>
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
                                            <label for="">Template Category</label>
                                            
                                            
                                                <!--select ng-model="alertData.template_category" name="template_category" class="form-control" required disabled>
                                                    <option ng-if="alertData.template_category===0" value="0" ng-selected="true" >Default</option>
                                                    <option ng-if="alertData.template_category===1" value="1" ng-selected = "true">Default/Custom</option>
                                                </select-->
                                                
                                                <div class="form-group" ng-if="alertData.template_category===1">   
                                                    <div>
                                                        <div style="float:left;width: 30%">
                                                            <span style="margin-top:5px;margin-left: 10px;background-color:#5cb85c !important;float:left;width:12px;height:12px;">&nbsp;&nbsp;</span>&nbsp;&nbsp;Custom<br>
                                                            <span style="margin-top:5px;margin-left: 10px;background-color:#d9534f !important;float:left;width:12px;height:12px;">&nbsp;&nbsp;</span>&nbsp;&nbsp;Default
                                                        </div>
                                                        <div style="float:right;width: 70%">
                                                            <span class="fa fa-toggle-on toggleClassActive" ng-if="alertData.template_type === 1" ng-click="changeTemplateType(0,alertData);"></span> 
                                                            <span class="fa fa-toggle-on fa-rotate-180 toggleClassInactive" ng-if="alertData.template_type === 0" ng-click="changeTemplateType(1,alertData);"></span>
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    <div>
                                                        
                                                            <span ng-show='alertData.template_type == 1 && alertData.friendly_name !=null ' style="cursor: pointer;" ng-click="display_ddl_custom(1)">
                                                                <label><strong>Custom Templates Friendly Name</strong></label><br>
                                                                <div  class="alert alert-warning fade in" style="background:#e2e2e2;border-color: #5cb85c;">
                                                                    <span class="close">
                                                                            ×
                                                                    </span>
                                                                        {{alertData.friendly_name}}
                                                                </div>
                                                               
                                                            </span>
                                                            
                                                            <div ng-show='alertData.template_type == 1 && ddl_friendly_name_flag == 1 '>    
                                                                <span class="close btn-default purple" style="margin-top: 7px;position: absolute;margin-left: 312px;z-index: 0;" ng-click="display_ddl_custom(0)">
                                                                         ×
                                                                </span>
                                                                Select Template
                                                                <ui-select ng-model="alertData.custom_template_id" theme="select2"  style="width:90%" ng-change="updateCustomTemplate(alertData)">
                                                                    <ui-select-match placeholder="Select or search a custom ">{{$select.selected.friendly_name}}</ui-select-match>
                                                                    <ui-select-choices repeat="item in custom_template_list | filter: $select.search">
                                                                      <div ng-bind-html="item.friendly_name | highlight: $select.search" ></div>
                                                                    </ui-select-choices>
                                                                </ui-select>    
                                                            </div> 
                                                            
                                                    </div>
                                                            
                                                </div>
                                                
                                                <div class="form-group" ng-if="alertData.template_category===0">
                                                    <strong>Default Only</strong>
                                                </div>
                                                
                                                <div ng-show="sbtBtn && alertFrom.template_category.$invalid" ng-messages="alertFrom.template_category.$error"  class="help-block has-error">
                                                    <div ng-message="required" style="color: red !important;">This field is required</div>
                                                </div> 
                                                
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group" >
                                            <label for="">Define SMS CC Numbers (comma separated multiple numbers)</label>
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
                                            <label for="">Define SMS CC Employees</label>
                                             <span class="input-icon icon-right">
                                                <ui-select multiple ng-model="alertData.sms_cc_employees" name="sms_cc_employees" theme="select2" ng-disabled="disabled" style="width: 300px;" ng-required ng-init="getEmployees()">
                                                    <ui-select-match placeholder="Select Employee">{{$item.first_name}} {{$item.last_name}} </ui-select-match>
                                                    <ui-select-choices repeat="Employee in Employees | filter:$select.search">
                                                        {{Employee.first_name}} {{Employee.last_name}} 
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
                                            <label for="">CC Email Ids(comma separated multiple Emails Ids)</label>
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
                                            <label for="">CC Email Employees : </label>
                                            <span class="input-icon icon-right">
                                                <ui-select multiple ng-model="alertData.email_cc_employees" name="email_cc_employees" theme="select2" ng-disabled="disabled" style="width: 300px;" ng-required ng-change="">
                                                    <ui-select-match placeholder="Select Email">{{$item.office_email_id}}</ui-select-match>
                                                    <ui-select-choices repeat="Employee in Employees | filter:$select.search">
                                                       {{Employee.first_name}} {{Employee.last_name}}  ( {{Employee.office_email_id}} ) 
                                                    </ui-select-choices>
                                                </ui-select>
                                                <div ng-show="sbtBtn && alertFrom.email_cc_employees.$invalid " ng-messages="alertFrom.email_cc_employees.$error" class="help-block">
                                                    <div ng-message="required" style="color: red !important;">This field is required</div>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </span>                                           
                            </div>
                        </div>
                        <div class="col-sm-6">
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
                    <div class="row">
                        <div class="col-lg-12 col-xs-12 col-md-12">
                            <button type="submit" class="btn btn-primary" ng-click="sbtBtn=true">{{buttonLabel}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
