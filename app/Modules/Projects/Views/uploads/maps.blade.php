<div class="row">
    <form role="form" name="mapForm" ng-controller="basicInfoController" ng-submit="saveBasicInfo(mapData, projectImages)">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div id="horizontal-form">
                <div class="col-sm-3 col-xs-6">
                    <div class="form-group">
                        <label>Location Map</label>
                        <span class="input-icon icon-right">
                            <input type="file" ngf-select ng-model="projectImages.location_map_images" name="location_map_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" ngf-model-invalid="errorFile" ng-change="checkImageExtension(userData.emp_photo_url)">
                        </span>   
                    </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <div class="form-group">
                        <label>Google Map Iframe</label>
                        <span class="input-icon icon-right">
                            <textarea class="form-control" ng-model="mapData.google_map_iframe" name="google_map_iframe"></textarea>
                        </span>                                                   
                    </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <div class="form-group">
                        <label>Google Map URL</label>
                        <span class="input-icon icon-right">
                            <textarea class="form-control" ng-model="mapData.google_map_short_url" name="google_map_short_url"></textarea>
                        </span>                                                   
                    </div>
                </div>
            </div>
            <div id="horizontal-form">
                <div class="col-sm-6 col-xs-6" ng-if="location_map_images">
                    <div class="img-div2" data-title="name" ng-repeat="list in location_map_images">    
                        <i class="fa fa-times rem-icon"  title=""></i>
                        <img ng-src="{{list}}" class="thumb photoPreview">
                    </div>
                </div>
            </div> 
        </div>
        
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><br>
            <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-primary">Save & Continue</button>
            </div> 
        </div>  
        
    </form>
</div>
