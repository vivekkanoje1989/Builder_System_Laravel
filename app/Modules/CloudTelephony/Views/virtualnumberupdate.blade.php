<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="cloudtelephonyController" ng-init="managevLists([[ !empty($id) ?  $id : '0' ]], 'edit')"> 
        <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{ pageHeading }} {{virtualno}}</h5>
         <div id="WiredWizard" class="wizard wizard-wired" data-target="#WiredWizardsteps">
            <ul class="steps">
                <li  class="wiredstep1 active"><span class="step">1</span><span class="title">New Customer Settings</span><span class="chevron"></span></li>
                <li  class="wiredstep2 {{cls}}" ng-click="extesionstep(registrationData.menu_status,[[ !empty($id) ?  $id : '0' ]])"><span class="step">2</span><span class="title">Extension Settings</span> <span class="chevron"></span></li>
                <li  class="wiredstep3 active" ng-click="existingcustomerstep([[ !empty($id) ?  $id : '0' ]])"><span class="step">3</span><span class="title">Existing Customer Settings</span> <span class="chevron"></span></li>
                <li  class="wiredstep4 active" ng-click="nonworkinghoursstep([[ !empty($id) ?  $id : '0' ]])"><span class="step">4</span><span class="title">Non Working Hours Settings</span> <span class="chevron"></span></li>
            </ul>
        </div>
        <div class="step-content" id="WiredWizardsteps">
            <div class="step-pane active" id="wiredstep1">
                <form name="updatevnoForm" novalidate ng-submit="updatevnoForm.$valid && updateVirtualNumber(registrationData,registrationData.welcome_tune_audio,registrationData.hold_tune_audio)" >
                    <input type="hidden" ng-model="updatevnoForm.csrfToken" name="csrftoken" id="csrftoken" ng-init="updatevnoForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <input type="hidden" name="id" id="id" ng-model="registrationData.id" ng-value="[[ $id ]]">
                    <div id="registration-form">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group" ng-class="">
                                            <label for="">Virtual Number <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="registrationData.virtual_display_number" name="virtual_display_number" class="form-control" oninput="if (/[^0-9]/g.test(this.value)) this.value = this.value.replace(/[^0-9 ]/g,'')" maxlength="12" disabled>
                                             </span>                                
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.welcome_tune_type_id != '1'">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" ng-model="registrationData.menu_status" name="menu_status" class="form-control" value="{{ registrationData.menu_status}}">
                                                    <span class="text">This number is having menu options</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>  

                                <div class="row"> 
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
                                                    <div ng-message="required" class="sp-err">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.welcome_tune_type_id}} </span>
                                            </span>
                                            <div class="checkbox" ng-show="registrationData.welcome_tune_type_id != '1'">
                                                <label>
                                                    <input type="checkbox" ng-model="registrationData.set_to_all_welcome_tone" name="set_to_all_welcome_tone" class="form-control" value="{{ registrationData.set_to_all_welcome_tone}}">
                                                    <span class="text">Set to all other numbers</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.welcome_tune_type_id == '3'"> 
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.welcome_tune_audio.$dirty && updatevnoForm.welcome_tune_audio.$invalid)}">
                                            <label for="">Upload Welcome Greeting Mp3</label>
                                            <span class="input-icon icon-right">
                                                <audio id="welcomeaudio" controls></audio>
                                                <input type="file" multiple ngf-select ng-model="registrationData.welcome_tune_audio" id="welcome_tune_audio" accept="audio/*" class="form-control" name="welcome_tune_audio">
                                                <div ng-show="step1" ng-messages="updatevnoForm.welcome_tune_audio.$error" class="help-block step1">
                                                    <div ng-message="required" class="sp-err">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.welcome_tune}} </span>                                           
                                        </div>
                                    </div> 
                                     <div class="col-md-6 col-sm-6 col-xs-12" ng-show="(registrationData.welcome_tune_type_id == '2')">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.welcome_tune.$dirty && updatevnoForm.welcome_tune.$invalid)}">
                                            <label for="">Enter text to read as a welcome greeting</label>
                                            <textarea ng-model="registrationData.welcome_tune" name="welcome_tune" class="form-control" ng-required ="registrationData.welcome_tune_type_id==2">{{ registrationData.welcome_tune}}</textarea>
                                            <span class="input-icon icon-right">
                                                <div ng-show="step1" ng-messages="updatevnoForm.welcome_tune.$error" class="help-block step1">
                                                    <div ng-message="required" class="sp-err">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.welcome_tune}} </span>
                                        </div>
                                    </div>

                                </div>  

                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.menu_status != '1'">

                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.hold_tune_type_id.$dirty && updatevnoForm.hold_tune_type_id.$invalid)}">
                                            <label for="">Hold Tune / Message <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.hold_tune_type_id" id="hold_tune_type_id" name="hold_tune_type_id" ng-init="cttunetype1()" class="form-control" required>
                                                    <option value="">Select Hold Tune Type</option>
                                                    <option ng-repeat="ct_tune_type1 in ct_tune_types1" value="{{ct_tune_type1.id}}">{{ct_tune_type1.type}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1" ng-messages="updatevnoForm.hold_tune_type_id.$error" class="help-block step1">
                                                    <div ng-message="required" class="sp-err">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.hold_tune_type_id}} </span>
                                            </span>
                                            <div class="checkbox" ng-show="registrationData.hold_tune_type_id != '1'">
                                                <label>
                                                    <input type="checkbox" ng-model="registrationData.set_to_all_hold_tone" name="set_to_all_hold_tone" class="form-control" value="{{ registrationData.set_to_all_hold_tone}}">
                                                    <span class="text">Set to all other numbers</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="(registrationData.hold_tune_type_id == '3' && registrationData.menu_status != '1')">
                                        <div class="form-group">
                                            <label for="">Upload Hold Tune Mp3</label>
                                            <span class="input-icon icon-right">
                                                <audio id="holdaudio" controls></audio>
                                                <input type="file" multiple ngf-select ng-model="registrationData.hold_tune_audio"  id="hold_tune_audio" class="form-control" name="hold_tune_audio" accept="audio/*">
                                                <div ng-show="step1" ng-messages="updatevnoForm.hold_tune_audio.$error" class="help-block step1">
                                                    <div ng-message="required" class="sp-err">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.hold_tune}} </span>
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="(registrationData.hold_tune_type_id == '2' && registrationData.menu_status != '1')">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.hold_tune.$dirty && updatevnoForm.hold_tune.$invalid)}">
                                            <label for="">Enter text to read as a hold message</label>
                                            <textarea ng-model="registrationData.hold_tune" name="hold_tune" class="form-control" ng-required ="registrationData.hold_tune_type_id==2">{{ registrationData.hold_tune}}</textarea>
                                            <span class="input-icon icon-right">
                                                <div ng-show="step1" ng-messages="updatevnoForm.hold_tune.$error" class="help-block step1">
                                                    <div ng-message="required" class="sp-err">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.hold_tune}} </span>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.menu_status != '1'">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.forwarding_type_id.$dirty && updatevnoForm.forwarding_type_id.$invalid)}">
                                            <label for="">Forwarding Type <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.forwarding_type_id" name="forwarding_type_id" ng-init="ct_forwarding_types()" class="form-control" ng-required = "registrationData.menu_status != '1'">
                                                    <option value="">Select Forwarding Type</option>
                                                    <option ng-repeat="ct_forwarding_type in ct_forwarding_types" value="{{ct_forwarding_type.id}}">{{ct_forwarding_type.type}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1" ng-messages="updatevnoForm.forwarding_type_id.$error" class="help-block step1">
                                                    <div ng-message="required" class="sp-err">This field is required.</div>
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
                                                    <div ng-message="required" class="sp-err">This field is required.</div>
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
                                                <select ng-model="registrationData.insert_enquiry" name="insert_enquiry" id="insert_enquiry" class="form-control" ng-disabled="registrationData.editing_status == '1'">
                                                    <option value="">Please Select</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>                                    
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1" ng-messages="updatevnoForm.insert_enquiry.$error" class="help-block step1">
                                                    <div ng-message="required" class="sp-err">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.insert_enquiry}} </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div ng-controller="blockTypeCtrl">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="">Project</label>
                                            <span class="input-icon icon-right">
                                                <select ng-controller="projectCtrl" ng-model="registrationData.project_id" name="project_id" id="project_id" class="form-control" ng-change="getBlockTypes(registrationData.project_id)">
                                                    <option value="">Select Project</option>
                                                    <option ng-repeat="plist in projectList" value="{{plist.id}}_{{plist.project_name}}">{{plist.project_name}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                        </div>
                                    </div> 
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">Blocks</label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.block_id" name="block_id" class="form-control">
                                                    <option value="">Select Block</option>
                                                    <option ng-repeat="list in blockTypeList" value="{{list.id}}">{{list.block_name}}</option>
                                                </select>  
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                        </div>
                                    </div> 
                                    </div> 
                                </div>
                                <div class="row" ng-controller="salesSourceCtrl">
                                    <div class="col-sm-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="">Select source</label>
                                            <span class="input-icon icon-right">
                                                <select class="form-control" ng-change="onsalesSoucesChange(registrationData.source_id)" ng-model="registrationData.source_id" name="sales_source_id" id="source_id" ng-disabled="registrationData.editing_status == '1'" required>
                                                    <option value="">Select Source</option>
                                                    <option ng-repeat="source in salessources" value="{{source.id}}" ng-selected="{{source.id == registrationData.source_id}}">{{source.sales_source_name}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1 && updatevnoForm.source_id.$invalid" ng-messages="updatevnoForm.source_id.$error" class="help-block">
                                                    <div ng-message="required" class="sp-err">This field is required</div>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="">Select subsource</label>
                                            <span class="input-icon icon-right">
                                                <select class="form-control" ng-model="registrationData.sub_source_id" name="sub_source_id" id="sales_subsource_id" ng-disabled="registrationData.editing_status == '1'">
                                                    <option value="">Select Subsource</option>
                                                    <option ng-repeat="subSource in subSourceList" value="{{subSource.id}}" ng-selected="{{subSource.id == registrationData.sub_source_id}}">{{subSource.enquiry_subsource}}</option>
                                                </select>   
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1 && updatevnoForm.sub_source_id.$invalid" ng-messages="updatevnoForm.sub_source_id.$error" class="help-block">
                                                    <div ng-message="required" class="sp-err">This field is required</div>
                                                </div>
                                            </span>                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="">Source Description</label>
                                            <textarea ng-model="registrationData.source_disc" name="source_disc" class="form-control" ng-disabled="registrationData.editing_status == '1'">{{ registrationData.source_disc}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.menu_status == '0'" ng-controller="getEmployeeCtrl">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.employees1.$dirty && updatevnoForm.employees1.$invalid)}">
                                            <label for="">Select Employees <span class="sp-err">*</span></label>	
                                            <span class="input-icon icon-right">
                                                <ui-select multiple ng-model="registrationData.employees1" name="employees1" theme="select2" ui-select-required ng-disabled="disabled" style="width: 100%;" ng-required="registrationData.menu_status == '0'">
                                                    <ui-select-match placeholder="Select Employees">{{$item.first_name}} {{$item.last_name}}&nbsp;( {{$item.designation_name.designation}} )</ui-select-match>
                                                    <ui-select-choices repeat="list in employees1 | filter:$select.search">
                                                        {{list.first_name}}  {{list.last_name}}&nbsp;( {{list.designation_name.designation}} )
                                                    </ui-select-choices>
                                                </ui-select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="emptyEmployees" class="help-block sp-err step1 {{ applyClassEmployee }}">
                                                    This field is required.
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.employees1}} </span>
                                            </span>
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
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.msc_default_employee_id.$dirty && updatevnoForm.msc_default_employee_id.$invalid)}" ng-controller="getEmployeeCtrl">
                                            <label for="">Send SMS & Email information of missed call to (default Employee)  <span class="sp-err">*</span></label>
                                            <ui-select multiple ng-model="registrationData.msc_default_employee_id" name="msc_default_employee_id" theme="select2" ui-select-required ng-disabled="disabled" style="width: 300px;" required>
                                                <ui-select-match placeholder="Select Employees">{{$item.first_name}} {{$item.last_name}}&nbsp;( {{$item.designation_name.designation}} )</ui-select-match>
                                                <ui-select-choices repeat="list1 in memployees | filter:$select.search">
                                                    {{list1.first_name}}  {{list1.last_name}}&nbsp; ( {{list1.designation_name.designation}} )
                                                </ui-select-choices>
                                            </ui-select>
                                            <div ng-show="step1" ng-messages="updatevnoForm.msc_default_employee_id.$error" class="help-block step1">
                                                <div ng-message="required" class="sp-err">This field is required.</div>
                                            </div>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.msc_default_employee_id}} </span>
                                        </div>
                                    </div>  


                                </div> 

                            </div>
                        </div>

                       
                        <div class="row"><br>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <center><button type="submit" class="btn btn-primary" ng-click="step1 = true">Save and Continue</button>
                                    <!--                                &nbsp;&nbsp;&nbsp;<a ng-if="registrationData.menu_status == '1'" class="btn btn-primary" href="#/[[config('global.getUrl')]]/extensionmenu/view/{{registrationData.id}}">Next</a>
                                <a ng-if="registrationData.menu_status != '1'" class="btn btn-primary" href="#/virtualnumber/existingupdate/{{ registrationData.id }}">Next</a>-->
                                </center>
                            </div>
                        </div>

                    </div>
                    <!--  </div>-->
                </form>
            </div>

        </div>
    </div>
</div>


<style>
    .checkbox{
        margin-top: 15px !important;
    }
    li span { cursor: pointer; cursor: hand; }
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
            document.getElementById('holdaudio').autoplay = false;

        });

        document.getElementById('welcome_tune_audio').addEventListener('change', function(event){

            //consolePrint('change on input#holffile triggered');
            var file = this.files[0],
             fileURL = blob.createObjectURL(file);
            console.log(file);
            document.getElementById('welcomeaudio').src = fileURL;
            document.getElementById('welcomeaudio').autoplay = false;

        });


       
    });
</script>
