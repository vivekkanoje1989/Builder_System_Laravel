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
            </ul>
        </div>
        <div class="step-content" id="WiredWizardsteps">
            <div class="step-pane active" id="wiredstep1">
                <form name="updatevnoForm" novalidate ng-submit="updatevnoForm.$valid && updateVirtualNumber(registrationData,registrationData.welcome_tune_audio,registrationData.hold_tune_audio)" ng-init="managevLists([[ !empty($id) ?  $id : '0' ]], 'edit')">
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
                                                <select ng-model="registrationData.welcome_tune_type_id" id="welcome_tune_type_id" name="welcome_tune_type_id" ng-init="cttunetype()" class="form-control" ng-change="menuStatus()" required>
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
                                                <audio id="welcomeaudio" controls></audio>
                                                <input type="file" multiple ngf-select ng-model="registrationData.welcome_tune_audio" id="welcome_tune_audio" class="form-control" name="welcome_tune_audio">
                                                <div ng-show="step1" ng-messages="updatevnoForm.welcome_tune_audio.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.welcome_tune}} </span>                                           
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
                                                <select ng-model="registrationData.hold_tune_type_id" id="hold_tune_type_id" name="hold_tune_type_id" ng-init="cttunetype1()" class="form-control" required>
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
                                                <audio id="holdaudio" controls></audio>
                                                <input type="file" multiple ngf-select ng-model="registrationData.hold_tune_audio"  id="hold_tune_audio" class="form-control" name="hold_tune_audio" accept="mp3/*">
                                                <div ng-show="step1" ng-messages="updatevnoForm.hold_tune_audio.$error" class="help-block step1">
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
                                                <select ng-model="registrationData.nwh_welcome_tune_type_id" id="nwh_welcome_tune_type_id" name="nwh_welcome_tune_type_id" ng-init="cttunetype2()" class="form-control" ng-required = "registrationData.nwh_status==1">
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
                                                <audio id="nwhaudio" controls></audio>
                                                <input type="file"  multiple ngf-select ng-model="registrationData.nwh_welcome_tune_audio"  id="nwh_welcome_tune_audio" class="form-control" name="nwh_welcome_tune_audio" accept="mp3/*">
                                                <div ng-show="step1" ng-messages="updatevnoForm.nwh_welcome_tune_audio.$error" class="help-block step1">
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
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <center><button type="submit" class="btn btn-primary" ng-click="step1 = true">Save and Continue</button>
                                </center>
                            </div>
                        </div>
                    </div>
                </form>
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

<script type="text/javascript">
    $(document).ready(function(){   
        /*** Add attribute ***/
        $("#welcome_tune_type_id").change(function(){
            $("#welcome_tune_audio").attr("ng-required","registrationData.welcome_tune_type_id==3");
        });  
        
         $("#hold_tune_type_id").change(function(){
            $("#hold_tune_audio").attr("ng-required","registrationData.hold_tune_type_id==3");
        }); 
         $("#nwh_welcome_tune_type_id").change(function(){
            $("#nwh_welcome_tune_audio").attr("ng-required","registrationData.nwh_welcome_tune_type_id==3");
        }); 
        
        var blob = window.URL || window.webkitURL;
        if (!blob) {
            console.log('Your browser does not support Blob URLs :(');
            return;           
        }

        document.getElementById('hold_tune_audio').addEventListener('change', function(event){

            //consolePrint('change on input#holffile triggered');
            var file = this.files[0],
            fileURL = blob.createObjectURL(file);
            console.log(file);
            document.getElementById('holdaudio').src = fileURL;
            document.getElementById('holdaudio').autoplay = true;

        });

        document.getElementById('welcome_tune_audio').addEventListener('change', function(event){

            //consolePrint('change on input#holffile triggered');
            var file = this.files[0],
             fileURL = blob.createObjectURL(file);
            console.log(file);
            document.getElementById('welcomeaudio').src = fileURL;
            document.getElementById('welcomeaudio').autoplay = true;

        });


        document.getElementById('nwh_welcome_tune_audio').addEventListener('change', function(event){

            //consolePrint('change on input#holffile triggered');
            var file = this.files[0],
             fileURL = blob.createObjectURL(file);
            console.log(file);
            document.getElementById('nwhaudio').src = fileURL;
            document.getElementById('nwhaudio').autoplay = true;

        });

    });
</script>
