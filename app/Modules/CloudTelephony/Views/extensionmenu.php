<!--Registration Form for VN-->
<?php

use Illuminate\Support\Facades\Route;
?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="cloudtelephonyController">
        <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{ pageHeading}}</h5>
        <div id="WiredWizard" class="wizard wizard-wired" data-target="#WiredWizardsteps" ui-jq="wizard">
            <ul class="steps">
                <li data-target="#wiredstep1" class="active"><span class="step">2</span><span class="title">Extension Settings</span><span class="chevron"></span></li>
            </ul>
        </div>
        <div class="step-pane" id="wiredstep1">


            <div class="widget-body">
                <div id="extensionmenu-form">

                    <div class="row" ng-init="manageextLists(<?php echo $id; ?>, 'view')">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="widget">
                                <div class="widget-header ">
                                    <span class="widget-caption">Extension setting for virtual number {{ virtualno[0]['virtual_number'] }} for Company Website</span>

                                    <div class="widget-buttons">
<!--                                        <a href="" widget-maximize></a>
                                        <a href="" widget-collapse></a>
                                        <a href="" widget-dispose disabled></a>-->
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
                                                    <div class="fa-hover" tooltip-html-unsafe="Edit" style="display: block;"><a href="" ng-click="manageextUpdate({{ listNumber.id}},'edit')"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;</div>
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
                        

                        <form name="updateextForm" novalidate ng-submit="updateextForm.$valid && createExtNumber(extData1,extData1.msc_welcome_tune_audio,extData1.welcome_tune_audio,virtualno[0]['id'])">
                            <input type="hidden" name="id" id="id" ng-model="extData1.id" ng-init="extData1.id='0'" value="{{extData1.id}}">
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
                                                    <input type="checkbox" ng-model="extData1.msc_facility_status" ng-init="extData1.msc_facility_status = 0" id="msc_facility_status" name="msc_facility_status" class="form-control" value="0">
                                                    <span class="text">Enable Missed Call Setting(ONLY MISSED CALL) </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>  
                                <div class="row" ng-show="extData1.msc_facility_status==1"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.msc_welcome_tune_type_id.$dirty && updateextForm.msc_welcome_tune_type_id.$invalid)}">
                                            <label for="">Missed Call Welcome Greeting <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="extData1.msc_welcome_tune_type_id" name="msc_welcome_tune_type_id"id="msc_welcome_tune_type_id" ng-init="cttunetype()" class="form-control" ng-required="extData1.msc_facility_status==1">
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

                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="extData1.msc_welcome_tune_type_id==3"> 
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.msc_welcome_tune_audio.$dirty && updateextForm.msc_welcome_tune_audio.$invalid)}">
                                            <label for="">Upload Missed Call Welcome Greeting Mp3</label>
                                            <span class="input-icon icon-right">
                                                <audio controls=""><source type="audio/mpeg"  id="audiourl" src="" /></audio>
                                                <input type="file" ngf-select ng-model="extData1.msc_welcome_tune_audio" id="msc_welcome_tune_audio" class="form-control" name="msc_welcome_tune_audio">
                                                <div ng-show="step2" ng-messages="updatevnoForm.msc_welcome_tune_audio.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.msc_welcome_tune}} </span>
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="extData1.msc_welcome_tune_type_id==2">
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.msc_welcome_tune.$dirty && updateextForm.msc_welcome_tune.$invalid)}">
                                            <label for="">Enter text to read as a missed call welcome greeting</label>
                                            <textarea ng-model="extData1.msc_welcome_tune" name="msc_welcome_tune" class="form-control" ng-required="extData1.msc_welcome_tune_type_id==2">{{ extData1.msc_welcome_tune}}</textarea>
                                            <span class="input-icon icon-right">
                                                <div ng-show="step2" ng-messages="updateextForm.msc_welcome_tune.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.msc_welcome_tune}} </span>
                                        </div>
                                    </div>
                                </div>  


                                <div class="row" ng-show="extData1.msc_facility_status==0"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.welcome_tune_type_id.$dirty && updateextForm.welcome_tune_type_id.$invalid)}">
                                            <label for="">Welcome Greeting <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="extData1.welcome_tune_type_id" name="welcome_tune_type_id" id="welcome_tune_type_id" ng-init="cttunetype1()" class="form-control" ng-required="extData1.msc_facility_status==0">
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

                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="extData1.welcome_tune_type_id==3"> 
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.welcome_tune_audio.$dirty && updateextForm.welcome_tune_audio.$invalid)}">
                                            <label for="">Upload Welcome Greeting Mp3</label>
                                            <span class="input-icon icon-right">
                                                <audio controls=""><source type="audio/mpeg"  id="audiourl" src="" /></audio>
                                                <input type="file" ngf-select ng-model="extData1.welcome_tune_audio" id="welcome_tune_audio" class="form-control" name="welcome_tune_audio">
                                                <div ng-show="step2" ng-messages="updatevnoForm.welcome_tune_audio.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.welcome_tune}} </span>
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="extData1.welcome_tune_type_id==2">
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.welcome_tune.$dirty && updateextForm.welcome_tune.$invalid)}">
                                            <label for="">Enter text to read as a welcome greeting</label>
                                            <textarea ng-model="extData1.welcome_tune" name="welcome_tune" class="form-control" ng-required="extData1.welcome_tune_type_id==2">{{ extData1.welcome_tune}}</textarea>
                                            <span class="input-icon icon-right">
                                                <div ng-show="step2" ng-messages="updateextForm.welcome_tune.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.welcome_tune}} </span>
                                        </div>
                                    </div>
                                </div>  


                                <div class="row" ng-show="extData1.msc_facility_status==0"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.hold_tune_type_id.$dirty && updateextForm.hold_tune_type_id.$invalid)}">
                                            <label for="">Hold Tune <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="extData1.hold_tune_type_id" name="hold_tune_type_id" id="hold_tune_type_id" ng-init="cttunetype2()" class="form-control" ng-required="extData1.msc_facility_status==0">
                                                    <option value="">Select Welcome Tune Type</option>
                                                    <option ng-repeat="ct_tune_type2 in ct_tune_types2" value="{{ct_tune_type2.id}}">{{ct_tune_type2.type}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step2" ng-messages="updateextForm.hold_tune_type_id.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.hold_tune_type_id}} </span>
                                            </span>
                                        </div>
                                    </div> 

                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="extData1.hold_tune_type_id==3"> 
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.hold_tune_audio.$dirty && updateextForm.hold_tune_audio.$invalid)}">
                                            <label for="">Upload Hold Tune Mp3</label>
                                            <span class="input-icon icon-right">
                                                <audio controls=""><source type="audio/mpeg"  id="audiourl" src="" /></audio>
                                                <input type="file" ngf-select ng-model="extData1.hold_tune_audio" id="hold_tune_audio" class="form-control" name="hold_tune_audio" ng-required="extData1.hold_tune_type_id==3">
                                                <div ng-show="step2" ng-messages="updatevnoForm.hold_tune_audio.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.hold_tune}} </span>
                                        </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="extData1.hold_tune_type_id==2">
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.hold_tune.$dirty && updateextForm.hold_tune.$invalid)}">
                                            <label for="">Enter text to read as a hold tune</label>
                                            <textarea ng-model="extData1.hold_tune" name="hold_tune" class="form-control" ng-required="extData1.hold_tune_type_id==2">{{ extData1.hold_tune}}</textarea>
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
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="extData1.forwarding_type_id==2 || extData1.forwarding_type_id==3">
                                        <div  class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.forwarding_time.$dirty && updateextForm.forwarding_time.$invalid)}">
                                            <label for="">Forwarding Time (Seconds) <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="extData1.forwarding_time" name="forwarding_time"  class="form-control" ng-required="extData1.forwarding_type_id==2 || extData1.forwarding_type_id==3">
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


                                <div class="row" ng-controller="enquirySourceCtrl"> 

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.source_id.$dirty && updateextForm.source_id.$invalid)}">
                                            <label for="">Source <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="extData1.source_id" id="source_id" name="source_id" ng-init="enquirysources()" ng-change="onEnquirySourceChange()" class="form-control" required>
                                                    <option value="">Select Source</option>
                                                    <option ng-repeat="enquirysource in sourceList" value="{{enquirysource.id}}">{{enquirysource.source_name}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step2" ng-messages="updateextForm.source_id.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.source_id}} </span>
                                            </span>
                                        </div>
                                    </div> 

                                    <div class="col-md-6 col-sm-6 col-xs-12 bord-r8" ng-show="subSourceList.length>0">
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.sub_source_id.$dirty && updateextForm.sub_source_id.$invalid)}">
                                            <label for="">Sub Source <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="extData1.sub_source_id" name="sub_source_id" class="form-control" ng-required="enquirysubsources.length>0">
                                                    <option value="">Select Sub Source</option>
                                                    <option ng-repeat="enquirysubsource in subSourceList" value="{{enquirysubsource.id}}">{{enquirysubsource.sub_source}}</option>
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
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>                                    
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

                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.ext_name.$dirty && updateextForm.ext_name.$invalid)}">
                                            <label for="">Extension Name</label>
                                            <input type="text" id="ext_name" name="ext_name" class="form-control" ng-model="extData1.ext_name" required>
                                            <span class="input-icon icon-right">
                                                <div ng-show="step2" ng-messages="updateextForm.ext_name.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                            </span>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.ext_name}} </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" ng-show="extData1.msc_facility_status==1">
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.msc_call_insert_enquiry.$dirty && updateextForm.msc_call_insert_enquiry.$invalid)}">
                                            <label for="">Missed Call Enquiry <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="extData1.msc_call_insert_enquiry" name="msc_call_insert_enquiry" id="msc_call_insert_enquiry" class="form-control" ng-required="extData1.msc_facility_status==1">
                                                    <option value="">Please Select</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>                                    
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="step2" ng-messages="updateextForm.msc_call_insert_enquiry.$error" class="help-block step2">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.msc_call_insert_enquiry}} </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="col-md-6 col-sm-6 col-xs-12 bord-l8">
                                        <div class="form-group">
                                            <div class="checkbox" ng-init="extData1.msc_employee_type=0">
                                                <label>
                                                    <input name="msc_employee_type" ng-model="extData1.msc_employee_type" type="radio" value="0">
                                                    <span class="text"> To Round Robin Wise missed call forwarding to employees </span>
                                                </label>
                                                <label>
                                                    <input name="msc_employee_type" ng-model="extData1.msc_employee_type" type="radio" value="1">
                                                    <span class="text">To default employee </span>
                                                </label>
                                            </div>
                                            <span class="error" style="color:#e46f61" ng-show="errorMsg"> {{ errorMsg.msc_employee_type}} </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : step2 && (!updateextForm.employees1.$dirty && updateextForm.employees1.$invalid)}"  ng-controller="employeesCtrl">
                                            <label for="">Select Employees <span class="sp-err">*</span></label>	
                                            <ui-select multiple ng-model="extData1.employees1" name="employees1" theme="select2" ui-select-required  style="width: 300px;" required>
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
                                            <ui-select multiple ng-model="extData1.msc_default_employee_id" name="msc_default_employee_id" theme="select2" ui-select-required style="width: 300px;">
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
                                <center><a class="btn btn-primary" href="#/<?php echo config('global.getUrl');?>/virtualnumber/update/{{ virtualno[0]['id'] }}">Back</a></center>
                                <br>
                                <center>
                                    <button type="submit" class="btn btn-primary" ng-click="step2 = true">Submit</button>
                                </center>
                                <br>
                                <center><a class="btn btn-primary" href="#/<?php echo config('global.getUrl');?>/virtualnumber/existingupdate/{{ virtualno[0]['id'] }}">Next</a></center>
                                <br>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<style>
    .checkbox{
        margin-top: 28px !important;
    }
</style>
