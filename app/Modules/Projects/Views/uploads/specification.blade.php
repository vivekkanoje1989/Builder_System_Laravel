<style>
.card {
  text-align: center;
  background: #fff;
  border-radius: 2px;
  display: inline-block;
  height: 100px;
  margin: 1rem;
  position: relative;
  width: 90px;
}
.card-4 {
  box-shadow: 0 5px 12px rgba(0,0,0,0.25), 0px -3px 15px rgba(0,0,0,0.22);
}
.img-div2 {
    margin-bottom: 15px !important;
}
.textStyle{
    margin-top: 4px;
    background-color: #c6e2fb;
}
</style>
<div class="row">
    <form role="form" name="specificationForm" ng-submit="!specificationForm.$pristine && specificationForm.$valid && uploadsData(projectData.prid,'',specificationData)">
        <input type="hidden" ng-model="specificationData.csrfToken" name="csrftoken" ng-init="specificationData.csrfToken = '[[csrf_token()]]'" class="form-control">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label></label>
                    <div class="card card-4 img-div2" ng-if="specificationTitle" ng-repeat="list in specificationTitle" id="del_specification_images_{{$index}}">
                        <i class="fa fa-times rem-icon" title="" ng-click="deleteImage({{specificationTitle}},'{{list.image}}', {{$index}}, {{projectData.project_id}}, 'project/specification_images/', 'specification_images')"></i>
                        <img ng-src="[[ config('global.s3Path') ]]/project/specification_images/{{list.image}}" class="thumb photoPreview">
                        <div class="textStyle"><span class="ng-binding">{{list.title}}</span></div>
                    </div>
                    <span class="input-icon icon-right">
                        <a href data-toggle="modal" data-target="#specificationDataModal" ng-click="resetDetails()">CLICK HERE TO UPLOAD SPECIFICATION</a> 
                    </span>                                                   
                </div>
            </div> 
        </div>   
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="widget flat radius-bordered">
                    <div class="widget-header bordered-bottom bordered-themeprimary">
                        <span class="widget-caption">Specification Description</span>
                    </div>
                    <div class="widget-body no-padding">
                        <div ng-controller="TextAngularCtrl">
                            <div text-angular ng-model="specificationData.specification_description" name="specification_description" ta-text-editor-class="editor-text" ta-html-editor-class="editor-text"></div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><br>
            <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-primary">{{btnLabel}}</button>
                <button type="button" class="btn btn-primary" ng-click="cancel_uploads()">Cancel</button>
            </div> 
        </div>
    </form>
</div>
 <!-- Modal -->
<div class="modal fade modal-primary" id="specificationDataModal" role="dialog" tabindex='-1'>
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center">Specification Details</h4>
            </div>
            <form novalidate name="modalForm" id="modalForm" ng-submit="modalForm.$valid && specicationRow(projectData.prid,modalData,modalImages,'specificationData')">
                <div class="modal-body">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="row" ng-init="wings()">
                            <div class="col-sm-12">
                                <div class="form-group" ng-class="{ 'has-error' : modalSbtBtn && (!modalForm.wing.$dirty && modalForm.wing.$invalid)}">
                                    <label for="">Wing<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select ng-model="modalData.wing" name="wing" class="form-control" ng-change="selectFloor(modalData.wing)" required>
                                            <option value="">Select Wing</option>
                                            <option ng-repeat="wList in wingList" value="{{wList.id}}">{{wList.wing_name}}</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                    </span>
                                    <div ng-show="modalSbtBtn" ng-messages="modalForm.wing.$error" class="help-block">
                                        <div ng-message="required">This field is required</div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-sm-12">
                                <div class="form-group multi-sel-div" ng-class="{ 'has-error' : (modalSbtBtn && (!modalForm.floors.$dirty && modalForm.floors.$invalid))}">
                                    <label for="">Floors<span class="sp-err">*</span></label>	
                                    <ui-select multiple ng-model="modalData.floors" name="floors" theme="select2" ng-required="required">
                                        <ui-select-match placeholder="Select Floors">{{$item.floorName}}</ui-select-match>
                                        <ui-select-choices repeat="flist in floorList | filter:$select.search">
                                            {{flist.floorName}} 
                                        </ui-select-choices>
                                    </ui-select>
                                    <div ng-show="emptyFloorId && floorList.length > 0 && modalData.floors == ''" class="help-block {{ applyClassFloor}}">This field is required</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group" ng-class="{ 'has-error' : modalSbtBtn && (!modalForm.specification_images.$dirty && modalForm.specification_images.$invalid)}">
                                    <label>Specification Images<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <input type="file" ngf-select ng-model="modalImages.specification_images" name="specification_images" id="specification_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" required>
                                    </span>    
                                    <span class="help-block">{{specification_images_err}}</span>
                                    <div ng-show="modalSbtBtn" ng-messages="modalForm.specification_images.$error" class="help-block">
                                        <div ng-message="required">This field is required</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="block-img-div2" data-title="name" ng-repeat="list in specification_images_preview">    
                                    <img ng-src="{{list}}" class="thumb photoPreview">
                                </div>
                            </div> 
                        </div>  
                    </div>
                <div class="modal-footer" align="left">
                    <button type="submit" class="btn btn-primary" ng-click="modalSbtBtn=true; emptyFloorId = true;" ng-disabled="sbtbtnmodal">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
