<div class="row" ng-controller="emailconfigCtrl">
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Configure Email Accounts</span>
                <div class="widget-buttons">                   
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body ">
                <form name="emailConfigForm" novalidate ng-submit="emailConfigForm.$valid && createEmail(emailData, [[ $id ]])">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="col-sm-4 col-xs-6">
                                <div class="form-group" ng-class="{ 'has-error' : step1 && (!emailConfigForm.email.$dirty && emailConfigForm.email.$invalid)}">
                                    <label for="">Email <span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <input type="email" ng-model="emailData.email" name="email" class="form-control"  onKeypress="document.getElementById('createbtn').style.display = 'none';" ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/" required ng-model-options="{ allowInvalid: true, debounce: 300 }">
                                        <div ng-show="step1" ng-messages="emailConfigForm.email.$error">
                                            <div ng-message="required">This field is required.</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6">
                                <div class="form-group" ng-class="{ 'has-error' : step1 && (!emailConfigForm.password.$dirty && emailConfigForm.password.$invalid)}">
                                    <label for="">Password <span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <input type="password" ng-model="emailData.password"  onKeypress="document.getElementById('createbtn').style.display = 'none';"  id="password" name="password" class="form-control" required="required">                                            
                                        <div ng-show="step1" ng-messages="emailConfigForm.password.$error">
                                            <div ng-message="required">This field is required.</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6">
                                <div class="form-group multi-sel-div" ng-controller="listAllDepartmentCtrl" ng-class="{ 'has-error' : step1 && (!emailConfigForm.department_id.$dirty && emailConfigForm.department_id.$invalid)}">
                                    <label for="">Select Department <span class="sp-err">*</span></label>	
                                    <ui-select multiple ng-model="emailData.department_id" name="department_id" theme="select2" ng-disabled="disabled" style="width: 300px;" ng-change="checkDepartment()">
                                        <ui-select-match placeholder="Select Departments">{{$item.department_name}}</ui-select-match>
                                        <ui-select-choices repeat="list in lstAlldepartments ">
                                            {{list.department_name}} 
                                        </ui-select-choices>
                                    </ui-select>
                                    <div ng-show="emptyDepartmentId">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="col-sm-4 col-xs-6">
                                <div class="form-group">
                                     <label for="">Select Project <span class="sp-err">*</span></label>	
                                    <span class="input-icon icon-right">
                                    <select class="form-control" ng-model="emailData.project_id"  name="project_id" placeholder="project name">
                                        <option value="1">HAppy Home</option>
                                        <option value="2">bb</option>
                                        <option value="3">cc</option>
                                        <option value="4">dd</option>
                                    </select>
                                        <i class="fa fa-sort-desc"></i>
                                        </span>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6">
                                <div class="form-group" ng-class="{ 'has-error' : step1 && (!emailConfigForm.email.$dirty && emailConfigForm.email.$invalid)}">
                                     <label for="">Select Status <span class="sp-err">*</span></label>	
                                    <span class="input-icon icon-right">
                                        <select class="form-control" ng-model="emailData.status"  name="status" placeholder="Status">
                                            <option value="0">InActive</option>
                                            <option value="1">Active</option>                                            
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="col-sm-4 col-xs-6">
                                <input type="button"  class="btn btn-success"  id="testbtn" value="Test Mail" ng-disabled="(!emailConfigForm.email.$dirty && emailConfigForm.email.$invalid) && (!emailConfigForm.password.$dirty && emailConfigForm.password.$invalid)" ng-click="testMail(emailData, [[ $id ]])">
                                <input type="submit" id="createbtn" class="btn btn-info" value="Create" style="display:none;">
                            </div>
                            <div class="col-sm-4 col-xs-6"></div>
                            <div class="col-sm-4 col-xs-6"></div>
                        </div>                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>