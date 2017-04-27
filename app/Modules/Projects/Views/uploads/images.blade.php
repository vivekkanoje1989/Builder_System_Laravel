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
<form ng-controller="basicInfoController" role="form" name="imagesForm" ng-submit="saveBasicInfo(data, projectImages)" >
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Logo (Image Size: W 250 X H 250)</label>
                    <span class="input-icon icon-right">
                        <input type="file" ngf-select ng-model="projectImages.project_logo" name="project_logo" id="project_logo" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" ng-change="checkImageExtension(imagesData.project_logo)">
                    </span> 
                    <span class="help-block">{{project_logo_err}}</span>
                </div>
            </div>
            <div class="col-sm-12 col-xs-12" ng-if="project_logo">
                <div class="img-div2" data-title="name" ng-repeat="list in project_logo"> 
                    <i class="fa fa-times rem-icon" title=""></i>
                    <img ng-src="{{list}}" class="thumb photoPreview">
                </div>
            </div>
            <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Thumbnail (Image Size: W 250 X H 250 pixels)</label>
                    <span class="input-icon icon-right">
                        <input type="file" ngf-select ng-model="projectImages.project_thumbnail" name="project_thumbnail" id="project_thumbnail" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" ng-change="checkImageExtension(imagesData.project_thumbnail)">
                    </span>                                                   
                </div>
            </div>
            <div class="col-sm-12 col-xs-12" ng-if="project_thumbnail">
                <div class="img-div2" data-title="name" ng-repeat="list in project_thumbnail">    
                    <i class="fa fa-times rem-icon"  title=""></i>
                    <img ng-src="{{list}}" class="thumb photoPreview">
                </div>
            </div>
            <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
        </div>
    </div>     
    <div class="row">    
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Favicon (Image Size: W 250 X H 250 pixels)</label>
                    <span class="input-icon icon-right">
                        <input type="file" ngf-select ng-model="projectImages.project_favicon" name="project_favicon" id="project_favicon" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" ng-change="checkImageExtension(imagesData.project_favicon)">
                    </span>                                                   
                </div>
            </div>
            <div class="col-sm-12 col-xs-12" ng-if="project_favicon">
                <div class="img-div2" data-title="name" ng-repeat="list in project_favicon">   
                    <i class="fa fa-times rem-icon"  title=""></i>
                    <img ng-src="{{list}}" class="thumb photoPreview">
                </div>
            </div>
            <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Banner Images (Image Size: W 1000 X H 450)</label>
                    <span class="input-icon icon-right">
                        <input type="file" multiple ngf-select ng-model="projectImages.project_banner_images" name="project_banner_images" id="project_banner_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" ng-change="checkImageExtension(imagesData.project_banner_images)">
                    </span>                                                   
                </div>
            </div>
            <div class="col-sm-12 col-xs-12">
                <div class="img-div2" data-title="name" ng-repeat="list in project_banner_images">   
                    <i class="fa fa-times rem-icon"  title=""></i>
                    <img ng-src="{{list}}" class="thumb photoPreview">
                </div>
            </div>
            <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
        </div>        
    </div>

    <div class="row">      
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Background Image</label>
                    <span class="input-icon icon-right">
                        <input type="file" multiple ngf-select ng-model="projectImages.project_background_images" name="project_background_images" id="project_background_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" ng-change="checkImageExtension(imagesData.project_background_images)">
                    </span>                                                   
                </div>
            </div>
<!--            <div class="col-sm-12 col-xs-12" ng-hide="project_background_images_avtar">
                <div class="img-div2" data-title="name">   
                    <i class="fa fa-times rem-icon"  title=""></i>
                    <img ng-src="" class="thumb photoPreview">
                </div>
            </div>-->
            <div class="col-sm-12 col-xs-12">
                <div class="img-div2" data-title="name" ng-repeat="list in project_background_images">   
                    <i class="fa fa-times rem-icon"  title=""></i>
                    <img ng-src="{{list}}" class="thumb photoPreview">
                </div>
            </div>
            <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Upload Brochure</label>
                    <span class="input-icon icon-right">
                        <input type="file" multiple ngf-select ng-model="projectImages.project_broacher" name="project_broacher" id="project_broacher" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" ng-change="checkImageExtension(imagesData.project_broacher)">
                    </span>                                                   
                </div>
            </div>
            <div class="col-sm-12 col-xs-12">
                <div class="img-div2" data-title="name" ng-repeat="list in project_broacher">   
                    <i class="fa fa-times rem-icon"  title=""></i>
                    <img ng-src="{{list}}" class="thumb photoPreview">
                </div>
            </div>
            <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
        </div>
    </div>
<!--    <div class="row">     
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="col-sm-3 col-xs-12">
                <div class="form-group">
                    <label>Project Website</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" ng-model="imagesData.project_website" name="project_website">
                    </span>                                                   
                </div>
            </div>
        </div>
    </div>-->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><br>
        <div class=""><hr></div>
        <div class="form-group" align="center">
            <button type="submit" class="btn btn-primary">Save & Continue</button>
        </div> 
    </div>  
</form>