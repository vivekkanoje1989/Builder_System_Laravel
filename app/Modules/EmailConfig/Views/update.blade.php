<div class="row" ng-controller="emailconfigCtrl" ng-init="manageEmailConfig([[$id]])">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">{{pageHeading}}</span>
            </div>
            <div class="widget-body">
                <form name="emailConfigForm" novalidate ng-submit="emailConfigForm.$valid && createEmail(emailData, [[ $id ]])">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group" ng-class="{ 'has-error' : sbtbtn && (!emailConfigForm.email.$dirty && emailConfigForm.email.$invalid)}">
                                    <label for="">Email <span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <input type="email" ng-model="emailData.email" name="email" class="form-control" required>
                                        <div ng-show="sbtbtn" ng-messages="emailConfigForm.email.$error">
                                            <div ng-message="required">This field is required.</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group" ng-class="{ 'has-error' : sbtbtn && (!emailConfigForm.password.$dirty && emailConfigForm.password.$invalid)}">
                                    <label for="">Password <span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <input type="password" ng-model="emailData.password"  id="password" name="password" class="form-control" required="required">                                            
                                        <div ng-show="sbtbtn" ng-messages="emailConfigForm.password.$error">
                                            <div ng-message="required">This field is required.</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group multi-sel-div" ng-class="{ 'has-error' : (sbtbtn && (!emailConfigForm.department_id.$dirty && emailConfigForm.department_id.$invalid)) && emptyDepartmentId}" ng-controller="listDepartmentOnUpdateCtrl">
                                    <label for="">Select Department <span class="sp-err">*</span></label>	
                                    <ui-select multiple ng-model="emailData.department_id" name="department_id" theme="select2" ng-disabled="disabled" style="width: 300px;" ng-required="true" ng-change="checkDepartment()">
                                        <ui-select-match placeholder="Select Departments">{{$item.department_name}}</ui-select-match>
                                        <ui-select-choices repeat="list in listDepartmentOnUpdate  | filter:$select.search">
                                            {{list.department_name}} 
                                        </ui-select-choices>
                                    </ui-select>
                                    <div ng-show="emptyDepartmentId" class="help-block department {{ applyClassDepartment }}">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group" ng-controller="projectCtrl" ng-class="{ 'has-error' : sbtbtn && (!emailConfigForm.project_id.$dirty && emailConfigForm.project_id.$invalid)}">
                                    <label for="">Project <span class="sp-err">*</span></label>	
                                    <span class="input-icon icon-right">
                                    <select ng-model="emailData.project_id" name="project_id" class="form-control" required>
                                        <option value="">Select Project</option>
                                        <option ng-repeat="plist in projectList" value="{{plist.id}}">{{plist.project_name}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <div ng-show="sbtbtn" ng-messages="emailConfigForm.project_id.$error">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">                            
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group" ng-class="{ 'has-error' : sbtbtn && (!emailConfigForm.status.$dirty && emailConfigForm.email.$invalid)}">
                                     <label for="">Select status <span class="sp-err">*</span></label>	
                                    <span class="input-icon icon-right">
                                        <select class="form-control" ng-model="emailData.status"  name="status" placeholder="Status">
                                            <option value="0">InActive</option>
                                            <option value="1">Active</option>                                            
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                        <div ng-show="sbtbtn" ng-messages="emailConfigForm.status.$error">
                                            <div ng-message="required">This field is required.</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="right">
                            <input type="submit" class="btn btn-primary" value="Create" id="sbt" ng-click="sbtbtn=true">
                            <a href="[[ config('global.backendUrl') ]]#/emailConfig/index" class="btn btn-primary"><< Back To List</a>
                        </div>
                    </div>
                </form>    
            </div>
	</div>
    </div>
</div>
<script>
$(document).ready(function(){
    $("#sbt").click(function(e){
        if( $(".select2-input").attr('placeholder') === '' && $(".department").hasClass("ng-hide")) {}
        else{ $(".department").removeClass("ng-hide");}   
    })
});
</script>