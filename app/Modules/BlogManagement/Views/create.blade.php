<style>
    .editor-text {
        border: 1px solid #cecece;
        margin-top: 10px;
        background-color: #fff;
        padding: 10px;
    }
</style>
<div class="row" ng-controller="blogsCtrl" >  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Blog Management</span>

                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body table-responsive">     
                <form  ng-submit="blogsForm.$valid && doblogscreateAction(bannerImage, galleryImage)" name="blogsForm"  novalidate enctype="multipart/form-data">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <table class="table table-hover table-striped table-bordered" at-config="config">
                        <thead class="bord-bot">
                            <tr>
                                <td colspan="2">Add New Blog</td>
                            <tr>
                        </thead>
                        <tbody>
                        <input type="hidden" ng-model="blogId" name="blogId" id="blogId">                 
                        <tr><td>Title<span class="sp-err">*</span></td>
                            <td>
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!blogsForm.title.$dirty && blogsForm.title.$invalid) }">
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="title" name="title"  ng-change="errormsg = null" required>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="blogsForm.title.$error">
                                            <div ng-message="required">Title is required</div>
                                            <div ng-if="errormsg">{{errormsg}}</div>
                                        </div>
                                        <br/>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr><td>Url<span class="sp-err">*</span></td>
                            <td>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" ng-model="blog_seo_url" name="blog_seo_url"  required>
                                    <br/>
                                </span>
                            </td>
                        </tr>
                        <tr><td>Short Description <span class="sp-err">*</span></td>
                            <td>
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!blogsForm.blog_short_description.$dirty && blogsForm.blog_short_description.$invalid) }">
                                    <span class="input-icon icon-right">
                                        <div class="col-lg-12 col-sm-12 col-xs-12">
                                            <div class="widget flat radius-bordered">
                                                <div class="widget-header bordered-bottom bordered-themeprimary">

                                                </div>         
                                                <div class="widget-body no-padding">   
                                                    <div class="form-group">
                                                        <text-angular name="blog_short_description" ng-model="blog_short_description" required></text-angular>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="blogsForm.blog_short_description.$error">
                                                <div ng-message="required">Short description is required</div>
                                            </div>
                                            <br/>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr><td> Description <span class="sp-err">*</span></td>
                            <td>
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!blogsForm.blog_description.$dirty && blogsForm.blog_description.$invalid) }">
                                    <span class="input-icon icon-right">
                                        <div class="col-lg-12 col-sm-12 col-xs-12">
                                            <div class="widget flat radius-bordered">
                                                <div class="widget-header bordered-bottom bordered-themeprimary">

                                                </div>         
                                                <div class="widget-body no-padding">   
                                                    <div class="form-group">
                                                        <text-angular name="blog_description" ng-model="blog_description" required></text-angular>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="blogsForm.blog_description.$error">
                                                <div ng-message="required">Short description is required</div>
                                            </div>
                                            <br/>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr><td>Banner Image </td>
                            <td>
                                <span class="input-icon icon-right">
                                    <input type="file" ngf-select   ng-model="bannerImage" name="bannerImage" id="bannerImage" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                    <br/>
                                </span>
                            </td>
                        </tr>
                        <tr><td>Gallery Images</td>
                            <td>

                                <span class="input-icon icon-right">
                                    <input type="file" multiple ngf-select ng-model="galleryImage" name="galleryImage" id="galleryImage" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                    <br/>
                                </span>            
                            </td>
                        </tr>
                        <tr><td>Meta Description</td>
                            <td>
                                <span class="input-icon icon-right">
                                    <textarea ng-model="meta_description" name="metaDescription" cols="50" rows="5"></textarea>
                                    <br/>
                                </span>
                            </td>
                        </tr>
                        <tr><td>Meta Keywords</td>
                            <td>
                                <span class="input-icon icon-right">
                                    <textarea ng-model="meta_Keywords" name="meta_Keywords" cols="50" rows="5"></textarea>
                                </span>
                            </td>
                        </tr>
                        <tr><td></td>
                            <td><button type="Submit" class="btn btn-sub" ng-click="sbtBtn = true">Submit</button></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

