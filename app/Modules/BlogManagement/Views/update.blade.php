<style>
    .editor-text {
        border: 1px solid #cecece;
        margin-top: 10px;
        background-color: #fff;
        padding: 10px;
    }
    .thumb{
        width: 60px;
        height: 60px;
        margin-top: 0px !important;
    }
    .help-block {
        color: #e46f61;
    }
</style>
<div class="row" ng-controller="blogsCtrl" ng-init="editBlogs('<?php echo $id; ?>');" >  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="widget flat radius-bordered">
                    <div class="widget-body">
                        <div id="registration-form">
                            <form  ng-submit="blogsForm.$valid && doblogscreateAction(bannerImage, galleryImage)" name="blogsForm"  novalidate enctype="multipart/form-data">
                                <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                                <div class="form-title">
                                    Create blog
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 col-xs-12 ">
                                        <div class="form-group">
                                            <label>Title <span class="sp-err">*</span></label>
                                            <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!blogsForm.title.$dirty && blogsForm.title.$invalid) }">
                                                <span class="input-icon icon-right">
                                                    <input type="text" class="form-control" ng-model="title" name="title"  capitalizeFirst  ng-change="errormsg = null"  required>
                                                    <div class="help-block" ng-show="sbtBtn" ng-messages="blogsForm.title.$error">
                                                        <div ng-message="required">Title is required</div>
                                                        <div ng-if="errormsg">{{errormsg}}</div>
                                                    </div>
                                                    <br/>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label>Url</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control" ng-model="blog_seo_url"  name="blog_seo_url"  >
                                                <br/>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!blogsForm.blog_short_description.$dirty && blogsForm.blog_short_description.$invalid) }">
                                            <label>Blog short description</label>
                                            <span class="input-icon icon-right">
                                                <div class="col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="widget flat radius-bordered">
                                                        <div class="widget-header bordered-bottom bordered-themeprimary">
                                                        </div>         
                                                        <div class="widget-body no-padding">   
                                                            <div class="form-group">
                                                                <div text-angular name="blog_short_description"  capitalizeFirst ng-model="blog_short_description" ta-text-editor-class="editor-text" ta-html-editor-class="editor-text" required></div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="help-block" ng-show="sbtBtn" ng-messages="blogsForm.blog_short_description.$error">
                                                        <div ng-message="required">Short description is required</div>
                                                    </div>
                                                    <br/>
                                            </span>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!blogsForm.blog_description.$dirty && blogsForm.blog_description.$invalid) }">
                                        <label>Blog brief description</label>
                                        <span class="input-icon icon-right">
                                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                                <div class="widget flat radius-bordered">
                                                    <div class="widget-header bordered-bottom bordered-themeprimary">

                                                    </div>         
                                                    <div class="widget-body no-padding">   
                                                        <div class="form-group">
                                                            <div text-angular name="blog_description" capitalizeFirst ta-text-editor-class="editor-text" ta-html-editor-class="editor-text" ng-model="blog_description" required></div>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="help-block" ng-show="sbtBtn" ng-messages="blogsForm.blog_description.$error">
                                                    <div ng-message="required">Description is required</div>
                                                </div>
                                                <br/>
                                        </span>
                                    </div>
                                </div> 
                        </div>   
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Banner image</label>
                                <span class="input-icon icon-right">
                                    <input type="file" ngf-select   ng-model="bannerImage" name="bannerImage" id="bannerImage" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                    <br/>
                                </span>
                                <div ng-if="bannerImg">
                                    <img ng-src="{{blog_banner_images}}" width="80px" height="80px">
                                </div>
                                <div class="img-div2" data-title="name" ng-repeat="list in bannerImage_preview">    
                                    <img ng-src="{{list}}" class="thumb photoPreview">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label>Gallery image </label>
                                <span class="input-icon icon-right">
                                    <input type="file" multiple ngf-select ng-model="galleryImage" name="galleryImage" id="galleryImage" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                    <br/>
                                </span>
                                <div  ng-show="imgs" style="margin-top:18px;">
                                    <div  class="img-div2" data-title="name" ng-repeat="img in imgs track by $index" ng-model="allimages">   
                                        <i class="fa fa-times rem-icon" ng-if="img" title="{{img}}" ng-click="removeImg('{{img}}',{{$index}},{{blogId}})"></i>
                                        <img ng-if="img" src="[[ Session::get('s3Path') ]]Blog/gallery_image/{{img}}" style="width: 60px;height: 60px;">
                                    </div>
                                </div>
                                <div class="img-div2" data-title="name" ng-repeat="list in galleryImage_preview">    
                                    <img ng-src="{{list}}" class="thumb photoPreview" >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Meta Description</label>
                                <span class="input-icon icon-right">
                                    <textarea ng-model="meta_description" name="meta_description" capitalizeFirst class="form-control ng-pristine ng-valid ng-valid-maxlength ng-touched" maxlength="50" required></textarea>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label>Meta Keywords</label>
                                <span class="input-icon icon-right">
                                    <textarea ng-model="meta_Keywords" name="meta_Keywords"  capitalizeFirst class="form-control ng-pristine ng-valid ng-valid-maxlength ng-touched" maxlength="50" required></textarea>
                                </span>
                            </div>
                        </div>

                    </div>
                    <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true">Update</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

