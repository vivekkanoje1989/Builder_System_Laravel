<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="cloudtelephonyController" ng-init="managenonworkingLists([[ !empty($id) ?  $id : '0' ]], 'editnonworking')">
        <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{pageHeading}} {{virtualno}}</h5>
         <div id="WiredWizard" class="wizard wizard-wired" data-target="#WiredWizardsteps" >
             
           
            <ul class="steps" >
                <li  class="wiredstep4 active" ng-click="newcustomerstep([[ !empty($id) ?  $id : '0' ]])"><span class="step">1</span><span class="title">New Customer Settings</span><span class="chevron"></span></li>
                <li  class="wiredstep2 {{cls}}" ng-click="extesionstep(registrationData.menu_status,[[ !empty($id) ?  $id : '0' ]])"><span class="step">2</span><span class="title">Extension Settings</span> <span class="chevron"></span></li>
                <li  class="wiredstep3 active" ng-click="existingcustomerstep([[ !empty($id) ?  $id : '0' ]])"><span class="step">3</span><span class="title">Existing Customer Settings</span> <span class="chevron"></span></li>
                <li  class="wiredstep4 active"><span class="step">4</span><span class="title">Non Working Hours Settings</span> <span class="chevron"></span></li>
            </ul>
        </div>
        <div class="step-content" id="WiredWizardsteps">
            <div class="step-pane active" id="wiredstep4">
                <form name="updatevnoForm" novalidate ng-submit="updatevnoForm.$valid && updateNonWorkingSetting(registrationData,registrationData.nwh_welcome_tune_audio)" >
                    <input type="hidden" ng-model="updatevnoForm.csrfToken" name="csrftoken" id="csrftoken" ng-init="updatevnoForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <input type="hidden" name="id" id="id" ng-model="registrationData.id" ng-value="[[ $id ]]">
                    <!--            <div class="widget-body">-->
                    <div id="registration-form">
                     <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12"> 
                                <h3 class="form-devider">Define Non Working Hours Call Settings</h3>   
                            </div>    
                        </div>  
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 bord-r8">
                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step4 && (!updatevnoForm.nwh_status.$dirty && updatevnoForm.nwh_status.$invalid)}">
                                            <label for="">Apply Non Working Hours Settings <span class="sp-err">*</span></label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="radio" ng-model="registrationData.nwh_status" name="nwh_status" class="form-control" value="1">
                                                    <span class="text">Yes</span>
                                                </label>
                                            
                                                <label>
                                                    <input type="radio" ng-model="registrationData.nwh_status" name="nwh_status" class="form-control" value="0">
                                                    <span class="text">No</span>
                                                </label>
                                                </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div  class="form-group" ng-class="{ 'has-error' : step4 && (!updatevnoForm.nwh_start_time.$dirty && updatevnoForm.nwh_start_time.$invalid)}">
                                            <label for="">Select Non Working Hours Starts From <span class="sp-err">*</span></label>
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
                                                <div ng-show="step4" ng-messages="updatevnoForm.nwh_start_time.$error" class="help-block step4">
                                                    <div ng-message="required" class="sp-err">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.nwh_start_time}} </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step4 && (!updatevnoForm.nwh_welcome_tune_type_id.$dirty && updatevnoForm.nwh_welcome_tune_type_id.$invalid)}">
                                            <label for="">Non-Working Tune Type <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.nwh_welcome_tune_type_id" id="nwh_welcome_tune_type_id" name="nwh_welcome_tune_type_id" ng-init="cttunetype2()" class="form-control" ng-required = "registrationData.nwh_status==1">
                                                    <option value="">Select Tune Type</option>
                                                    <option ng-repeat="ct_tune_type2 in ct_tune_types2" value="{{ct_tune_type2.id}}">{{ct_tune_type2.type}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step4" ng-messages="updatevnoForm.nwh_welcome_tune_type_id.$error" class="help-block step4">
                                                    <div ng-message="required" class="sp-err">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.nwh_welcome_tune_type_id}} </span>
                                            </span>
                                             <div class="checkbox" ng-show="registrationData.nwh_welcome_tune_type_id != '1'">
                                                <label>
                                                    <input type="checkbox" ng-model="registrationData.set_to_all_nwh_welcome_tone" name="set_to_all_nwh_welcome_tone" class="form-control" value="{{ registrationData.set_to_all_nwh_welcome_tone}}">
                                                    <span class="text">Set to all other numbers</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.nwh_welcome_tune_type_id == '3'">
                                        <div class="form-group">
                                            <label for="">Upload Non-Working Tune as Mp3</label>
                                            <span class="input-icon icon-right">
                                                <audio id="nwhaudio" controls></audio>
                                                <input type="file"  multiple ngf-select ng-model="registrationData.nwh_welcome_tune_audio"  id="nwh_welcome_tune_audio" class="form-control" name="nwh_welcome_tune_audio" accept="audio/*">
                                                <div ng-show="step4" ng-messages="updatevnoForm.nwh_welcome_tune_audio.$error" class="help-block step4">
                                                    <div ng-message="required" class="sp-err">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.nwh_welcome_tune}} </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="registrationData.nwh_welcome_tune_type_id == '2'">
                                        <div class="form-group" ng-class="{ 'has-error' : step4 && (!updatevnoForm.nwh_welcome_tune.$dirty && updatevnoForm.nwh_welcome_tune.$invalid)}">
                                            <label for="">Enter text to read as a non-working hours greeting</label>
                                            <textarea ng-model="registrationData.nwh_welcome_tune" name="nwh_welcome_tune" class="form-control" ng-required ="registrationData.nwh_welcome_tune_type_id==2">{{ registrationData.nwh_welcome_tune}}</textarea>
                                            <span class="input-icon icon-right">
                                                <div ng-show="step4" ng-messages="updatevnoForm.nwh_welcome_tune.$error" class="help-block step4">
                                                    <div ng-message="required" class="sp-err">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.nwh_welcome_tune}} </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                             <div class="col-md-6 col-sm-6 col-xs-12 bord-r8">
                                <div class="row">
                                     <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div  class="form-group" ng-class="{ 'has-error' : step4 && (!updatevnoForm.nwh_end_time.$dirty && updatevnoForm.nwh_end_time.$invalid)}">
                                            <label for="">Select Non Working Hours Ends On {{registrationData.nwh_end_time}}<span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.nwh_end_time" name="nwh_end_time"  class="form-control" ng-required = "registrationData.nwh_status==1">
                                                    <option value="">Select Start Time</option>
                                                    <option value="07:00:00">7:00 AM</option>
                                                    <option value="07:30:00">7:30 AM</option>
                                                    <option value="08:00:00">8:00 AM</option>
                                                    <option value="08:30:00">8:30 AM</option> 
                                                    <option value="09:00:00">9:00 AM</option>
                                                    <option value="09:30:00">9:30 AM</option>
                                                    <option value="10:00:00">10:00 AM</option>
                                                    <option value="10:30:00">10:30 AM</option>
                                                    <option value="11:00:00">11:00 AM</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step4" ng-messages="updatevnoForm.nwh_end_time.$error" class="help-block step4">
                                                    <div ng-message="required" class="sp-err">This field is required.</div>
                        </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.nwh_end_time}} </span>
                                            </span>
                                        </div>
                                     </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step4 && (!updatevnoForm.nwh_call_insert_enquiry.$dirty && updatevnoForm.nwh_call_insert_enquiry.$invalid)}">
                                            <label for="">Insert Enquiry In Non Working Hours <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="registrationData.nwh_call_insert_enquiry" name="nwh_call_insert_enquiry" id="nwh_call_insert_enquiry" class="form-control" ng-required = "registrationData.nwh_status==1">
                                                    <option value="">Please Select</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>                                    
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step4" ng-messages="updatevnoForm.nwh_call_insert_enquiry.$error" class="help-block step4">
                                                    <div ng-message="required" class="sp-err">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.nwh_call_insert_enquiry}} </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </div>

                        <div class="row"><br>
                            <center><button type="submit" class="btn btn-primary" ng-click="step4 = true">Submit</button></center>
                        </div>
                        </div>
                    
                    <!--  </div>-->
                </form>
            </div>

        </div>
    </div>
</div>
<style>
li span { cursor: pointer; cursor: hand; }
</style>

<script>
     $(document).ready(function(){
          $("#nwh_welcome_tune_type_id").change(function(){
            $("#nwh_welcome_tune_audio").attr("ng-required","registrationData.nwh_welcome_tune_type_id==3");
        }); 
        var blob = window.URL || window.webkitURL;
        if (!blob) {
            console.log('Your browser does not support Blob URLs :(');
            return;           
        }
        
     document.getElementById('nwh_welcome_tune_audio').addEventListener('change', function(event){

            //consolePrint('change on input#holffile triggered');
            var file = this.files[0],
             fileURL = blob.createObjectURL(file);
            console.log(file);
            document.getElementById('nwhaudio').src = fileURL;
            document.getElementById('nwhaudio').autoplay = false;

        });
    });

</script>
