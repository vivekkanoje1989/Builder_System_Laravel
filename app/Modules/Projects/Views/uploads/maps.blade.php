<div class="row">
    <form role="form" name="mapForm" ng-submit="!mapForm.$pristine && mapForm.$valid && uploadsData(projectData.prid, projectImages, mapData)" novalidate>
        <input type="hidden" ng-model="mapData.csrfToken" name="csrftoken" ng-init="mapData.csrfToken = '[[csrf_token()]]'" class="form-control">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-sm-4 col-xs-12">
                <div class="form-group">
                    <label>Google Map Iframe</label>
                    <span class="input-icon icon-right">
                        <textarea class="form-control" ng-model="mapData.google_map_iframe" name="google_map_iframe" rows="4"></textarea>
                    </span>                                                   
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div class="form-group">
                    <label>Google Map URL</label>
                    <span class="input-icon icon-right">
                        <textarea class="form-control" ng-model="mapData.google_map_short_url" name="google_map_short_url" rows="4" ng-pattern="/^((http[s]?|ftp):\/)?\/?([^:\/\s]+)((\/\w+)*\/)([\w\-\.]+[^#?\s]+)(.*)?(#[\w\-]+)?$/"></textarea>
                        <div ng-show="formButton" ng-messages="mapForm.google_map_short_url.$error" class="help-block errMsg">
                            <div ng-message="pattern">Please enter valid url</div>
                        </div>
                    </span>                                                   
                </div>
            </div>
            <div class="col-sm-4 col-xs-6">
                <div class="form-group">
                    <label>Location Map</label>
                    <span class="input-icon icon-right">
                        <input type="file" ngf-select multiple ng-model="projectImages.location_map_images" name="location_map_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" ngf-model-invalid="errorFile" ng-change="checkImageExtension(userData.emp_photo_url)">
                    </span>   
                </div>
            </div>
            <div class="col-sm-4 col-xs-12" ng-if="location_map_images">
                <div class="img-div2" data-title="name" ng-repeat="list in location_map_images" id="del_location_map_images_{{$index}}}">    
                    <i class="fa fa-times rem-icon"  title="" ng-click="deleteImage({{location_map_images}},'{{list}}', {{$index}}, {{projectData.project_id}}, 'project/location_map_images/', 'location_map_images')"></i>
                    <img ng-src="[[ config('global.s3Path') ]]/project/location_map_images/{{list}}" class="thumb photoPreview">
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
                <button type="submit" class="btn btn-primary" ng-click="formButton=true">{{btnLabel}}</button>
                <button type="button" class="btn btn-primary" ng-click="cancel_uploads()">Cancel</button>
            </div> 
        </div>  
    </form>
</div>
