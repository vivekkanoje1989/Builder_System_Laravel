<div class="row">
    <form role="form" name="amenitiesForm" ng-submit="saveBasicInfo(amenityData, projectImages)">
        <input type="hidden" ng-model="amenitiesForm.csrfToken" name="csrftoken" ng-init="amenitiesForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Amenities Images (Size: W 250 X H 250)</label>
                    <span class="input-icon icon-right">
                        <input type="file" ngf-select multiple ng-model="projectImages.amenities_images" name="amenities_images" id="amenities_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" ng-change="checkImageExtension(imagesData.project_thumbnail)">
                    </span>                                                   
                </div>
            </div>
            <div class="col-sm-12 col-xs-12" ng-if="amenities_images">
                <div class="img-div2" data-title="name" ng-repeat="list in amenities_images" id="del_amenities_images_{{$index}}">    
                    <i class="fa fa-times rem-icon"  title="" ng-click="deleteImage({{amenities_images}},'{{list}}', {{$index}}, {{projectData.project_id}}, 'project/amenities_images/', 'amenities_images')"></i>
                    <img ng-src="[[ Session::get('s3Path') ]]/project/amenities_images/{{list}}" class="thumb photoPreview">
                </div>
                <div class="img-div2" data-title="name" ng-repeat="list in amenities_images_preview">    
                    <i class="fa fa-times rem-icon"  title=""></i>
                    <img ng-src="{{list}}" class="thumb photoPreview">
                </div>
            </div>
            
            <div class="col-sm-6 col-xs-12">
            <label for="">Select Amenities List <span class="sp-err">*</span></label>
                <div class="form-group" ng-controller="amenitiesCtrl">                    	
                    <ui-select multiple ng-model="amenityData.project_amenities_list" name="project_amenities_list" theme="select2">
                        <ui-select-match>{{$item.name_of_amenity}}</ui-select-match>
                        <ui-select-choices repeat="list in amenitiesList| filter:$select.search">
                            {{list.name_of_amenity}} 
                        </ui-select-choices>
                    </ui-select> 
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-sm-3 col-xs-6 col-lg-6">  
                <div class="widget flat radius-bordered">
                    <div class="widget-header bordered-bottom bordered-themeprimary">
                        <span class="widget-caption">Amenities Description</span>
                    </div>
                    <div class="widget-body no-padding">
                        <div ng-controller="TextAngularCtrl">
                            <div text-angular ng-model="amenityData.amenities_description" name="amenities_description" ta-text-editor-class="editor-text" ta-html-editor-class="editor-text"></div>
                        </div>
                    </div>
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
