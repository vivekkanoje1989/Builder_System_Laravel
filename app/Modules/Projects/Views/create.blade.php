<div class="row">
    <div class="widget flat radius-bordered">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="projectController">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{pageHeading}}</h5>
            <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12">
                <div id="customer-form">
                    <form novalidate name="projectForm" ng-submit="projectForm.$valid && createProject(projectData)">
                        <div class="row">
                            <div class="col-sm-3 col-xs-6">  
                                <div class="form-group" ng-class="{ 'has-error' : formButton && (!projectForm.project_name.$dirty  && projectForm.project_name.$invalid)}">
                                    <label>Project Name <span class="sp-err">*</span></label>
                                    <input type="text" ng-model="projectData.project_name" capitalizeFirst class="form-control" name="project_name" required>   
                                    <div ng-show="formButton" ng-messages="projectForm.project_name.$error" class="help-block">
                                        <div ng-message="required">This field is required.</div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group" ng-class="{ 'has-error' : formButton && (!projectForm.project_punch_line.$dirty  && projectForm.project_punch_line.$invalid)}">
                                    <label>Punch Line <span class="sp-err">*</span></label>
                                    <input type="text" ng-model="projectData.project_punch_line" class="form-control" name="project_punch_line" required>
                                    <div ng-show="formButton" ng-messages="projectForm.project_punch_line.$error" class="help-block">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">  
                                <div class="form-group" ng-controller="projectTypeCntrl" ng-class="{ 'has-error' : formButton && (!projectForm.project_type_id.$dirty  && projectForm.project_type_id.$invalid)}">
                                    <label>Project Type <span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select ng-model="projectData.project_type_id" name="project_type_id" class="form-control" required>
                                            <option value="">Select type</option>
                                            <option ng-repeat="tlist in typeList" value="{{tlist.id}}">{{tlist.project_type}}</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                        <div ng-show="formButton" ng-messages="projectForm.project_type_id.$error" class="help-block">
                                            <div ng-message="required">This field is required.</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group" ng-controller="projectStatusCntrl" ng-class="{ 'has-error' : formButton && (!projectForm.project_status.$dirty  && projectForm.project_status.$invalid)}">
                                    <label>Project Status <span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select ng-model="projectData.project_status" name="project_status" class="form-control" required>
                                            <option value="">Select Status</option>
                                            <option ng-repeat="slist in statusList" value="{{slist.id}}">{{slist.project_status}}</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                        <div ng-show="formButton" ng-messages="projectForm.project_status.$error" class="help-block">
                                            <div ng-message="required">This field is required.</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" ng-disabled="projectSbtBtn" ng-click="formButton=true">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>