<div class="row">
    <form role="form" name="mapForm" ng-submit="saveBasicInfo(mapData, projectImages)">
        <input type="hidden" ng-model="mapForm.csrfToken" name="csrftoken" ng-init="mapForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-sm-3 col-xs-12">
                <div class="form-group">
                    <label>Google Map Iframe</label>
                    <span class="input-icon icon-right">
                        <textarea class="form-control" ng-model="mapData.google_map_iframe" name="google_map_iframe"></textarea>
                    </span>                                                   
                </div>
            </div>
            <div class="col-sm-3 col-xs-12">
                <div class="form-group">
                    <label>Google Map URL</label>
                    <span class="input-icon icon-right">
                        <textarea class="form-control" ng-model="mapData.google_map_short_url" name="google_map_short_url"></textarea>
                    </span>                                                   
                </div>
            </div>
            <div class="col-sm-3 col-xs-6">
                <div class="form-group">
                    <label>Location Map</label>
                    <span class="input-icon icon-right">
                        <input type="file" ngf-select multiple ng-model="projectImages.location_map_images" name="location_map_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" ngf-model-invalid="errorFile" ng-change="checkImageExtension(userData.emp_photo_url)">
                    </span>   
                </div>
            </div>
            <div class="col-sm-6 col-xs-12" ng-if="location_map_images">
                <div class="img-div2" data-title="name" ng-repeat="list in location_map_images" id="del_location_map_images_{{$index}}}">    
                    <i class="fa fa-times rem-icon"  title="" ng-click="deleteImage({{location_map_images}},'{{list}}', {{$index}}, {{projectData.project_id}}, 'project/location_map_images/', 'location_map_images')"></i>
                    <img ng-src="[[ Session::get('s3Path') ]]/project/location_map_images/{{list}}" class="thumb photoPreview">
                </div>
                <div class="img-div2" data-title="name" ng-repeat="list in location_map_images_preview">    
                    <i class="fa fa-times rem-icon"  title=""></i>
                    <img ng-src="{{list}}" class="thumb photoPreview">
                </div>
            </div>
        </div>       
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><br>
            <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-primary">Save</button>
            </div> 
        </div>  
        
    </form>
</div>
