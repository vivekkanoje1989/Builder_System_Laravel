<!--Registration Form for VN-->
<?php
use Illuminate\Support\Facades\Route;
$currentPath= Route::getCurrentRoute()->getActionName();
//echo $currentPath;exit;
?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="cloudtelephonyController">
        <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{ pageHeading }}</h5>
        <div id="WiredWizard" class="wizard wizard-wired" data-target="#WiredWizardsteps" ui-jq="wizard">
            <ul class="steps">
                <li data-target="#wiredstep1" class="active"><span class="step">1</span><span class="title">New Customer Settings</span><span class="chevron"></span></li>
                <li data-target="#wiredstep2"><span class="step">2</span><span class="title">Extension Settings</span> <span class="chevron"></span></li>
                <li data-target="#wiredstep3"><span class="step">3</span><span class="title">Existing Customer Settings</span> <span class="chevron"></span></li>
                <li data-target="#wiredstep4"><span class="step">4</span><span class="title">Call Logs</span> <span class="chevron"></span></li>
            </ul>

        </div>
        <div class="step-content" id="WiredWizardsteps">
            <div class="step-pane active" id="wiredstep1">
                <form name="updatevnoForm" novalidate ng-submit="updatevnoForm.$valid && updateVirtualNumber(registrationData,registrationData.welcome_tune_audio)" ng-init="managevLists([[ !empty($id) ?  $id : '0' ]], 'edit')">
                    <input type="hidden" ng-model="updatevnoForm.csrfToken" name="csrftoken" id="csrftoken" ng-init="updatevnoForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <input type="hidden" name="id" id="id" ng-model="registrationData.id" ng-value="[[ $id ]]">
                    <!--            <div class="widget-body">-->
                    <div id="registration-form">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.virtual_number.$dirty && updatevnoForm.virtual_number.$invalid)}">
                                            <label for="">Virtual Number <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="registrationData.virtual_number" name="virtual_number" class="form-control" oninput="if (/[^0-9]/g.test(this.value)) this.value = this.value.replace(/[^0-9 ]/g,'')" maxlength="12" required>
                                                <div ng-show="step1" ng-messages="updatevnoForm.virtual_number.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.virtual_number}} </span>
                                            </span>                                
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.welcome_tune_type_id.$dirty && updatevnoForm.welcome_tune_type_id.$invalid)}">
                                            <label for="">Welcome Greeting <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.welcome_tune_type_id" name="welcome_tune_type_id" ng-init="cttunetype()" class="form-control" ng-change="menuStatus()" required>
                                                    <option value="">Select Welcome Tune Type</option>
                                                    <option ng-repeat="ct_tune_type in ct_tune_types" value="{{ct_tune_type.id}}">{{ct_tune_type.type}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1" ng-messages="updatevnoForm.welcome_tune_type_id.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.welcome_tune_type_id}} </span>
                                            </span>
                                        </div>
                                    </div> 
                                </div>  


                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.welcome_tune_type_id != '1'">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" ng-model="registrationData.menu_status" name="menu_status" class="form-control" value="{{ registrationData.menu_status}}">
                                                    <span class="text">Welcome greeting with menu </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.welcome_tune_type_id == '3'"> 
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.welcome_tune_audio.$dirty && updatevnoForm.welcome_tune_audio.$invalid)}">
                                            <label for="">Upload Welcome Greeting Mp3</label>
                                            <span class="input-icon icon-right">
                                                <audio controls=""><source type="audio/mpeg"  id="audiourl" src="" /></audio>
                                                <input type="file" ngf-select ng-model="registrationData.welcome_tune_audio" id="welcome_tune_audio" class="form-control" name="welcome_tune_audio">
                                                <div ng-show="step1" ng-messages="updatevnoForm.welcome_tune_audio.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.welcome_tune_audio}} </span>                                           
                                        </div>
                                    </div> 
                                     <div class="col-md-6 col-sm-6 col-xs-12" ng-show="(registrationData.welcome_tune_type_id == '2')">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.welcome_tune.$dirty && updatevnoForm.welcome_tune.$invalid)}">
                                            <label for="">Enter text to read as a hold tune</label>
                                            <textarea ng-model="registrationData.welcome_tune" name="welcome_tune" class="form-control" ng-required ="registrationData.welcome_tune_type_id==2">{{ registrationData.welcome_tune}}</textarea>
                                            <span class="input-icon icon-right">
                                                <div ng-show="step1" ng-messages="updatevnoForm.welcome_tune.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.welcome_tune}} </span>
                                        </div>
                                    </div>

                                </div>  

                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.menu_status != '1'">

                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.hold_tune_type_id.$dirty && updatevnoForm.hold_tune_type_id.$invalid)}">
                                            <label for="">Hold Tune <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.hold_tune_type_id" name="hold_tune_type_id" ng-init="cttunetype1()" class="form-control" required>
                                                    <option value="">Select Hold Tune Type</option>
                                                    <option ng-repeat="ct_tune_type1 in ct_tune_types1" value="{{ct_tune_type1.id}}">{{ct_tune_type1.type}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1" ng-messages="updatevnoForm.hold_tune_type_id.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.hold_tune_type_id}} </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="(registrationData.hold_tune_type_id == '3' && registrationData.menu_status != '1')">
                                        <div class="form-group">
                                            <label for="">Upload Hold Tune Mp3</label>
                                            <span class="input-icon icon-right">
                                                <audio controls>
                                                    <source type="audio/mpeg" ng-src="https://s3-ap-south-1.amazonaws.com/lms-auto/1/cloud_calling/caller_tune/hold_tune071056.mp3"">
                                                </audio>
                                                <input type="file"  id="hold_tune" class="" name="hold_tune" accept="mp3/*" ng-required = "registrationData.hold_tune_type_id==3">
                                                <div ng-show="step1" ng-messages="updatevnoForm.hold_tune.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.hold_tune}} </span>
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="(registrationData.hold_tune_type_id == '2' && registrationData.menu_status != '1')">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.hold_tune.$dirty && updatevnoForm.hold_tune.$invalid)}">
                                            <label for="">Enter text to read as a hold tune</label>
                                            <textarea ng-model="registrationData.hold_tune" name="hold_tune" class="form-control" ng-required ="registrationData.hold_tune_type_id==2">{{ registrationData.hold_tune}}</textarea>
                                            <span class="input-icon icon-right">
                                                <div ng-show="step1" ng-messages="updatevnoForm.hold_tune.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.hold_tune}} </span>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.forwarding_type_id.$dirty && updatevnoForm.forwarding_type_id.$invalid)}">
                                            <label for="">Forwarding Type <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.forwarding_type_id" name="forwarding_type_id" ng-init="ct_forwarding_types()" class="form-control" required>
                                                    <option value="0">Select Forwarding Type</option>
                                                    <option ng-repeat="ct_forwarding_type in ct_forwarding_types" value="{{ct_forwarding_type.id}}">{{ct_forwarding_type.type}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1" ng-messages="updatevnoForm.forwarding_type_id.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.forwarding_type_id}} </span>
                                            </span>
                                        </div>

                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.forwarding_type_id > '1'">
                                        <div  class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.forwarding_time.$dirty && updatevnoForm.forwarding_time.$invalid)}">
                                            <label for="">Forwarding Time (Seconds) <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.forwarding_time" name="forwarding_time"  class="form-control" required>
                                                    <option value="0">Select Forwarding Time</option>
                                                    <option value="10">10 Seconds</option>
                                                    <option value="20">20 Seconds</option>
                                                    <option value="30">30 Seconds</option>
                                                    <option value="40">40 Seconds</option> 
                                                    <option value="50">50 Seconds</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1" ng-messages="updatevnoForm.forwarding_time.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.forwarding_time}} </span>
                                            </span>
                                        </div>
                                    </div> 
                                </div>  

                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-12 bord-l8">
                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.insert_enquiry.$dirty && updatevnoForm.insert_enquiry.$invalid)}">
                                            <label for="">Insert Enquiry <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.insert_enquiry" name="insert_enquiry" id="insert_enquiry" class="form-control" required>
                                                    <option value="">Please Select</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>                                    
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1" ng-messages="updatevnoForm.insert_enquiry.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.insert_enquiry}} </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.model_project_id.$dirty && updatevnoForm.model_project_id.$invalid)}">
                                            <label for="">Vehicle Model <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-controller="vehiclemodelCtrl" ng-model="registrationData.model_project_id" name="model_project_id" ng-init="vehiclemodels()" class="form-control" required>
                                                    <option value="">Select Vehicle Model</option>
                                                    <option ng-repeat="vehiclemodel in vehiclemodels" value="{{vehiclemodel.id}}">{{vehiclemodel.model_name}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1" ng-messages="updatevnoForm.model_project_id.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.model_project_id}} </span>
                                            </span>
                                        </div>
                                    </div> 
                                </div>  


                                <div class="row" ng-controller="sourceCtrl" > 

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.source_id.$dirty && updatevnoForm.source_id.$invalid)}">
                                            <label for="">Source <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.source_id" name="source_id" ng-init="enquirysources()" ng-change="getsubsource(registrationData.source_id)" class="form-control" required>
                                                    <option value="">Select Source</option>
                                                    <option ng-repeat="enquirysource in enquirysources" value="{{enquirysource.id}}">{{enquirysource.source_name}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1" ng-messages="updatevnoForm.source_id.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.source_id}} </span>
                                            </span>
                                        </div>
                                    </div> 

                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.sub_source_id.$dirty && updatevnoForm.sub_source_id.$invalid)}">
                                            <label for="">Sub Source <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.sub_source_id" name="sub_source_id" class="form-control" required>
                                                    <option value="0">Select Sub Source</option>
                                                    <option ng-repeat="enquirysubsource in enquirysubsources" value="{{enquirysubsource.id}}">{{enquirysubsource.sub_source}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1" ng-messages="updatevnoForm.sub_source_id.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.sub_source_id}} </span>
                                            </span>
                                        </div>
                                    </div>

                                </div>  
                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.source_disc.$dirty && updatevnoForm.source_disc.$invalid)}">
                                            <label for="">Enter Source Description</label>
                                            <textarea ng-model="registrationData.source_disc" name="source_disc" class="form-control" required>{{ registrationData.source_disc}}</textarea>
                                            <span class="input-icon icon-right">
                                                <div ng-show="step1" ng-messages="updatevnoForm.source_disc.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.source_disc}} </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.menu_status == '0'">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.employees1.$dirty && updatevnoForm.employees1.$invalid)}"  ng-controller="employeesCtrl">
                                            <label for="">Select Employees <span class="sp-err">*</span></label>	
                                            <ui-select multiple ng-model="registrationData.employees1" name="employees1" theme="select2" ui-select-required ng-disabled="disabled" style="width: 300px;" ng-required="registrationData.menu_status == '0'">
                                                <ui-select-match placeholder="Select Employees">{{$item.first_name}}</ui-select-match>
                                                <ui-select-choices repeat="list in employees1 | filter:$select.search">
                                                    {{list.first_name}} 
                                                </ui-select-choices>
                                            </ui-select>
                                            <div ng-show="step1" ng-messages="updatevnoForm.employees1.$error" class="help-block step1">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.employees1}} </span>
                                        </div>
                                    </div> 
                                </div>  
                                <div class="row">  

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="checkbox" style="margin-top: 0px !important;">
                                            <label>
                                                <input type="checkbox" ng-model="registrationData.missed_call_insert_enquiry" name="missed_call_insert_enquiry" class="form-control" value="{{ registrationData.missed_call_insert_enquiry}}" ng-change="enquirymissedcallStatus()">
                                                <span class="text">Insert Enquiry on missed call</span>
                                            </label>
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.menu_status == '1'">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.msc_default_employee_id.$dirty && updatevnoForm.msc_default_employee_id.$invalid)}" ng-controller="employeesCtrl">
                                            <label for="">Send SMS & Email information of missed call to (default Employee)  <span class="sp-err">*</span></label>
                                            <ui-select multiple ng-model="registrationData.msc_default_employee_id" name="msc_default_employee_id" theme="select2" ui-select-required ng-disabled="disabled" style="width: 300px;" required>
                                                <ui-select-match placeholder="Select Employees">{{$item.first_name}}</ui-select-match>
                                                <ui-select-choices repeat="list in employees1 | filter:$select.search">
                                                    {{list.first_name}} 
                                                </ui-select-choices>
                                            </ui-select>
                                            <div ng-show="step1" ng-messages="updatevnoForm.msc_default_employee_id.$error" class="help-block step1">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.msc_default_employee_id}} </span>
                                        </div>
                                    </div>  


                                </div> 

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12"> 
                                <h3 class="form-devider">Define Non Working Hours Call Settings</h3>   
                            </div>    
                        </div>  
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 bord-r8">
                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.nwh_status.$dirty && updatevnoForm.nwh_status.$invalid)}">
                                            <label for="">Non Working Hours Status <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.nwh_status" name="nwh_status" id="nwh_status" class="form-control">
                                                    <option value="">Please Select</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>                                    
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1" ng-messages="updatevnoForm.nwh_status.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.nwh_status}} </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div  class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.nwh_start_time.$dirty && updatevnoForm.nwh_start_time.$invalid)}">
                                            <label for="">Select Non Working Hours Starting From <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.nwh_start_time" name="nwh_start_time"  class="form-control" ng-required = "registrationData.nwh_status==1">
                                                    <option value="">Select Start Time</option>
                                                    <option value="17:00:00">5:00 PM</option>
                                                    <option value="17:30:00">5:30 PM</option>
                                                    <option value="18:00:00">6:00 PM</option>
                                                    <option value="18:30:00">6:30 PM</option> 
                                                    <option value="19:00:00">7:00 PM</option>
                                                    <option value="19:30:00">7:30 PM</option>
                                                    <option value="20:00:00">8:00 PM</option>
                                                    <option value="20:30:00">8:30 PM</option>
                                                    <option value="21:00:00">9:00 PM</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1" ng-messages="updatevnoForm.nwh_start_time.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.nwh_start_time}} </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <div  class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.nwh_end_time.$dirty && updatevnoForm.nwh_end_time.$invalid)}">
                                            <label for="">Select You Resume Working From Hours <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.nwh_end_time" name="nwh_end_time"  class="form-control" ng-required = "registrationData.nwh_status==1">
                                                    <option value="">Select Start Time</option>
                                                    <option value="7:00:00">7:00 AM</option>
                                                    <option value="7:30:00">7:30 AM</option>
                                                    <option value="8:00:00">8:00 AM</option>
                                                    <option value="8:30:00">8:30 AM</option> 
                                                    <option value="9:00:00">9:00 AM</option>
                                                    <option value="9:30:00">9:30 AM</option>
                                                    <option value="10:00:00">10:00 AM</option>
                                                    <option value="10:30:00">10:30 AM</option>
                                                    <option value="11:00:00">11:00 AM</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1" ng-messages="updatevnoForm.nwh_end_time.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.nwh_end_time}} </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.nwh_call_insert_enquiry.$dirty && updatevnoForm.nwh_call_insert_enquiry.$invalid)}">
                                            <label for="">Insert Enquiry (Non Working Hours) <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.nwh_call_insert_enquiry" name="nwh_call_insert_enquiry" id="nwh_call_insert_enquiry" class="form-control" ng-required = "registrationData.nwh_status==1">
                                                    <option value="">Please Select</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>                                    
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1" ng-messages="updatevnoForm.nwh_call_insert_enquiry.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.nwh_call_insert_enquiry}} </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.nwh_welcome_tune_type_id.$dirty && updatevnoForm.nwh_welcome_tune_type_id.$invalid)}">
                                            <label for="">Non-Working Tune Type <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.nwh_welcome_tune_type_id" name="nwh_welcome_tune_type_id" ng-init="cttunetype2()" class="form-control" ng-required = "registrationData.nwh_status==1">
                                                    <option value="">Select Tune Type</option>
                                                    <option ng-repeat="ct_tune_type2 in ct_tune_types2" value="{{ct_tune_type2.id}}">{{ct_tune_type2.type}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1" ng-messages="updatevnoForm.nwh_welcome_tune_type_id.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.nwh_welcome_tune_type_id}} </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.nwh_welcome_tune_type_id == '3'">
                                        <div class="form-group">
                                            <label for="">Upload Non-Working Tune as Mp3</label>
                                            <span class="input-icon icon-right">
                                                <audio controls>
                                                    <source type="audio/mpeg" ng-src="https://s3-ap-south-1.amazonaws.com/lms-auto/1/cloud_calling/caller_tune/hold_tune071056.mp3"">
                                                </audio>
                                                <input type="file"  id="nwh_welcome_tune" class="" name="nwh_welcome_tune" accept="mp3/*" ng-required = "registrationData.nwh_welcome_tune_type_id==3">
                                                <div ng-show="step1" ng-messages="updatevnoForm.nwh_welcome_tune.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.nwh_welcome_tune}} </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.nwh_welcome_tune_type_id == '2'">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.nwh_welcome_tune.$dirty && updatevnoForm.nwh_welcome_tune.$invalid)}">
                                            <label for="">Enter text to read as a non-working tune</label>
                                            <textarea ng-model="registrationData.nwh_welcome_tune" name="nwh_welcome_tune" class="form-control" ng-required ="registrationData.nwh_welcome_tune_type_id==2">{{ registrationData.nwh_welcome_tune}}</textarea>
                                            <span class="input-icon icon-right">
                                                <div ng-show="step1" ng-messages="updatevnoForm.nwh_welcome_tune.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.nwh_welcome_tune}} </span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>


                        <div class="row"><br>
                            <center><button type="submit" class="btn btn-primary" ng-click="step1 = true">Submit</button></center>
                        </div>

                    </div>
                    <!--  </div>-->
                </form>
            </div>

            <!---------------------------------------------------------------STEP 2 ---------------------------------------------------------------------------->


