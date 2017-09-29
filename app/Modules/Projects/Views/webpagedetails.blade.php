<style>
.box {
  display: block;  
  background: white;
  margin-bottom: 1em;
}

.fade-in {
  height: 100px;
  width: 1px;
  opacity: 0;
  transition: all .75s ease;
}

.fade-in.show {
  opacity: 1;
  height: 100%;
  width: 100%;
}

.fade1 {
  transition: all linear 1000ms;
}

</style>

<div class="row" ng-controller='projectController'>
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">{{projectName}}</span>
            </div>
            <div class="widget-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-6 col-xs-12">
                        <input type="hidden" ng-model="projectData.project_id" name="project_id" value="[[ $projectId ]]"/>
                        <div class="mainPanel">
                            <div class="col-md-3">
                                <div class="databox radius-bordered databox-shadowed databox-graded databox-vertical">
                                    <div class="databox-top bg-blue">
                                        <div class="databox-icon">
                                            <i class="fa fa fa-plus-square"></i>
                                        </div>
                                    </div>
                                    <div class="databox-bottom text-align-center">
                                        <span class="databox-text">
                                            <button class="btn_webpageSettings" ng-init="webpageSettings([[ $projectId ]],'')">Website Settings</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body"><button class="btn_uploads" ng-disabled="showAllTabs" ng-click="!showAllTabs && uploadsData([[ $projectId ]],'', '')">Uploads</button></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body"><button class="btn_inventory" ng-disabled="showAllTabs" ng-click="!showAllTabs && getInventoryDetails([[ $projectId ]],0, '')">Project Inventory</button></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body"><button class="btn_floor_inventory" ng-disabled="showAllTabs">Floor Inventory</button></div>
                                </div>
                            </div>
                        </div>

                        
                        <div id="fade-in" class="box">
                            <div class="content_website_settings">
                                <div data-ng-include="'/projects/basicinfo'"></div>
                            </div>
                        </div>
                        <div id="fade-in-uploads" class="box">
                            <div heading="Uploads" class="content_uploads">
                                <div data-ng-include="'/projects/uploads'"></div>
                            </div>
                        </div>
                        <div id="fade-in-inventory" class="box">
                            <div heading="Uploads" class="content_inventory">
                                <div data-ng-include="'/projects/inventory'"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.content_website_settings').hide();    
    $('.content_uploads').hide();    
    $('.content_inventory').hide(); 
    
    $('.btn_webpageSettings').on('click', function(){
        $('#fade-in').toggleClass('show');
        $('.mainPanel').hide();
        $('.content_website_settings').show();        
    });
    $('.btn_uploads').on('click', function(){
        $('#fade-in-uploads').toggleClass('show');
        $('.mainPanel').hide();
        $('.content_uploads').show();        
    }); 
    $('.btn_inventory').on('click', function(){
        $('#fade-in-inventory').toggleClass('show');
        $('.mainPanel').hide();
        $('.content_inventory').show();        
    }); 
});
</script>