<div class="row">
    <form role="form" name="statusForm" ng-submit="saveStatusInfo(statusData, stProjectImages)" enctype="multipart/form-data">
        <input type="hidden" ng-model="statusForm.csrfToken" name="csrftoken" ng-init="statusForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
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
                        <td><div ng-repeat="imgList in statusImages[(1 + $index) - 1]" style="float: left;"><img ng-src="[[ Session::get('s3Path') ]]/project/images/{{ imgList }}" style="width: 50px;height: 50px;"></div>
                        <td ng-if="slist.status == 1">Yes</td>
                        <td ng-if="slist.status == 0">No</td>
                        <td>{{slist.short_description}}</td>
                        <td><button class="btn btn-sm btn-danger" ng-confirm-click="Are you sure to delete this record ?" confirmed-click="delStatusRecord({{ slist.id }},{{statusImages[(1 + $index) - 1]}})">Delete</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-sm-3 col-xs-6">  
                <div class="form-group">
                    <label>Images (Size: W 1000 X H 450)</label>
                    <span class="input-icon icon-right">
                        <input type="file" multiple ngf-select ng-model="stProjectImages.images" name="images" id="images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" ng-change="checkImageExtension(statusImages.images)">
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
                    <label for="">Status</label>    
                    <div class="control-group">
                        <div class="radio">
                            <label>
                                <input name="form-field-radio" type="radio" ng-model="statusData.status" value="1" class="colored-success">
                                <span class="text">Yes</span>
                            </label>
                            &nbsp;&nbsp;
                            <label>
                                <input name="form-field-radio" type="radio" ng-model="statusData.status" value="0" class="colored-blue">
                                <span class="text">No</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-sm-12 col-xs-6">  
                <div class="widget flat radius-bordered">
                    <div class="widget-header bordered-bottom bordered-themeprimary">
                        <span class="widget-caption">Short Description</span>
                    </div>
                    <div class="widget-body no-padding">
                        <div ng-controller="TextAngularCtrl">
                            <div text-angular ng-model="statusData.status_short_description" name="status_short_description" ta-text-editor-class="editor-text" ta-html-editor-class="editor-text"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-sm-3 col-xs-6">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </form>
</div>
