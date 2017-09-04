<div class="row" ng-controller="propertyPortalsController">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">{{ page_heading }}</span>
            </div>
            <div class="widget-body">
                <form name="portalAccountForm" novalidate ng-submit="portalAccountForm.$valid && createPortalAccount(portalData,aliasLists,[[$portalTypeId]],0)" ng-init="managePortalAccounts([[ $portalTypeId ]],[[!empty($portalAccountId) ? $portalAccountId : '0']], 'edit')">
                    <input type="hidden" ng-model="portalAccountForm.csrfToken" name="csrftoken" id="csrftoken" ng-init="portalAccountForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <input type="hidden" ng-model="portalData.portalTypeId" name="portalTypeId" id="portalTypeId" ng-init="portalAccountForm.portalTypeId = '[[ $portalTypeId ]]'" value="[[ $portalTypeId ]]" class="form-control">
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Friendly Account Name <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="portalData.portal_name" name="portal_name" class="form-control" maxlength="15" required>
                                    <i class="fa fa-address-card"></i>
                                    <div ng-messages="portalAccountForm.portal_name.$error">
                                        <div ng-message="required" class="sp-err">This field is required.</div>
                                    </div>
                                    <div ng-if="portal_name" class="sp-err portal_name">{{portal_name}}</div>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12" ng-show="portalData.enquiry_alocation_types == '0'">                            
                            <div class="form-group multi-sel-div" ng-controller="assignEmployeeCtrl">
                                <label for="">Employees <span class="sp-err">*</span></label>	
                                <ui-select multiple='true' ng-model="portalData.employee_id" name="employee_id" theme="select2" ng-disabled="disabled" style="width: 300px;" ng-required ng-change="checkPortalEmployees()" required>
                                   <ui-select-match placeholder="Select Employees">{{$item.first_name}}{{$item.last_name}}</ui-select-match>
                                    <ui-select-choices repeat="list in lstAllEmployees | filter:$select.search ">
                                        {{list.first_name}} {{list.last_name}}
                                    </ui-select-choices>
                                </ui-select>
                                <div ng-show="emptyEmployeeId" class="sp-err" >
                                    This field is required.
                                </div>
                                 <div ng-if="employee_id" class="sp-err employee_id">{{employee_id}}</div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Status</label>
                                <span class="input-icon icon-right">
                                    <select class="form-control" ng-model="portalData.status" name="portalData.status">
                                        <option value="">Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>  
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Assign Enquiries To  <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right" ng-init="portalData.enquiry_alocation_types =0">
                                    <div class="radio">
                                        <label>
                                            <input name="enquiry_alocation_types" type="radio" ng-model="portalData.enquiry_alocation_types" name="enquiry_alocation_types" value="0" checked >
                                            <span class="text">Common Employee </span>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input name="enquiry_alocation_types" type="radio" ng-model="portalData.enquiry_alocation_types" name="enquiry_alocation_types" value="1">
                                            <span class="text">Project Specific Employee</span>
                                        </label>
                                    </div>
                                     <div ng-if="enquiry_alocation_types" class="sp-err enquiry_alocation_types">{{enquiry_alocation_types}}</div>
                                </span>
                            </div> 
                        </div>                       
                    </div>
                    <div class="row">
                         <div class="col-sm-3 col-xs-6" ng-if="[[$portalTypeId]] === 2 || [[$portalTypeId]] === 3 || [[$portalTypeId]] === 4 || [[$portalTypeId]] === 5">
                            <div class="form-group">
                                <label for="">User Name</label>
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="portalData.username" name="username" class="form-control" maxlength="15">
                                    <i class="fa fa-user"></i>
                                    <div ng-messages="portalAccountForm.first_name.$error">
                                        <div ng-message="required" class="sp-err">This field is required.</div>
                                    </div>
                                </span>                                
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6" ng-if="[[$portalTypeId]] === 2 || [[$portalTypeId]] === 3 || [[$portalTypeId]] === 4 || [[$portalTypeId]] === 5">
                            <div class="form-group">
                                <label for="">Password</label>
                                <span class="input-icon icon-right">
                                    <input type="password" ng-model="portalData.password" name="password" class="form-control" maxlength="15">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6" ng-if="[[$portalTypeId]] === 5 || [[$portalTypeId]] === 1">
                            <div class="form-group">
                                <label for="" ng-if="[[$portalTypeId]] === 5">ECN key</label>
                                <label for="" ng-if="[[$portalTypeId]] === 1">API key</label>
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="portalData.api_key" name="api_key" class="form-control">
                                    <i class="fa fa-user"></i>                                    
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div align="right">  <p class="add-btn btn btn-primary" data-toggle="modal"  ng-click="clearPopup()" data-target="#projectModal"><i class="fa fa-plus"></i></p></div>
                            <div class="table-responsive" id="portalaliastable" style="">
                                <table class="table table-hover table-striped table-bordered" at-config="config">
                                    <caption class="table-caption" ng-show="portalData.enquiry_alocation_types == '1'">Project Specific Employees</caption>
                                    <caption class="table-caption" ng-show="portalData.enquiry_alocation_types == '0'">Common Employees</caption>
                                    <thead class="bord-bot">
                                        <tr>
                                            <th style="width:5%">Sr. No.</th>
                                            <th style="width:30%">Project Name</th>
                                            <th style="width:30%">Project Alias Name</th>
                                            <th style="width:30%" ng-if="portalData.enquiry_alocation_types == '1'">Employee Name</th>
                                            <th style="width:5%">Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="aliasList in aliasLists">
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ aliasList.project_id }}</td>
                                            <td>{{ aliasList.project_alias }}</td>
                                            <td style="display:none;" ng-if="portalData.enquiry_alocation_types == '1'">{{ aliasList.project_employee_id }}</td>
                                            <td ng-if="portalData.enquiry_alocation_types == '1'">{{ aliasList.project_employee_name }}</td>
                                            <td>Edit</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 2%;display:none;" id="btnCreate">
                        <div class="col-md-12 col-xs-12" align="right">                            
                            <button type="submit" class="btn btn-primary btn-submit-last"  ng-disabled="portalAccountForm.$invalid">{{ buttonLabel }}</button>                                
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
     <!-- Modal -->
    <div class="modal fade" id="projectModal" role="dialog" tabindex="-1">    
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{ modal_title}}</h4>
                </div>
                <form name="addProjectForm" novalidate ng-submit="addProjectForm.$valid && addEditProjects(modal)">  
                    <div class="modal-body">               
                        <input type='hidden' id="property_portal_type_id" name="actionModal" ng-model="modal.property_portal_id" value="[[ $portalTypeId ]]">
                        <div class="form-group">                            
                            <span class="input-icon icon-right">
                               Alias Name :
                                <input type="text" class="form-control" ng-model="modal.project_alias" name="project_alias" placeholder="Alias Name" required="required">                                
                            </span>
                            <label>Project Name :</label>
                            <span class="input-icon icon-right">                                
                                <select class="form-control" ng-model="modal.project_id">
                                    <option value="1">Happy Home</option>
                                    <option value="2">Country Yard</option>
                                    <option value="3">Sankheshwar</option>
                                    <option value="4">Dream castle</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                            <span ng-if="portalData.enquiry_alocation_types == '1'">
                                <div class="form-group multi-sel-div" class="form-control" ng-controller="assignEmployeeCtrl"  style="width: 100%;">
                                    <label for="">Select Common Employee <span class="sp-err">*</span></label>	
                                    <ui-select multiple ng-model="modal.employee_id" name="employee_id" theme="select2" ng-disabled="disabled" style="width: 300px;" ng-required ng-change="checkPortalAliasEmployees()">
                                        <ui-select-match placeholder="Select Employees">{{$item.first_name}} {{$item.last_name}}</ui-select-match>
                                        <ui-select-choices repeat="list in lstAllEmployees | filter:$select.search ">
                                            {{list.first_name}} {{list.last_name}}                                            
                                        </ui-select-choices>
                                    </ui-select>
                                   
                                    <div ng-show="isEmptyEmployeeId" class="sp-err">
                                        This field is required.
                                    </div>
                                    <div ng-if="employee_id" class="sp-err employee_id">{{employee_id}}</div>
                                </div> 
                            </span>
                        </div>                
                    </div>
                    <div class="modal-footer" align="center">
                        <button type="submit" class="btn btn-primary" ng-click="" ng-disabled="addProjectForm.$invalid">Add</button>                       
                    </div>  
                </form>                      
            </div>
        </div>
    </div>
</div>

