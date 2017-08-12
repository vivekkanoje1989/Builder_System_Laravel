<style>
    .editor-text {
        border: 1px solid #cecece;
        margin-top: 10px;
        background-color: #fff;
        padding: 10px;
    }
    .editor-text {
        border: 1px solid #cecece;
        margin-top: 10px;
        background-color: #fff;
        padding: 10px;
    }
</style>
<div class="row" ng-controller='contentPagesCtrl'>
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Web Pages</span>
            </div>
            <div class="widget-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs" id="myTab9">
                        <li class="active"><a data-toggle="tab" data-target="#pageManagement" style="cursor:pointer">Web Page Management</a></li>
                        <li><a data-toggle="tab" data-target="#subPageManagement" style="cursor:pointer">Sub Web Page Management</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="pageManagement" class="tab-pane in active">
                            <form name="contentPageForm" novalidate ng-submit="contentPageForm.$valid && updateWebPage(contentPage, imgs, imagePage.banner_images, [[ $pageId]])" ng-init="manageWebPage([[ $pageId ]]); manageImagePage([[ $pageId ]]);">  
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-xs-12">

                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Page Name<span class="sp-err">*</span></label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contentPage.page_name" name="page_name" class="form-control" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="255">
                                                    <i class="fa fa-address-card"></i>
                                                    <div ng-messages="contentPageForm.page_name.$error">
                                                        <div ng-message="required" class="err">Page name is required.</div>
                                                    </div>
                                                     <div ng-if="page_name" class="errMsg page_name sp-err">{{page_name}}</div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Page Title<span class="sp-err">*</span></label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contentPage.page_title" name="page_title" class="form-control" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="60" >
                                                    <i class="fa fa-address-card"></i>
                                                    <div ng-messages="contentPageForm.page_title.$error">
                                                        <div ng-message="required" class="err">Page title is required.</div>
                                                    </div>
                                                    <div ng-if="page_title" class="errMsg page_title sp-err">{{page_title}}</div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Seo Url<span class="sp-err"></span></label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contentPage.seo_url" name="seo_url" class="form-control" maxlength="250">                                                             
                                                </span>
                                            </div>
                                        </div> 
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Seo Page Title<span class="sp-err"></span></label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contentPage.seo_page_title" name="seo_page_title" class="form-control" maxlength="250">
                                                </span>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-xs-12">                                            
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Canonical Tag<span class="sp-err"></span></label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contentPage.canonical_tag" name="canonical_tag" class="form-control" maxlength="150">                                                             
                                                </span>
                                            </div>
                                        </div>   
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Position<span class="sp-err"></span></label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contentPage.parent_page_position" required name="parent_page_position" maxlength="2"  oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  class="form-control">                                                             
                                                </span>
                                                <div ng-messages="contentPageForm.parent_page_position.$error">
                                                    <div ng-message="required">Page position is required.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Status <span class="sp-err">*</span></label>
                                                <span class="input-icon icon-right">
                                                    <select class="form-control" ng-model="contentPage.status" name="status" required>
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                    <div ng-messages="contentPageForm.status.$error">
                                                        <div ng-message="required" class="err">Select status</div>
                                                    </div>
                                                     <div ng-if="status" class="errMsg status sp-err">{{status}}</div>
                                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                                                </span>
                                            </div> 
                                        </div>                                            
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Meta Description<span class="sp-err"></span></label>
                                                <span class="input-icon icon-right">
                                                    <textarea rows="2" cols="50" ng-model="contentPage.meta_description" name="meta_description" class="form-control"></textarea>
                                                </span>
                                            </div>
                                        </div>                                            
                                    </div>                                                
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-xs-12"> 
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Meta Keywords<span class="sp-err"></span></label>
                                                <span class="input-icon icon-right">
                                                    <textarea rows="2" cols="50" ng-model="contentPage.meta_keywords" name="meta_keywords" class="form-control"></textarea>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-sm-9 col-xs-12">
                                            <div class="col-sm-4 col-xs-6">
                                                <div class="form-group">
                                                    <label for=""> Banner Images<span class="sp-err"></span></label>
                                                    <span class="input-icon icon-right">
                                                        <input type="file" multiple ngf-select ng-model="imagePage.banner_images" name="banner_images" id="banner_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" ng-change="checkImageExtension(imagePage.banner_images)">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-8 col-xs-6">
                                                <div class="img-div2" ng-if="imgs" data-title="name" ng-repeat="img in imgs track by $index" ng-model="imagePage.allimages">   
                                                    <i class="fa fa-times rem-icon" ng-if="img"  title="{{ img}}" ng-click="removeImg('{{img}}',{{$index}},[[ $pageId]])"></i>
                                                    <img ng-if="img" ng-src="[[ Config('global.s3Path') ]]/website/banner-images/{{img}}" style="width: 60px;height: 60px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-xs-12">
                                        <div class="col-lg-12 col-sm-12 col-xs-12">
                                            <div class="widget flat radius-bordered">
                                                <div class="widget-header bordered-bottom bordered-themeprimary">
                                                    <span class="widget-caption">Page Content</span>
                                                </div>
                                                <div class="widget-body no-padding">
                                                    <div ng-controller="TextAngularCtrl">
                                                        <div text-angular ng-model="contentPage.page_content" name="demo-editor" ta-text-editor-class="editor-text" ta-html-editor-class="editor-text"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12" align="right">
                                        <button type="submit" class="btn btn-primary btn-submit-last" ng-disabled="">Save</button>
                                        <a href="[[ config('global.backendUrl') ]]#/webpages/index" class="btn btn-primary"><< Back To List</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="subPageManagement" class="tab-pane">
                            <form name="imageMgntForm" novalidate ng-submit=" imageMgntForm.$valid && updateSubWebPage(subcontentPage, subimgs, subImagePage.banner_images, [[ $pageId]])" enctype="multipart/form-data">  
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-xs-12">
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <input type="hidden" ng-model="subId" value="0">

                                                <label for="">Sub Page Name<span class="sp-err">*</span></label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="subcontentPage.page_name" name="page_name" class="form-control" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15" >
                                                    <i class="fa fa-address-card"></i>
                                                    <div  ng-if="sbtBtn"  ng-messages="imageMgntForm.page_name.$error">
                                                        <div ng-message="required" class="err">Page name is required.</div>
                                                    </div>
                                                     <div ng-if="page_name" class="errMsg page_name sp-err">{{page_name}}</div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Page Title<span class="sp-err">*</span></label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="subcontentPage.page_title" name="page_title" class="form-control" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15" required>
                                                    <i class="fa fa-address-card"></i>
                                                    <div ng-if="sbtBtn" ng-messages="imageMgntForm.page_title.$error">
                                                        <div ng-message="required" class="err">Page title is required.</div>
                                                    </div>
                                                     <div ng-if="page_title" class="errMsg page_title sp-err">{{page_title}}</div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Seo Page Title<span class="sp-err"></span></label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="subcontentPage.seo_page_title" name="seo_page_title" class="form-control">                                                             
                                                </span>
                                            </div>
                                        </div> 
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Seo Url<span class="sp-err"></span></label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="subcontentPage.seo_url" name="seo_url" class="form-control">                                                             
                                                </span>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-xs-12">
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Meta Description<span class="sp-err"></span></label>
                                                <span class="input-icon icon-right">
                                                    <textarea rows="3" cols="30" ng-model="subcontentPage.meta_description" name="meta_description" class="form-control"></textarea>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Meta Keywords<span class="sp-err"></span></label>
                                                <span class="input-icon icon-right">
                                                    <textarea rows="3" cols="30" ng-model="subcontentPage.meta_keywords" name="meta_keywords" class="form-control"></textarea>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Canonical Tag<span class="sp-err"></span></label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="subcontentPage.canonical_tag" name="canonical_tag" class="form-control">                                                             
                                                </span>
                                            </div>
                                        </div>   
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Position<span class="sp-err">*</span></label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="subcontentPage.child_page_position" required  name ="child_page_position" maxlength="2" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  name="parent_page_position" class="form-control">                                                             
                                                </span>
                                                <div ng-if="sbtBtn"  ng-messages="imageMgntForm.child_page_position.$error">
                                                    <div ng-message="required" class="err sp-err">Page position is required.</div>
                                                </div>
                                                <div ng-if="child_page_position" class="errMsg status sp-err">{{child_page_position}}</div>
                                            </div>
                                        </div>
                                    </div>                                                
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-xs-12">
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Status <span class="sp-err">*</span></label>
                                                <span class="input-icon icon-right">
                                                    <select class="form-control" ng-model="subcontentPage.status" name="status" required>
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                    <div ng-if="sbtBtn" ng-messages="imageMgntForm.status.$error">
                                                        <div ng-message="required" class="err">Select status</div>
                                                    </div>
                                                    <div ng-if="status" class="errMsg status sp-err">{{status}}</div>
                                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                                                </span>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-xs-12">
                                        <div class="col-lg-12 col-sm-12 col-xs-12">
                                            <div class="widget flat radius-bordered">
                                                <div class="widget-header bordered-bottom bordered-themeprimary">
                                                    <span class="widget-caption">Page Content</span>
                                                </div>
                                                <div class="widget-body no-padding">
                                                    <div ng-controller="TextAngularCtrl">
                                                        <div text-angular ng-model="subcontentPage.page_content" name="page_content" ta-text-editor-class="editor-text" ta-html-editor-class="editor-text"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                                <div class="col-sm-3 col-xs-6">
                                                    <div class="form-group">
                                                        <label for=""> Banner Images<span class="sp-err"></span></label>
                                                        <span class="input-icon icon-right">
                                                            <input type="file" multiple ngf-select ng-model="subImagePage.banner_images" name="banner_images" id="subbanner_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" ng-change="checkImageExtension(imagePage.banner_images)">
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-9 col-xs-6">
                                                    <div class="img-div2" ng-if="imgs" data-title="name" ng-repeat="img in subimgs track by $index" ng-model="imagePage.subimages">   
                                                        <i class="fa fa-times rem-icon" ng-if="img"  title="{{img}}" ng-click="removeSubImg('{{img}}',{{$index}})"></i>
                                                        <img ng-if="img" ng-src="[[ Config('global.s3Path') ]]website/banner-images/{{img}}" style="width: 60px;height: 60px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12" align="right">
                                                <button type="submit" class="btn btn-primary btn-submit-last" ng-click="sbtBtn = true;" ng-disabled="">Save</button>
                                                <span class="sp-err">{{err_msg}}</span>
                                                <a href="[[ config('global.backendUrl') ]]#/webpages/index" class="btn btn-primary"><< Back To List</a>
                                            </div>
                                        </div>
                                        <div class="widget-body table-responsive" ng-init="getSubPages([[ $pageId]])">
                                            <table class="table table-hover table-striped table-bordered" at-config="config">
                                                <thead class="bord-bot">
                                                    <tr>
                                                        <th>Sr. No. </th>
                                                        <th>Page Name</th>
                                                        <th>Page Title</th>
                                                        <th>Seo Url</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="list in subPage">
                                                        <td>{{$index + 1}}</td>
                                                        <td>{{list.page_name}}</td>
                                                        <td>{{list.page_title}}</td>
                                                        <td>{{list.seo_url}}</td>
                                                        <td class="fa-div">
                                                            <div class="fa-hover" style="float:center" tooltip-html-unsafe="Edit Sub Page" style="display: block;"><a href="javascript:void(0);" ng-click="editSubPage({{list}},{{$index}},{{list.id}})"><i class="fa fa-pencil"></i></a></div>
                                                        </td>
                                                    </tr>                                            
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>