<style>
    .note-box{
        background-color: pink;
        border:1px solid #000;
        padding:2%;        
    }
</style>
<div class='' ng-controller="empDeviceController" ng-init='manageDevice([[ $id ]], "")'>
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="widget">
                <div class="widget-header">
                    <span class="widget-caption">Add Device</span>
                    <div class="widget-buttons">
                        <a href="" widget-maximize></a>
                        <a href="" widget-collapse></a>
                        <a href="" widget-dispose></a>
                    </div>
                </div>
                <div class="widget-body">
                    <form name="deviceConfig" class="" ng-submit="deviceConfig.$valid && saveDeviceConfig([[ $id ]], deviceData)" novalidate>
                        <input type="hidden" ng-model="deviceConfig.csrfToken" name="csrftoken" id="csrftoken" ng-init="deviceConfig.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">                                
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <label for="">Device Name <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="deviceData.device_name" name="device_name" class="form-control" required>
                                            <div ng-show="createBtn" ng-messages="deviceConfig.device_name.$error">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <label for="">Device Mac <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="deviceData.device_mac" name="device_mac" class="form-control" required>
                                            <div ng-show="createBtn" ng-messages="deviceConfig.device_mac.$error">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <label for="">Device Status <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select class="form-control" name="status" ng-model="deviceData.device_status" required>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                            <div ng-show="createBtn" ng-messages="deviceConfig.device_status.$error">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group multi-sel-div" ng-controller="getAllEmployeesCtrl" ng-class="{ 'has-error' : step1 && (!deviceConfig.employee_id.$dirty && deviceConfig.employee_id.$invalid)}">
                                        <label for="">Select Employees <span class="sp-err">*</span></label>	
                                        <ui-select multiple ng-model="deviceData.employee_id" name="employee_id" theme="select2" ng-disabled="disabled" style="width: 300px;" required  ng-change="checkDepartment()">
                                            <ui-select-match placeholder="Select Employees">{{$item.first_name}} {{$item.last_name}}</ui-select-match>
                                            <ui-select-choices repeat="list in employeeList | filter:$select.search">
                                                {{list.first_name}} {{list.last_name}}
                                            </ui-select-choices>
                                        </ui-select>
                                        <div ng-show="createBtn" ng-messages="deviceConfig.employee_id.$error">
                                            <div ng-message="required">This field is required.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <label for="">Device Description <span class="sp-err"></span></label>
                                        <span class="input-icon icon-right">
                                            <textarea ng-model="deviceData.device_description" cols="20" rows="4" name="device_description" class="form-control"></textarea>                                            
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <label for="">Remarks <span class="sp-err"></span></label>
                                        <span class="input-icon icon-right">
                                            <textarea ng-model="deviceData.remarks" name="remarks" cols="20" rows="4" class="form-control"></textarea>                                            
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group" ng-class="{ 'has-error' : step5 && (!deviceConfig.device_type.$dirty && deviceConfig.device_type.$invalid)}">
                                        <label for="">Device Type <span class="sp-err">*</span></label>
                                        <div class="control-group">
                                            <div class="radio">
                                                <label>
                                                    <input name="form-field-radio" type="radio" ng-model="deviceData.device_type" value="1" class="colored-danger" ng-checked="true">
                                                    <span class="text">Desktop </span>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input name="form-field-radio" type="radio" ng-model="deviceData.device_type" value="2" class="colored-blue">
                                                    <span class="text">Laptop</span>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input name="form-field-radio" type="radio" ng-model="deviceData.device_type" value="3" class="colored-success">
                                                    <span class="text">Mobile/Tablet</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div ng-show="step5" ng-messages="deviceConfig.device_type.$error" class="help-block step5">
                                            <div ng-message="required">This field is required.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6 pull-left col-sm-2">
                                    <div class="note-box">
                                        <span>
                                            <b>Note: </b>Discuss With Sir
                                        </span>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="col-sm-3 col-xs-6">
                                    <input type="submit" name="btnname" class="btn btn-primary" value="{{ btnLable}}" ng-click="createBtn = true">
                                </div>                                    
                            </div>                                
                        </div>
                    </form>
                </div>                   
            </div>
        </div>
    </div>
</div>