<!--            <div class="step-pane" id="wiredstep2">


                            <div class="widget-body">
                <div id="extensionmenu-form">


                    <div class="row" ng-controller="cloudtelephonyController" ng-init="manageextLists('', 'extmenulist')">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="widget">
                                <div class="widget-header ">
                                    <span class="widget-caption">Extension setting for virtual number [918928389389] for Company Website</span>

                                                    <div class="widget-buttons">
                                                        <a href="" widget-maximize></a>
                                                        <a href="" widget-collapse></a>
                                                        <a href="" widget-dispose disabled></a>
                                                    </div>
                                </div>
                                <div class="widget-body table-responsive">
                                    <table class="table table-hover table-striped table-bordered" at-config="config">
                                        <thead class="bord-bot">
                                            <tr>
                                                <th style="width:5%">Extension</th>
                                                <th style="width: 15%">Ext Name</th>
                                                <th style="width: 15%">Forwarding Type</th>
                                                <th style="width: 5%">Insert Enquiry</th>
                                                <th style="width: 15%">Assigned Employee</th>
                                                <th style="width: 5%">Status</th>
                                                <th style="width: 5%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr role="row" dir-paginate="listNumber in listNumbers | filter:search | itemsPerPage:itemsPerPage">
                                                <td>{{ listNumber.ext_number}}</td>
                                                <td>{{ listNumber.ext_name}}</td>
                                                <td>{{ listNumber.type}}</td>
                                                <td ng-if="listNumber.insert_enquiry == 1">Yes</td>
                                                <td ng-if="listNumber.insert_enquiry == 0">No</td>
                                                <td>{{ listNumber.name}}</td>
                                                <td ng-if="listNumber.menu_status == 1">Active</td>
                                                <td ng-if="listNumber.menu_status == 0">Inactive</td>
                                                <td class="fa-div">
                                                    <div class="fa-hover" tooltip-html-unsafe="Edit" style="display: block;"><a href="javascript:void(0)" ng-click="manageextLists({{listNumber.id}}, 'extedit')"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="DTTTFooter">
                                        <div class="col-sm-6">
                                            <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 to {{ itemsPerPage}} of {{ listNumbersLength}} entries</div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                                                <dir-pagination-controls class="pagination" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>    

                    <div class="row">

                        <form name="updateextForm" novalidate ng-submit="updateextForm.$valid && createExtNumber(extData1)" ng-init="manageextLists([[ !empty($id) ?  $id : '0' ]], 'edit')">
                            <input type="hidden" ng-model="updateextForm.csrfToken" name="csrftoken" id="csrftoken" ng-init="updateextForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                            <input type="hidden" name="menu_id" id="menu_id" ng-model="extData1.id" value="{{extData1.id}}">
                            <div class="col-md-6 col-sm-6 col-xs-12  bord-r8">
                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <div  class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.ext_number.$dirty && updateextForm.ext_number.$invalid)}">
                                            <label for="">Extension <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="extData1.ext_number" name="ext_number"  class="form-control" required>
                                                    <option value="">Select Extension No</option>
                                                    <option value="1">Ext 1</option>
                                                    <option value="2">Ext 2</option>
                                                    <option value="3">Ext 3</option>
                                                    <option value="4">Ext 4</option> 
                                                    <option value="5">Ext 5</option>
                                                    <option value="5">Ext 6</option>
                                                    <option value="5">Ext 7</option>
                                                    <option value="5">Ext 8</option>
                                                    <option value="5">Ext 9</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step2" ng-messages="updateextForm.ext_number.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.ext_number}} </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" ng-model="extData1.msc_facility_status" name="msc_facility_status" class="form-control" value="{{ extData1.msc_facility_status}}">
                                                    <span class="text">Enable Missed Call Setting(ONLY MISSED CALL) </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>  
                                <div class="row" ng-show="extData1.msc_facility_status == '1'"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.msc_welcome_tune_type_id.$dirty && updateextForm.msc_welcome_tune_type_id.$invalid)}">
                                            <label for="">Welcome Greeting <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="extData1.msc_welcome_tune_type_id" name="msc_welcome_tune_type_id" ng-init="cttunetype()" class="form-control" required>
                                                    <option value="">Select Welcome Tune Type</option>
                                                    <option ng-repeat="ct_tune_type in ct_tune_types" value="{{ct_tune_type.id}}">{{ct_tune_type.type}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step2" ng-messages="updateextForm.msc_welcome_tune_type_id.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.msc_welcome_tune_type_id}} </span>
                                            </span>
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="extData1.msc_welcome_tune_type_id == '3'"> 
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.msc_welcome_tune.$dirty && updateextForm.msc_welcome_tune.$invalid)}">
                                            <label for="">Upload Welcome Greeting Mp3</label>
                                            <span class="input-icon icon-right">
                                                <audio controls=""><source type="audio/mpeg"  id="audiourl" src="" /></audio>

                                                <input type="file"  id="waiting_tune" class="" name="msc_welcome_tune" accept="mp3/*" ng-required ="extData1.msc_welcome_tune_type_id==3">
                                                <div ng-show="step2" ng-messages="updateextForm.msc_welcome_tune.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.msc_welcome_tune}} </span>
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12"  ng-show="extData1.msc_welcome_tune_type_id == '2'">

                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.msc_welcome_tune.$dirty && updateextForm.msc_welcome_tune.$invalid)}">
                                            <label for="">Enter text to read as a welcome greeting</label>
                                            <textarea ng-model="extData1.msc_welcome_tune" name="msc_welcome_tune" class="form-control" ng-required ="extData1.msc_welcome_tune_type_id==2">{{ extData1.msc_welcome_tune}}</textarea>
                                            <span class="input-icon icon-right">
                                                <div ng-show="step2" ng-messages="updateextForm.msc_welcome_tune.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.msc_welcome_tune}} </span>
                                        </div>
                                    </div>

                                </div>  
                                <div class="row" ng-show="extData1.msc_facility_status != '1'"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" >
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.welcome_tune_type_id.$dirty && updateextForm.welcome_tune_type_id.$invalid)}">
                                            <label for="">Welcome Greeting <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="extData1.welcome_tune_type_id" name="welcome_tune_type_id" ng-init="cttunetype()" class="form-control" ng-change="menuStatus()" required>
                                                    <option value="">Select Welcome Tune Type</option>
                                                    <option ng-repeat="ct_tune_type in ct_tune_types" value="{{ct_tune_type.id}}">{{ct_tune_type.type}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step2" ng-messages="updateextForm.welcome_tune_type_id.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.welcome_tune_type_id}} </span>
                                            </span>
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="extData1.welcome_tune_type_id == '3'"> 
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.welcome_tune.$dirty && updateextForm.welcome_tune.$invalid)}">
                                            <label for="">Upload Welcome Greeting Mp3</label>
                                            <span class="input-icon icon-right">
                                                        <p>{{ url1 }}</p>

                                                <audio controls=""><source type="audio/mpeg"  id="audiourl" src="" /></audio>

                                                <input type="file"  id="waiting_tune" class="" name="welcome_tune" accept="mp3/*" ng-required ="extData1.welcome_tune_type_id==3">
                                                <div ng-show="step2" ng-messages="updateextForm.welcome_tune.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.welcome_tune}} </span>
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12"  ng-show="extData1.welcome_tune_type_id == '2'">

                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.welcome_tune.$dirty && updateextForm.welcome_tune.$invalid)}">
                                            <label for="">Enter text to read as a welcome greeting</label>
                                            <textarea ng-model="extData1.welcome_tune" name="welcome_tune" class="form-control" ng-required ="extData1.welcome_tune_type_id==2">{{ extData1.welcome_tune}}</textarea>
                                            <span class="input-icon icon-right">
                                                <div ng-show="step2" ng-messages="updateextForm.welcome_tune.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.welcome_tune}} </span>
                                        </div>
                                    </div>

                                </div> 
                                <div class="row" ng-show="extData1.msc_facility_status != '1'"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" >

                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.hold_tune_type_id.$dirty && updateextForm.hold_tune_type_id.$invalid)}">
                                            <label for="">Hold Tune <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="extData1.hold_tune_type_id" name="hold_tune_type_id" ng-init="cttunetype1()" class="form-control" required>
                                                    <option value="">Select Hold Tune Type</option>
                                                    <option ng-repeat="ct_tune_type1 in ct_tune_types1" value="{{ct_tune_type1.id}}">{{ct_tune_type1.type}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step2" ng-messages="updateextForm.hold_tune_type_id.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.hold_tune_type_id}} </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="(extData1.hold_tune_type_id == '3' && extData1.menu_status != '1')">
                                        <div class="form-group">
                                            <label for="">Upload Hold Tune Mp3</label>
                                            <span class="input-icon icon-right">
                                                <audio controls>
                                                    <source type="audio/mpeg" ng-src="https://s3-ap-south-1.amazonaws.com/lms-auto/1/cloud_calling/caller_tune/hold_tune071056.mp3"">
                                                </audio>
                                                <input type="file"  id="hold_tune" class="" name="hold_tune" accept="mp3/*" ng-required = "extData1.hold_tune_type_id==3">
                                                <div ng-show="step2" ng-messages="updateextForm.hold_tune.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.hold_tune}} </span>
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="(extData1.hold_tune_type_id == '2' && extData1.menu_status != '1')">
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.hold_tune.$dirty && updateextForm.hold_tune.$invalid)}">
                                            <label for="">Enter text to read as a hold tune</label>
                                            <textarea ng-model="extData1.hold_tune" name="hold_tune" class="form-control" ng-required ="extData1.hold_tune_type_id==2">{{ extData1.hold_tune}}</textarea>
                                            <span class="input-icon icon-right">
                                                <div ng-show="step2" ng-messages="updateextForm.hold_tune.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.hold_tune}} </span>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.forwarding_type_id.$dirty && updateextForm.forwarding_type_id.$invalid)}">
                                            <label for="">Forwarding Type <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="extData1.forwarding_type_id" name="forwarding_type_id" ng-init="ct_forwarding_types()" class="form-control" required>
                                                    <option value="0">Select Forwarding Type</option>
                                                    <option ng-repeat="ct_forwarding_type in ct_forwarding_types" value="{{ct_forwarding_type.id}}">{{ct_forwarding_type.type}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step2" ng-messages="updateextForm.forwarding_type_id.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.forwarding_type_id}} </span>
                                            </span>
                                        </div>

                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="extData1.forwarding_type_id > '1'">
                                        <div  class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.forwarding_time.$dirty && updateextForm.forwarding_time.$invalid)}">
                                            <label for="">Forwarding Time (Seconds) <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="extData1.forwarding_time" name="forwarding_time"  class="form-control" required>
                                                    <option value="0">Select Forwarding Time</option>
                                                    <option value="10">10 Seconds</option>
                                                    <option value="20">20 Seconds</option>
                                                    <option value="30">30 Seconds</option>
                                                    <option value="40">40 Seconds</option> 
                                                    <option value="50">50 Seconds</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step2" ng-messages="updateextForm.forwarding_time.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.forwarding_time}} </span>
                                            </span>
                                        </div>
                                    </div> 
                                </div>

                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.insert_enquiry.$dirty && updateextForm.insert_enquiry.$invalid)}">
                                            <label for="">Insert Enquiry <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="extData1.insert_enquiry" name="insert_enquiry" id="insert_enquiry" class="form-control" required>
                                                    <option value="">Please Select</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>                                    
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step2" ng-messages="updateextForm.insert_enquiry.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.insert_enquiry}} </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12 bord-r8">
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.model_project_id.$dirty && updateextForm.model_project_id.$invalid)}">
                                            <label for="">Vehicle Model <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-controller="vehiclemodelCtrl" ng-model="extData1.model_project_id" name="model_project_id" ng-init="vehiclemodels()" class="form-control" required>
                                                    <option value="">Select Vehicle Model</option>
                                                    <option ng-repeat="vehiclemodel in vehiclemodels" value="{{vehiclemodel.id}}">{{vehiclemodel.model_name}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step2" ng-messages="updateextForm.model_project_id.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.model_project_id}} </span>
                                            </span>
                                        </div>
                                    </div> 
                                </div>  


                                <div class="row" ng-controller="sourceCtrl" > 

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.source_id.$dirty && updateextForm.source_id.$invalid)}">
                                            <label for="">Source <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="extData1.source_id" name="source_id" ng-init="enquirysources()" ng-change="getsubsource(extData1.source_id)" class="form-control" required>
                                                    <option value="">Select Source</option>
                                                    <option ng-repeat="enquirysource in enquirysources" value="{{enquirysource.id}}">{{enquirysource.source_name}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step2" ng-messages="updateextForm.source_id.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.source_id}} </span>
                                            </span>
                                        </div>
                                    </div> 

                                    <div class="col-md-6 col-sm-6 col-xs-12 bord-r8">

                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.sub_source_id.$dirty && updateextForm.sub_source_id.$invalid)}">
                                            <label for="">Sub Source <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="extData1.sub_source_id" name="sub_source_id" class="form-control" required>
                                                    <option value="0">Select Sub Source</option>
                                                    <option ng-repeat="enquirysubsource in enquirysubsources" value="{{enquirysubsource.id}}">{{enquirysubsource.sub_source}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step2" ng-messages="updateextForm.sub_source_id.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.sub_source_id}} </span>
                                            </span>
                                        </div>
                                    </div>

                                </div>  
                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.source_disc.$dirty && updateextForm.source_disc.$invalid)}">
                                            <label for="">Enter Source Description</label>
                                            <textarea ng-model="extData1.source_disc" name="source_disc" class="form-control" required>{{ extData1.source_disc}}</textarea>
                                            <span class="input-icon icon-right">
                                                <div ng-show="step2" ng-messages="updateextForm.source_disc.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.source_disc}} </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.menu_status.$dirty && updateextForm.menu_status.$invalid)}">
                                            <label for="">Status <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="extData1.menu_status" name="menu_status" id="menu_status" class="form-control" required>
                                                    <option value="">Please Select</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>                                    
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step2" ng-messages="updateextForm.menu_status.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.menu_status}} </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>  
                                <div class="row">  
                                    <div class="col-md-6 col-sm-6 col-xs-12 bord-l8">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label>
                                                    <input name="msc_employee_type" ng-model="extData1.msc_employee_type" type="radio" value="0">
                                                    <span class="text"> To Round Robin Wise missed call forwarding to employees </span>
                                                </label>
                                                <label>
                                                    <input name="incoming_call_status" ng-model="extData1.msc_employee_type" type="radio" value="1">
                                                    <span class="text">To default employee </span>
                                                </label>
                                            </div>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.msc_employee_type}} </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="extData1.msc_employee_type == '0'">
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.employees1.$dirty && updateextForm.employees1.$invalid)}"  ng-controller="employeesCtrl">
                                            <label for="">Select Employees <span class="sp-err">*</span></label>	
                                            <ui-select multiple ng-model="extData1.employees1" name="employees1" theme="select2" ui-select-required ng-disabled="disabled" style="width: 300px;" ng-required="extData1.menu_status == '0'">
                                                <ui-select-match placeholder="Select Employees">{{$item.first_name}}</ui-select-match>
                                                <ui-select-choices repeat="list in employees1 | filter:$select.search">
                                                    {{list.first_name}} 
                                                </ui-select-choices>
                                            </ui-select>
                                            <div ng-show="step2" ng-messages="updateextForm.employees1.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.employees1}} </span>
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="extData1.msc_employee_type == '1'">
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.msc_default_employee_id.$dirty && updateextForm.msc_default_employee_id.$invalid)}" ng-controller="employeesCtrl">
                                            <label for="">Send SMS & Email information of missed call to (default Employee)  <span class="sp-err">*</span></label>
                                            <ui-select multiple ng-model="extData1.msc_default_employee_id" name="msc_default_employee_id" theme="select2" ui-select-required ng-disabled="disabled" style="width: 300px;" required>
                                                <ui-select-match placeholder="Select Employees">{{$item.first_name}}</ui-select-match>
                                                <ui-select-choices repeat="list in employees1 | filter:$select.search">
                                                    {{list.first_name}} 
                                                </ui-select-choices>
                                            </ui-select>
                                            <div ng-show="step2" ng-messages="updateextForm.msc_default_employee_id.$error" class="help-block step2">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.msc_default_employee_id}} </span>
                                        </div>
                                    </div>  


                                </div> 

                            </div>        

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <br>
                                <center>
                                    <button type="submit" class="btn btn-primary" ng-click="step2 = true">Submit</button>
                                </center>
                            </div>


                        </form>



                    </div>
                </div>
                                            </div>

            </div>-->
            <div class="step-pane" id="wiredstep3">This is step 3</div>
            <div class="step-pane" id="wiredstep4">This is step 4</div>
        </div>
        <div class="actions actions-footer" id="WiredWizard-actions">
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-sm btn-prev"> <i class="fa fa-angle-left"></i>Prev</button>
                <button type="button" class="btn btn-primary btn-sm btn-next" data-last="Finish">Next<i class="fa fa-angle-right"></i></button>
            </div>
        </div>
    </div>
</div>
</form>

<style>
    .checkbox{
        margin-top: 28px !important;
    }
</style>
