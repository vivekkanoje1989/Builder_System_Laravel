<div class="row">
    <form role="form" name="statusForm" id="statusForm" ng-submit="!statusForm.$pristine && statusForm.$valid && saveStatusInfo(projectData.prid, stProjectImages, statusData)" enctype="multipart/form-data">
        <input type="hidden" ng-model="statusForm.csrfToken" name="csrftoken" ng-init="statusForm.csrfToken = '[[csrf_token()]]'">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th style="width:5%;">Sr. No.</th>
                        <th>Image</th>
                        <th>Show on website</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="slist in statusRow" id="del_{{ slist.id }}">
                        <td>{{$index + 1}}</td>
                        <td><div ng-repeat="imgList in statusImages[(1 + $index) - 1]" style="float: left;"><img ng-src="[[ config('global.s3Path') ]]/project/images/{{ imgList }}" style="width: 50px;height: 50px;"></div>
                        <td ng-if="slist.status == 1">Yes</td>
                        <td ng-if="slist.status == 0">No</td>
                        <td>{{slist.short_description | htmlToPlaintext}}</td>
                        <td><button class="btn btn-sm btn-danger" ng-confirm-click="Are you sure to delete this record ?" confirmed-click="delStatusRecord({{ slist.id }},{{statusImages[(1 + $index) - 1]}})">Delete</button></td>
                    </tr>
                    <tr ng-if="statusRow==''">
                        <td colspan="5" align="center">No Records Found</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-sm-3 col-xs-6">  
                <div class="form-group">
                    <label>Images<span class="sp-err">*</span></label>
                    <span class="input-icon icon-right">
                        <input type="file" multiple ngf-select ng-model="stProjectImages.images" name="images" id="statusimages" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" ng-change="checkImageExtension(statusImages.images)" required>
                        <div ng-show="formButton" ng-messages="statusForm.images.$error" class="help-block">
                            <div ng-message="required">This field is required.</div>
                        </div>
                    </span>                                                   
                </div>
                 <div class="col-sm-12 col-xs-12">
                    <div class="img-div2" data-title="name" ng-repeat="list in images_preview">   
                        <i class="fa fa-times rem-icon"  title=""></i>
                        <img ng-src="{{list}}" class="thumb photoPreview">
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-6">
                <div class="form-group">
                    <label for="">Status<span class="sp-err">*</span></label>    
                    <div class="control-group">
                        <div class="radio">
                            <label>
                                <input name="status" type="radio" ng-model="statusData.status" value="1" class="colored-success" required>
                                <span class="text">Yes</span>
                            </label>
                            &nbsp;&nbsp;
                            <label>
                                <input name="status" type="radio" ng-model="statusData.status" value="0" class="colored-blue" required>
                                <span class="text">No</span>
                            </label>
                        </div>
                        <div ng-show="formButton" ng-messages="statusForm.status.$error" class="help-block">
                            <div ng-message="required">This field is required.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-sm-12 col-xs-6">  
                <div class="widget flat radius-bordered">
                    <div class="widget-header bordered-bottom bordered-themeprimary">
                        <span class="widget-caption">Short Description<span class="sp-err">*</span></span>
                    </div>
                    <div class="widget-body no-padding">
                        <div ng-controller="TextAngularCtrl">
                            <div text-angular ng-model="statusData.status_short_description" name="status_short_description" ta-text-editor-class="editor-text" ta-html-editor-class="editor-text" required></div>
                        </div>
                    </div>
                    <div ng-show="formButton" ng-messages="statusForm.status_short_description.$error" class="help-block">
                        <div ng-message="required">This field is required.</div>
                    </div>
                </div>
            </div>
        </div>  
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class=""><hr></div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-primary" ng-click="formButton=true">{{btnLabel}}</button>
                <button type="button" class="btn btn-primary" ng-click="cancel_uploads()">Cancel</button>
            </div>
        </div>        
    </form>
</div>
