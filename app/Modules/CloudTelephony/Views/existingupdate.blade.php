<!--Registration Form for VN-->

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="cloudtelephonyController" ng-init="managevLists([[ !empty($id) ?  $id : '0' ]], 'existingedit')">
        <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{ pageHeading}} {{virtualno}}</h5>
        <div id="WiredWizard" class="wizard wizard-wired" data-target="#WiredWizardsteps" ui-jq="wizard">
            <ul class="steps">
                <li  class="wiredstep1 active" ng-click="newcustomerstep([[ !empty($id) ?  $id : '0' ]])"><span class="step">1</span><span class="title">New Customer Settings</span><span class="chevron"></span></li>
                 <li  class="wiredstep2 {{cls}}" ng-click="extesionstep(registrationData.menu_status,[[ !empty($id) ?  $id : '0' ]])"><span class="step">2</span><span class="title">Extension Settings</span> <span class="chevron"></span></li>
                <li  class="wiredstep3 active" ng-click="existingcustomerstep([[ !empty($id) ?  $id : '0' ]])" ><span class="step">3</span><span class="title">Existing Customer Settings</span> <span class="chevron"></span></li>
                <li  class="wiredstep4 active" ng-click="nonworkinghoursstep([[ !empty($id) ?  $id : '0' ]])"><span class="step">4</span><span class="title">Non Working Hours Settings</span> <span class="chevron"></span></li>
            </ul>
        </div>
        <div class="step-content" id="WiredWizardsteps">
            <div class="step-pane active" id="wiredstep1">
                <form name="updatevnoForm" novalidate ng-submit="updatevnoForm.$valid && updateExisting(registrationData, registrationData.welcome_tune_audio, registrationData.hold_tune_audio)" >
                    <input type="hidden" ng-model="updatevnoForm.csrfToken" name="csrftoken" id="csrftoken" ng-init="updatevnoForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <input type="hidden" name="id" id="id" ng-model="registrationData.id" ng-value="[[ $id ]]">
                    <!--            <div class="widget-body">-->
                    <div id="registration-form">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.ec_call_status.$dirty && updatevnoForm.ec_call_status.$invalid)}">
                                            <label for="">Define Call Forwarding Settings<span class="sp-err">*</span></label>
                                            <div class="checkbox">
                                                <label>
                                                    <input name="ec_call_status" ng-model="registrationData.ec_call_status" type="radio" value="1">
                                                    <span class="text">Forward to enquiry owner </span>
                                                </label>
                                                <label>
                                                    <input name="ec_call_status" ng-model="registrationData.ec_call_status" type="radio" value="0">
                                                    <span class="text">Forward as per menu </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>


                                    
                                </div>  
                                <div class="row" ng-show="registrationData.ec_call_status == '1'"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.ec_call_statu = '1'">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.ec_welcome_tune_type_id.$dirty && updatevnoForm.ec_welcome_tune_type_id.$invalid)}">
                                            <label for="">Welcome Greeting <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.ec_welcome_tune_type_id" id="ec_welcome_tune_type_id" name="ec_welcome_tune_type_id" ng-init="cttunetype()" class="form-control" ng-required="registrationData.ec_call_status=='1'">
                                                    <option value="">Select Welcome Tune Type</option>
                                                    <option ng-repeat="ct_tune_type in ct_tune_types" ng-selected="ct_tune_type.id==registrationData.ec_welcome_tune_type_id" value="{{ct_tune_type.id}}">{{ct_tune_type.type}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1" ng-messages="updatevnoForm.ec_welcome_tune_type_id.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.ec_welcome_tune_type_id}} </span>
                                            </span>
                                            <div class="checkbox" ng-show="registrationData.ec_welcome_tune_type_id != '1'">
                                                <label>
                                                    <input type="checkbox" ng-model="registrationData.set_to_all_welcome_tone" name="set_to_all_welcome_tone" class="form-control" value="{{ registrationData.set_to_all_welcome_tone}}">
                                                    <span class="text">Set to all other numbers</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.ec_welcome_tune_type_id == '3'"> 
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.welcome_tune_audio.$dirty && updatevnoForm.welcome_tune_audio.$invalid)}">
                                            <label for="">Upload Welcome Greeting Mp3</label>
                                            <span class="input-icon icon-right">
                                                <audio id="ecwelcomeaudio" controls></audio>
                                                <input type="file" multiple ngf-select ng-model="registrationData.welcome_tune_audio" accept="audio/*" id="welcome_tune_audio" class="form-control" name="welcome_tune_audio">
                                                <div ng-show="step1" ng-messages="updatevnoForm.welcome_tune_audio.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.ec_welcome_tune}} </span>                                           
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.ec_welcome_tune_type_id == '2'">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.ec_welcome_tune.$dirty && updatevnoForm.ec_welcome_tune.$invalid)}">
                                            <label for="">Enter text to read as a welcome greeting</label>
                                            <textarea ng-model="registrationData.ec_welcome_tune" name="ec_welcome_tune" class="form-control" ng-required ="registrationData.ec_welcome_tune_type_id==2">{{ registrationData.ec_welcome_tune}}</textarea>
                                            <span class="input-icon icon-right">
                                                <div ng-show="step1" ng-messages="updatevnoForm.ec_welcome_tune.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.ec_welcome_tune}} </span>
                                        </div>
                                    </div>
                                </div>  
                                <div class="row" ng-show="registrationData.ec_call_status == '1'"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.ec_hold_tune_type_id.$dirty && updatevnoForm.ec_hold_tune_type_id.$invalid)}">
                                            <label for="">Hold Tune / Message <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.ec_hold_tune_type_id" id="ec_hold_tune_type_id" name="ec_hold_tune_type_id" ng-init="cttunetype1()" class="form-control" required>
                                                    <option value="">Select Hold Tune Type</option>
                                                    <option ng-repeat="ct_tune_type1 in ct_tune_types1" ng-selected="ct_tune_type1.id==registrationData.ec_hold_tune_type_id" value="{{ct_tune_type1.id}}">{{ct_tune_type1.type}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1" ng-messages="updatevnoForm.ec_hold_tune_type_id.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.ec_hold_tune_type_id}} </span>
                                            </span>
                                            <div class="checkbox" ng-show="registrationData.ec_hold_tune_type_id != '1'">
                                                <label>
                                                    <input type="checkbox" ng-model="registrationData.set_to_all_hold_tone" name="set_to_all_hold_tone" class="form-control" value="{{ registrationData.set_to_all_hold_tone}}">
                                                    <span class="text">Set to all other numbers</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="(registrationData.ec_hold_tune_type_id == '3' )">
                                        <div class="form-group">
                                            <label for="">Upload Hold Tune Mp3</label>
                                            <span class="input-icon icon-right">
                                                <audio id="echoldaudio" controls></audio>
                                                <input type="file" multiple ngf-select ng-model="registrationData.hold_tune_audio" accept="audio/*" id="hold_tune_audio" class="form-control" name="hold_tune_audio" accept="mp3/*">
                                                <div ng-show="step1" ng-messages="updatevnoForm.hold_tune_audio.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.ec_hold_tune}} </span>
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="(registrationData.ec_hold_tune_type_id == '2' )">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.ec_hold_tune.$dirty && updatevnoForm.ec_hold_tune.$invalid)}">
                                            <label for="">Enter text to read as a hold message</label>
                                            <textarea ng-model="registrationData.ec_hold_tune" name="ec_hold_tune" class="form-control" ng-required ="registrationData.ec_hold_tune_type_id==2">{{ registrationData.ec_hold_tune}}</textarea>
                                            <span class="input-icon icon-right">
                                                <div ng-show="step1" ng-messages="updatevnoForm.ec_hold_tune.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.ec_hold_tune}} </span>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.alert_to_enq_owner.$dirty && updatevnoForm.alert_to_enq_owner.$invalid)}">
                                            <label for="">If Caller is existing customer then send SMS & Email to enquiry owner or default employee <span class="sp-err">*</span></label>
                                            <div class="checkbox">
                                                <label>
                                                    <input name="alert_to_enq_owner" ng-model="registrationData.alert_to_enq_owner" type="radio" value="1">
                                                    <span class="text">To enquiry owner </span>
                                                </label>
                                                <label>
                                                    <input name="alert_to_enq_owner" ng-model="registrationData.alert_to_enq_owner" type="radio" checked="true" value="0">
                                                    <span class="text">To default employee </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>  

                            </div>
                            
                            
                            <div class="col-md-6 col-sm-6 col-xs-12 bord-l8">
                                <label  style="padding: 5px;float: left;width: 100%;opacity: 0.85;" for=""><b style="margin-left: -7px;font-size: 15px;">(1)&nbsp;<u>In case of Open enquiry</u></b></label><br>
                                <div class="row"> 
                                   <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.open_enquiry_owner_emp_action.$dirty && updatevnoForm.open_enquiry_owner_emp_action.$invalid)}">
                                            (A)&nbsp;&nbsp;<label for="">Call connected to enquiry owner <span class="sp-err">*</span>&nbsp;(If calls are forwarded to enquiry owner)</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input name="open_enquiry_owner_emp_action" ng-model="registrationData.open_enquiry_owner_emp_action" type="radio" value="0">
                                                    <span class="text">Update followup of existing enquiry. </span>
                                                </label>
                                                <label class="text" style="color:green">
                                                    (Recommended)&nbsp;</label><br>
                                                
                                               <label>
                                                    <input name="open_enquiry_owner_emp_action" ng-model="registrationData.open_enquiry_owner_emp_action" type="radio" value="1">
                                                    <span class="text">Open new enquiry. </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                
                                <div class="row"> 
                                   <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.open_enquiry_other_emp_action.$dirty && updatevnoForm.open_enquiry_other_emp_action.$invalid)}">
                                           (B)&nbsp;&nbsp; <label for="">Call connected to other employee then enquiry owner <span class="sp-err">*</span>&nbsp;(If calls are forwarded as per menu)</label>
                                            <div class="checkbox">
                                                 <label>
                                                    <input name="open_enquiry_other_emp_action" ng-model="registrationData.open_enquiry_other_emp_action" type="radio" value="1">
                                                    <span class="text">Update followup of existing enquiry & reassign the same to call connected employee. </span>
                                                </label><label class="text" style="color:green">
                                                    &nbsp;(Recommended)&nbsp;</label>
                                                <label>
                                                    <input name="open_enquiry_other_emp_action" ng-model="registrationData.open_enquiry_other_emp_action" type="radio" value="0">
                                                    <span class="text">Update followup of the existing enquiry & keep the same in enquiry owners id. </span>
                                                </label>
                                               <label>
                                                    <input name="open_enquiry_other_emp_action" ng-model="registrationData.open_enquiry_other_emp_action" type="radio" value="2">
                                                    <span class="text">Open a new enquiry of call connected employee. </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <label style="padding: 5px;float: left;width: 100%;opacity: 0.85;" for=""><b style="margin-left: -7px;font-size: 15px;">(2)&nbsp;<u>In case of Lost enquiry</u></b> </label><br>
                                <div class="row"> 
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.lost_enquiry_owner_emp_action.$dirty && updatevnoForm.lost_enquiry_owner_emp_action.$invalid)}">
                                            (A)&nbsp;&nbsp;<label for="">Call connected to enquiry owner <span class="sp-err">*</span></label>
                                            <div class="checkbox">
                                                <label>
                                                    <input name="lost_enquiry_owner_emp_action" ng-model="registrationData.lost_enquiry_owner_emp_action" type="radio" value="0">
                                                    <span class="text">Open new enquiry. </span>
                                                </label><label class="text" style="color:green">
                                                    &nbsp;(Recommended)&nbsp;</label><br>
                                                <label>
                                                    <input name="lost_enquiry_owner_emp_action" ng-model="registrationData.lost_enquiry_owner_emp_action" type="radio" value="1">
                                                    <span class="text">Update followup of existing enquiry and set that enquiry to open again. </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <div class="row"> 
                                   <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.lost_enquiry_other_emp_action.$dirty && updatevnoForm.lost_enquiry_other_emp_action.$invalid)}">
                                           (B)&nbsp;&nbsp; <label for="">Call connected to other employee then enquiry owner <span class="sp-err">*</span></label>
                                            <div class="checkbox">
                                                <label>
                                                    <input name="lost_enquiry_other_emp_action" ng-model="registrationData.lost_enquiry_other_emp_action" type="radio" value="0">
                                                    <span class="text">Open a new enquiry in the call connected employees id. </span>
                                                </label><label class="text" style="color:green">
                                                    &nbsp;(Recommended)&nbsp;</label>
                                               <label>
                                                    <input name="lost_enquiry_other_emp_action" ng-model="registrationData.lost_enquiry_other_emp_action" type="radio" value="2">
                                                    <span class="text">Update followup of existing enquiry and set that enquiry as open again & reassign the same to call connected employee. </span>
                                                </label>
                                                 <label>
                                                    <input name="lost_enquiry_other_emp_action" ng-model="registrationData.lost_enquiry_other_emp_action" type="radio" value="1">
                                                    <span class="text">Update followup of existing enquiry and set that enquiry as open again & keep the same in enquiry owners id. </span>
                                                </label>
                                            </div>
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

        </div>
    </div>
</div>
</form>

<style>
    .checkbox{
        margin-top: 15px !important;
    }
     li span { cursor: pointer; cursor: hand; }
</style>


<script type="text/javascript">
    $(document).ready(function(){   
        /*** Add attribute ***/
       
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
            console.log('File name: '+file.name);
            console.log('File type: '+file.type);
            console.log('File BlobURL: '+ fileURL);
            document.getElementById('echoldaudio').src = fileURL;
            document.getElementById('echoldaudio').autoplay = false;

        });

        document.getElementById('welcome_tune_audio').addEventListener('change', function(event){

            //consolePrint('change on input#holffile triggered');
            var file = this.files[0],
             fileURL = blob.createObjectURL(file);
            console.log(file);
            console.log('File name: '+file.name);
            console.log('File type: '+file.type);
            console.log('File BlobURL: '+ fileURL);
            document.getElementById('ecwelcomeaudio').src = fileURL;
            document.getElementById('ecwelcomeaudio').autoplay = false;

        });
    });
</script>
