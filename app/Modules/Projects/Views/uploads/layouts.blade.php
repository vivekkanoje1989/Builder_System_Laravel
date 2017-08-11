<div class="row">
    <form role="form">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h5 class="row-title"><i class="fa fa-arrow-circle-o-right themeprimary"></i>Layout Plan</h5>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label></label>
                            <div class="card card-4 img-div2" ng-if="layoutTitle" ng-repeat="t in layoutTitle" style="height: 82px !important;" id="del_layout_plan_images_{{$index}}">
                                <i class="fa fa-times rem-icon" title="" ng-click="deleteImage({{layoutTitle}},'{{t}}', {{$index}}, {{projectData.project_id}}, 'project/layout_plan_images/', 'layout_plan_images')"></i>
                                <img ng-src="[[ Session::get('s3Path') ]]/project/layout_plan_images/{{t.image}}" class="thumb photoPreview">
                                <div class="textStyle"><span class="ng-binding">{{t.title}}</span></div>
                            </div>
                            <span class="input-icon icon-right">
                                <a href data-toggle="modal" data-target="#layoutDataModal" ng-click="resetLayoutDetails()">CLICK HERE TO UPLOAD LAYOUT DETAILS</a> 
                            </span>                                                  
                        </div>
                    </div> 
                </div>
  
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h5 class="row-title"><i class="fa fa-arrow-circle-o-right themeprimary"></i>Floor Plan</h5>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label></label>
                            <div class="card card-4 img-div2" ng-if="floorTitle" ng-repeat="t in floorTitle" id="del_floor_plan_images_{{$index}}">
                                <i class="fa fa-times rem-icon" title="" ng-click="deleteImage({{floorTitle}},'{{t}}', {{$index}}, {{projectData.project_id}}, 'project/floor_plan_images/', 'floor_plan_images')"></i>
                                <img ng-src="[[ Session::get('s3Path') ]]/project/floor_plan_images/{{t.image}}" class="thumb photoPreview">
                                <div class="textStyle"><span class="ng-binding">{{t.title}}</span></div>
                            </div>
                            <span class="input-icon icon-right">
                                <a href data-toggle="modal" data-target="#floorDataModal" ng-click="resetFloorDetails()">CLICK HERE TO UPLOAD FLOOR DETAILS</a> 
                            </span>                                                   
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

 <!-- Layout Modal -->
<div class="modal fade" id="layoutDataModal" role="dialog" tabindex='-1'>
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center">Layout Details</h4>
            </div>
            <form novalidate name="lmodalForm" ng-submit="lmodalForm.$valid && layoutRow(lmodalData,lmodalImages)">
                <input type="hidden" ng-model="lmodalForm.csrfToken" name="csrftoken" ng-init="lmodalForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                <div class="modal-body">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div id="horizontal-form" class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group" ng-class="{ 'has-error' : lmodalSbtBtn && (!lmodalForm.wing.$dirty && lmodalForm.wing.$invalid)}">
                                    <label>Project Wing<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select ng-model="lmodalData.wing" name="wing" class="form-control" required>
                                            <option value="">Select Wing</option>
                                            <option ng-repeat="wList in wingList" value="{{wList.id}}">{{wList.wing_name}}</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                    </span>
                                    <div ng-show="lmodalSbtBtn" ng-messages="lmodalForm.wing.$error" class="help-block">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group" ng-class="{ 'has-error' : lmodalSbtBtn && (!lmodalForm.layout_plan_images.$dirty && lmodalForm.layout_plan_images.$invalid)}">
                                    <label>Upload Layout Plan<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <input type="file" ngf-select ng-model="lmodalImages.layout_plan_images" name="layout_plan_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile">
                                    </span>  
                                    <div ng-show="lmodalSbtBtn" ng-messages="lmodalForm.layout_plan_images.$error" class="help-block">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="img-div2" data-title="name" ng-repeat="list in layout_plan_images_preview">    
                                    <img ng-src="{{list}}" class="thumb photoPreview">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" align="left">
                        <button type="submit" class="btn btn-primary" ng-click="lmodalSbtBtn=true">Add</button>
                    </div>
                </div>                    
            </form>
        </div>
    </div>
</div>
 
  <!-- Floor Modal -->
  
  <div class="modal fade" id="floorDataModal" role="dialog" tabindex='-1'>
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center">Floor Details</h4>
            </div>
            <form novalidate name="fmodalForm" ng-submit="fmodalForm.$valid && specicationRow(fmodalData,fmodalImages,'floorData')">
                <input type="hidden" ng-model="fmodalForm.csrfToken" name="csrftoken" ng-init="fmodalForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                <div class="modal-body">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div id="horizontal-form" class="row" ng-init="wings()">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group" ng-class="{ 'has-error' : fmodalSbtBtn && (!fmodalForm.wing.$dirty && fmodalForm.wing.$invalid)}">
                                    <label>Project Wing<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select ng-model="fmodalData.wing" name="wing" class="form-control" ng-change="selectFloor(fmodalData.wing)" required>
                                            <option value="">Select Wing</option>
                                            <option ng-repeat="wList in wingList" value="{{wList.id}}">{{wList.wing_name}}</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                    </span>
                                    <div ng-show="fmodalSbtBtn" ng-messages="fmodalForm.wing.$error" class="help-block">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group" ng-class="{ 'has-error' : fmodalSbtBtn && (!fmodalForm.floors.$dirty && fmodalForm.floors.$invalid)}">
                                    <label>Select Floors<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <ui-select multiple ng-model="fmodalData.floors" name="floors" theme="select2" style="width:540px;" ng-required="required">
                                            <ui-select-match>{{$item.floorName}}</ui-select-match>
                                            <ui-select-choices repeat="flist in floorList | filter:$select.search">
                                                {{flist.floorName}} 
                                            </ui-select-choices>
                                        </ui-select>   
                                    </span>
                                    <div ng-show="fmodalSbtBtn" ng-messages="fmodalForm.floors.$error" class="help-block">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group" ng-class="{ 'has-error' : fmodalSbtBtn && (!fmodalForm.floor_plan_images.$dirty && fmodalForm.floor_plan_images.$invalid)}">
                                    <label>Upload Floor Plan<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <input type="file" ngf-select ng-model="fmodalImages.floor_plan_images" name="floor_plan_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile">
                                    </span>  
                                    <div ng-show="fmodalSbtBtn" ng-messages="fmodalForm.floor_plan_images.$error" class="help-block">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="img-div2" data-title="name" ng-repeat="list in floor_plan_images_preview">    
                                    <img ng-src="{{list}}" class="thumb photoPreview">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" align="left">
                        <button type="submit" class="btn btn-primary" ng-click="fmodalSbtBtn=true">Add</button>
                    </div>
                </div>                    
            </form>
        </div>
    </div>
</div>
  