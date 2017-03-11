<div ng-controller="propertyPortalsController">
    <form name="portalAccountForm" novalidate ng-submit="portalAccountForm.$valid && createUser(userData, userData.emp_photo_url, [[$portalTypeId]])" ng-init="managePortalAccounts([[!empty($portalTypeId) ? $portalTypeId : '0']], 'edit')">
        <input type="hidden" ng-model="portalAccountForm.csrfToken" name="csrftoken" id="csrftoken" ng-init="portalAccountForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
        <input type="hidden" ng-model="portalData.portalTypeId" name="portalTypeId" id="portalTypeId" ng-init="portalAccountForm.portalTypeId = '[[ $portalTypeId ]]'" value="[[ $portalTypeId ]]" class="form-control">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>Add Account</h5>
                <div class="widget">
                    <div class="widget-header ">
                        <span class="widget-caption">Add Account</span>
                        <div class="widget-buttons">
                            <a href="" widget-maximize></a>
                            <a href="" widget-collapse></a>
                            <a href="" widget-dispose></a>
                        </div>
                    </div>
                    <div class="widget-body table-responsive" style="padding-bottom: 5%;">
                        <div class="row">
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label for="">Friendly Account Name <span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <input type="text" ng-model="portalData.friendly_account_name" name="friendly_account_name" class="form-control" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15" required>
                                        <i class="fa fa-address-card"></i>
                                        <div ng-messages="portalAccountForm.friendly_account_name.$error">
                                            <div ng-message="required">This field is required.</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6" ng-if="[[$portalTypeId]] === 2 || [[$portalTypeId]] === 3 || [[$portalTypeId]] === 4 || [[$portalTypeId]] === 5">
                                <div class="form-group">
                                    <label for="">User Name</label>
                                    <span class="input-icon icon-right">
                                        <input type="text" ng-model="portalData.username" name="username" class="form-control" oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15">
                                        <i class="fa fa-user"></i>
                                        <div ng-messages="portalAccountForm.first_name.$error">
                                            <div ng-message="required">This field is required.</div>
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
                                    <label for="" ng-if="[[$portalTypeId]] === 5">ecn key</label>
                                    <label for="" ng-if="[[$portalTypeId]] === 1">API key</label>
                                    <span class="input-icon icon-right">
                                        <input type="text" ng-model="portalData.api_key" name="api_key" class="form-control">
                                        <i class="fa fa-user"></i>                                    
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label for="">Assign Enquiries To  <span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <div class="radio">
                                            <label>
                                                <input name="assignEmployee" type="radio" ng-model="portalData.assign_employee" name="assign_employee" value="commonEmp" checked>
                                                <span class="text">Common Employee </span>
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input name="assignEmployee" type="radio" ng-model="portalData.assign_employee" name="assign_employee" value="specificEmp">
                                                <span class="text">Project Specific Employee</span>
                                            </label>
                                        </div>
                                    </span>

                                </div> 
                            </div>
                            <div class="col-sm-3 col-xs-12" ng-show="portalData.assign_employee == 'commonEmp'">                            
                                <div class="form-group multi-sel-div" class="form-control" ng-controller="assignEmployeeCtrl">
                                    <label for="">Select Common Employee <span class="sp-err">*</span></label>	
                                    <ui-select multiple='true' class="form-control" ng-model="portalData.employee_id" name="employee_id" theme="" ng-disabled="disabled" style="width: 300px;" ng-required ng-change="checkDepartment()">
                                        <ui-select-match placeholder="Select Employees">{{$item.first_name}}{{$item.last_name}}</ui-select-match>
                                        <ui-select-choices repeat="list in employeeList | filter:$select.search ">
                                            {{list.first_name}} {{list.last_name}}({{list.designation}})
                                        </ui-select-choices>
                                    </ui-select>
                                    <div ng-show="" >
                                        This field is required.
                                    </div>
                                    {{ portalData.employee_id}}
                                </div>                           
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <span class="input-icon icon-right">
                                        <i class="fa fa-angle-down"></i>
                                        <select class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </span>
                                </div>
                            </div>

                        </div> 

                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div align="right">  <p class="add-btn btn btn-primary" data-toggle="modal" data-target="#projectModal"><i class="fa fa-plus"></i></p></div>
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-bordered" at-config="config">
                                        <caption class="table-caption" ng-show="portalData.assign_employee == 'specificEmp'">Project Specific Employees</caption>
                                        <caption class="table-caption" ng-show="portalData.assign_employee == 'commonEmp'">Common Employees</caption>
                                        <thead class="bord-bot">
                                            <tr>
                                                <th style="width:5%">Sr. No.</th>
                                                <th style="width:30%">Project Name</th>
                                                <th style="width:30%">Project Alias Name</th>
                                                <th style="width:30%" ng-if="portalData.assign_employee == 'specificEmp'">Employee Name</th>
                                                <th style="width:5%">Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>fsdf</td>
                                                <td>fsdf</td>
                                                <td>fsdf</td>
                                                <td ng-if="portalData.assign_employee == 'specificEmp'">fsdf</td>
                                                <td>fsdf</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12" align="right">                            
                                <button type="submit" class="btn btn-primary btn-submit-last"  ng-disabled="portalAccountForm.$invalid" ng-click="step5 = true">Create</button>
                                <button type="reset" class="btn btn-primary">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Modal -->
    <div class="modal fade" id="projectModal" role="dialog" tabindex="-1">    
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{ modal_title}}</h4>
                </div>
                <form name="addProjectForm" novalidate ng-submit="addProjectForm.$valid && addEditProjects()">  
                    <div class="modal-body">               
                        <input type='hidden' id="actionModal" nema="actionModal" ng-model="actionModal">
                        <div class="form-group">                            
                            <span class="input-icon icon-right">
                               Alias Name :
                                <input type="text" class="form-control" ng-model="modal.reason" name="reason" placeholder="Reason" required="required">                                
                            </span>
                            <label>Project Name :</label>
                            <span class="input-icon icon-right">                                
                                <select class="form-control" ng-model="modal.lost_reason_status">
                                    <option value="1">Active</option>
                                    <option value="0">In Active</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                            <span>
                                <div class="form-group multi-sel-div" class="form-control" ng-controller="assignEmployeeCtrl">
                                    <label for="">Select Common Employee <span class="sp-err">*</span></label>	
                                    <ui-select multiple='true' class="form-control" ng-model="modal.employee_id" name="employee_id" theme="" ng-disabled="disabled" style="width: 300px;" ng-required ng-change="checkDepartment()">
                                        <ui-select-match placeholder="Select Employees">{{$item.first_name}}{{$item.last_name}}</ui-select-match>
                                        <ui-select-choices repeat="list in employeeList | filter:$select.search ">
                                            {{list.first_name}} {{list.last_name}}({{list.designation}})
                                        </ui-select-choices>
                                    </ui-select>
                                    <div ng-show="" >
                                        This field is required.
                                    </div>
                                    {{ portalData.employee_id}}
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
