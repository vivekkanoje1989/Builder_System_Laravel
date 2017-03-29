<div class="row" ng-controller="emailconfigCtrl" ng-init="manageEmailConfig([[$id]])">
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
                <form name="updateEmailConfigForm" novalidate ng-submit="userForm.$valid && createEmail(emailData, [[ $id ]])">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="col-sm-4 col-xs-6">
                                <div class="form-group" ng-class="{ 'has-error' : step1 && (!updateEmailConfigForm.email.$dirty && updateEmailConfigForm.email.$invalid)}">
                                    <label for="">Email <span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <input type="text" ng-model="emailData.email"  name="email" class="form-control" required="required">                                            
                                        <div ng-show="step1" ng-messages="updateEmailConfigForm.email.$error" class="help-block step1">
                                            <div ng-message="required">This field is required.</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6">
                                <div class="form-group" ng-class="{ 'has-error' : step1 && (!updateEmailConfigForm.password.$dirty && updateEmailConfigForm.password.$invalid)}">
                                    <label for="">Password <span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <input type="password" ng-model="emailData.password"  name="password" class="form-control" required="required">                                            
                                        <div ng-show="step1" ng-messages="updateEmailConfigForm.password.$error" class="help-block step1">
                                            <div ng-message="required">This field is required.</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6">
                                <div class="form-group multi-sel-div" ng-class="{ 'has-error' : (step4 && (!updateEmailConfigForm.department_id.$dirty && updateEmailConfigForm.department_id.$invalid)) && emptyDepartmentId}" ng-controller="departmentCtrl">
                                    <label for="">Select Department <span class="sp-err">*</span></label>	
                                    <ui-select multiple ng-model="emailData.department_id" name="department_id" theme="select2" ng-disabled="disabled" style="width: 300px;" ng-required="true"  ng-change="checkDepartment()">
                                        <ui-select-match placeholder="Select Departments">{{$item.department_name}}</ui-select-match>
                                        <ui-select-choices repeat="list in departments | filter:$select.search">
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
                            <div class="col-sm-4 col-xs-6"></div>
                            <div class="col-sm-4 col-xs-6">
                            <input type="button"  class="btn btn-success" value="Test Mail" ng-click="testMail()">
                            <input type="submit"  class="btn btn-info" value="Save">
                            </div>
                            <div class="col-sm-4 col-xs-6"></div>
                        </div>                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>