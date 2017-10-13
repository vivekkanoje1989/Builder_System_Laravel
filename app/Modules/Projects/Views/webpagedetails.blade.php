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
.btn-sq-lg{
    align-items:center;
    display:flex;
    flex-direction:column;
    justify-content:center;
    height: 100px;
    border-radius: 13px;
    margin: 20px 0 20px 0;
    border-width: 1px;
    box-shadow: 0px 3px 9px 2px #ccc;
}
.cstimg{
    font-size:2.5em !important;
    width: 45px;
    height: 80px;
    padding: 5px;
    border-radius: 7px;
}

</style>

<div class="row" ng-controller='projectController'>
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Project {{projectName}} {{moduleName}}</span>
            </div>
            <div class="widget-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-6 col-xs-12">
                        <input type="hidden" ng-model="projectData.project_id" name="project_id" value="[[ $projectId ]]"/>
                        <div class="mainPanel">
                            
                            <div class="col-md-2 col-sm-2">
                                <div id="button1">
                                    <a class="btn btn-sq-lg bordered-themeprimary btn_webpageSettings" ng-init="webpageSettings([[ $projectId ]],'')" ng-click="moduleName=': Basic Information'">
                                        <img src="images/Wesite-Setting.png" class="btn-primary cstimg" />
                                        <hr style="width: 100%;">
                                        <b style="font-size: 15px;">Website Settings</b>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <div id="button1">
                                    <a class="btn btn-sq-lg bordered-themeprimary btn_uploads" ng-disabled="showAllTabs" ng-click="!showAllTabs && uploadsData([[ $projectId ]],'', '')">
                                        <img src="{{showAllTabs ? 'images/Ban-icon.png' : 'images/Uploads.png'}}" class="btn-primary cstimg"/>
                                        <hr style="width: 100%;">
                                        <b style="font-size: 15px;">Uploads</b>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <div id="button1">
                                    <a class="btn btn-sq-lg bordered-themeprimary btn_inventory" ng-disabled="showAllTabs" ng-click="!showAllTabs && getInventoryDetails([[ $projectId ]],0, '')">
                                        <img src="{{showAllTabs ? 'images/Ban-icon.png' : 'images/Project-Inventory.png'}}" class="btn-primary cstimg" />
                                        <hr style="width: 100%;">
                                        <b style="font-size: 15px;">Project Inventory</b>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <div id="button1">
                                    <a class="btn btn-sq-lg bordered-themeprimary"  ng-disabled="showAllTabs">
                                        <img src="{{showAllTabs ? 'images/Ban-icon.png' : 'images/Floor-Inventory.png'}}" class="btn-primary cstimg" />
                                        <hr style="width: 100%;">
                                        <b style="font-size: 15px;">Floor Inventory</b>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <div id="button1">
                                    <a class="btn btn-sq-lg bordered-themeprimary"  ng-disabled="showAllTabs">
                                        <img src="{{showAllTabs ? 'images/Ban-icon.png' : 'images/Parking-Inventory.png'}}" class="btn-primary cstimg" />
                                        <hr style="width: 100%;">
                                        <b style="font-size: 15px;">Parking Inventory</b>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <div id="button1">
                                    <a class="btn btn-sq-lg bordered-themeprimary"  ng-disabled="showAllTabs">
                                        <img src="{{showAllTabs ? 'images/Ban-icon.png' : 'images/Project-Stage.png'}}" class="btn-primary cstimg" />
                                        <hr style="width: 100%;">
                                        <b style="font-size: 15px;">Project Stage</b>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <div id="button1">
                                    <a class="btn btn-sq-lg bordered-themeprimary"  ng-disabled="showAllTabs">
                                        <img src="{{showAllTabs ? 'images/Ban-icon.png' : 'images/Discount-Mangement.png'}}" class="btn-primary cstimg" />
                                        <hr style="width: 100%;">
                                        <b style="font-size: 15px;">Discount Management</b>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <div id="button1">
                                    <a class="btn btn-sq-lg bordered-themeprimary"  ng-disabled="showAllTabs">
                                        <img src="{{showAllTabs ? 'images/Ban-icon.png' : 'images/Agreement-cost.png'}}" class="btn-primary cstimg" />
                                        <hr style="width: 100%;">
                                        <b style="font-size: 15px;">Agreement Cost</b>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <div id="button1">
                                    <a class="btn btn-sq-lg bordered-themeprimary"  ng-disabled="showAllTabs">
                                        <img src="{{showAllTabs ? 'images/Ban-icon.png' : 'images/Collection-Calculations.png'}}" class="btn-primary cstimg" />
                                        <hr style="width: 100%;">
                                        <b style="font-size: 15px;">Collection Calculations</b>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <div id="button1">
                                    <a class="btn btn-sq-lg bordered-themeprimary"  ng-disabled="showAllTabs">
                                        <img src="{{showAllTabs ? 'images/Ban-icon.png' : 'images/Documents.png'}}" class="btn-primary cstimg" />
                                        <hr style="width: 100%;">
                                        <b style="font-size: 15px;">Documents</b>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <div id="button1">
                                    <a class="btn btn-sq-lg bordered-themeprimary"  ng-disabled="showAllTabs">
                                        <img src="{{showAllTabs ? 'images/Ban-icon.png' : 'images/SMS-Email-Templates.png'}}" class="btn-primary cstimg" />
                                        <hr style="width: 100%;">
                                        <b style="font-size: 15px;">SMS & Email Templates</b>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <div id="button1">
                                    <a class="btn btn-sq-lg bordered-themeprimary"  ng-disabled="showAllTabs">
                                        <img src="{{showAllTabs ? 'images/Ban-icon.png' : 'images/Project-Authority.png'}}" class="btn-primary cstimg" />
                                        <hr style="width: 100%;">
                                        <b style="font-size: 15px;">Project Authority</b>
                                    </a>
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
        if(angular.element(".btn_uploads").scope().showAllTabs == false){
            $('#fade-in-uploads').toggleClass('show');
            $('.mainPanel').hide();
            $('.content_uploads').show();        
        }
    }); 
    $('.btn_inventory').on('click', function(){        
        if(angular.element(".btn_inventory").scope().showAllTabs == false){
            $('#fade-in-inventory').toggleClass('show');
            $('.mainPanel').hide();
            $('.content_inventory').show();        
        }
    }); 
});
</script>