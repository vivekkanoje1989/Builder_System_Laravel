<style>
    .nav>li>a{
        padding: 10px 10px;
    }
</style>
<div class="row" ng-controller="projectController">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <h5 class="row-title"><i class="fa fa-arrow-circle-o-right themeprimary"></i>Project Web Page</h5>
        <div class="row">
            <div class="col-lg-12 col-sm-6 col-xs-12">
                <input type="hidden" ng-model="projectData.project_id" name="project_id" value="[[ $projectId ]]"/>
                <tabset>
                    <tab heading="Website Settings">
                        <div data-ng-include="'/projects/basicinfo'" ng-init="webpageSettings([[ $projectId ]],'')"></div>
                    </tab>
                    <tab heading="Uploads" class="uploadsTab" disabled="showAllTabs" ng-click="!showAllTabs && uploadsData([[ $projectId ]],'', '')">
                        <div data-ng-include=" '/projects/uploads' "></div>
                    </tab>
                    <tab heading="Project Inventory" disabled="showAllTabs" ng-click="!showAllTabs && getInventoryDetails([[ $projectId ]],0,'')">
                        <div data-ng-include=" '/projects/inventory' "></div>
                    </tab>
                    <tab heading="Floor Inventory" disabled="showAllTabs">
                        <p>Floor Inventory</p>
                    </tab>
                    <tab heading="Parking Inventory" disabled="showAllTabs">
                        <p>Parking Inventory</p>
                    </tab>
                    <tab heading="Project Stage" disabled="showAllTabs">
                        <p>Project Stage</p>
                    </tab>
                    <tab heading="Discount Management" disabled="showAllTabs">
                        <p>Discount Management</p>
                    </tab>
                    <tab heading="Agreement Cost" disabled="showAllTabs">
                        <p>Agreement Cost</p>
                    </tab>
                    <tab heading="Collection Calculations" disabled="showAllTabs">
                        <p>Collection Calculations</p>
                    </tab>
                    <tab heading="Documents" disabled="showAllTabs">
                        <p>Documents</p>
                    </tab>
                    <tab heading="SMS & Email Templates" disabled="showAllTabs">
                        <p>SMS & Email Templates</p>
                    </tab>
                    <tab heading="Project Authority" disabled="showAllTabs">
                        <p>Project Authority</p>
                    </tab>
                </tabset>
                <div class="horizontal-space"></div>
            </div>
        </div>
    </div>
</div>