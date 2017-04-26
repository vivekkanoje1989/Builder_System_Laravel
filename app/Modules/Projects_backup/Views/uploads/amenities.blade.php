<div class="row">
    <form role="form" name="amenitiesForm" ng-submit="saveBasicInfo(projectData, projectImages)">
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Amenities Images (Image Size: W 250 X H 250)</label>
                    <span class="input-icon icon-right">
                        <input type="file" ngf-select ng-model="projectImages.amenities_images" name="amenities_images" id="amenities_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" ng-change="checkImageExtension(imagesData.project_thumbnail)">
                    </span>                                                   
                </div>
            </div>
            <div class="col-sm-12 col-xs-12" ng-if="amenities_images">
                <div class="img-div2" data-title="name" ng-repeat="list in amenities_images">    
                    <i class="fa fa-times rem-icon"  title=""></i>
                    <img ng-src="{{list}}" class="thumb photoPreview">
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group" ng-controller="amenitiesCtrl">
                    <label for="">Select Amenities List <span class="sp-err">*</span></label>	
                    <ui-select multiple ng-model="projectData.project_amenities_list" name="project_amenities_list" theme="select2"  style="width: 300px;">
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
                            <div text-angular ng-model="projectData.amenities_description" name="amenities_description" ta-text-editor-class="editor-text" ta-html-editor-class="editor-text"></div>
                        </div>
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
