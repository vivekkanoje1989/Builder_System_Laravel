<style>
    .thumb{
        width: 60px;
        height: 60px;
        margin-top: 0px !important;
    }
    .help-block {
        color: #e46f61;
    }
</style>
<form role="form" name="imagesForm" ng-submit="!imagesForm.$pristine && imgesForm.$valid && uploadsData(projectData.prid, projectImages, '')" novalidate>
    <input type="hidden" ng-model="projectImages.csrfToken" name="csrftoken" ng-init="projectImages.csrfToken = '[[ csrf_token() ]]'">
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Logo</label>
                    <span class="input-icon icon-right">
                        <input type="file" ngf-select ng-model="projectImages.project_logo" name="project_logo" id="project_logo" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" ng-change="checkImageExtension(projectImages.project_logo)">
                    </span> 
                    <span class="help-block">{{project_logo_err}}</span>
                </div>
            </div>
            <div class="col-sm-12 col-xs-12">
                <div ng-if="!project_logo_preview" class="img-div2" data-title="name" ng-repeat="list in project_logo"> 
                    <img ng-src="[[ config('global.s3Path') ]]/project/project_logo/{{list}}" class="thumb photoPreview">
                </div>
                <div class="img-div2" data-title="name" ng-repeat="list in project_logo_preview">    
                    <img ng-src="{{list}}" class="thumb photoPreview">
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Thumbnail</label>
                    <span class="input-icon icon-right">
                        <input type="file" ngf-select ng-model="projectImages.project_thumbnail" name="project_thumbnail" id="project_thumbnail" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" ng-change="checkImageExtension(projectImages.project_thumbnail)">
                    </span>                                                   
                </div>
                <span class="help-block">{{project_thumbnail_err}}</span>
            </div>
            <div class="col-sm-12 col-xs-12">
                <div ng-if="!project_thumbnail_preview" class="img-div2" data-title="name" ng-repeat="list in project_thumbnail">    
                    <img ng-src="[[ config('global.s3Path') ]]/project/project_thumbnail/{{list}}" class="thumb photoPreview">
                </div>
                <div class="img-div2" data-title="name" ng-repeat="list in project_thumbnail_preview">    
                    <img ng-src="{{list}}" class="thumb photoPreview">
                </div>
            </div>
        </div>
    </div>     
    <div class="row">    
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Favicon</label>
                    <span class="input-icon icon-right">
                        <input type="file" ngf-select ng-model="projectImages.project_favicon" name="project_favicon" id="project_favicon" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" ng-change="checkImageExtension(projectImages.project_favicon)">
                    </span>                                                   
                </div>
                <span class="help-block">{{project_favicon_err}}</span>
            </div>
            <div class="col-sm-12 col-xs-12">
                <div ng-if="!project_favicon_preview" class="img-div2" data-title="name" ng-repeat="list in project_favicon">   
                    <img ng-src="[[ config('global.s3Path') ]]/project/project_favicon/{{list}}" class="thumb photoPreview">
                </div>
                <div class="img-div2" data-title="name" ng-repeat="list in project_favicon_preview">    
                    <img ng-src="{{list}}" class="thumb photoPreview">
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Banner Images</label>
                    <span class="input-icon icon-right">
                        <input type="file" multiple ngf-select ng-model="projectImages.project_banner_images" name="project_banner_images" id="project_banner_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" ng-change="checkImageExtension(projectImages.project_banner_images)">
                    </span>                                                   
                </div>
                <span class="help-block">{{project_banner_images_err}}</span>
            </div>
            <div class="col-sm-12 col-xs-12">
                <div class="img-div2" data-title="name" ng-repeat="list in project_banner_images" id="del_project_banner_images_{{$index}}">   
                    <i class="fa fa-times rem-icon"  title="" ng-click="deleteImage({{project_banner_images}},'{{list}}', {{$index}}, {{projectData.project_id}}, 'project/project_banner_images/', 'project_banner_images')"></i>
                    <img ng-src="[[ config('global.s3Path') ]]/project/project_banner_images/{{list}}" class="thumb photoPreview">
                </div>
                <div class="img-div2" data-title="name" ng-repeat="list in project_banner_images_preview">    
                    <!--<i class="fa fa-times rem-icon" title=""></i>-->
                    <img ng-src="{{list}}" class="thumb photoPreview">
                </div>
            </div>
        </div>        
    </div>

    <div class="row">      
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Background Image</label>
                    <span class="input-icon icon-right">
                        <input type="file" multiple ngf-select ng-model="projectImages.project_background_images" name="project_background_images" id="project_background_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" ng-change="checkImageExtension(projectImages.project_background_images)">
                    </span>                                                   
                </div>
                <span class="help-block">{{project_background_images_err}}</span>
            </div>
            <div class="col-sm-12 col-xs-12">
                <div class="img-div2" data-title="name" ng-repeat="list in project_background_images" id="del_project_background_images_{{$index}}">   
                    <i class="fa fa-times rem-icon"  title="" ng-click="deleteImage({{project_background_images}},'{{list}}', {{$index}}, {{projectData.project_id}}, 'project/project_background_images/', 'project_background_images')"></i>
                    <img ng-src="[[ config('global.s3Path') ]]/project/project_background_images/{{list}}" class="thumb photoPreview">
                </div>
                <div class="img-div2" data-title="name" ng-repeat="list in project_background_images_preview">    
                    <!--<i class="fa fa-times rem-icon"  title=""></i>-->
                    <img ng-src="{{list}}" class="thumb photoPreview">
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Upload Brochure</label>
                    <span class="input-icon icon-right">
                        <input type="file" multiple ngf-select ng-model="projectImages.project_brochure" name="project_brochure" id="project_brochure" accept="file/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" ng-change="checkImageExtension(projectImages.project_brochure)">
                    </span>                                                   
                </div>
                <span class="help-block">{{project_brochure_err}}</span>
            </div>
            <div class="col-sm-12 col-xs-12">
                <div class="img-div2" data-title="name" ng-repeat="list in project_brochure" id="del_project_brochure_{{$index}}">   
                    <i class="fa fa-times rem-icon"  title="" ng-click="deleteImage({{project_brochure}},'{{list}}', {{$index}}, {{projectData.project_id}}, 'project/project_brochure/', 'project_brochure')"></i>
                    <img ng-src="images/pdf_icon.png" class="thumb photoPreview">
                </div>
                <div class="img-div2" data-title="name" ng-repeat="list in project_brochure_preview">    
                    <!--<i class="fa fa-times rem-icon"  title=""></i>-->
                    <img ng-src="{{list}}" class="thumb photoPreview">
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><br>
        <div class=""><hr></div>
        <div class="form-group" align="center">
            <button type="submit" class="btn btn-primary" ng-disabled="sbtbtnFiles">{{btnLabel}}</button>
            <button type="button" class="btn btn-primary" ng-click="cancel_uploads()">Cancel</button>
        </div> 
    </div>  
</form>
