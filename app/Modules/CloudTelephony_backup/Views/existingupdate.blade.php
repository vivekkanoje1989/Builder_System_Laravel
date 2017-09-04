<!--Registration Form for VN-->

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="cloudtelephonyController">
        <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{ pageHeading}}</h5>
        <div id="WiredWizard" class="wizard wizard-wired" data-target="#WiredWizardsteps" ui-jq="wizard">
            <ul class="steps">
                <li data-target="#wiredstep1" class="active"><span class="step">3</span><span class="title">Existing Customer Settings</span><span class="chevron"></span></li>
            </ul>
        </div>
        <div class="step-content" id="WiredWizardsteps">
            <div class="step-pane active" id="wiredstep1">
                <form name="updatevnoForm" novalidate ng-submit="updatevnoForm.$valid && updateExisting(registrationData, registrationData.welcome_tune_audio, registrationData.hold_tune_audio)" ng-init="managevLists([[ !empty($id) ?  $id : '0' ]], 'existingedit')">
                    <input type="hidden" ng-model="updatevnoForm.csrfToken" name="csrftoken" id="csrftoken" ng-init="updatevnoForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <input type="hidden" name="id" id="id" ng-model="registrationData.id" ng-value="[[ $id ]]">
                    <!--            <div class="widget-body">-->
                    <div id="registration-form">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.ec_call_status.$dirty && updatevnoForm.ec_call_status.$invalid)}">
                                            <label for="">Call coming on this number to be forwarded to the enquiry owner or as per the Menu <span class="sp-err">*</span></label>
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

                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.ec_call_status == '1'">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.read_cust_name.$dirty && updatevnoForm.read_cust_name.$invalid)}">
                                            <label for="">Read Customers name with welcome greeting <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.read_cust_name" name="read_cust_name" id="read_cust_name" class="form-control" ng-required="registrationData.ec_call_status=='1'">
                                                    <option value="">Please Select</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>                                    
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1" ng-messages="updatevnoForm.read_cust_name.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.read_cust_name}} </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.ec_call_status == '1'">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.read_emp_name.$dirty && updatevnoForm.read_emp_name.$invalid)}">
                                            <label for="">Read Employees name while transferring call <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.read_emp_name" name="read_emp_name" id="read_emp_name" class="form-control" ng-required="registrationData.ec_call_status=='1'">
                                                    <option value="">Please Select</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>                                    
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step1" ng-messages="updatevnoForm.read_emp_name.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.read_emp_name}} </span>
                                            </span>
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
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.ec_welcome_tune_type_id == '3'"> 
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.welcome_tune_audio.$dirty && updatevnoForm.welcome_tune_audio.$invalid)}">
                                            <label for="">Upload Welcome Greeting Mp3</label>
                                            <span class="input-icon icon-right">
                                                <audio id="ecwelcomeaudio" controls></audio>
                                                <input type="file" ngf-select ng-model="registrationData.welcome_tune_audio" id="welcome_tune_audio" class="form-control" name="welcome_tune_audio">
                                                <div ng-show="step1" ng-messages="updatevnoForm.welcome_tune_audio.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.ec_welcome_tune}} </span>                                           
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.ec_welcome_tune_type_id == '2'">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.ec_welcome_tune.$dirty && updatevnoForm.ec_welcome_tune.$invalid)}">
                                            <label for="">Enter text to read as a hold tune</label>
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
                                            <label for="">Hold Tune <span class="sp-err">*</span></label>
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
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="(registrationData.ec_hold_tune_type_id == '3' && registrationData.menu_status != '1')">
                                        <div class="form-group">
                                            <label for="">Upload Hold Tune Mp3</label>
                                            <span class="input-icon icon-right">
                                                <audio id="echoldaudio" controls></audio>
                                                <input type="file" ngf-select ng-model="registrationData.hold_tune_audio"  id="hold_tune_audio" class="form-control" name="hold_tune_audio" accept="mp3/*">
                                                <div ng-show="step1" ng-messages="updatevnoForm.hold_tune_audio.$error" class="help-block step1">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.ec_hold_tune}} </span>
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="(registrationData.ec_hold_tune_type_id == '2' && registrationData.menu_status != '1')">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.ec_hold_tune.$dirty && updatevnoForm.ec_hold_tune.$invalid)}">
                                            <label for="">Enter text to read as a hold tune</label>
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
                                <div class="row"> 
                                   <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.open_enquiry_owner_emp_action.$dirty && updatevnoForm.open_enquiry_owner_emp_action.$invalid)}">
                                            <label for="">Call connected to enquiry owner <span class="sp-err">*</span></label>
                                            <div class="checkbox">
                                                <label>
                                                    <input name="open_enquiry_owner_emp_action" ng-model="registrationData.open_enquiry_owner_emp_action" type="radio" value="0">
                                                    <span class="text">Update followup of existing enquiry. </span>
                                                </label>
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
                                            <label for="">Call connected to other employee then enquiry owner <span class="sp-err">*</span></label>
                                            <div class="checkbox">
                                                <label>
                                                    <input name="open_enquiry_other_emp_action" ng-model="registrationData.open_enquiry_other_emp_action" type="radio" value="0">
                                                    <span class="text">Update followup of the existing enquiry and keep the same in enquiry owners id. </span>
                                                </label>
                                                <label>
                                                    <input name="open_enquiry_other_emp_action" ng-model="registrationData.open_enquiry_other_emp_action" type="radio" value="1">
                                                    <span class="text">Update followup of existing enquiry & reassign the same to call connected employee. </span>
                                                </label>
                                                <label>
                                                    <input name="open_enquiry_other_emp_action" ng-model="registrationData.open_enquiry_other_emp_action" type="radio" value="2">
                                                    <span class="text">Open a new enquiry of call connected employee. </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <div class="row"> 
                                   <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.lost_enquiry_owner_emp_action.$dirty && updatevnoForm.lost_enquiry_owner_emp_action.$invalid)}">
                                            <label for="">Call connected to enquiry owner <span class="sp-err">*</span></label>
                                            <div class="checkbox">
                                                <label>
                                                    <input name="lost_enquiry_owner_emp_action" ng-model="registrationData.lost_enquiry_owner_emp_action" type="radio" value="0">
                                                    <span class="text">Open new enquiry. </span>
                                                </label>
                                                <label>
                                                    <input name="lost_enquiry_owner_emp_action" ng-model="registrationData.lost_enquiry_owner_emp_action" type="radio" value="1">
                                                    <span class="text">Update followup of existing enquiry and set that enquiry as open again. </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <div class="row"> 
                                   <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!updatevnoForm.lost_enquiry_other_emp_action.$dirty && updatevnoForm.lost_enquiry_other_emp_action.$invalid)}">
                                            <label for="">Call connected to other employee then enquiry owner <span class="sp-err">*</span></label>
                                            <div class="checkbox">
                                                <label>
                                                    <input name="lost_enquiry_other_emp_action" ng-model="registrationData.lost_enquiry_other_emp_action" type="radio" value="0">
                                                    <span class="text">Open a new enquiry of the call connected employee. </span>
                                                </label>
                                                <label>
                                                    <input name="lost_enquiry_other_emp_action" ng-model="registrationData.lost_enquiry_other_emp_action" type="radio" value="1">
                                                    <span class="text">Update followup of existing enquiry and set that enquiry as open again and keep the same in enquiry owners id. </span>
                                                </label>
                                                <label>
                                                    <input name="lost_enquiry_other_emp_action" ng-model="registrationData.lost_enquiry_other_emp_action" type="radio" value="2">
                                                    <span class="text">Update followup of existing enquiry and set that enquiry as open again & reassign the same to call connected employee. </span>
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
        margin-top: 28px !important;
    }
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
            document.getElementById('echoldaudio').autoplay = true;

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
            document.getElementById('ecwelcomeaudio').autoplay = true;

        });
    });
</script>
