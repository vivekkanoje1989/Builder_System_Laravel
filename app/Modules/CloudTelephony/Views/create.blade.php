<!--Registration Form for VN-->

<form name="numberregistrationForm" novalidate ng-submit="numberregistrationForm.$valid && registrationNumber(registrationData)" ng-controller="cloudtelephonyController" ng-init="manageLists([[ !empty($id) ?  $id : '0' ]],'edit')">
    <input type="hidden" ng-model="numberregistrationForm.csrfToken" name="csrftoken" id="csrftoken" ng-init="numberregistrationForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
    <input type="hidden" name="id" id="id" ng-model="registrationData.id" ng-value="[[ $id ]]">
<div class="col-lg-12 col-sm-12 col-xs-12">
    <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{ pageHeading}}</h5>
                        <div class="widget flat radius-bordered">
                            <div class="widget-header bordered-bottom bordered-themeprimary">
                                <span class="widget-caption">Virtual Number Registration</span>
                            </div>
                            <div class="widget-body">
                                <div id="registration-form">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group" ng-class="{ 'has-error' : step1 && (!numberregistrationForm.client_id.$dirty && numberregistrationForm.client_id.$invalid)}">
                                                    <label for="">Select Client <span class="sp-err">*</span></label>
                                                    <span class="input-icon icon-right">
                                                        <select ng-controller="clientCtrl" ng-model="registrationData.client_id" name="client_id" class="form-control" required>
                                                            <option value="">Select Client</option>
                                                            <option ng-repeat="client in clients" value="{{client.id}}">{{client.marketing_name}}</option>
                                                        </select>
                                                        <i class="fa fa-sort-desc"></i>
                                                        <div ng-show="step1" ng-messages="numberregistrationForm.client_id.$error" class="help-block step1">
                                                            <div ng-message="required">This field is required.</div>
                                                        </div>
                                                        <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.client_id }} </span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group" ng-class="{ 'has-error' : step1 && (!numberregistrationForm.virtual_number.$dirty && numberregistrationForm.virtual_number.$invalid)}">
                                                    <label for="">Virtual Number <span class="sp-err">*</span></label>
                                                    <span class="input-icon icon-right">
                                                        <input type="text" ng-model="registrationData.virtual_number" name="virtual_number" class="form-control" oninput="if (/[^0-9]/g.test(this.value)) this.value = this.value.replace(/[^0-9 ]/g,'')" maxlength="10" required>
                                                        <div ng-show="step1" ng-messages="numberregistrationForm.virtual_number.$error" class="help-block step1">
                                                            <div ng-message="required">This field is required.</div>
                                                        </div>
                                                        <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.virtual_number }} </span>
                                                    </span>                                
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" ng-model="registrationData.default_number" name="default_number" class="form-control" value="{{ registrationData.default_number }}" ng-change="outboundStatus()">
                                                            <span class="text">Default Number</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-lg-4">
                                                <div class="form-group">
                                                <div class="checkbox">
                                                    <label for="">Incoming Call Status :</label>
                                                    <label>
                                                        <input name="incoming_call_status" ng-model="registrationData.incoming_call_status" type="radio" value="1">
                                                        <span class="text">Yes </span>
                                                    </label>
                                                    <label>
                                                        <input name="incoming_call_status" ng-model="registrationData.incoming_call_status" type="radio" value="0">
                                                        <span class="text">No </span>
                                                    </label>
                                                </div>
                                                    <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.incoming_call_status }} </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div ng-show="registrationData.incoming_call_status == '1'" class="form-group" ng-class="{ 'has-error' : step1 && (!numberregistrationForm.incoming_pulse_duration.$dirty && numberregistrationForm.incoming_pulse_duration.$invalid)}">
                                                    <label for="">Incoming Pulse Duration (Seconds) <span class="sp-err">*</span></label>
                                                    <span class="input-icon icon-right">
                                                        <select ng-model="registrationData.incoming_pulse_duration" name="incoming_pulse_duration"  class="form-control" required>
                                                            <option value="">Incoming Pulse Duration</option>
                                                             <option value="15">15 Seconds</option>
                                                             <option value="30">30 Seconds</option>
                                                             <option value="60">60 Seconds</option>
                                                             <option value="180">180 Seconds</option>                                                             
                                                        </select>
                                                       <i class="fa fa-sort-desc"></i>
                                                       <div ng-show="step1" ng-messages="numberregistrationForm.incoming_pulse_duration.$error" class="help-block step1">
                                                            <div ng-message="required">This field is required.</div>
                                                        </div>
                                                       <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.incoming_pulse_duration }} </span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div ng-show="registrationData.incoming_call_status == '1'" class="form-group" ng-class="{ 'has-error' : step1 && (!numberregistrationForm.incoming_pulse_rate.$dirty && numberregistrationForm.incoming_pulse_rate.$invalid)}">
                                                    <label for="">Incoming Pulse Rate (Paisa) <span class="sp-err">*</span></label>
                                                    <span class="input-icon icon-right">
                                                        <input type="text" class="form-control" name="incoming_pulse_rate" ng-model="registrationData.incoming_pulse_rate" id="incomingPulseRate" placeholder="Incoming Pulse Rate" oninput="if (/[^0-9]/g.test(this.value)) this.value = this.value.replace(/[^0-9 ]/g,'')" maxlength="3" required>
                                                        <div ng-show="step1" ng-messages="numberregistrationForm.incoming_pulse_rate.$error" class="help-block step1">
                                                            <div ng-message="required">This field is required.</div>
                                                        </div>
                                                        <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.incoming_pulse_rate }} </span>
                                                    </span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-lg-4">
                                                <div class="form-group" ng-show="registrationData.default_number == '1'">
                                                <div class="checkbox">
                                                    <label for="">Outbound Call Status :</label>
                                                    <label>
                                                        <input name="outbound_call_status" ng-model="registrationData.outbound_call_status" type="radio" value="1">
                                                        <span class="text">Yes </span>
                                                    </label>
                                                    <label>
                                                       <input name="outbound_call_status" ng-model="registrationData.outbound_call_status" type="radio" checked="true" value="0">
                                                        <span class="text">No </span>
                                                    </label>
                                                </div>
                                                    <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.outbound_call_status }} </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div ng-show="registrationData.outbound_call_status == '1'" class="form-group" ng-class="{ 'has-error' : step1 && (!numberregistrationForm.outbound_pulse_duration.$dirty && numberregistrationForm.outbound_pulse_duration.$invalid)}">
                                                    <label for="">Outbound Pulse Duration (Seconds) <span class="sp-err">*</span></label>
                                                    <span class="input-icon icon-right">
                                                        <select ng-model="registrationData.outbound_pulse_duration" name="outbound_pulse_duration"  class="form-control" ng-required="registrationData.outbound_call_status == '1'">
                                                            <option value="">Outbound Pulse Duration</option>
                                                             <option value="15">15 Seconds</option>
                                                             <option value="30">30 Seconds</option>
                                                             <option value="60">60 Seconds</option>
                                                             <option value="180">180 Seconds</option>                                                             
                                                        </select>
                                                       <i class="fa fa-sort-desc"></i>
                                                       <div ng-show="step1" ng-messages="numberregistrationForm.outbound_pulse_duration.$error" class="help-block step1">
                                                            <div ng-message="required">This field is required.</div>
                                                        </div>
                                                       <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.outbound_pulse_duration }} </span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div ng-show="registrationData.outbound_call_status == '1'" class="form-group" ng-class="{ 'has-error' : step1 && (!numberregistrationForm.outbound_pulse_rate.$dirty && numberregistrationForm.outbound_pulse_rate.$invalid)}">
                                                    <label for="">Outbound Pulse Rate (Paisa) <span class="sp-err">*</span></label>
                                                    <span class="input-icon icon-right">
                                                        <input type="text" class="form-control" name="outbound_pulse_rate" ng-model="registrationData.outbound_pulse_rate" id="outboundPulseRate" placeholder="Outbound Pulse Rate" oninput="if (/[^0-9]/g.test(this.value)) this.value = this.value.replace(/[^0-9 ]/g,'')" maxlength="3" ng-required="registrationData.outbound_call_status == '1'">
                                                        <div ng-show="step1" ng-messages="numberregistrationForm.outbound_pulse_rate.$error" class="help-block step1">
                                                            <div ng-message="required">This field is required.</div>
                                                        </div>
                                                         <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.outbound_pulse_rate }} </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-lg-4">
                                                 <label for="">Activation Date <span class="sp-err">*</span></label>
                                                 <div ng-controller="DatepickerDemoCtrl" class="form-group" ng-class="{ 'has-error' : step1 && (!numberregistrationForm.activation_date.$dirty  && numberregistrationForm.activation_date.$invalid)}">
                                                    <p class="input-group">
                                                    <input type="text" class="form-control" ng-model="registrationData.activation_date" name="activation_date" id="activation_date" datepicker-popup="{{format}}" is-open="opened" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" close-text="Close"  required/>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                    </span>
                                                    </p>
                                                    <div ng-show="step1" ng-messages="numberregistrationForm.activation_date.$error" class="help-block step1">
                                                        <div ng-message="required">This field is required.</div>
                                                    </div>
                                                    <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.activation_date }} </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group" ng-class="{ 'has-error' : step1 && (!numberregistrationForm.rent_duration.$dirty  && numberregistrationForm.rent_duration.$invalid)}">
                                                    <label for="">Rent Duration <span class="sp-err">*</span></label>
                                                    <span class="input-icon icon-right">
                                                        <select ng-model="registrationData.rent_duration" name="rent_duration" id="rent_duration" class="form-control" required>
                                                            <option value="">Rent Duration</option>
                                                             <option value="1">Monthly</option>
                                                             <option value="2">Quarterly</option>
                                                             <option value="3">Half Yearly</option>
                                                             <option value="4">Yearly</option>                                                             
                                                        </select>
                                                       <i class="fa fa-sort-desc"></i>
                                                        <div ng-show="step1" ng-messages="numberregistrationForm.rent_duration.$error" class="help-block step1">
                                                            <div ng-message="required">This field is required.</div>
                                                        </div>
                                                       <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.rent_duration }} </span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group" ng-class="{ 'has-error' : step1 && (!numberregistrationForm.rent_amount.$dirty  && numberregistrationForm.rent_amount.$invalid)}">
                                                    <label for="">Rent Amount (Rs.)<span class="sp-err">*</span></label>
                                                    <span class="input-icon icon-right">
                                                        <input type="text" ng-model="registrationData.rent_amount" name="rent_amount" id="rent_amount" class="form-control" maxlength="3" required>
                                                        <div ng-show="step1" ng-messages="numberregistrationForm.rent_amount.$error" class="help-block step1">
                                                            <div ng-message="required">This field is required.</div>
                                                        </div>
                                                        <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.rent_amount }} </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <center><button type="submit" class="btn btn-primary" ng-click="step1=true">Submit</button></center>
                                        </div>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
      </form>
