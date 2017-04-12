<div class="row" ng-controller="basicInfoController">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <h5 class="row-title"><i class="fa fa-arrow-circle-o-right themeprimary"></i>Project Web Page</h5>
        <div class="row" ng-controller="projectCtrl">
            <div class="col-sm-3 col-xs-6">  
                <div class="form-group">
                    <label>Projects<span class="sp-err">*</span></label>
                    <span class="input-icon icon-right">
                        <select ng-model="projectData.project_id" name="project_id" class="form-control" required>
                            <option value="">Select type</option>
                            <option ng-repeat="plist in projectList" value="{{plist.id}}">{{plist.project_name}}</option>
                        </select>
                        <i class="fa fa-sort-desc"></i>
                    </span>
                </div>
            </div>
            <div class="col-lg-12 col-sm-6 col-xs-12" ng-if='projectData.project_id'>
                <tabset>
                    <tab heading="Website Settings">
                        <div data-ng-include=" '[[ config('global.getUrl') ]]/projects/basicinfo' "></div>
                    </tab>
                    <tab heading="Uploads" class="uploadsTab">
                        <div data-ng-include=" '[[ config('global.getUrl') ]]/projects/uploads' "></div>
                    </tab>
                    <tab heading="Project Inventory">
                        <div data-ng-include=" '[[ config('global.getUrl') ]]/projects/inventory' "></div>
                    </tab>
                    <tab heading="Floor Inventory">
                        <p>Floor Inventory</p>
                    </tab>
                    <tab heading="Parking Inventory">
                        <p>Parking Inventory</p>
                    </tab>
                    <tab heading="Project Stage">
                        <p>Project Stage</p>
                    </tab>
                    <tab heading="Discount Management">
                        <p>Discount Management</p>
                    </tab>
                    <tab heading="Agreement Cost">
                        <p>Agreement Cost</p>
                    </tab>
                    <tab heading="Collection Calculations">
                        <p>Collection Calculations</p>
                    </tab>
                    <tab heading="Documents">
                        <p>Documents</p>
                    </tab>
                    <tab heading="SMS & Email Templates">
                        <p>SMS & Email Templates</p>
                    </tab>
                    <tab heading="Project Authority">
                        <p>Project Authority</p>
                    </tab>
                </tabset>
                <div class="horizontal-space"></div>
            </div>
        </div>
    </div>
</div>