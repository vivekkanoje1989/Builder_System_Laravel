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
<div class="row" ng-controller="blogsCtrl" ng-init="editBlogs('<?php echo $id; ?>');">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Edit Blog</span>
            </div>
            <div class="widget-body">
                <form  ng-submit="blogsForm.$valid && doblogscreateAction(blogData.blog_banner_images, blogData.blog_images,blogData,galleryImage_preview)" name="blogsForm"  novalidate enctype="multipart/form-data">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Title <span class="sp-err">*</span></label>
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!blogsForm.blog_title.$dirty && blogsForm.blog_title.$invalid) }">
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="blogData.blog_title" capitalizeFirst name="blog_title"  ng-change="errormsg = null" required >
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="blogsForm.blog_title.$error">
                                            <div ng-message="required">Title is required</div>
                                            <div ng-if="errormsg">{{errormsg}}</div>
                                        </div>
                                         <div ng-if="blog_title" class="sp-err blog_title">{{blog_title}}</div>
                                        <br/>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label>Url</label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" ng-model="blogData.blog_seo_url"  name="blog_seo_url"  >
                                    <br/>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Meta Description</label>
                                <span class="input-icon icon-right">
                                    <textarea ng-model="blogData.meta_description" capitalizeFirst name="meta_description" class="form-control ng-pristine ng-valid ng-valid-maxlength ng-touched" maxlength="50" ></textarea>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label>Meta Keywords</label>
                                <span class="input-icon icon-right">
                                    <textarea ng-model="blogData.meta_keywords" capitalizeFirst name="meta_keywords" class="form-control ng-pristine ng-valid ng-valid-maxlength ng-touched" maxlength="50" ></textarea>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Banner image</label>
                                <span class="input-icon icon-right">
                                    <input type="file" ngf-select   ng-model="blogData.blog_banner_images" name="blog_banner_images" id="blog_banner_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                </span>
                                <span class="help-block">{{bannerImage_err}}</span>
                            </div>
                            <div class="img-div2" data-title="name" ng-repeat="list in bannerImage_preview">    
                                <img ng-src="[[ Config('global.s3Path') ]]/Blog/blog_banner_images/{{list}}" class="thumb photoPreview">
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label>Gallery image</label>
                                <span class="input-icon icon-right">
                                    <input type="file" multiple ngf-select ng-model="blogData.blog_images" name="blog_images" id="blog_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                </span>
                                <span class="help-block">{{galleryImage_err}}</span>
                            </div>
                             <!--<img ng-if="!employee_photo_file_name_preview" ng-src="[[ Config('global.s3Path') ]]employee-photos/{{imgUrl}}" class="thumb photoPreview">-->
                            <div class="img-div2" data-title="name" ng-repeat="list in galleryImage_preview track by $index" > 
                                <i class="fa fa-times rem-icon" ng-if="list"  title="{{list}}" ng-click="removeGalleryImg('{{list}}',{{$index}})"></i>
                                <img ng-if="list" ng-src="[[ Config('global.s3Path') ]]/Blog/gallery_image/{{list}}" class="thumb photoPreview">
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Blog Code <span class="sp-err">*</span></label>
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!blogsForm.blog_code.$dirty && blogsForm.blog_code.$invalid) }">
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="blogData.blog_code" name="blog_code" maxlength="50" required>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="blogsForm.blog_code.$error">
                                            <div ng-message="required">Code is required</div>
                                        </div>
                                         <div ng-if="blog_code" class="sp-err blog_code">{{blog_code}}</div>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Blog Status <span class="sp-err">*</span></label>
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!blogsForm.blog_status.$dirty && blogsForm.blog_status.$invalid) }">
                                    <span class="input-icon icon-right">
                                        <select ng-model="blogData.blog_status" name="blog_status" class="form-control" required>
                                            <option value="">Select Status</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="blogsForm.blog_status.$error">
                                            <div ng-message="required">Please select status</div>
                                        </div>
                                        <div ng-if="blog_status" class="sp-err blog_status">{{blog_status}}</div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div><br/>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!blogsForm.blog_short_description.$dirty && blogsForm.blog_short_description.$invalid) }">
                                <span class="input-icon icon-right">
                                    <div class="widget flat radius-bordered">
                                        <div class="widget-header bordered-bottom bordered-themeprimary"><span class="widget-caption">Short Description</span></div>         
                                        <div class="widget-body no-padding">   
                                            <div class="form-group">
                                                <div text-angular name="blog_short_description"  capitalizeFirst ng-model="blogData.blog_short_description" ta-text-editor-class="editor-text" ta-html-editor-class="editor-text" required></div>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="help-block" ng-show="sbtBtn" ng-messages="blogsForm.blog_short_description.$error">
                                        <div ng-message="required">Short description is required</div>
                                    </div>
                                    <div ng-if="blog_short_description" class="sp-err blog_short_description">{{blog_short_description}}</div>
                                </span>
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div ng-class="{ 'has-error' : sbtBtn && (!blogsForm.blog_description.$dirty && blogsForm.blog_description.$invalid) }">
                                <span class="input-icon icon-right">
                                    <div class="widget flat radius-bordered">
                                        <div class="widget-header bordered-bottom bordered-themeprimary"><span class="widget-caption">Brief Description</span></div>         
                                        <div class="widget-body no-padding">   
                                            <div class="form-group">
                                                <div text-angular name="blog_description" capitalizeFirst ng-model="blogData.blog_description" ta-text-editor-class="editor-text" ta-html-editor-class="editor-text" required></div>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="help-block" ng-show="sbtBtn" ng-messages="blogsForm.blog_description.$error">
                                        <div ng-message="required">Brief description is required</div>
                                    </div>
                                    <div ng-if="blog_description" class="sp-err blog_description">{{blog_description}}</div>
                                </span>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12" align="right">
                            <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true" ng-disabled="updateBlog">Update</button>
                            <a href="[[ config('global.backendUrl') ]]#/blog/index" class="btn btn-primary"><< Back to list</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

