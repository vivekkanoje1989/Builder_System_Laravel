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
                <span class="widget-caption">Edit Content</span>
            </div>
            <div class="widget-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs" id="myTab9">
                        <li class="active"><a data-toggle="tab" data-target="#pageManagement" style="cursor:pointer">Edit Webpage</a></li>
                        <li><a data-toggle="tab" data-target="#subPageManagement" style="cursor:pointer">Edit Sub Webpage</a></li>
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
                                                    <input type="text" ng-model="contentPage.page_name" required name="page_name" class="form-control" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="255">
                                                    <i class="fa fa-address-card"></i>
                                                    <div  ng-if="sbtBtn1" ng-messages="contentPageForm.page_name.$error">
                                                        <div ng-message="required" class="err">This field is required.</div>
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
                                                    <div ng-if="sbtBtn1" ng-messages="contentPageForm.page_title.$error">
                                                        <div ng-message="required" class="err">This field is required. </div>
                                                    </div>
                                                    <div ng-if="page_title" class="errMsg page_title sp-err">{{page_title}}</div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Seo Url<span class="sp-err"></span></label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contentPage.seo_url" capitalizeFirst name="seo_url" class="form-control" maxlength="250">                                                             
                                                </span>
                                            </div>
                                        </div> 
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Seo Page Title<span class="sp-err"></span></label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contentPage.seo_page_title" capitalizeFirst name="seo_page_title" class="form-control" maxlength="250">
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
                                                    <input type="text" ng-model="contentPage.canonical_tag" name="canonical_tag" capitalizeFirst class="form-control" maxlength="150">                                                             
                                                </span>
                                            </div>
                                        </div>   
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Position<span class="sp-err">*</span></label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contentPage.parent_page_position" required name="parent_page_position" maxlength="2"  oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  class="form-control">                                                             
                                                </span>
                                                <div ng-if="sbtBtn1" ng-messages="contentPageForm.parent_page_position.$error">
                                                    <div ng-message="required" class="err">This field is required.</div>
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
                                                    
                                                    <div ng-if="status" class="errMsg status sp-err">{{status}}</div>
                                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                                                </span>
                                            </div> 
                                        </div>                                            
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Meta Description<span class="sp-err"></span></label>
                                                <span class="input-icon icon-right">
                                                    <textarea rows="2" cols="50" ng-model="contentPage.meta_description"  name="meta_description" class="form-control capitalize"></textarea>
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
                                                    <textarea rows="2" cols="50" ng-model="contentPage.meta_keywords" name="meta_keywords" style="text-transform: capitalize;" class="form-control"></textarea>
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
                                                    <i class="fa fa-times rem-icon" ng-if="img"  title="{{ img}}" ng-click="removeImg('{{img}}',{{$index}}, [[ $pageId]])"></i>
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
                                                        <div text-angular ng-model="contentPage.page_content"  class="capitalize" name="demo-editor" ta-text-editor-class="editor-text" ta-html-editor-class="editor-text"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12" >
                                        <div class="col-md-12 col-xs-12" align="right">
                                            <button type="submit" class="btn btn-primary btn-submit-last" ng-disabled="" ng-click="sbtBtn1 = true;">Update</button>
                                            <a href="[[ config('global.backendUrl') ]]#/webpages/index" class="btn btn-primary">Cancel</a>
                                        </div>
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
                                                    <input type="text" ng-model="subcontentPage.subpage_name" required  name="subpage_name" class="form-control" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15" >
                                                    <i class="fa fa-address-card"></i>
                                                    <div  ng-if="sbtBtn"  ng-messages="imageMgntForm.subpage_name.$error">
                                                        <div ng-message="required" class="err">This field is required.</div>
                                                    </div>
                                                    <div ng-if="subpage_name" class="errMsg page_name sp-err">{{subpage_name}}</div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Page Title<span class="sp-err">*</span></label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="subcontentPage.subpage_title" name="subpage_title" class="form-control" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15" required>
                                                    <i class="fa fa-address-card"></i>
                                                    <div ng-if="sbtBtn" ng-messages="imageMgntForm.subpage_title.$error">
                                                        <div ng-message="required" class="err">This field is required.</div>
                                                    </div>
                                                    <div ng-if="subpage_title" class="errMsg page_title sp-err">{{subpage_title}}</div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Seo Page Title<span class="sp-err"></span></label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="subcontentPage.seo_page_title" capitalizeFirst name="seo_page_title" class="form-control">                                                             
                                                </span>
                                            </div>
                                        </div> 
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Seo Url<span class="sp-err"></span></label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="subcontentPage.seo_url" name="seo_url" capitalizeFirst class="form-control">                                                             
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
                                                    <textarea rows="3" cols="30" ng-model="subcontentPage.meta_description" name="meta_description" class="form-control capitalize"></textarea>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Meta Keywords<span class="sp-err"></span></label>
                                                <span class="input-icon icon-right">
                                                    <textarea rows="3" cols="30" ng-model="subcontentPage.meta_keywords" name="meta_keywords" class="form-control capitalize"></textarea>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Canonical Tag<span class="sp-err"></span></label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="subcontentPage.canonical_tag" capitalizeFirst name="canonical_tag" class="form-control">                                                             
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
                                                    <div ng-message="required" class="err sp-err">This field is required.</div>
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
                                                        <div ng-message="required" class="err">This field is required.</div>
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
                                                        <div text-angular ng-model="subcontentPage.page_content" class="capitalize"  name="page_content" ta-text-editor-class="editor-text" ta-html-editor-class="editor-text"></div>
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
                                        <div class='col-lg-12 col-sm-12 col-xs-12'>
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
                                                            <td class="">
                                                                <div  style="float:center" tooltip-html-unsafe="Edit Sub Page" style="display: block;"><a href="javascript:void(0);" ng-click="editSubPage({{list}},{{$index}},{{list.id}})" class='btn-primary btn-xs'><i class="fa fa-edit"></i>Edit</a></div>
                                                            </td>
                                                        </tr>                                            
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                    </div><br><br>

                                    <div class="col-md-12 col-xs-12" style="margin-top:25px;">
                                        <div class="col-md-12 col-xs-12" align="right">
                                            <button type="submit" class="btn btn-primary btn-submit-last" ng-click="sbtBtn = true;" ng-disabled="">Update</button>
                                            <span class="sp-err">{{err_msg}}</span>
                                            <a href="[[ config('global.backendUrl') ]]#/webpages/index" class="btn btn-primary">Cancel</a>
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