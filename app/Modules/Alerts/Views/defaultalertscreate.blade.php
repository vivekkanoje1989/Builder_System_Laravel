<style>
    .bordered-bot {
        border-color: #2dc3e8 !important;
    }

</style>

<div class="row">
    <div class="widget flat radius-bordered ">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="defaultalertsController">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i> Default Template</h5>
            <div class="widget-body bordered-top bordered-sky col-lg-12 col-sm-12 col-xs-12">
                <div id="customer-form">
                    <form novalidate role="form" ng-submit="defaultAlertForm.$valid &&  createAlert(defaultAlertData,[[ !empty($alertId) ?  $alertId : '0' ]])" name="defaultAlertForm" ng-init="manageDafaultAlerts([[ !empty($alertId) ?  $alertId : '0' ]],'edit')">
                        <input type="hidden" ng-model="defaultAlertData.csrfToken" name="csrftoken" id="csrftoken" ng-init="defaultAlertData.csrfToken = '[[ csrf_token() ]]'" class="form-control">
                        <input type="hidden" ng-model="defaultAlertData.client_id" name="client_id">
                        <div class="row col-lg-12 col-sm-12 col-xs-12">  
                            <hr class="wide" />
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="form-title">
                                    Default Template 
                                </div>
                            </div>
                            
                            
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="well with-header  with-footer col-md-12 col-xs-12 mar-bot30">
                                    <div class="buttons-preview">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group" >
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 nopadleft">
                                                   <label for="definpu">Template For :</label>
                                        </div>
                                        <div class="col-lg-8 col-md-2 col-sm-2 col-xs-12 nopadleft">
                                            <span class="input-icon icon-right">
                                                <select ng-model="defaultAlertData.templates_event_id" ng-init="getTemplatesEvents()" name="templates_event_id" class="form-control" ng-disabled="true" required >
                                                    <option value="">Select Event</option>
                                                    <option ng-repeat="t in templateEvents track by $index" value="{{t.id}}" ng-selected="{{ t.id == defaultAlertData.templates_event_id}}">{{t.event_name}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="sbtBtn && defaultAlertForm.templates_event_id.$invalid " ng-messages="defaultAlertForm.templates_event_id.$error" class="help-block">
                                                    <div ng-message="required" style="color: red !important;">This field is required</div>
                                                </div> 
                                            </span>       
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-sm-6">
                                    <div class="form-group" >
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 nopadleft">
                                                  <label for="definpu">Template To :</label>
                                        </div>
                                        <div class="col-lg-8 col-md-2 col-sm-2 col-xs-12 nopadleft">
                                            <span class="input-icon icon-right">
                                                <select ng-model="defaultAlertData.template_for" name="template_for" class="form-control" ng-disabled="true" required >
                                                    <option value="">Select For</option>
                                                    <option value="0">Employee</option>
                                                    <option value="1">Customer</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="sbtBtn && defaultAlertForm.template_for.$invalid " ng-messages="defaultAlertForm.template_for.$error" class="help-block">
                                                    <div ng-message="required" style="color: red !important;">This field is required</div>
                                                </div> 
                                            </span>     
                                        </div>
                                    </div>
                                </div>                             
                            </div>
                                        <br>
                                        
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group" >
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 nopadleft">
                                                   <label for="definpu">SMS Body :</label>
                                        </div>
                                        <div class="col-lg-8 col-md-2 col-sm-2 col-xs-12 nopadleft">
                                            <span class="input-icon icon-right">
                                                <textarea ng-model="defaultAlertData.sms_body" name="sms_body" style="height: 100px;" class="form-control ng-pristine ng-valid ng-valid-required ng-touched" ng-disabled="true" required=""></textarea>
                                                <i class="fa fa fa-align-left"></i>
                                                <div ng-show="sbtBtn &amp;&amp; defaultAlertForm.sms_body.$invalid " ng-messages="defaultAlertForm.sms_body.$error" class="help-block ng-hide ng-inactive">
                                                <div ng-message="required" style="color: red !important;">This field is required</div>
                                                </div>
                                            </span>      
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-sm-6">
                                    <div class="form-group" >
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 nopadleft">
                                                   <label for="definpu">Email Subject :</label>
                                        </div>
                                        <div class="col-lg-8 col-md-2 col-sm-2 col-xs-12 nopadleft">
                                            <span class="input-icon icon-right">
                                                <textarea ng-model="defaultAlertData.email_subject" name="email_subject" class="form-control ng-pristine ng-valid ng-valid-required ng-touched" ng-disabled="true" required=""></textarea>
                                                <i class="fa fa fa-align-left"></i>
                                                <div ng-show="sbtBtn &amp;&amp; defaultAlertForm.email_subject.$invalid " ng-messages="defaultAlertForm.email_subject.$error" class="help-block ng-hide ng-inactive">
                                                <div ng-message="required" style="color: red !important;">This field is required</div>
                                                </div>
                                            </span>   
                                        </div>
                                    </div>
                                </div>                             
                            </div>
                                        <br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 nopadleft">
                                        <label for="definpu">Email Body :</label>
                                    </div>   
                                    
                                    <span  style="float: left;" class="input-icon icon-right emailbody_data" ng-bind-html="defaultAlertData.email_body">

                                    </span>  
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
            


